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
