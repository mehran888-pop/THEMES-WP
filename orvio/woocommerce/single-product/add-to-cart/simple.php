<?php
/**
 * Simple product add to cart.
 *
 * @package Orvio
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

echo wc_get_stock_html( $product ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

if ( ! $product->is_in_stock() ) {
	return;
}

do_action( 'woocommerce_before_add_to_cart_form' );
?>
<form class="cart orvio-buy" data-orvio-single-atc data-orvio-atc-behavior="<?php echo esc_attr( orvio_opt( 'atc_behavior', 'auto' ) ); ?>" data-product_id="<?php echo esc_attr( $product->get_id() ); ?>" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype="multipart/form-data">
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
	<?php
	do_action( 'woocommerce_before_add_to_cart_quantity' );
	woocommerce_quantity_input(
		array(
			'min_value'   => $product->get_min_purchase_quantity(),
			'max_value'   => $product->get_max_purchase_quantity(),
			'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // phpcs:ignore WordPress.Security.NonceVerification.Missing
		)
	);
	do_action( 'woocommerce_after_add_to_cart_quantity' );
	?>
	<button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button orvio-btn orvio-btn--primary alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
</form>
<?php
do_action( 'woocommerce_after_add_to_cart_form' );
