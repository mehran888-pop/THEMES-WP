<?php
/**
 * Account dashboard.
 *
 * @package Orvio
 */

defined( 'ABSPATH' ) || exit;

$orders = function_exists( 'wc_get_orders' ) ? wc_get_orders( array( 'customer' => get_current_user_id(), 'limit' => 5 ) ) : array();
$current = wp_get_current_user();
$name    = $current->display_name ?: $current->user_login;
$full_name = trim( $current->first_name . ' ' . $current->last_name );
$avatar_id = orvio_account_avatar_id( $current->ID );
$status_classes = array(
	'completed'  => 'done',
	'processing' => 'ship',
	'on-hold'    => 'wait',
	'pending'    => 'wait',
	'cancelled'  => 'cancel',
	'failed'     => 'cancel',
	'refunded'   => 'cancel',
);
$avatar_status = isset( $_GET['orvio_avatar'] ) ? sanitize_key( wp_unslash( $_GET['orvio_avatar'] ) ) : '';
$member_since  = $current->user_registered ? date_i18n( get_option( 'date_format' ), strtotime( $current->user_registered ) ) : '';
?>
<div class="orvio-dashboard">
	<?php if ( 'updated' === $avatar_status ) : ?>
		<div class="orvio-account-alert orvio-account-alert--success" role="status"><?php echo esc_html( orvio_t( 'Your profile photo was updated.', 'عکس پروفایل شما با موفقیت تغییر کرد.' ) ); ?></div>
	<?php elseif ( 'removed' === $avatar_status ) : ?>
		<div class="orvio-account-alert" role="status"><?php echo esc_html( orvio_t( 'Your profile photo was removed.', 'عکس پروفایل حذف شد.' ) ); ?></div>
	<?php elseif ( 'error' === $avatar_status ) : ?>
		<div class="orvio-account-alert orvio-account-alert--error" role="alert"><?php echo esc_html( orvio_t( 'Please choose a valid image under 5 MB.', 'یک تصویر معتبر با حجم کمتر از ۵ مگابایت انتخاب کنید.' ) ); ?></div>
	<?php endif; ?>

	<section class="orvio-profile-card" aria-labelledby="orvio-profile-title">
		<div class="orvio-profile-card__wash" aria-hidden="true"></div>
		<div class="orvio-profile-card__top">
			<div class="orvio-profile-identity">
				<div class="orvio-profile-avatar" data-avatar-preview-wrap>
					<?php echo orvio_account_avatar_html( $current->ID, 144 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span class="orvio-profile-avatar__status" aria-hidden="true"></span>
				</div>
				<div class="orvio-profile-identity__copy">
					<p class="orvio-eyebrow"><?php echo esc_html( orvio_t( 'Personal space', 'فضای شخصی شما' ) ); ?></p>
					<h2 id="orvio-profile-title"><?php echo esc_html( $name ); ?></h2>
					<p><?php echo esc_html( $full_name && $full_name !== $name ? $full_name : ( '@' . $current->user_login ) ); ?></p>
					<div class="orvio-profile-chips">
						<span><?php echo esc_html( orvio_t( 'Customer', 'مشتری' ) ); ?></span>
						<?php if ( $member_since ) : ?><span><?php echo esc_html( orvio_t( 'Member since', 'عضو از' ) . ' ' . $member_since ); ?></span><?php endif; ?>
					</div>
				</div>
			</div>
			<div class="orvio-profile-actions">
				<a class="orvio-btn orvio-btn--light" href="<?php echo esc_url( wc_get_account_endpoint_url( 'edit-account' ) ); ?>"><?php echo esc_html( orvio_t( 'Edit profile', 'ویرایش پروفایل' ) ); ?></a>
				<a class="orvio-btn orvio-btn--ghost-light" href="<?php echo esc_url( orvio_shop_url() ); ?>"><?php echo esc_html( orvio_t( 'Continue shopping', 'ادامه خرید' ) ); ?></a>
			</div>
		</div>
		<div class="orvio-profile-card__bottom">
			<div class="orvio-profile-details">
				<div><span><?php echo esc_html( orvio_t( 'Email', 'ایمیل' ) ); ?></span><strong><?php echo esc_html( $current->user_email ); ?></strong></div>
				<div><span><?php echo esc_html( orvio_t( 'Username', 'نام کاربری' ) ); ?></span><strong><?php echo esc_html( '@' . $current->user_login ); ?></strong></div>
				<?php if ( $member_since ) : ?><div><span><?php echo esc_html( orvio_t( 'Active since', 'فعال از' ) ); ?></span><strong><?php echo esc_html( $member_since ); ?></strong></div><?php endif; ?>
			</div>
			<div class="orvio-avatar-editor">
				<form class="orvio-avatar-form" method="post" enctype="multipart/form-data">
					<label class="orvio-upload-drop" for="orvio-avatar-input">
						<span class="orvio-upload-drop__icon" aria-hidden="true">+</span>
						<span><strong><?php echo esc_html( $avatar_id ? orvio_t( 'Change photo', 'تغییر عکس' ) : orvio_t( 'Add profile photo', 'افزودن عکس پروفایل' ) ); ?></strong><small data-avatar-name><?php echo esc_html( orvio_t( 'JPG, PNG, WEBP · max 5 MB', 'JPG، PNG، WEBP · حداکثر ۵ مگابایت' ) ); ?></small></span>
						<input id="orvio-avatar-input" type="file" name="orvio_avatar" accept="image/jpeg,image/png,image/webp,image/gif" data-avatar-input>
					</label>
					<input type="hidden" name="orvio_avatar_action" value="upload">
					<?php wp_nonce_field( 'orvio_avatar', 'orvio_avatar_nonce' ); ?>
					<div class="orvio-avatar-form__actions">
						<button type="submit" class="orvio-btn orvio-btn--light orvio-btn--sm"><?php echo esc_html( orvio_t( 'Upload photo', 'بارگذاری عکس' ) ); ?></button>
						<?php if ( $avatar_id ) : ?>
							<button type="submit" class="orvio-avatar-remove" name="orvio_avatar_remove" value="1"><?php echo esc_html( orvio_t( 'Remove', 'حذف' ) ); ?></button>
						<?php endif; ?>
					</div>
				</form>
			</div>
		</div>
	</section>

	<div class="orvio-dashboard__section-head">
		<div><p class="orvio-eyebrow"><?php echo esc_html( orvio_t( 'Your overview', 'نمای کلی حساب' ) ); ?></p><h3><?php echo esc_html( orvio_t( 'Everything in one place', 'همه‌چیز در یک نگاه' ) ); ?></h3></div>
		<a class="orvio-text-link" href="<?php echo esc_url( wc_get_account_endpoint_url( 'orders' ) ); ?>"><?php echo esc_html( orvio_t( 'View all orders', 'مشاهده همه سفارش‌ها' ) ); ?> <span aria-hidden="true">←</span></a>
	</div>
	<div class="orvio-stats-row orvio-dashboard__stats">
		<div class="orvio-stat"><span class="orvio-stat__icon" aria-hidden="true">↗</span><strong><?php echo esc_html( (string) count( $orders ) ); ?></strong><span><?php echo esc_html( orvio_t( 'Recent orders', 'سفارش‌های اخیر' ) ); ?></span></div>
		<div class="orvio-stat"><span class="orvio-stat__icon" aria-hidden="true">◷</span><strong><?php echo esc_html( (string) ( function_exists( 'wc_get_customer_order_count' ) ? wc_get_customer_order_count( $current->ID ) : 0 ) ); ?></strong><span><?php echo esc_html( orvio_t( 'All orders', 'همه سفارش‌ها' ) ); ?></span></div>
		<div class="orvio-stat"><span class="orvio-stat__icon" aria-hidden="true">◌</span><strong><?php echo function_exists( 'wc_get_customer_total_spent' ) ? wp_kses_post( wc_price( wc_get_customer_total_spent( $current->ID ) ) ) : '0'; ?></strong><span><?php echo esc_html( orvio_t( 'Total spent', 'مجموع خرید' ) ); ?></span></div>
	</div>

	<section class="orvio-panel orvio-orders-panel" aria-labelledby="orvio-orders-title">
		<div class="orvio-panel__head"><div><p class="orvio-eyebrow"><?php echo esc_html( orvio_t( 'Activity', 'فعالیت‌ها' ) ); ?></p><h3 id="orvio-orders-title"><?php echo esc_html( orvio_t( 'Recent orders', 'آخرین سفارش‌ها' ) ); ?></h3></div><span class="orvio-panel__count"><?php echo esc_html( (string) count( $orders ) ); ?></span></div>
		<?php if ( $orders ) : ?>
			<div class="orvio-table-wrap" tabindex="0" role="region" aria-label="<?php echo esc_attr( orvio_t( 'Recent orders', 'آخرین سفارش‌ها' ) ); ?>">
			<table class="orvio-table">
				<thead><tr><th>#</th><th><?php esc_html_e( 'Date', 'woocommerce' ); ?></th><th><?php esc_html_e( 'Status', 'woocommerce' ); ?></th><th><?php esc_html_e( 'Total', 'woocommerce' ); ?></th></tr></thead>
				<tbody>
					<?php foreach ( $orders as $order ) : ?>
						<?php $status = $order->get_status(); ?>
						<tr>
							<td><a href="<?php echo esc_url( $order->get_view_order_url() ); ?>"><?php echo esc_html( $order->get_order_number() ); ?></a></td>
							<td><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></td>
							<td><span class="orvio-status orvio-status--<?php echo esc_attr( $status_classes[ $status ] ?? 'ship' ); ?>"><?php echo esc_html( wc_get_order_status_name( $status ) ); ?></span></td>
							<td><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			</div>
		<?php else : ?>
			<div class="orvio-empty orvio-empty--dashboard"><strong><?php echo esc_html( orvio_t( 'Your next order starts here.', 'سفارش بعدی شما از اینجا شروع می‌شود.' ) ); ?></strong><p><?php echo esc_html( orvio_t( 'Explore the collection and save your favorites.', 'کالکشن را ببینید و علاقه‌مندی‌های خود را ذخیره کنید.' ) ); ?></p><a class="orvio-btn orvio-btn--dark orvio-btn--sm" href="<?php echo esc_url( orvio_shop_url() ); ?>"><?php echo esc_html( orvio_t( 'Explore shop', 'مشاهده فروشگاه' ) ); ?></a></div>
		<?php endif; ?>
	</section>
</div>
