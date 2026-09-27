<?php
/**
 * Account dashboard.
 *
 * @package Orvio
 */

defined( 'ABSPATH' ) || exit;
$orders = function_exists( 'wc_get_orders' ) ? wc_get_orders( array( 'customer' => get_current_user_id(), 'limit' => 5 ) ) : array();
$current = wp_get_current_user();
?>
<div class="orvio-welcome">
	<div>
		<p class="orvio-note" style="color:#E7C3B0"><?php echo esc_html( orvio_t( 'Welcome back', 'خوش آمدید' ) ); ?></p>
		<h2><?php echo esc_html( $current->display_name ); ?></h2>
	</div>
	<a class="orvio-btn orvio-btn--light" href="<?php echo esc_url( orvio_shop_url() ); ?>"><?php echo esc_html( orvio_t( 'Shop', 'فروشگاه' ) ); ?></a>
</div>
<div class="orvio-stats-row">
	<div class="orvio-stat"><strong><?php echo esc_html( (string) count( $orders ) ); ?></strong><span><?php echo esc_html( orvio_t( 'Recent orders', 'سفارش‌های اخیر' ) ); ?></span></div>
	<div class="orvio-stat"><strong><?php echo esc_html( (string) ( function_exists( 'wc_get_customer_order_count' ) ? wc_get_customer_order_count( get_current_user_id() ) : 0 ) ); ?></strong><span><?php echo esc_html( orvio_t( 'All orders', 'همه سفارش‌ها' ) ); ?></span></div>
	<div class="orvio-stat"><strong><?php echo function_exists( 'wc_get_customer_total_spent' ) ? wp_kses_post( wc_price( wc_get_customer_total_spent( get_current_user_id() ) ) ) : '0'; ?></strong><span><?php echo esc_html( orvio_t( 'Spent', 'مجموع خرید' ) ); ?></span></div>
</div>
<div class="orvio-panel">
	<h2 style="font-size:16px;letter-spacing:0"><?php echo esc_html( orvio_t( 'Recent orders', 'آخرین سفارش‌ها' ) ); ?></h2>
	<?php if ( $orders ) : ?>
		<table class="orvio-table">
			<thead><tr><th>#</th><th><?php esc_html_e( 'Date', 'woocommerce' ); ?></th><th><?php esc_html_e( 'Status', 'woocommerce' ); ?></th><th><?php esc_html_e( 'Total', 'woocommerce' ); ?></th></tr></thead>
			<tbody>
				<?php foreach ( $orders as $order ) : ?>
					<tr>
						<td><a href="<?php echo esc_url( $order->get_view_order_url() ); ?>"><?php echo esc_html( $order->get_order_number() ); ?></a></td>
						<td><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></td>
						<td><span class="orvio-status orvio-status--ship"><?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?></span></td>
						<td><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php else : ?>
		<p class="orvio-note"><?php echo esc_html( orvio_t( 'No orders yet.', 'هنوز سفارشی ندارید.' ) ); ?></p>
	<?php endif; ?>
</div>
<?php
printf(
	wp_kses_post( __( 'Hello %1$s (not %1$s? <a href="%2$s">Log out</a>)', 'woocommerce' ) ),
	esc_html( $current->display_name ),
	esc_url( wc_logout_url() )
);
?>
