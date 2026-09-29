<?php
/**
 * Checkout form. Keeps WooCommerce hooks and required IDs.
 *
 * @package Orvio
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_checkout_form', $checkout );

if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}
?>
<?php if ( orvio_pagehead_once() ) : ?>
	<div class="orvio-pagehead">
		<?php orvio_breadcrumb(); ?>
		<h1><?php echo esc_html( orvio_t( 'Checkout', 'تسویه و صورتحساب' ) ); ?></h1>
	</div>
<?php endif; ?>
<ol class="orvio-steps">
	<li class="is-on"><small>01</small><?php echo esc_html( orvio_t( 'Details', 'اطلاعات' ) ); ?></li>
	<li class="is-on"><small>02</small><?php echo esc_html( orvio_t( 'Shipping', 'ارسال' ) ); ?></li>
	<li class="is-on"><small>03</small><?php echo esc_html( orvio_t( 'Payment', 'پرداخت' ) ); ?></li>
</ol>
<form name="checkout" method="post" class="checkout woocommerce-checkout orvio-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
	<div class="orvio-checkout__main" id="customer_details">
		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
		<div class="orvio-panel"><?php do_action( 'woocommerce_checkout_billing' ); ?></div>
		<div class="orvio-panel"><?php do_action( 'woocommerce_checkout_shipping' ); ?></div>
		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
	</div>
	<aside class="orvio-checkout__side orvio-panel">
		<h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>
		<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
		<div id="order_review" class="woocommerce-checkout-review-order">
			<?php do_action( 'woocommerce_checkout_order_review' ); ?>
		</div>
		<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
	</aside>
</form>
<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
