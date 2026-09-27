<?php
/**
 * Assets.
 *
 * @package Orvio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', 'orvio_enqueue' );
function orvio_enqueue() {
	$css = ORVIO_DIR . '/assets/css/main.css';
	$js  = ORVIO_DIR . '/assets/js/theme.js';
	wp_enqueue_style( 'orvio', ORVIO_URI . '/assets/css/main.css', array(), file_exists( $css ) ? filemtime( $css ) : ORVIO_VERSION );
	wp_enqueue_style( 'orvio-style', get_stylesheet_uri(), array( 'orvio' ), ORVIO_VERSION );
	wp_enqueue_script( 'orvio', ORVIO_URI . '/assets/js/theme.js', array(), file_exists( $js ) ? filemtime( $js ) : ORVIO_VERSION, true );
	wp_localize_script( 'orvio', 'OrvioData', array(
		'ajax'     => admin_url( 'admin-ajax.php' ),
		'nonce'    => wp_create_nonce( 'orvio' ),
		'cart'     => function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '',
		'cartType' => orvio_opt( 'cart_type', 'drawer' ),
		'i18n'     => array(
			'added'    => orvio_t( 'Added to bag', 'به سبد اضافه شد' ),
			'empty'    => orvio_t( 'Your bag is empty.', 'سبد شما خالی است.' ),
			'sent'     => orvio_t( 'Message received.', 'پیام شما ثبت شد.' ),
			'required' => orvio_t( 'Please fill this field.', 'این فیلد را پر کنید.' ),
		),
	) );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'admin_enqueue_scripts', 'orvio_admin_assets' );
function orvio_admin_assets( $hook ) {
	if ( 'toplevel_page_orvio-settings' !== $hook ) {
		return;
	}
	wp_enqueue_style( 'orvio-admin', ORVIO_URI . '/assets/css/admin.css', array(), ORVIO_VERSION );
	wp_enqueue_script( 'orvio-admin', ORVIO_URI . '/assets/js/admin.js', array(), ORVIO_VERSION, true );
}

add_filter( 'woocommerce_enqueue_styles', 'orvio_dequeue_wc_styles' );
function orvio_dequeue_wc_styles( $styles ) {
	unset( $styles['woocommerce-layout'], $styles['woocommerce-smallscreen'] );
	return $styles;
}
