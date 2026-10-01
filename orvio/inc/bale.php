<?php
/**
 * Bale bot integration for product management and channel publishing.
 *
 * The integration uses Bale's Bot API over HTTPS. Credentials stay in the
 * WordPress options table and are never hard-coded in the theme package.
 *
 * @package Orvio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return the stable webhook URL. A secret is generated only when the admin
 * opens the Bale settings or registers the webhook for the first time.
 */
function orvio_bale_webhook_url() {
	$secret = (string) orvio_opt( 'bale_webhook_secret', '' );
	if ( ! $secret ) {
		$secret   = wp_generate_password( 40, false, false );
		$settings = orvio_settings();
		$settings['bale_webhook_secret'] = $secret;
		update_option( 'orvio_settings', $settings );
	}
	return add_query_arg( 'key', rawurlencode( $secret ), rest_url( 'orvio/v1/bale/webhook' ) );
}

function orvio_bale_api_url( $method ) {
	$token = preg_replace( '/[^A-Za-z0-9:_-]/', '', (string) orvio_opt( 'bale_bot_token', '' ) );
	return 'https://tapi.bale.ai/bot' . $token . '/' . sanitize_key( $method );
}

/**
 * Call a JSON Bale Bot API method.
 *
 * @return array|WP_Error
 */
function orvio_bale_api( $method, $params = array() ) {
	if ( ! orvio_opt( 'bale_bot_token', '' ) ) {
		return new WP_Error( 'orvio_bale_no_token', orvio_t( 'Bale bot token is not configured.', 'توکن ربات بله تنظیم نشده است.' ) );
	}
	$response = wp_remote_post(
		orvio_bale_api_url( $method ),
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
		$message = is_array( $body ) && ! empty( $body['description'] ) ? $body['description'] : orvio_t( 'Bale API request failed.', 'درخواست به API بله ناموفق بود.' );
		return new WP_Error( 'orvio_bale_api_error', $message, array( 'status' => $code, 'body' => $body ) );
	}
	return $body;
}

function orvio_bale_admin_ids() {
	$raw = preg_split( '/[\s,;]+/', (string) orvio_opt( 'bale_admin_ids', '' ) );
	$ids = array();
	foreach ( (array) $raw as $id ) {
		$id = trim( (string) $id );
		if ( '' !== $id ) {
			$ids[] = $id;
		}
	}
	return array_values( array_unique( $ids ) );
}

function orvio_bale_is_admin( $user_id ) {
	return $user_id && in_array( (string) $user_id, orvio_bale_admin_ids(), true );
}

function orvio_bale_sessions() {
	$sessions = get_option( 'orvio_bale_sessions', array() );
	return is_array( $sessions ) ? $sessions : array();
}

function orvio_bale_get_session( $user_id ) {
	$sessions = orvio_bale_sessions();
	$key      = (string) $user_id;
	if ( empty( $sessions[ $key ]['expires'] ) || time() > (int) $sessions[ $key ]['expires'] ) {
		unset( $sessions[ $key ] );
		update_option( 'orvio_bale_sessions', $sessions, false );
		return array();
	}
	return is_array( $sessions[ $key ] ) ? $sessions[ $key ] : array();
}

function orvio_bale_set_session( $user_id, $session ) {
	$sessions = orvio_bale_sessions();
	$sessions[ (string) $user_id ] = array_merge( (array) $session, array( 'expires' => time() + DAY_IN_SECONDS ) );
	update_option( 'orvio_bale_sessions', $sessions, false );
}

function orvio_bale_clear_session( $user_id ) {
	$sessions = orvio_bale_sessions();
	unset( $sessions[ (string) $user_id ] );
	update_option( 'orvio_bale_sessions', $sessions, false );
}

function orvio_bale_keyboard( $rows ) {
	return array( 'inline_keyboard' => $rows );
}

function orvio_bale_button( $text, $callback_data ) {
	return array( 'text' => $text, 'callback_data' => $callback_data );
}

function orvio_bale_url_button( $text, $url ) {
	return array( 'text' => $text, 'url' => $url );
}

function orvio_bale_send_message( $chat_id, $text, $keyboard = array() ) {
	$params = array( 'chat_id' => (string) $chat_id, 'text' => wp_html_excerpt( wp_strip_all_tags( (string) $text ), 4090, '…' ) );
	if ( ! empty( $keyboard ) ) {
		$params['reply_markup'] = $keyboard;
	}
	return orvio_bale_api( 'sendMessage', $params );
}

