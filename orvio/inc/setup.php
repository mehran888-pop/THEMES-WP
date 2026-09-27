<?php
/**
 * Theme setup.
 *
 * @package Orvio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_setup_theme', 'orvio_setup' );
function orvio_setup() {
	load_theme_textdomain( 'orvio', ORVIO_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_filter( 'get_custom_logo', function ( $html ) {
		return str_replace( 'custom-logo-link', 'custom-logo-link orvio-logo', $html );
	} );

	add_theme_support( 'custom-logo', array(
		'height'      => 80,
		'width'       => 240,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/main.css' );

	add_image_size( 'orvio-card', 800, 800, true );
	add_image_size( 'orvio-banner', 1600, 900, true );

	register_nav_menus( array(
		'primary' => orvio_t( 'Category menu', 'منوی دسته‌ها' ),
		'footer'  => orvio_t( 'Footer menu', 'منوی فوتر' ),
		'mobile'  => orvio_t( 'Mobile menu', 'منوی موبایل' ),
	) );

	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 800,
		'single_image_width'    => 900,
		'product_grid'          => array(
			'default_rows'    => 4,
			'min_rows'        => 1,
			'max_rows'        => 8,
			'default_columns' => 3,
			'min_columns'     => 2,
			'max_columns'     => 5,
		),
	) );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}

add_action( 'widgets_init', 'orvio_widgets' );
function orvio_widgets() {
	register_sidebar( array(
		'name'          => orvio_t( 'Shop filters', 'فیلتر فروشگاه' ),
		'id'            => 'shop-filters',
		'before_widget' => '<section class="orvio-filter %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<strong>',
		'after_title'   => '</strong>',
	) );
	for ( $i = 1; $i <= 3; $i++ ) {
		register_sidebar( array(
			'name'          => sprintf( orvio_t( 'Footer %d', 'فوتر %d' ), $i ),
			'id'            => 'footer-' . $i,
			'before_widget' => '<div class="orvio-footer-widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		) );
	}
}

add_action( 'admin_notices', 'orvio_dependency_notice' );
function orvio_dependency_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( $screen && 'toplevel_page_orvio-settings' === $screen->id ) {
		return;
	}
	if ( ! class_exists( 'WooCommerce' ) ) {
		echo '<div class="notice notice-warning"><p>' . esc_html( orvio_t( 'Orvio is ready. Install and activate WooCommerce for the shop, cart, checkout and account.', 'اُرویو آماده است. برای فروشگاه، سبد، صورتحساب و حساب کاربری، ووکامرس را فعال کنید.' ) ) . '</p></div>';
	}
	if ( ! did_action( 'elementor/loaded' ) ) {
		echo '<div class="notice notice-info"><p>' . esc_html( orvio_t( 'Install Elementor to use Orvio widgets: products, banners, header cart, category menu, about and contact.', 'برای ویجت‌های اختصاصی اُرویو (کالا، بنر، سبد هدر، منوی دسته، درباره ما و تماس) المنتور را نصب کنید.' ) ) . '</p></div>';
	}
}
