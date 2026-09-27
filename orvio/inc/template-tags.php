<?php
/**
 * Template tags.
 *
 * @package Orvio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function orvio_announcement_text() {
	$locale = function_exists( 'determine_locale' ) ? determine_locale() : get_locale();
	if ( 0 === strpos( $locale, 'en' ) && orvio_opt( 'announcement_en' ) ) {
		return orvio_opt( 'announcement_en' );
	}
	return orvio_opt( 'announcement' );
}

function orvio_cart_count() {
	if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
		return 0;
	}
	return WC()->cart->get_cart_contents_count();
}

function orvio_cart_total_html() {
	if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
		return '';
	}
	return WC()->cart->get_cart_subtotal();
}

function orvio_account_url() {
	return function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : wp_login_url();
}

function orvio_shop_url() {
	return function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
}

function orvio_breadcrumb() {
	if ( function_exists( 'woocommerce_breadcrumb' ) && ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) ) {
		woocommerce_breadcrumb( array(
			'delimiter'   => '<span class="orvio-crumb__sep">/</span>',
			'wrap_before' => '<nav class="orvio-crumb" aria-label="Breadcrumb">',
			'wrap_after'  => '</nav>',
		) );
		return;
	}
	echo '<nav class="orvio-crumb"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( orvio_t( 'Home', 'خانه' ) ) . '</a>';
	if ( ! is_front_page() ) {
		echo '<span class="orvio-crumb__sep">/</span><span>' . esc_html( wp_get_document_title() ) . '</span>';
	}
	echo '</nav>';
}

function orvio_product_cats() {
	if ( ! taxonomy_exists( 'product_cat' ) ) {
		return array();
	}
	$terms = get_terms( array(
		'taxonomy'   => 'product_cat',
		'hide_empty' => true,
		'parent'     => 0,
	) );
	return is_wp_error( $terms ) ? array() : $terms;
}

function orvio_posted_on() {
	echo '<time datetime="' . esc_attr( get_the_date( DATE_W3C ) ) . '">' . esc_html( get_the_date() ) . '</time>';
}