function orvio_bale_send_product( $product_id, $chat_id = '' ) {
	if ( ! function_exists( 'wc_get_product' ) ) {
		return new WP_Error( 'orvio_bale_woocommerce', orvio_t( 'WooCommerce is required.', 'ووکامرس لازم است.' ) );
	}
	$product = wc_get_product( $product_id );
	$chat_id = $chat_id ? $chat_id : orvio_opt( 'bale_channel_id', '' );
	if ( ! $product || ! $chat_id ) {
		return new WP_Error( 'orvio_bale_product_channel', orvio_t( 'Product or Bale channel is missing.', 'محصول یا کانال بله تنظیم نشده است.' ) );
	}
	$regular = wp_strip_all_tags( wc_price( (float) $product->get_regular_price() ) );
	$current = wp_strip_all_tags( $product->get_price_html() );
	$excerpt = wp_html_excerpt( wp_strip_all_tags( $product->get_short_description() ), 420, '…' );
	if ( ! $excerpt ) {
		$excerpt = wp_html_excerpt( wp_strip_all_tags( $product->get_description() ), 420, '…' );
	}
	$categories = wp_strip_all_tags( wc_get_product_category_list( $product->get_id(), '، ' ) );
	$status     = $product->is_in_stock() ? orvio_t( 'Available', 'موجود' ) : orvio_t( 'Out of stock', 'ناموجود' );
	$lines      = array( '🛍️ ' . $product->get_name() );
	if ( $excerpt ) {
		$lines[] = $excerpt;
	}
	$lines[] = '━━━━━━━━━━━━';
	$lines[] = '💳 ' . ( $current ? $current : $regular );
	if ( $product->is_on_sale() && $regular ) {
		$lines[] = '🏷️ ' . orvio_t( 'Regular price', 'قیمت قبل' ) . ': ' . $regular;
	}
	$lines[] = '📦 ' . $status;
	if ( $categories ) {
		$lines[] = '🗂️ ' . $categories;
	}
	$lines[] = '';
	$lines[] = orvio_t( 'For details and purchase:', 'برای مشاهده جزئیات و خرید:' );
	$lines[] = $product->get_permalink();
	$default_caption = implode( "\n", $lines );
	$template = (string) orvio_opt( 'bale_product_template', '' );
	$caption  = $template ? strtr(
		$template,
		array(
			'{title}'             => $product->get_name(),
			'{short_description}' => $excerpt,
			'{description}'       => wp_html_excerpt( wp_strip_all_tags( $product->get_description() ), 700, '…' ),
			'{price}'             => $current ? $current : $regular,
			'{regular_price}'     => $regular,
			'{stock}'             => $status,
			'{category}'          => $categories,
			'{sku}'               => $product->get_sku(),
			'{url}'               => $product->get_permalink(),
			'{id}'                => (string) $product->get_id(),
		)
	) : $default_caption;
	$keyboard  = orvio_bale_keyboard( array( array( orvio_bale_url_button( 'مشاهده و خرید', $product->get_permalink() ) ) ) );
	$image_url  = $product->get_image_id() ? wp_get_attachment_image_url( $product->get_image_id(), 'large' ) : '';
	$params     = array( 'chat_id' => (string) $chat_id );
	if ( $image_url ) {
		$params['photo']   = esc_url_raw( $image_url );
		$params['caption'] = wp_html_excerpt( $caption, 4090, '…' );
		$params['reply_markup'] = $keyboard;
		return orvio_bale_api( 'sendPhoto', $params );
	}
	return orvio_bale_send_message( $chat_id, $caption, $keyboard );
}

function orvio_bale_product_categories( $value ) {
	$names = preg_split( '/[,،]+/', (string) $value );
	$ids   = array();
	foreach ( (array) $names as $name ) {
		$name = sanitize_text_field( trim( $name ) );
		if ( ! $name ) {
			continue;
		}
		$term = get_term_by( 'name', $name, 'product_cat' );
		if ( ! $term ) {
			$term = get_term_by( 'slug', sanitize_title( $name ), 'product_cat' );
		}
		if ( ! $term ) {
			$created = wp_insert_term( $name, 'product_cat' );
			if ( ! is_wp_error( $created ) ) {
				$ids[] = (int) $created['term_id'];
			}
		} else {
			$ids[] = (int) $term->term_id;
		}
	}
	return array_values( array_unique( $ids ) );
}

