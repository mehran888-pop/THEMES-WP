<?php
/**
 * Assets.
 *
 * @package Orvio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', 'orvio_enqueue', 20 );
function orvio_enqueue() {
	$css = ORVIO_DIR . '/assets/css/main.css';
	$js  = ORVIO_DIR . '/assets/js/theme.js';
	$deps = array();
	if ( wp_style_is( 'woocommerce-general', 'registered' ) ) {
		$deps[] = 'woocommerce-general';
	}
	wp_enqueue_style( 'orvio', ORVIO_URI . '/assets/css/main.css', $deps, file_exists( $css ) ? filemtime( $css ) : ORVIO_VERSION );
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
	if ( false === strpos( (string) $hook, 'orvio' ) ) {
		return;
	}
	wp_enqueue_style( 'orvio-admin', ORVIO_URI . '/assets/css/admin.css', array(), ORVIO_VERSION );
	wp_enqueue_script( 'orvio-admin', ORVIO_URI . '/assets/js/admin.js', array(), ORVIO_VERSION, true );
}

add_action( 'wp_head', 'orvio_button_overrides', 100 );
function orvio_button_overrides() {
	$style = orvio_opt( 'atc_style', 'pill' );
	$radius = 'pill' === $style ? '999px' : ( 'soft' === $style ? '14px' : '12px' );
	$bg     = 'outline' === $style ? 'transparent' : ( 'soft' === $style ? 'var(--accent-soft,#f3e4dc)' : 'var(--accent)' );
	$color  = 'outline' === $style || 'soft' === $style ? 'var(--ink)' : '#fff';
	$border = 'outline' === $style ? '1.5px solid var(--ink)' : '0';
	$width  = 'block' === $style ? '100%' : 'auto';
	$flex   = 'block' === $style ? '1 1 100%' : '1 1 auto';
	$hover  = 'outline' === $style ? 'background:var(--ink)!important;color:#fff!important' : ( 'soft' === $style ? 'background:var(--accent)!important;color:#fff!important' : 'background:var(--ink)!important;color:#fff!important' );
	echo '<style id="orvio-atc">.woocommerce div.product form.cart,.woocommerce div.product form.cart .woocommerce-variation-add-to-cart,.woocommerce div.product form.cart .orvio-buy{display:flex;flex-wrap:wrap;align-items:center;gap:10px}.woocommerce div.product form.cart .variations,.woocommerce div.product form.cart table.variations,.woocommerce div.product form.cart .single_variation_wrap{flex:1 1 100%;width:100%}.woocommerce div.product form.cart .quantity,.woocommerce div.product form.cart .orvio-qty{float:none!important;margin:0!important}.woocommerce div.product .single_add_to_cart_button,.woocommerce div.product form.cart button.button.alt,.woocommerce div.product form.cart .orvio-btn--primary{float:none!important;flex:' . $flex . '!important;display:inline-flex!important;align-items:center;justify-content:center;box-sizing:border-box;width:' . $width . '!important;max-width:100%;min-width:0;min-height:48px!important;height:auto!important;padding:12px 18px!important;border:' . $border . '!important;border-radius:' . $radius . '!important;background:' . $bg . '!important;color:' . $color . '!important;font-weight:700!important;font-size:14px!important;line-height:1.35!important;white-space:normal!important;text-align:center;box-shadow:none!important;text-shadow:none!important;overflow:visible}.woocommerce div.product .single_add_to_cart_button:hover{' . $hover . '}.woocommerce div.product .single_add_to_cart_button.disabled,.woocommerce div.product .single_add_to_cart_button:disabled{opacity:.45!important}</style>';
}

add_filter( 'woocommerce_enqueue_styles', 'orvio_dequeue_wc_styles' );
function orvio_dequeue_wc_styles( $styles ) {
	unset( $styles['woocommerce-layout'], $styles['woocommerce-smallscreen'] );
	return $styles;
}
