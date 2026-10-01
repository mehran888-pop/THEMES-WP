<?php
/**
 * Public support chat connected to a Bale support bot.
 *
 * @package Orvio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function orvio_bale_support_webhook_url() {
	$secret = (string) orvio_opt( 'bale_support_secret', '' );
	if ( ! $secret ) {
		$secret   = wp_generate_password( 40, false, false );
		$settings = orvio_settings();
		$settings['bale_support_secret'] = $secret;
		update_option( 'orvio_settings', $settings );
	}
	return add_query_arg( 'key', rawurlencode( $secret ), rest_url( 'orvio/v1/bale/support-webhook' ) );
}

function orvio_bale_support_admin_ids() {
	$raw = preg_split( '/[\s,;]+/', (string) orvio_opt( 'bale_support_admin_ids', '' ) );
	$ids = array();
	foreach ( (array) $raw as $id ) {
		$id = trim( (string) $id );
		if ( '' !== $id ) {
			$ids[] = $id;
		}
	}
	return array_values( array_unique( $ids ) );
}

function orvio_bale_support_is_admin( $user_id ) {
	return $user_id && in_array( (string) $user_id, orvio_bale_support_admin_ids(), true );
}

function orvio_bale_support_api( $method, $params = array() ) {
	$token = preg_replace( '/[^A-Za-z0-9:_-]/', '', (string) orvio_opt( 'bale_support_bot_token', '' ) );
	if ( ! $token ) {
		return new WP_Error( 'orvio_support_no_token', orvio_t( 'Support Bale bot token is not configured.', 'توکن ربات پشتیبانی بله تنظیم نشده است.' ) );
	}
	$response = wp_remote_post(
		'https://tapi.bale.ai/bot' . $token . '/' . sanitize_key( $method ),
		array(
			'timeout' => 20,
			'headers' => array( 'Content-Type' => 'application/json; charset=utf-8' ),
			'body'    => wp_json_encode( $params ),
		)
	);
	if ( is_wp_error( $response ) ) {
		return $response;
	}
	$code = wp_remote_retrieve_response_code( $response );
	$body = json_decode( wp_remote_retrieve_body( $response ), true );
	if ( $code < 200 || $code >= 300 || ! is_array( $body ) || empty( $body['ok'] ) ) {
		$message = is_array( $body ) && ! empty( $body['description'] ) ? $body['description'] : orvio_t( 'Support Bale API request failed.', 'درخواست API ربات پشتیبانی بله ناموفق بود.' );
		return new WP_Error( 'orvio_support_api_error', $message, array( 'status' => $code, 'body' => $body ) );
	}
	return $body;
}

function orvio_support_token_is_valid( $token ) {
	return is_string( $token ) && (bool) preg_match( '/^[a-f0-9-]{20,64}$/i', $token );
}

function orvio_support_get_session( $token ) {
	if ( ! orvio_support_token_is_valid( $token ) ) {
		return array();
	}
	$session = get_transient( 'orvio_support_' . strtolower( $token ) );
	if ( ! is_array( $session ) || empty( $session['token'] ) ) {
		return array();
	}
	return $session;
}

function orvio_support_save_session( $session ) {
	if ( empty( $session['token'] ) || ! orvio_support_token_is_valid( $session['token'] ) ) {
		return false;
	}
	$session['updated'] = time();
	return set_transient( 'orvio_support_' . strtolower( $session['token'] ), $session, 7 * DAY_IN_SECONDS );
}

function orvio_support_index() {
	$index = get_option( 'orvio_support_index', array() );
	return is_array( $index ) ? $index : array();
}

function orvio_support_save_index( $index ) {
	return update_option( 'orvio_support_index', $index, false );
}

function orvio_support_add_index( $session ) {
	$index = orvio_support_index();
	$index[ $session['token'] ] = array(
		'token'   => $session['token'],
		'name'    => $session['name'] ?? '',
		'updated' => $session['updated'] ?? time(),
		'created' => $session['created'] ?? time(),
		'status'  => $session['status'] ?? 'open',
	);
	$cutoff = time() - 7 * DAY_IN_SECONDS;
	foreach ( $index as $token => $item ) {
		if ( empty( $item['updated'] ) || (int) $item['updated'] < $cutoff ) {
			unset( $index[ $token ] );
		}
	}
	orvio_support_save_index( $index );
}

function orvio_support_append_message( $session, $role, $text ) {
	$text = trim( wp_strip_all_tags( (string) $text ) );
	if ( ! $text ) {
		return $session;
	}
	if ( ! isset( $session['messages'] ) || ! is_array( $session['messages'] ) ) {
		$session['messages'] = array();
	}
	$session['messages'][] = array(
		'id'   => wp_generate_uuid4(),
		'role' => in_array( $role, array( 'visitor', 'agent', 'system' ), true ) ? $role : 'system',
		'text' => wp_html_excerpt( $text, 2000, '…' ),
		'time' => time(),
	);
	if ( count( $session['messages'] ) > 100 ) {
		$session['messages'] = array_slice( $session['messages'], -100 );
	}
	orvio_support_save_session( $session );
	orvio_support_add_index( $session );
	return $session;
}

function orvio_support_public_messages( $session, $since = 0 ) {
	$messages = array();
	$all      = ! empty( $session['messages'] ) && is_array( $session['messages'] ) ? $session['messages'] : array();
	foreach ( $all as $index => $message ) {
		if ( (int) $index < (int) $since ) {
			continue;
		}
		$messages[] = array(
			'id'   => $message['id'] ?? (string) $index,
			'role' => $message['role'] ?? 'system',
			'text' => $message['text'] ?? '',
			'time' => ! empty( $message['time'] ) ? (int) $message['time'] : time(),
		);
	}
	return $messages;
}

function orvio_support_chat_response( $session, $since = 0 ) {
	return array(
		'token'    => $session['token'],
		'since'    => count( $session['messages'] ?? array() ),
		'messages' => orvio_support_public_messages( $session, $since ),
		'status'   => $session['status'] ?? 'open',
	);
}

function orvio_bale_support_notify( $session, $message, $new = false ) {
	$prefix = $new ? '🆕 گفت‌وگوی جدید پشتیبانی' : '📩 پیام جدید پشتیبانی';
	$lines  = array(
		$prefix,
		'👤 ' . ( $session['name'] ?? 'مهمان سایت' ),
		'🔖 REF: ' . $session['token'],
		'',
		wp_html_excerpt( wp_strip_all_tags( $message ), 1200, '…' ),
	);
	$keyboard = array( 'inline_keyboard' => array( array( array( 'text' => '💬 پاسخ به این گفتگو', 'callback_data' => 'support:reply:' . $session['token'] ) ) ) );
	foreach ( orvio_bale_support_admin_ids() as $admin_id ) {
		orvio_bale_support_api( 'sendMessage', array( 'chat_id' => $admin_id, 'text' => implode( "\n", $lines ), 'reply_markup' => $keyboard ) );
	}
}

function orvio_support_notify_visitor( $session, $text ) {
	return orvio_support_append_message( $session, 'agent', $text );
}

function orvio_support_start_request() {
	check_ajax_referer( 'orvio_support', 'nonce' );
	$token   = sanitize_text_field( wp_unslash( $_POST['session'] ?? '' ) );
	$name    = sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) );
	$email   = sanitize_email( wp_unslash( $_POST['email'] ?? '' ) );
	$message = sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) );
	if ( ! $name ) {
		$name = 'مهمان سایت';
	}
	if ( ! $message || strlen( $message ) > 8000 ) {
		wp_send_json_error( array( 'message' => orvio_t( 'Please enter a message.', 'لطفاً پیام خود را وارد کنید.' ) ), 400 );
	}
	$session = orvio_support_get_session( $token );
	$is_new  = empty( $session );
	if ( $is_new ) {
		$token = wp_generate_uuid4();
		$session = array(
			'token'    => $token,
			'name'     => $name,
			'email'    => $email,
			'created'  => time(),
			'updated'  => time(),
			'status'   => 'open',
			'messages' => array(),
		);
		$greeting = trim( (string) orvio_opt( 'bale_support_greeting', 'سلام! پیام شما برای پشتیبانی ارسال شد. همکاران ما به‌زودی پاسخ می‌دهند.' ) );
		if ( $greeting ) {
			$session = orvio_support_append_message( $session, 'system', $greeting );
		}
	} else {
		$session['status'] = 'open';
		if ( $name && 'مهمان سایت' !== $name ) {
			$session['name'] = $name;
		}
		if ( $email ) {
			$session['email'] = $email;
		}
	}
	$session = orvio_support_append_message( $session, 'visitor', $message );
	orvio_bale_support_notify( $session, $message, $is_new );
	wp_send_json_success( orvio_support_chat_response( $session, 0 ) );
}

function orvio_support_poll_request() {
	check_ajax_referer( 'orvio_support', 'nonce' );
	$token   = sanitize_text_field( wp_unslash( $_POST['session'] ?? '' ) );
	$since   = absint( $_POST['since'] ?? 0 );
	$session = orvio_support_get_session( $token );
	if ( empty( $session ) ) {
		wp_send_json_error( array( 'message' => orvio_t( 'This chat has expired.', 'این گفت‌وگو منقضی شده است.' ) ), 404 );
	}
	wp_send_json_success( orvio_support_chat_response( $session, $since ) );
}

add_action( 'wp_ajax_orvio_support_start', 'orvio_support_start_request' );
add_action( 'wp_ajax_nopriv_orvio_support_start', 'orvio_support_start_request' );
add_action( 'wp_ajax_orvio_support_poll', 'orvio_support_poll_request' );
add_action( 'wp_ajax_nopriv_orvio_support_poll', 'orvio_support_poll_request' );

function orvio_bale_support_agent_sessions() {
	$sessions = get_option( 'orvio_bale_support_agent_sessions', array() );
	return is_array( $sessions ) ? $sessions : array();
}

function orvio_bale_support_set_agent_session( $user_id, $token ) {
	$sessions = orvio_bale_support_agent_sessions();
	$sessions[ (string) $user_id ] = array( 'token' => $token, 'expires' => time() + DAY_IN_SECONDS );
	update_option( 'orvio_bale_support_agent_sessions', $sessions, false );
}

function orvio_bale_support_get_agent_session( $user_id ) {
	$sessions = orvio_bale_support_agent_sessions();
	$item     = $sessions[ (string) $user_id ] ?? array();
	if ( empty( $item['token'] ) || empty( $item['expires'] ) || time() > (int) $item['expires'] ) {
		return '';
	}
	return $item['token'];
}

function orvio_bale_support_clear_agent_session( $user_id ) {
	$sessions = orvio_bale_support_agent_sessions();
	unset( $sessions[ (string) $user_id ] );
	update_option( 'orvio_bale_support_agent_sessions', $sessions, false );
}

function orvio_bale_support_agent_reply( $chat_id, $user_id, $token, $text ) {
	$session = orvio_support_get_session( $token );
	if ( empty( $session ) ) {
		orvio_bale_support_api( 'sendMessage', array( 'chat_id' => $chat_id, 'text' => 'این گفت‌وگو منقضی شده است.' ) );
		orvio_bale_support_clear_agent_session( $user_id );
		return;
	}
	orvio_support_notify_visitor( $session, $text );
	orvio_bale_support_api( 'sendMessage', array( 'chat_id' => $chat_id, 'text' => '✅ پاسخ برای مشتری ارسال شد. REF: ' . $token ) );
}

function orvio_bale_support_handle_update( $update ) {
	$callback = ! empty( $update['callback_query'] ) ? $update['callback_query'] : array();
	$message  = ! empty( $update['message'] ) ? $update['message'] : array();
	$from     = $callback['from'] ?? $message['from'] ?? array();
	$user_id  = $from['id'] ?? '';
	$chat_id  = $callback['message']['chat']['id'] ?? $message['chat']['id'] ?? $user_id;
	$text     = trim( (string) ( $message['text'] ?? '' ) );
	if ( ! $callback && preg_match( '/^\/(id|whoami)$/i', $text ) ) {
		orvio_bale_support_api( 'sendMessage', array( 'chat_id' => $chat_id, 'text' => 'شناسه عددی کاربر بله شما: ' . $user_id ) );
		return;
	}
	if ( ! orvio_bale_support_is_admin( $user_id ) ) {
		return;
	}
	if ( $callback && ! empty( $callback['id'] ) ) {
		orvio_bale_support_api( 'answerCallbackQuery', array( 'callback_query_id' => (string) $callback['id'] ) );
	}
	$data = (string) ( $callback['data'] ?? '' );
	if ( preg_match( '/^support:reply:([a-f0-9-]{20,64})$/i', $data, $matches ) ) {
		$token = $matches[1];
		if ( orvio_support_get_session( $token ) ) {
			orvio_bale_support_set_agent_session( $user_id, $token );
			orvio_bale_support_api( 'sendMessage', array( 'chat_id' => $chat_id, 'text' => '✍️ پاسخ خود را برای REF ' . $token . ' بنویسید. برای پایان پاسخ /close را بفرستید.' ) );
		}
		return;
	}
	if ( $callback ) {
		return;
	}
	if ( ! $text ) {
		return;
	}
	if ( preg_match( '/^\/close$/i', $text ) ) {
		$token = orvio_bale_support_get_agent_session( $user_id );
		if ( $token ) {
			$session = orvio_support_get_session( $token );
			if ( $session ) {
				$session['status'] = 'closed';
				orvio_support_append_message( $session, 'system', 'گفت‌وگو توسط پشتیبان بسته شد.' );
			}
			orvio_bale_support_clear_agent_session( $user_id );
			orvio_bale_support_api( 'sendMessage', array( 'chat_id' => $chat_id, 'text' => 'گفت‌وگو بسته شد.' ) );
		}
		return;
	}
	if ( preg_match( '/^\/reply\s+([a-f0-9-]{20,64})\s+(.+)$/is', $text, $matches ) ) {
		orvio_bale_support_agent_reply( $chat_id, $user_id, $matches[1], $matches[2] );
		return;
	}
	$token = orvio_bale_support_get_agent_session( $user_id );
	if ( $token ) {
		orvio_bale_support_agent_reply( $chat_id, $user_id, $token, $text );
		return;
	}
	orvio_bale_support_api( 'sendMessage', array( 'chat_id' => $chat_id, 'text' => 'برای پاسخ به یک گفت‌وگو، ابتدا دکمه «پاسخ به این گفتگو» را بزنید یا از /reply REF پیام استفاده کنید.' ) );
}

add_action( 'rest_api_init', 'orvio_bale_support_register_rest_route' );
function orvio_bale_support_register_rest_route() {
	register_rest_route(
		'orvio/v1',
		'/bale/support-webhook',
		array(
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => 'orvio_bale_support_webhook',
			'permission_callback' => '__return_true',
		)
	);
}

function orvio_bale_support_webhook( WP_REST_Request $request ) {
	if ( ! orvio_opt( 'bale_support_enabled', 0 ) ) {
		return rest_ensure_response( array( 'ok' => true ) );
	}
	$expected = (string) orvio_opt( 'bale_support_secret', '' );
	$received = (string) $request->get_param( 'key' );
	if ( ! $expected || ! $received || ! hash_equals( $expected, $received ) ) {
		return new WP_Error( 'orvio_support_forbidden', 'Forbidden', array( 'status' => 403 ) );
	}
	$update = $request->get_json_params();
	if ( is_array( $update ) ) {
		orvio_bale_support_handle_update( $update );
	}
	return rest_ensure_response( array( 'ok' => true ) );
}

function orvio_bale_support_admin_redirect( $status ) {
	$url = add_query_arg( array( 'page' => 'orvio-settings', 'orvio-tab' => 'support', 'orvio-bale' => $status ), admin_url( 'admin.php' ) );
	wp_safe_redirect( $url );
	exit;
}

add_action( 'admin_post_orvio_bale_support_test', 'orvio_bale_support_admin_test' );
function orvio_bale_support_admin_test() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Unauthorized', 'orvio' ), '', array( 'response' => 403 ) );
	}
	check_admin_referer( 'orvio_bale_support_action' );
	$result = orvio_bale_support_api( 'getMe' );
	orvio_bale_support_admin_redirect( is_wp_error( $result ) ? 'support-test-error' : 'support-test-ok' );
}

add_action( 'admin_post_orvio_bale_support_set_webhook', 'orvio_bale_support_admin_set_webhook' );
function orvio_bale_support_admin_set_webhook() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Unauthorized', 'orvio' ), '', array( 'response' => 403 ) );
	}
	check_admin_referer( 'orvio_bale_support_action' );
	$result = orvio_bale_support_api( 'setWebhook', array( 'url' => orvio_bale_support_webhook_url() ) );
	orvio_bale_support_admin_redirect( is_wp_error( $result ) ? 'support-webhook-error' : 'support-webhook-ok' );
}

add_action( 'admin_post_orvio_bale_support_delete_webhook', 'orvio_bale_support_admin_delete_webhook' );
function orvio_bale_support_admin_delete_webhook() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Unauthorized', 'orvio' ), '', array( 'response' => 403 ) );
	}
	check_admin_referer( 'orvio_bale_support_action' );
	$result = orvio_bale_support_api( 'deleteWebhook' );
	orvio_bale_support_admin_redirect( is_wp_error( $result ) ? 'support-delete-error' : 'support-delete-ok' );
}

add_action( 'wp_footer', 'orvio_render_support_widget' );
function orvio_render_support_widget() {
	if ( is_admin() || ! orvio_opt( 'bale_support_enabled', 0 ) || ! orvio_opt( 'bale_support_bot_token', '' ) ) {
		return;
	}
	?>
	<div class="orvio-support" data-support-widget>
		<button type="button" class="orvio-support__launcher" data-support-open aria-expanded="false"><span class="orvio-support__launcher-icon" aria-hidden="true">✦</span><span><?php echo esc_html( orvio_t( 'Online support', 'پشتیبانی آنلاین' ) ); ?></span></button>
		<section class="orvio-support__panel" data-support-panel hidden aria-label="<?php echo esc_attr( orvio_t( 'Online support', 'پشتیبانی آنلاین' ) ); ?>">
			<header class="orvio-support__header"><div><strong><?php echo esc_html( orvio_t( 'Online support', 'پشتیبانی آنلاین' ) ); ?></strong><small><?php echo esc_html( orvio_t( 'We usually reply quickly', 'معمولاً سریع پاسخ می‌دهیم' ) ); ?></small></div><button type="button" data-support-close aria-label="<?php echo esc_attr( orvio_t( 'Close', 'بستن' ) ); ?>">×</button></header>
			<div class="orvio-support__messages" data-support-messages aria-live="polite"></div>
			<form class="orvio-support__form" data-support-form>
				<div class="orvio-support__identity"><input type="text" name="name" placeholder="نام شما" autocomplete="name"><input type="email" name="email" placeholder="ایمیل (اختیاری)" autocomplete="email"></div>
				<textarea name="message" rows="3" required maxlength="2000" placeholder="پیام خود را بنویسید…"></textarea>
				<div class="orvio-support__form-foot"><small><?php echo esc_html( orvio_t( 'Your message is sent securely to our support team.', 'پیام شما به‌صورت امن برای تیم پشتیبانی ارسال می‌شود.' ) ); ?></small><button type="submit"><?php echo esc_html( orvio_t( 'Send', 'ارسال' ) ); ?></button></div>
				<p class="orvio-support__error" data-support-error role="alert" hidden></p>
			</form>
		</section>
	</div>
	<?php
}