function orvio_bale_attach_image( $url, $product_id ) {
	$url = esc_url_raw( trim( (string) $url ) );
	if ( ! $url || ! wp_http_validate_url( $url ) ) {
		return 0;
	}
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';
	$attachment_id = media_sideload_image( $url, $product_id, '', 'id' );
	return is_wp_error( $attachment_id ) ? 0 : (int) $attachment_id;
}

function orvio_bale_image_urls( $value ) {
	$urls = preg_split( '/[\s,]+/', (string) $value );
	$urls = array_map( 'esc_url_raw', (array) $urls );
	return array_values( array_filter( $urls ) );
}

function orvio_bale_product_data( $product ) {
	$category_names = wp_strip_all_tags( wc_get_product_category_list( $product->get_id(), ', ' ) );
	$image_url      = $product->get_image_id() ? wp_get_attachment_image_url( $product->get_image_id(), 'large' ) : '';
	$gallery_urls   = array();
	foreach ( $product->get_gallery_image_ids() as $gallery_id ) {
		$gallery_url = wp_get_attachment_image_url( $gallery_id, 'large' );
		if ( $gallery_url ) {
			$gallery_urls[] = $gallery_url;
		}
	}
	return array(
		'title'             => $product->get_name(),
		'short_description' => $product->get_short_description(),
		'description'       => $product->get_description(),
		'regular_price'     => $product->get_regular_price(),
		'sale_price'        => $product->get_sale_price(),
		'sku'               => $product->get_sku(),
		'stock_quantity'    => $product->managing_stock() ? (string) $product->get_stock_quantity() : '',
		'category'          => $category_names,
		'image'             => $image_url,
		'gallery'           => implode( ' ', $gallery_urls ),
		'status'            => $product->get_status(),
	);
}

function orvio_bale_new_product_data() {
	return array(
		'title'             => '',
		'short_description' => '',
		'description'       => '',
		'regular_price'     => '',
		'sale_price'        => '',
		'sku'               => '',
		'stock_quantity'    => '',
		'category'          => '',
		'image'             => '',
		'gallery'           => '',
		'status'            => 'draft',
	);
}

function orvio_bale_field_labels() {
	return array(
		'title'             => 'نام محصول',
		'short_description' => 'توضیح کوتاه',
		'description'       => 'توضیح کامل',
		'regular_price'     => 'قیمت اصلی',
		'sale_price'        => 'قیمت تخفیف',
		'sku'               => 'شناسه محصول SKU',
		'stock_quantity'    => 'موجودی',
		'category'          => 'دسته‌بندی‌ها',
		'image'             => 'تصویر اصلی',
		'gallery'           => 'تصاویر گالری',
	);
}

function orvio_bale_prompt_product_field( $chat_id, $user_id, $field, $data, $editing = false ) {
	$labels = orvio_bale_field_labels();
	$label  = $labels[ $field ] ?? $field;
	$current = isset( $data[ $field ] ) && '' !== (string) $data[ $field ] ? "\nمقدار فعلی: " . $data[ $field ] : '';
	$hints = array(
		'sale_price'     => 'برای حذف قیمت تخفیف، «رد کردن» را بزنید.',
		'stock_quantity' => 'عدد موجودی را وارد کنید؛ برای مدیریت‌نکردن موجودی، «رد کردن» را بزنید.',
		'category'       => 'نام چند دسته را با ویرگول فارسی یا انگلیسی جدا کنید. دسته جدید خودکار ساخته می‌شود.',
		'image'          => 'یک URL عمومی و مستقیم تصویر وارد کنید.',
		'gallery'        => 'چند URL تصویر را با فاصله یا ویرگول جدا کنید.',
	);
	$text = '🧩 ' . ( $editing ? 'ویرایش محصول' : 'محصول جدید' ) . "\n\n" . $label . ' را وارد کنید.' . $current;
	if ( ! empty( $hints[ $field ] ) ) {
		$text .= "\n" . $hints[ $field ];
	}
	$rows = array();
	if ( $editing ) {
		$rows[] = array( orvio_bale_button( '↩ حفظ مقدار فعلی', 'bale:keep' ) );
		if ( 'title' !== $field ) {
			$rows[] = array( orvio_bale_button( '🧹 پاک‌کردن مقدار', 'bale:skip' ) );
		}
	} elseif ( 'title' !== $field ) {
		$rows[] = array( orvio_bale_button( '⏭ رد کردن', 'bale:skip' ) );
	}
	$rows[] = array( orvio_bale_button( '✖ لغو', 'bale:cancel' ) );
	orvio_bale_send_message( $chat_id, $text, orvio_bale_keyboard( $rows ) );
	$session = orvio_bale_get_session( $user_id );
	$session['field'] = $field;
	orvio_bale_set_session( $user_id, $session );
}

