<?php
/**
 * Account dashboard.
 *
 * @package Orvio
 */

defined( 'ABSPATH' ) || exit;

$orders = function_exists( 'wc_get_orders' ) ? wc_get_orders( array( 'customer' => get_current_user_id(), 'limit' => 5 ) ) : array();
$current = wp_get_current_user();
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
?>
<div class="orvio-dashboard">
	<?php if ( 'updated' === $avatar_status ) : ?>
		<div class="orvio-account-alert orvio-account-alert--success" role="status"><?php echo esc_html( orvio_t( 'Your profile photo was updated.', 'عکس پروفایل شما با موفقیت تغییر کرد.' ) ); ?></div>
	<?php elseif ( 'removed' === $avatar_status ) : ?>
		<div class="orvio-account-alert" role="status"><?php echo esc_html( orvio_t( 'Your profile photo was removed.', 'عکس پروفایل حذف شد.' ) ); ?></div>
	<?php elseif ( 'error' === $avatar_status ) : ?>
		<div class="orvio-account-alert orvio-account-alert--error" role="alert"><?php echo esc_html( orvio_t( 'Please choose a valid image under 5 MB.', 'یک تصویر معتبر با حجم کمتر از ۵ مگابایت انتخاب کنید.' ) ); ?></div>
	<?php endif; ?>

	<div class="orvio-dashboard__main">
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
</div>
