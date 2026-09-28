<?php
/**
 * AJAX: search suggestions and contact form.
 *
 * @package Orvio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_ajax_orvio_search', 'orvio_ajax_search' );
add_action( 'wp_ajax_nopriv_orvio_search', 'orvio_ajax_search' );
function orvio_ajax_search() {
	check_ajax_referer( 'orvio', 'nonce' );
	$q = isset( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : '';
	if ( strlen( $q ) < 2 ) {
		wp_send_json_success( array() );
	}
	$query = new WP_Query( array(
		's'              => $q,
		'post_type'      => class_exists( 'WooCommerce' ) ? 'product' : 'post',
		'posts_per_page' => 6,
		'post_status'    => 'publish',
	) );
	$items = array();
	foreach ( $query->posts as $post ) {
		$product = function_exists( 'wc_get_product' ) ? wc_get_product( $post ) : null;
		$items[] = array(
			'id'    => $post->ID,
			'title' => get_the_title( $post ),
			'url'   => get_permalink( $post ),
			'img'   => get_the_post_thumbnail_url( $post, 'thumbnail' ),
			'price' => $product ? $product->get_price_html() : '',
		);
	}
	wp_send_json_success( $items );
}

add_action( 'wp_ajax_orvio_contact', 'orvio_ajax_contact' );
add_action( 'wp_ajax_nopriv_orvio_contact', 'orvio_ajax_contact' );
function orvio_ajax_contact() {
	check_ajax_referer( 'orvio', 'nonce' );
	if ( ! empty( $_POST['orvio_hp'] ) ) {
		wp_send_json_success();
	}
	$name    = sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) );
	$email   = sanitize_email( wp_unslash( $_POST['email'] ?? '' ) );
	$phone   = sanitize_text_field( wp_unslash( $_POST['phone'] ?? '' ) );
	$message = sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) );
	if ( ! $name || ! $message || ! is_email( $email ) ) {
		wp_send_json_error( array( 'message' => orvio_t( 'Please check the form.', 'فرم را کامل کنید.' ) ), 400 );
	}
	$to = orvio_opt( 'email' ) ?: get_option( 'admin_email' );
	$sent = wp_mail(
		$to,
		sprintf( orvio_t( 'Message from %s', 'پیام از %s' ), $name ),
		$message . "\n\n" . $phone . "\n" . $email,
		array( 'Reply-To: ' . $email )
	);
	if ( ! $sent ) {
		wp_send_json_error( array( 'message' => orvio_t( 'Could not send.', 'ارسال نشد.' ) ), 500 );
	}
	wp_send_json_success( array( 'message' => orvio_t( 'Message received.', 'پیام شما ثبت شد.' ) ) );
}

function orvio_is_elementor( $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	return $post_id && 'builder' === get_post_meta( $post_id, '_elementor_edit_mode', true );
}

/*
 * Update a mini-cart line without abandoning the drawer. The cart form still
 * posts to the native cart URL when JavaScript is unavailable; this endpoint
 * only enhances that form with an in-place update and refreshed fragments.
 */
add_action( 'wp_ajax_orvio_update_cart_item', 'orvio_ajax_update_cart_item' );
add_action( 'wp_ajax_nopriv_orvio_update_cart_item', 'orvio_ajax_update_cart_item' );
function orvio_ajax_update_cart_item() {
	check_ajax_referer( 'orvio', 'nonce' );
	if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
		wp_send_json_error( array( 'message' => 'Cart unavailable.' ), 400 );
	}

	$key = isset( $_POST['cart_item_key'] ) ? wc_clean( wp_unslash( $_POST['cart_item_key'] ) ) : '';
	$qty = isset( $_POST['quantity'] ) ? absint( wp_unslash( $_POST['quantity'] ) ) : 1;
	$cart = WC()->cart->get_cart();
	if ( ! $key || ! isset( $cart[ $key ] ) || empty( $cart[ $key ]['data'] ) ) {
		wp_send_json_error( array( 'message' => 'Cart item unavailable.' ), 404 );
	}

	$product = $cart[ $key ]['data'];
	$qty     = max( 1, $qty );
	if ( $product->is_sold_individually() ) {
		$qty = 1;
	}
	$max = $product->get_max_purchase_quantity();
	if ( $max > 0 ) {
		$qty = min( $qty, $max );
	}
	WC()->cart->set_quantity( $key, $qty, false );
	WC()->cart->calculate_totals();

	$count = WC()->cart->get_cart_contents_count();
	ob_start();
	woocommerce_mini_cart();
	$mini = ob_get_clean();
	$fragments = array(
		'div.orvio-minicart'                  => '<div class="orvio-drawer__body orvio-minicart">' . $mini . '</div>',
		'span.orvio-count[data-cart-count]'   => '<span class="orvio-count' . ( $count ? '' : ' is-zero' ) . '" data-cart-count>' . esc_html( (string) $count ) . '</span>',
		'span.orvio-cartbtn__total'           => '<span class="orvio-cartbtn__total" data-cart-total>' . WC()->cart->get_cart_subtotal() . '</span>',
	);
	wp_send_json( array( 'fragments' => $fragments ) );
}
