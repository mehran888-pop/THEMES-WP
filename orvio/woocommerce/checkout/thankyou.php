<?php
/**
 * Thank-you / invoice.
 *
 * @package Orvio
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="orvio-invoice">
	<?php if ( $order ) : ?>
		<?php do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>
		<?php if ( $order->has_status( 'failed' ) ) : ?>
			<p class="woocommerce-notice woocommerce-notice--error"><?php esc_html_e( 'Unfortunately your order cannot be processed.', 'woocommerce' ); ?></p>
		<?php else : ?>
			<div class="orvio-invoice__top">
				<div>
					<div class="orvio-okbadge"><?php echo esc_html( orvio_t( 'Your order is in', 'سفارش شما ثبت شد' ) ); ?></div>
					<h1><?php echo esc_html( orvio_t( 'Invoice', 'صورتحساب' ) ); ?></h1>
					<p class="orvio-note"><?php echo esc_html( $order->get_order_number() ); ?></p>
				</div>
				<div>
					<strong><?php bloginfo( 'name' ); ?></strong>
					<p class="orvio-note"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></p>
				</div>
			</div>
			<p><?php echo wp_kses_post( $order->get_formatted_billing_address() ); ?></p>
			<table>
				<thead><tr><th><?php esc_html_e( 'Product', 'woocommerce' ); ?></th><th><?php esc_html_e( 'Total', 'woocommerce' ); ?></th></tr></thead>
				<tbody>
					<?php foreach ( $order->get_items() as $item ) : ?>
						<tr>
							<td><?php echo esc_html( $item->get_name() ); ?> × <?php echo esc_html( $item->get_quantity() ); ?></td>
							<td><?php echo wp_kses_post( $order->get_formatted_line_subtotal( $item ) ); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<div class="orvio-sum-row orvio-sum-row--total"><span><?php esc_html_e( 'Total', 'woocommerce' ); ?></span><span><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></span></div>
			<button type="button" class="orvio-btn orvio-btn--ghost" onclick="print()"><?php echo esc_html( orvio_t( 'Print invoice', 'چاپ صورتحساب' ) ); ?></button>
			<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
			<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
		<?php endif; ?>
	<?php else : ?>
		<p><?php echo esc_html( orvio_t( 'Thank you. Your order has been received.', 'سپاس. سفارش دریافت شد.' ) ); ?></p>
	<?php endif; ?>
</div>