function orvio_bale_start_product( $chat_id, $user_id, $product_id = 0 ) {
	if ( ! function_exists( 'wc_get_product' ) ) {
		orvio_bale_send_message( $chat_id, 'ووکامرس فعال نیست.' );
		return;
	}
	$data = orvio_bale_new_product_data();
	if ( $product_id ) {
		$product = wc_get_product( $product_id );
		if ( ! $product ) {
			orvio_bale_send_message( $chat_id, 'محصول پیدا نشد.' );
			return;
		}
		$data = orvio_bale_product_data( $product );
	}
	orvio_bale_set_session(
		$user_id,
		array(
			'action'     => 'product',
			'product_id' => (int) $product_id,
			'data'       => $data,
			'editing'    => (bool) $product_id,
			'field'      => 'title',
		)
	);
	orvio_bale_prompt_product_field( $chat_id, $user_id, 'title', $data, (bool) $product_id );
}

function orvio_bale_finish_product( $chat_id, $user_id, $session ) {
	$data       = $session['data'] ?? array();
	$product_id = absint( $session['product_id'] ?? 0 );
	$product    = $product_id ? wc_get_product( $product_id ) : new WC_Product_Simple();
	if ( ! $product ) {
		$product = new WC_Product_Simple();
	}
	if ( empty( $data['title'] ) ) {
		orvio_bale_send_message( $chat_id, 'نام محصول الزامی است. دوباره از /new شروع کنید.' );
		orvio_bale_clear_session( $user_id );
		return;
	}
	try {
		$product->set_name( sanitize_text_field( $data['title'] ) );
		$product->set_short_description( sanitize_textarea_field( $data['short_description'] ?? '' ) );
		$product->set_description( sanitize_textarea_field( $data['description'] ?? '' ) );
		$product->set_regular_price( wc_format_decimal( $data['regular_price'] ?? '' ) );
		$product->set_sale_price( ! empty( $data['sale_price'] ) ? wc_format_decimal( $data['sale_price'] ) : '' );
		$product->set_sku( sanitize_text_field( $data['sku'] ?? '' ) );
		if ( '' !== (string) ( $data['stock_quantity'] ?? '' ) ) {
			$product->set_manage_stock( true );
			$product->set_stock_quantity( max( 0, (int) $data['stock_quantity'] ) );
			$product->set_stock_status( (int) $data['stock_quantity'] > 0 ? 'instock' : 'outofstock' );
		} else {
			$product->set_manage_stock( false );
			$product->set_stock_status( 'instock' );
		}
		$product->set_category_ids( orvio_bale_product_categories( $data['category'] ?? '' ) );
		$product->set_status( in_array( $data['status'] ?? 'draft', array( 'draft', 'publish' ), true ) ? $data['status'] : 'draft' );
		$saved_id = $product->save();
		if ( ! $saved_id ) {
			throw new Exception( 'Product could not be saved.' );
		}
		$featured = orvio_bale_attach_image( $data['image'] ?? '', $saved_id );
		if ( $featured ) {
			$product->set_image_id( $featured );
		}
		$gallery_ids = array();
		foreach ( orvio_bale_image_urls( $data['gallery'] ?? '' ) as $gallery_url ) {
			$gallery_id = orvio_bale_attach_image( $gallery_url, $saved_id );
			if ( $gallery_id ) {
				$gallery_ids[] = $gallery_id;
			}
		}
		if ( $gallery_ids ) {
			$product->set_gallery_image_ids( $gallery_ids );
		}
		$product->save();
	} catch ( Throwable $error ) {
		orvio_bale_send_message( $chat_id, '❌ ذخیره محصول انجام نشد: ' . $error->getMessage() );
		orvio_bale_clear_session( $user_id );
		return;
	}
	orvio_bale_clear_session( $user_id );
	$action_text = $product_id ? 'ویرایش شد' : 'ساخته شد';
	orvio_bale_send_message(
		$chat_id,
		'✅ محصول «' . $product->get_name() . '» با موفقیت ' . $action_text . '.\nشناسه: ' . $saved_id . '\nوضعیت: ' . ( 'publish' === $product->get_status() ? 'منتشر شده' : 'پیش‌نویس' ),
		orvio_bale_keyboard(
			array(
				array( orvio_bale_button( '📣 ارسال به کانال بله', 'bale:send:' . $saved_id ) ),
				array( 'publish' === $product->get_status() ? orvio_bale_button( '✅ منتشرشده', 'bale:list' ) : orvio_bale_button( '✅ انتشار در سایت', 'bale:publish:' . $saved_id ) ),
				array( orvio_bale_button( '✏️ ویرایش دوباره', 'bale:edit:' . $saved_id ), orvio_bale_button( '📋 فهرست محصولات', 'bale:list' ) ),
			)
		)
	);
	if ( ! $product_id && 'publish' === $product->get_status() && orvio_opt( 'bale_auto_publish', 0 ) ) {
		$result = orvio_bale_send_product( $saved_id );
		if ( is_wp_error( $result ) ) {
			orvio_bale_send_message( $chat_id, '⚠️ محصول ساخته شد اما ارسال خودکار انجام نشد: ' . $result->get_error_message() );
		}
	}
}

