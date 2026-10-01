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


/**
 * Return the custom profile avatar attachment for a user.
 *
 * Gravatar remains the fallback so this does not replace WordPress/WooCommerce
 * identity behavior when the user has not uploaded a picture.
 */
function orvio_account_avatar_id( $user_id = 0 ) {
	$user_id = $user_id ? absint( $user_id ) : get_current_user_id();
	return absint( get_user_meta( $user_id, 'orvio_avatar_id', true ) );
}

function orvio_account_initials( $user_id = 0 ) {
	$user_id = $user_id ? absint( $user_id ) : get_current_user_id();
	$user    = get_userdata( $user_id );
	$name    = $user ? trim( $user->first_name . ' ' . $user->last_name ) : '';
	$name    = $name ?: ( $user ? $user->display_name : orvio_t( 'Profile', 'پروفایل' ) );
	$parts   = preg_split( '/\s+/u', $name, -1, PREG_SPLIT_NO_EMPTY );
	$letters = array();
	foreach ( array_slice( (array) $parts, 0, 2 ) as $part ) {
		$letters[] = function_exists( 'mb_substr' ) ? mb_substr( $part, 0, 1, 'UTF-8' ) : substr( $part, 0, 1 );
	}
	return esc_html( implode( '', $letters ) ?: 'O' );
}

function orvio_account_avatar_html( $user_id = 0, $size = 128 ) {
	$user_id   = $user_id ? absint( $user_id ) : get_current_user_id();
	$avatar_id = orvio_account_avatar_id( $user_id );
	$user      = get_userdata( $user_id );
	$name      = $user ? ( $user->display_name ?: $user->user_login ) : orvio_t( 'Profile', 'پروفایل' );
	if ( $avatar_id ) {
		$image = wp_get_attachment_image(
			$avatar_id,
			array( $size, $size ),
			false,
			array(
				'class' => 'orvio-profile-avatar__image',
				'alt'   => $name,
			)
		);
		if ( $image ) {
			return $image;
		}
	}
	$avatar = get_avatar( $user_id, $size, '', $name, array( 'class' => 'orvio-profile-avatar__image' ) );
	return $avatar ?: '<span class="orvio-profile-avatar__initials" aria-hidden="true">' . orvio_account_initials( $user_id ) . '</span>';
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

	// The current title is already rendered by the pagehead h1. Keep the
	// breadcrumb contextual without printing that same title a second time.
	echo '<nav class="orvio-crumb" aria-label="Breadcrumb"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( orvio_t( 'Home', 'خانه' ) ) . '</a>';

	if ( is_page() ) {
		$ancestors = array_reverse( get_post_ancestors( get_queried_object_id() ) );
		foreach ( $ancestors as $ancestor_id ) {
			echo '<span class="orvio-crumb__sep">/</span><a href="' . esc_url( get_permalink( $ancestor_id ) ) . '">' . esc_html( get_the_title( $ancestor_id ) ) . '</a>';
		}
	} elseif ( is_single() ) {
		$posts_page = absint( get_option( 'page_for_posts' ) );
		if ( $posts_page ) {
			echo '<span class="orvio-crumb__sep">/</span><a href="' . esc_url( get_permalink( $posts_page ) ) . '">' . esc_html( get_the_title( $posts_page ) ) . '</a>';
		} elseif ( function_exists( 'get_the_category' ) ) {
			$categories = get_the_category();
			if ( ! empty( $categories ) && ! is_wp_error( $categories[0] ) ) {
				echo '<span class="orvio-crumb__sep">/</span><a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
			}
		}
	}

	echo '</nav>';
}

/**
 * Allow only one page heading block per request.
 *
 * WooCommerce can render an inner template inside a page template; the guard
 * keeps a second breadcrumb/title block from being printed in that situation.
 */
function orvio_pagehead_once() {
	static $rendered = false;
	if ( $rendered ) {
		return false;
	}
	$rendered = true;
	return true;
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