function orvio_bale_list_products( $chat_id ) {
	if ( ! function_exists( 'wc_get_products' ) ) {
		orvio_bale_send_message( $chat_id, 'ووکامرس فعال نیست.' );
		return;
	}
	$products = wc_get_products( array( 'limit' => 10, 'status' => array( 'publish', 'draft', 'pending' ), 'orderby' => 'date', 'order' => 'DESC' ) );
	if ( ! $products ) {
		orvio_bale_send_message( $chat_id, 'هنوز محصولی ثبت نشده است.' );
		return;
	}
	$rows = array();
	$text = "📋 فهرست محصولات\n\n";
	foreach ( $products as $product ) {
		$status = 'publish' === $product->get_status() ? '✅' : '📝';
		$text .= $status . ' #' . $product->get_id() . ' — ' . $product->get_name() . "\n";
		$rows[] = array( orvio_bale_button( '✏️ #' . $product->get_id(), 'bale:edit:' . $product->get_id() ), 'publish' === $product->get_status() ? orvio_bale_button( '📣 ارسال', 'bale:send:' . $product->get_id() ) : orvio_bale_button( '✅ انتشار', 'bale:publish:' . $product->get_id() ), orvio_bale_button( '🗑', 'bale:delete:' . $product->get_id() ) );
		if ( 'publish' !== $product->get_status() ) {
			$rows[] = array( orvio_bale_button( '📣 ارسال به کانال', 'bale:send:' . $product->get_id() ) );
		}
	}
	$rows[] = array( orvio_bale_button( '➕ محصول جدید', 'bale:new' ) );
	orvio_bale_send_message( $chat_id, $text, orvio_bale_keyboard( $rows ) );
}

function orvio_bale_main_menu( $chat_id, $text = '' ) {
	if ( ! $text ) {
		$text = "🤖 مدیریت محصولات Orvio در بله\n\nاز دکمه‌های زیر استفاده کنید یا یکی از دستورات /new، /products، /edit ID، /send ID و /delete ID را بفرستید.";
	}
	orvio_bale_send_message(
		$chat_id,
		$text,
		orvio_bale_keyboard(
			array(
				array( orvio_bale_button( '➕ محصول جدید', 'bale:new' ), orvio_bale_button( '📋 محصولات', 'bale:list' ) ),
				array( orvio_bale_button( '❔ راهنما', 'bale:help' ) ),
			)
		)
	);
}

function orvio_bale_help( $chat_id ) {
	orvio_bale_send_message( $chat_id, "راهنمای مدیریت محصول\n\n/new — ساخت محصول کامل\n/products — فهرست محصولات\n/edit 123 — ویرایش محصول\n/publish 123 — انتشار در سایت\n/send 123 — ارسال قالب حرفه‌ای به کانال\n/delete 123 — انتقال به زباله‌دان\n/cancel — لغو فرم فعلی\n\nدر فرم ساخت، نام، توضیح کوتاه و کامل، قیمت، تخفیف، SKU، موجودی، دسته‌بندی، تصویر، گالری و وضعیت محصول دریافت می‌شود." );
}

function orvio_bale_process_value( $chat_id, $user_id, $session, $value ) {
	$field = $session['field'] ?? '';
	$data  = $session['data'] ?? orvio_bale_new_product_data();
	$value = trim( (string) $value );
	if ( '-' === $value || 'رد کردن' === $value ) {
		$value = '';
	}
	if ( 'title' === $field ) {
		$value = sanitize_text_field( $value );
	} elseif ( in_array( $field, array( 'short_description', 'description' ), true ) ) {
		$value = sanitize_textarea_field( $value );
	} elseif ( in_array( $field, array( 'regular_price', 'sale_price' ), true ) ) {
		$value = $value ? wc_format_decimal( $value ) : '';
	} elseif ( 'stock_quantity' === $field ) {
		$value = '' === $value ? '' : (string) max( 0, absint( $value ) );
	} elseif ( 'sku' === $field ) {
		$value = sanitize_text_field( $value );
	} elseif ( 'category' === $field ) {
		$value = sanitize_text_field( $value );
	} elseif ( in_array( $field, array( 'image', 'gallery' ), true ) ) {
		$value = implode( ' ', orvio_bale_image_urls( $value ) );
	}
	$data[ $field ] = $value;
	$session['data'] = $data;
	$fields = array_keys( orvio_bale_field_labels() );
	$index  = array_search( $field, $fields, true );
	$next   = false !== $index && isset( $fields[ $index + 1 ] ) ? $fields[ $index + 1 ] : 'status';
	if ( 'status' === $next ) {
		$session['field'] = 'status';
		orvio_bale_set_session( $user_id, $session );
		orvio_bale_send_message( $chat_id, 'وضعیت محصول را انتخاب کنید.', orvio_bale_keyboard( array( array( orvio_bale_button( '📝 پیش‌نویس', 'bale:status:draft' ), orvio_bale_button( '✅ انتشار در سایت', 'bale:status:publish' ) ), array( orvio_bale_button( '✖ لغو', 'bale:cancel' ) ) ) ) );
		return;
	}
	orvio_bale_set_session( $user_id, $session );
	orvio_bale_prompt_product_field( $chat_id, $user_id, $next, $data, ! empty( $session['editing'] ) );
}

function orvio_bale_handle_callback( $callback ) {
	$data    = (string) ( $callback['data'] ?? '' );
	$chat_id = $callback['message']['chat']['id'] ?? ( $callback['from']['id'] ?? '' );
	$user_id = $callback['from']['id'] ?? '';
	if ( ! orvio_bale_is_admin( $user_id ) ) {
		return;
	}
	if ( ! empty( $callback['id'] ) ) {
		orvio_bale_api( 'answerCallbackQuery', array( 'callback_query_id' => (string) $callback['id'] ) );
	}
	if ( 'bale:new' === $data ) {
		orvio_bale_start_product( $chat_id, $user_id );
		return;
	}
	if ( 'bale:list' === $data ) {
		orvio_bale_clear_session( $user_id );
		orvio_bale_list_products( $chat_id );
		return;
	}
	if ( 'bale:help' === $data ) {
		orvio_bale_help( $chat_id );
		return;
	}
	if ( 'bale:cancel' === $data ) {
		orvio_bale_clear_session( $user_id );
		orvio_bale_main_menu( $chat_id, 'فرم لغو شد.' );
		return;
	}
	if ( 'bale:keep' === $data ) {
		$session = orvio_bale_get_session( $user_id );
		if ( ! empty( $session['action'] ) && 'product' === $session['action'] ) {
			$field = $session['field'] ?? '';
			orvio_bale_process_value( $chat_id, $user_id, $session, $session['data'][ $field ] ?? '' );
		}
		return;
	}
	if ( 'bale:skip' === $data ) {
		$session = orvio_bale_get_session( $user_id );
		if ( ! empty( $session['action'] ) && 'product' === $session['action'] ) {
			orvio_bale_process_value( $chat_id, $user_id, $session, '' );
		}
		return;
	}
	if ( preg_match( '/^bale:status:(draft|publish)$/', $data, $matches ) ) {
		$session = orvio_bale_get_session( $user_id );
		if ( ! empty( $session['action'] ) && 'product' === $session['action'] ) {
			$session['data']['status'] = $matches[1];
			orvio_bale_finish_product( $chat_id, $user_id, $session );
		}
		return;
	}
	if ( preg_match( '/^bale:(edit|send|delete|publish|confirm-delete):(\d+)$/', $data, $matches ) ) {
		$action = $matches[1];
		$id     = absint( $matches[2] );
		if ( 'edit' === $action ) {
			orvio_bale_start_product( $chat_id, $user_id, $id );
		} elseif ( 'send' === $action ) {
			$result = orvio_bale_send_product( $id );
			orvio_bale_send_message( $chat_id, is_wp_error( $result ) ? '❌ ' . $result->get_error_message() : '✅ محصول به کانال بله ارسال شد.' );
		} elseif ( 'publish' === $action ) {
			$product = wc_get_product( $id );
			if ( $product ) {
				$product->set_status( 'publish' );
				$product->save();
				orvio_bale_send_message( $chat_id, '✅ محصول در سایت منتشر شد.', orvio_bale_keyboard( array( array( orvio_bale_button( '📣 ارسال به کانال', 'bale:send:' . $id ) ) ) ) );
			}
		} elseif ( 'delete' === $action ) {
			orvio_bale_send_message( $chat_id, 'انتقال محصول #' . $id . ' به زباله‌دان تأیید شود؟', orvio_bale_keyboard( array( array( orvio_bale_button( 'بله، حذف کن', 'bale:confirm-delete:' . $id ), orvio_bale_button( 'لغو', 'bale:cancel' ) ) ) ) );
		} else {
			$product = wc_get_product( $id );
			if ( $product ) {
				wp_trash_post( $product->get_id() );
				orvio_bale_send_message( $chat_id, '🗑 محصول #' . $id . ' حذف شد.' );
			}
		}
	}
}

function orvio_bale_handle_update( $update ) {
	$callback = ! empty( $update['callback_query'] ) ? $update['callback_query'] : array();
	$message  = ! empty( $update['message'] ) ? $update['message'] : ( ! empty( $update['edited_message'] ) ? $update['edited_message'] : array() );
	$from     = $callback['from'] ?? $message['from'] ?? array();
	$user_id  = $from['id'] ?? '';
	$chat_id  = $callback['message']['chat']['id'] ?? $message['chat']['id'] ?? $user_id;
	$text     = trim( (string) ( $message['text'] ?? '' ) );
	if ( ! $user_id ) {
		return;
	}
	if ( ! $callback && preg_match( '/^\/(id|whoami)$/i', $text ) ) {
		orvio_bale_send_message( $chat_id, 'شناسه عددی کاربر بله شما: ' . $user_id . "\nاین عدد را در تنظیمات ربات، در فهرست کاربران مجاز وارد کنید." );
		return;
	}
	if ( ! orvio_bale_is_admin( $user_id ) ) {
		return;
	}
	if ( $callback ) {
		orvio_bale_handle_callback( $callback );
		return;
	}
	if ( ! $text ) {
		return;
	}
	if ( '/cancel' === strtolower( $text ) ) {
		orvio_bale_clear_session( $user_id );
		orvio_bale_main_menu( $chat_id, 'فرم لغو شد.' );
		return;
	}
	if ( preg_match( '/^\/(start|menu)$/i', $text ) ) {
		orvio_bale_clear_session( $user_id );
		orvio_bale_main_menu( $chat_id );
		return;
	}
	if ( preg_match( '/^\/help$/i', $text ) ) {
		orvio_bale_help( $chat_id );
		return;
	}
	if ( preg_match( '/^\/new$/i', $text ) ) {
		orvio_bale_start_product( $chat_id, $user_id );
		return;
	}
	if ( preg_match( '/^\/products?$/i', $text ) ) {
		orvio_bale_clear_session( $user_id );
		orvio_bale_list_products( $chat_id );
		return;
	}
	if ( preg_match( '/^\/(edit|send|publish|delete)\s+(\d+)$/i', $text, $matches ) ) {
		$action = strtolower( $matches[1] );
		$id     = absint( $matches[2] );
		if ( 'edit' === $action ) {
			orvio_bale_start_product( $chat_id, $user_id, $id );
		} elseif ( 'send' === $action ) {
			$result = orvio_bale_send_product( $id );
			orvio_bale_send_message( $chat_id, is_wp_error( $result ) ? '❌ ' . $result->get_error_message() : '✅ محصول به کانال بله ارسال شد.' );
		} elseif ( 'publish' === $action ) {
			$product = wc_get_product( $id );
			if ( $product ) {
				$product->set_status( 'publish' );
				$product->save();
				orvio_bale_send_message( $chat_id, '✅ محصول در سایت منتشر شد.' );
			}
		} else {
			$product = wc_get_product( $id );
			if ( $product ) {
				wp_trash_post( $product->get_id() );
				orvio_bale_send_message( $chat_id, '🗑 محصول #' . $id . ' حذف شد.' );
			}
		}
		return;
	}
	$session = orvio_bale_get_session( $user_id );
	if ( ! empty( $session['action'] ) && 'product' === $session['action'] && ! empty( $session['field'] ) ) {
		if ( 'status' === $session['field'] ) {
			orvio_bale_send_message( $chat_id, 'لطفاً وضعیت را با دکمه انتخاب کنید.' );
			return;
		}
		orvio_bale_process_value( $chat_id, $user_id, $session, $text );
		return;
	}
	orvio_bale_main_menu( $chat_id, 'دستور را متوجه نشدم. از منوی زیر انتخاب کنید.' );
}

add_action( 'rest_api_init', 'orvio_bale_register_rest_route' );
function orvio_bale_register_rest_route() {
	register_rest_route(
		'orvio/v1',
		'/bale/webhook',
		array(
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => 'orvio_bale_webhook',
			'permission_callback' => '__return_true',
		)
	);
}

function orvio_bale_webhook( WP_REST_Request $request ) {
	if ( ! orvio_opt( 'bale_enabled', 0 ) ) {
		return rest_ensure_response( array( 'ok' => true ) );
	}
	$expected = (string) orvio_opt( 'bale_webhook_secret', '' );
	$received = (string) $request->get_param( 'key' );
	if ( ! $expected || ! $received || ! hash_equals( $expected, $received ) ) {
		return new WP_Error( 'orvio_bale_forbidden', 'Forbidden', array( 'status' => 403 ) );
	}
	$update = $request->get_json_params();
	if ( is_array( $update ) ) {
		orvio_bale_handle_update( $update );
	}
	return rest_ensure_response( array( 'ok' => true ) );
}

function orvio_bale_admin_notice( $status ) {
	$messages = array(
		'test-ok'       => orvio_t( 'Bale bot connection is working.', 'اتصال ربات بله برقرار است.' ),
		'test-error'    => orvio_t( 'Bale bot connection failed. Check the token and server outbound HTTPS.', 'اتصال ربات بله ناموفق بود. توکن و دسترسی HTTPS خروجی سرور را بررسی کنید.' ),
		'webhook-ok'    => orvio_t( 'Bale webhook registered.', 'وب‌هوک بله با موفقیت ثبت شد.' ),
		'webhook-error' => orvio_t( 'Bale webhook could not be registered.', 'ثبت وب‌هوک بله ناموفق بود.' ),
		'delete-ok'     => orvio_t( 'Bale webhook disabled.', 'وب‌هوک بله غیرفعال شد.' ),
		'delete-error'  => orvio_t( 'Bale webhook could not be disabled.', 'غیرفعال‌کردن وب‌هوک بله ناموفق بود.' ),
	);
	return $messages[ $status ] ?? orvio_t( 'Bale action completed.', 'عملیات بله انجام شد.' );
}

function orvio_bale_admin_redirect( $status ) {
	$url = add_query_arg( array( 'page' => 'orvio-settings', 'orvio-tab' => 'bale', 'orvio-bale' => $status ), admin_url( 'admin.php' ) );
	wp_safe_redirect( $url );
	exit;
}

add_action( 'admin_post_orvio_bale_test', 'orvio_bale_admin_test' );
function orvio_bale_admin_test() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Unauthorized', 'orvio' ), '', array( 'response' => 403 ) );
	}
	check_admin_referer( 'orvio_bale_action' );
	$result = orvio_bale_api( 'getMe' );
	orvio_bale_admin_redirect( is_wp_error( $result ) ? 'test-error' : 'test-ok' );
}

add_action( 'admin_post_orvio_bale_set_webhook', 'orvio_bale_admin_set_webhook' );
function orvio_bale_admin_set_webhook() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Unauthorized', 'orvio' ), '', array( 'response' => 403 ) );
	}
	check_admin_referer( 'orvio_bale_action' );
	$result = orvio_bale_api( 'setWebhook', array( 'url' => orvio_bale_webhook_url() ) );
	orvio_bale_admin_redirect( is_wp_error( $result ) ? 'webhook-error' : 'webhook-ok' );
}

add_action( 'admin_post_orvio_bale_delete_webhook', 'orvio_bale_admin_delete_webhook' );
function orvio_bale_admin_delete_webhook() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Unauthorized', 'orvio' ), '', array( 'response' => 403 ) );
	}
	check_admin_referer( 'orvio_bale_action' );
	$result = orvio_bale_api( 'deleteWebhook' );
	orvio_bale_admin_redirect( is_wp_error( $result ) ? 'delete-error' : 'delete-ok' );
}
