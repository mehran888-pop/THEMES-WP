<?php
/**
 * Theme settings.
 *
 * @package Orvio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * English string with a Persian fallback on RTL / fa locales.
 * A loaded translation always wins.
 */
function orvio_t( $en, $fa = '' ) {
	$translated = __( $en, 'orvio' );
	if ( $translated !== $en ) {
		return $translated;
	}
	$locale = function_exists( 'determine_locale' ) ? determine_locale() : get_locale();
	if ( $fa && ( is_rtl() || 0 === strpos( $locale, 'fa' ) ) ) {
		return $fa;
	}
	return $en;
}

function orvio_mobile_nav_defaults() {
	return array(
		'item_1' => array( 'enabled' => 1, 'order' => 1, 'type' => 'home',       'label' => orvio_t( 'Home', 'خانه' ),       'icon' => 'home',  'url' => '' ),
		'item_2' => array( 'enabled' => 1, 'order' => 2, 'type' => 'categories', 'label' => orvio_t( 'Categories', 'دسته‌ها' ), 'icon' => 'grid',  'url' => '' ),
		'item_3' => array( 'enabled' => 1, 'order' => 3, 'type' => 'shop',       'label' => orvio_t( 'Shop', 'فروشگاه' ),     'icon' => 'store', 'url' => '' ),
		'item_4' => array( 'enabled' => 1, 'order' => 4, 'type' => 'cart',       'label' => orvio_t( 'Bag', 'سبد' ),          'icon' => 'bag',   'url' => '' ),
		'item_5' => array( 'enabled' => 1, 'order' => 5, 'type' => 'account',    'label' => orvio_t( 'Account', 'حساب' ),     'icon' => 'user',  'url' => '' ),
	);
}

function orvio_defaults() {
	return array(
		'accent'             => '#A34B2B',
		'bg'                 => '#F3EFE8',
		'ink'                => '#1C1916',
		'dark'               => '#171512',
		'bg_2'               => '#E8E1D6',
		'surface'            => '#FFFCF8',
		'muted'              => '#6E665E',
		'faint'              => '#8C837A',
		'line'               => '#E5DDD3',
		'line_strong'        => '#D5CCC0',
		'accent_dark'        => '#843C22',
		'accent_soft'        => '#F6E6DC',
		'forest'             => '#234237',
		'sale'               => '#9C2F2F',
		'star'               => '#A7843C',
		'dark_2'             => '#241F1B',
		'ok'                 => '#1C6B45',
		'warn'               => '#8A6412',
		'info'               => '#1E4E6B',
		'button_bg'          => '#A34B2B',
		'button_text'        => '#FFFFFF',
		'button_hover'       => '#843C22',
		'button_hover_text'  => '#FFFFFF',
		'focus_color'        => '#A34B2B',
		'selection_bg'       => '#E8CDBE',
		'global_shadow'      => 'soft',
		'global_transition'  => 220,
		'global_control_height' => 46,
		'global_section_spacing' => 48,
		'radius'             => 16,
		'container'          => 1220,
		'site_layout'        => 'wide',
		'atc_style'          => 'pill',
		'atc_behavior'       => 'auto',
		'atc_visual'         => 'text',
		'body_font'          => 'vazirmatn',
		'heading_font'       => 'vazirmatn',
		'site_style'         => 'editorial',
		'font_size'          => 15,
		'header_layout'      => 'classic',
		'footer_layout'      => 'classic',
		'header_account_style' => 'minimal',
		'header_cart_style'    => 'pill',
		'header_bg'          => '#FFFCF8',
		'header_ink'         => '#1C1916',
		'menu_size'          => 14,
		'sticky_header'      => 1,
		'show_search'        => 1,
		'show_account'       => 1,
		'show_cart'          => 1,
		'show_catbar'        => 1,
		'show_announcement'  => 1,
		'show_pagehead'      => 1,
		'show_woocommerce_breadcrumb' => 1,
		'announcement'       => 'ارسال رایگان برای سفارش‌های بالای ۲ میلیون تومان  ·  بازگشت آسان تا ۳۰ روز',
		'announcement_en'    => 'Free shipping over the threshold · Easy 30-day returns',
		'free_shipping'      => 2000000,
		'cart_type'          => 'drawer',
		'cart_drawer_side'       => 'right',
		'cart_drawer_style'      => 'saas',
		'cart_drawer_font'       => 'vazirmatn',
		'cart_drawer_overlay'    => 'dim',
		'cart_drawer_width'      => 420,
		'cart_drawer_font_size'  => 14,
		'cart_drawer_item_spacing' => 12,
		'cart_drawer_radius'     => 20,
		'cart_drawer_background' => '',
		'cart_drawer_text'       => '',
		'cart_drawer_accent'     => '',
		'cart_drawer_border'     => '',
		'mobile_nav_enabled'       => 1,
		'mobile_nav_style'         => 'bar',
		'mobile_nav_background'    => '',
		'mobile_nav_text'          => '',
		'mobile_nav_border'        => '',
		'mobile_nav_active'        => '',
		'mobile_nav_active_bg'     => '',
		'mobile_nav_shadow'        => '',
		'mobile_nav_radius'        => '',
		'mobile_nav_spacing'       => '',
		'mobile_nav_height'        => '',
		'mobile_nav_icon_size'     => '',
		'mobile_nav_active_style'  => 'soft',
		'mobile_nav_items'         => orvio_mobile_nav_defaults(),
		'shop_columns'           => 3,
		'shop_columns_desktop'   => 3,
		'shop_columns_mobile'    => 2,
		'products_per_page'      => 12,
		'shop_layout'        => 'sidebar-grid',
		'card_style'         => 'classic',
		'card_content'       => 'below',
		'shop_sidebar'       => 1,
		'product_layout'     => 'classic',
		'product_body_font'  => 'vazirmatn',
		'product_heading_font' => 'vazirmatn',
		'product_body_size'  => 15,
		'product_title_size' => 52,
		'product_price_size' => 30,
		'product_button_size' => 14,
		'product_content_width' => 1220,
		'product_width_mode' => 'inherit',
		'product_summary_width' => 46,
		'product_gap'        => 48,
		'product_radius'     => 24,
		'product_gallery_ratio' => 'square',
		'product_image_fit'  => 'cover',
		'product_tabs_style' => 'card',
		'product_text_color' => '#5D5852',
		'product_heading_color' => '#1C1916',
		'product_accent_color' => '#A34B2B',
		'product_price_color' => '#1C1916',
		'product_button_bg'  => '#1C1916',
		'product_button_hover' => '#A34B2B',
		'product_button_text' => '#FFFFFF',
		'product_sale_color' => '#A34B2B',
		'product_sale_bg'   => '#F4E6DE',
		'product_stock_color' => '#35624B',
		'product_muted_color' => '#807A72',
		'product_border_color' => '#DED7CD',
		'product_gallery_bg' => '#EEE7DE',
		'product_surface_color' => '#FFFCF8',
		'product_tab_bg'    => '#FFFCF8',
		'product_perk_bg'   => '#FFFCF8',
		'product_show_eyebrow' => 1,
		'product_show_sku'  => 1,
		'product_show_rating' => 1,
		'product_show_excerpt' => 1,
		'product_show_perks' => 1,
		'product_show_meta' => 1,
		'product_show_share' => 1,
		'product_show_gallery_note' => 1,
		'product_show_tabs'  => 1,
		'product_show_upsells' => 1,
		'product_show_related' => 1,
		'product_sticky_mobile' => 1,
		'related_count'      => 4,
		'sticky_summary'     => 1,
		'cart_layout'        => 'saas-split',
		'cart_style'         => 'saas',
		'checkout_layout'    => 'split',
		'account_layout'     => 'saas',
		'account_style'      => 'saas',
		'billing_fields'     => array(
			'billing_first_name' => 'required',
			'billing_last_name'  => 'required',
			'billing_company'    => 'optional',
			'billing_country'    => 'required',
			'billing_address_1'  => 'required',
			'billing_address_2'  => 'optional',
			'billing_city'       => 'required',
			'billing_state'      => 'optional',
			'billing_postcode'   => 'optional',
			'billing_phone'      => 'optional',
			'billing_email'      => 'required',
		),
		'phone'              => '021-91000042',
		'email'              => 'hello@orvio.shop',
		'address'            => 'تهران، خیابان طراحی، پلاک ۱۲',
		'hours'              => 'شنبه تا پنجشنبه، ۱۰ تا ۱۸',
		'footer_about'       => 'ویترینی از اشیاء روزمره؛ انتخاب‌شده برای دوام، سکوت و زیبایی بی‌هیاهو.',
		'copyright'          => '© Orvio',
		'instagram'          => '',
		'telegram'           => '',
		'whatsapp'           => '',
		'enable_wishlist'    => 1,
		'enable_quick_view'  => 1,
	);
}

function orvio_settings() {
	$saved = get_option( 'orvio_settings', array() );
	if ( ! is_array( $saved ) ) {
		$saved = array();
	}
	$settings = wp_parse_args( $saved, orvio_defaults() );
	/* Migrate the original single shop column setting to the desktop value. */
	if ( ! array_key_exists( 'shop_columns_desktop', $saved ) && isset( $saved['shop_columns'] ) ) {
		$settings['shop_columns_desktop'] = max( 2, min( 6, absint( $saved['shop_columns'] ) ) );
	}
	if ( ! array_key_exists( 'shop_columns_mobile', $saved ) ) {
		$settings['shop_columns_mobile'] = 2;
	}
	return $settings;
}

function orvio_opt( $key, $fallback = null ) {
	$settings = orvio_settings();
	if ( array_key_exists( $key, $settings ) && '' !== $settings[ $key ] ) {
		return $settings[ $key ];
	}
	return null === $fallback ? ( $settings[ $key ] ?? '' ) : $fallback;
}

function orvio_sanitize_settings( $input ) {
	$defaults = orvio_defaults();
	$clean    = array();
	$hex      = array( 'accent', 'bg', 'ink', 'dark', 'bg_2', 'surface', 'muted', 'faint', 'line', 'line_strong', 'accent_dark', 'accent_soft', 'forest', 'sale', 'star', 'dark_2', 'ok', 'warn', 'info', 'button_bg', 'button_text', 'button_hover', 'button_hover_text', 'focus_color', 'selection_bg', 'header_bg', 'header_ink' );
	foreach ( $hex as $key ) {
		$clean[ $key ] = sanitize_hex_color( $input[ $key ] ?? '' ) ?: $defaults[ $key ];
	}
	$clean['radius']            = max( 0, min( 28, absint( $input['radius'] ?? $defaults['radius'] ) ) );
	$clean['container']         = max( 960, min( 1680, absint( $input['container'] ?? $defaults['container'] ) ) );
	$clean['font_size']         = max( 13, min( 20, absint( $input['font_size'] ?? $defaults['font_size'] ) ) );
	$clean['menu_size']         = max( 12, min( 20, absint( $input['menu_size'] ?? $defaults['menu_size'] ) ) );
	$clean['global_control_height'] = max( 36, min( 68, absint( $input['global_control_height'] ?? $defaults['global_control_height'] ) ) );
	$clean['global_section_spacing'] = max( 16, min( 120, absint( $input['global_section_spacing'] ?? $defaults['global_section_spacing'] ) ) );
	$clean['global_transition'] = max( 80, min( 600, absint( $input['global_transition'] ?? $defaults['global_transition'] ) ) );
	$clean['global_shadow'] = in_array( $input['global_shadow'] ?? '', array( 'none', 'soft', 'medium', 'strong' ), true ) ? $input['global_shadow'] : 'soft';
	$fonts                      = array( 'vazirmatn', 'instrument', 'fraunces', 'system' );
	$clean['body_font']         = in_array( $input['body_font'] ?? '', $fonts, true ) ? $input['body_font'] : 'vazirmatn';
	$clean['heading_font']      = in_array( $input['heading_font'] ?? '', $fonts, true ) ? $input['heading_font'] : 'vazirmatn';
	$clean['site_style']        = in_array( $input['site_style'] ?? '', array( 'editorial', 'saas' ), true ) ? $input['site_style'] : 'editorial';
	$header_layouts              = array( 'classic', 'centered', 'split', 'minimal' );
	$clean['header_layout']       = in_array( $input['header_layout'] ?? '', $header_layouts, true ) ? $input['header_layout'] : 'classic';
	$footer_layouts              = array( 'classic', 'centered', 'minimal', 'editorial' );
	$clean['footer_layout']       = in_array( $input['footer_layout'] ?? '', $footer_layouts, true ) ? $input['footer_layout'] : 'classic';
	$header_button_styles         = array( 'minimal', 'pill', 'solid', 'outline', 'soft' );
	$clean['header_account_style'] = in_array( $input['header_account_style'] ?? '', $header_button_styles, true ) ? $input['header_account_style'] : 'minimal';
	$clean['header_cart_style']    = in_array( $input['header_cart_style'] ?? '', $header_button_styles, true ) ? $input['header_cart_style'] : 'pill';
	$clean['site_layout']          = in_array( $input['site_layout'] ?? '', array( 'wide', 'boxed', 'content-wide' ), true ) ? $input['site_layout'] : 'wide';
	$clean['atc_style']            = in_array( $input['atc_style'] ?? '', array( 'pill', 'block', 'outline', 'soft' ), true ) ? $input['atc_style'] : 'pill';
	$atc_behaviors                = array( 'auto', 'ajax-stay', 'cart', 'checkout' );
	$clean['atc_behavior']         = in_array( $input['atc_behavior'] ?? '', $atc_behaviors, true ) ? $input['atc_behavior'] : 'auto';
	$atc_visuals                  = array( 'text', 'icon', 'hover', 'tile', 'icon-only' );
	$clean['atc_visual']           = in_array( $input['atc_visual'] ?? '', $atc_visuals, true ) ? $input['atc_visual'] : 'text';
	$clean['cart_type']            = in_array( $input['cart_type'] ?? '', array( 'drawer', 'page' ), true ) ? $input['cart_type'] : 'drawer';
	$drawer_sides                 = array( 'left', 'right' );
	$drawer_styles                = array( 'saas', 'soft', 'dark', 'minimal' );
	$drawer_overlays              = array( 'dim', 'soft', 'strong', 'none' );
	$drawer_fonts                 = array( 'vazirmatn', 'instrument', 'fraunces', 'system' );
	$clean['cart_drawer_side']    = in_array( $input['cart_drawer_side'] ?? '', $drawer_sides, true ) ? $input['cart_drawer_side'] : 'right';
	$clean['cart_drawer_style']   = in_array( $input['cart_drawer_style'] ?? '', $drawer_styles, true ) ? $input['cart_drawer_style'] : 'saas';
	$clean['cart_drawer_font']    = in_array( $input['cart_drawer_font'] ?? '', $drawer_fonts, true ) ? $input['cart_drawer_font'] : 'vazirmatn';
	$clean['cart_drawer_overlay'] = in_array( $input['cart_drawer_overlay'] ?? '', $drawer_overlays, true ) ? $input['cart_drawer_overlay'] : 'dim';
	$clean['cart_drawer_width']   = max( 300, min( 620, absint( $input['cart_drawer_width'] ?? 420 ) ) );
	$clean['cart_drawer_font_size'] = max( 12, min( 20, absint( $input['cart_drawer_font_size'] ?? 14 ) ) );
	$clean['cart_drawer_item_spacing'] = max( 4, min( 32, absint( $input['cart_drawer_item_spacing'] ?? 12 ) ) );
	$clean['cart_drawer_radius']  = max( 0, min( 32, absint( $input['cart_drawer_radius'] ?? 20 ) ) );
	foreach ( array( 'cart_drawer_background', 'cart_drawer_text', 'cart_drawer_accent', 'cart_drawer_border' ) as $drawer_color ) {
		$clean[ $drawer_color ] = sanitize_hex_color( $input[ $drawer_color ] ?? '' ) ?: '';
	}
	$mobile_nav_styles          = array( 'bar', 'floating', 'pill', 'glass', 'dark', 'minimal' );
	$clean['mobile_nav_style']  = in_array( $input['mobile_nav_style'] ?? '', $mobile_nav_styles, true ) ? $input['mobile_nav_style'] : 'bar';
	$mobile_optional_colors     = array( 'mobile_nav_background', 'mobile_nav_text', 'mobile_nav_border', 'mobile_nav_active', 'mobile_nav_active_bg' );
	foreach ( $mobile_optional_colors as $key ) {
		$color        = sanitize_hex_color( $input[ $key ] ?? '' );
		$clean[ $key ] = $color ? $color : '';
	}
	$mobile_shadows             = array( '', 'soft', 'strong', 'none' );
	$clean['mobile_nav_shadow'] = in_array( $input['mobile_nav_shadow'] ?? '', $mobile_shadows, true ) ? $input['mobile_nav_shadow'] : '';
	$mobile_active_styles       = array( 'soft', 'solid', 'underline', 'dot' );
	$clean['mobile_nav_active_style'] = in_array( $input['mobile_nav_active_style'] ?? '', $mobile_active_styles, true ) ? $input['mobile_nav_active_style'] : 'soft';
	foreach ( array( 'mobile_nav_radius', 'mobile_nav_spacing', 'mobile_nav_height', 'mobile_nav_icon_size' ) as $key ) {
		$clean[ $key ] = '' === ( $input[ $key ] ?? '' ) ? '' : absint( $input[ $key ] );
	}
	$clean['mobile_nav_radius']    = '' === $clean['mobile_nav_radius'] ? '' : min( 40, $clean['mobile_nav_radius'] );
	$clean['mobile_nav_spacing']   = '' === $clean['mobile_nav_spacing'] ? '' : min( 20, $clean['mobile_nav_spacing'] );
	$clean['mobile_nav_height']    = '' === $clean['mobile_nav_height'] ? '' : max( 42, min( 96, $clean['mobile_nav_height'] ) );
	$clean['mobile_nav_icon_size'] = '' === $clean['mobile_nav_icon_size'] ? '' : max( 16, min( 32, $clean['mobile_nav_icon_size'] ) );
	$mobile_types               = array_keys( orvio_mobile_nav_type_choices() );
	$mobile_icons               = array_keys( orvio_mobile_nav_icon_choices() );
	$mobile_defaults            = orvio_mobile_nav_defaults();
	$clean['mobile_nav_items']  = array();
	foreach ( $mobile_defaults as $slot => $default ) {
		$raw = isset( $input['mobile_nav_items'][ $slot ] ) && is_array( $input['mobile_nav_items'][ $slot ] ) ? $input['mobile_nav_items'][ $slot ] : array();
		$clean['mobile_nav_items'][ $slot ] = array(
			'enabled' => empty( $raw['enabled'] ) ? 0 : 1,
			'order'   => max( 1, min( count( $mobile_defaults ), absint( $raw['order'] ?? $default['order'] ) ) ),
			'type'    => in_array( $raw['type'] ?? '', $mobile_types, true ) ? $raw['type'] : $default['type'],
			'label'   => ! empty( $raw['label'] ) ? sanitize_text_field( $raw['label'] ) : $default['label'],
			'icon'    => in_array( $raw['icon'] ?? '', $mobile_icons, true ) ? $raw['icon'] : $default['icon'],
			'url'     => esc_url_raw( $raw['url'] ?? '' ),
		);
	}
	$shop_layouts                 = array( 'sidebar-grid', 'wide-grid', 'list', 'masonry', 'minimal' );
	$product_layouts              = array( 'classic', 'gallery-right', 'stacked', 'immersive' );
	$page_layouts                 = array( 'split', 'classic', 'compact', 'focus', 'minimal' );
	$clean['shop_layout']         = in_array( $input['shop_layout'] ?? '', $shop_layouts, true ) ? $input['shop_layout'] : 'sidebar-grid';
	$clean['product_layout']      = in_array( $input['product_layout'] ?? '', $product_layouts, true ) ? $input['product_layout'] : 'classic';
	$product_fonts                = array( 'vazirmatn', 'instrument', 'fraunces', 'system' );
	$clean['product_body_font']   = in_array( $input['product_body_font'] ?? '', $product_fonts, true ) ? $input['product_body_font'] : 'vazirmatn';
	$clean['product_heading_font'] = in_array( $input['product_heading_font'] ?? '', $product_fonts, true ) ? $input['product_heading_font'] : 'vazirmatn';
	$clean['product_body_size']   = max( 12, min( 20, absint( $input['product_body_size'] ?? 15 ) ) );
	$clean['product_title_size']  = max( 30, min( 80, absint( $input['product_title_size'] ?? 52 ) ) );
	$clean['product_price_size']  = max( 18, min( 48, absint( $input['product_price_size'] ?? 30 ) ) );
	$clean['product_button_size'] = max( 11, min( 20, absint( $input['product_button_size'] ?? 14 ) ) );
	$clean['product_content_width'] = max( 900, min( 1680, absint( $input['product_content_width'] ?? 1220 ) ) );
	$product_width_modes = array( 'inherit', 'wide', 'extra-wide', 'boxed', 'content-wide' );
	$clean['product_width_mode'] = in_array( $input['product_width_mode'] ?? '', $product_width_modes, true ) ? $input['product_width_mode'] : 'inherit';
	$clean['product_summary_width'] = max( 36, min( 58, absint( $input['product_summary_width'] ?? 46 ) ) );
	$clean['product_gap']         = max( 12, min( 96, absint( $input['product_gap'] ?? 48 ) ) );
	$clean['product_radius']      = max( 0, min( 44, absint( $input['product_radius'] ?? 24 ) ) );
	$product_ratios              = array( 'square', 'portrait', 'landscape' );
	$clean['product_gallery_ratio'] = in_array( $input['product_gallery_ratio'] ?? '', $product_ratios, true ) ? $input['product_gallery_ratio'] : 'square';
	$clean['product_image_fit']   = in_array( $input['product_image_fit'] ?? '', array( 'cover', 'contain' ), true ) ? $input['product_image_fit'] : 'cover';
	$clean['product_tabs_style']  = in_array( $input['product_tabs_style'] ?? '', array( 'card', 'underline', 'minimal' ), true ) ? $input['product_tabs_style'] : 'card';
	foreach ( array( 'product_text_color', 'product_heading_color', 'product_accent_color', 'product_price_color', 'product_button_bg', 'product_button_hover', 'product_button_text', 'product_sale_color', 'product_sale_bg', 'product_stock_color', 'product_muted_color', 'product_border_color', 'product_gallery_bg', 'product_surface_color', 'product_tab_bg', 'product_perk_bg' ) as $product_color ) {
		$clean[ $product_color ] = sanitize_hex_color( $input[ $product_color ] ?? '' ) ?: $defaults[ $product_color ];
	}
	$product_toggles = array( 'product_show_eyebrow', 'product_show_sku', 'product_show_rating', 'product_show_excerpt', 'product_show_perks', 'product_show_meta', 'product_show_share', 'product_show_gallery_note', 'product_show_tabs', 'product_show_upsells', 'product_show_related', 'product_sticky_mobile' );
	foreach ( $product_toggles as $product_toggle ) {
		$clean[ $product_toggle ] = empty( $input[ $product_toggle ] ) ? 0 : 1;
	}
	$cart_layouts                = array( 'saas-split', 'saas-focus', 'saas-compact', 'saas-bento' );
	$clean['cart_layout']         = in_array( $input['cart_layout'] ?? '', $cart_layouts, true ) ? $input['cart_layout'] : 'saas-split';
	$clean['cart_style']          = 'saas';
	$clean['checkout_layout']     = in_array( $input['checkout_layout'] ?? '', $page_layouts, true ) ? $input['checkout_layout'] : 'split';
	$account_layouts              = array( 'saas' );
	$clean['account_layout']      = in_array( $input['account_layout'] ?? '', $account_layouts, true ) ? $input['account_layout'] : 'saas';
	$account_styles               = array( 'saas' );
	$clean['account_style']       = in_array( $input['account_style'] ?? '', $account_styles, true ) ? $input['account_style'] : 'saas';
	$card_styles                  = array( 'classic', 'minimal', 'overlay', 'editorial', 'deal', 'polaroid', 'magazine' );
	$clean['card_style']           = in_array( $input['card_style'] ?? '', $card_styles, true ) ? $input['card_style'] : 'classic';
	$card_contents                = array( 'below', 'tile', 'hover-info', 'hover-overlay' );
	$clean['card_content']         = in_array( $input['card_content'] ?? '', $card_contents, true ) ? $input['card_content'] : 'below';
	$desktop_columns = absint( $input['shop_columns_desktop'] ?? ( $input['shop_columns'] ?? 3 ) );
	$mobile_columns  = absint( $input['shop_columns_mobile'] ?? 2 );
	$clean['shop_columns_desktop'] = max( 2, min( 6, $desktop_columns ) );
	$clean['shop_columns_mobile']  = max( 1, min( 4, $mobile_columns ) );
	/* Keep the original key as a backward-compatible desktop alias. */
	$clean['shop_columns']      = $clean['shop_columns_desktop'];
	$clean['products_per_page'] = max( 4, min( 48, absint( $input['products_per_page'] ?? 12 ) ) );
	$clean['related_count']     = max( 2, min( 8, absint( $input['related_count'] ?? 4 ) ) );
	$clean['free_shipping']     = max( 0, absint( $input['free_shipping'] ?? 0 ) );
	$billing_defaults             = orvio_defaults()['billing_fields'];
	$clean['billing_fields']      = array();
	$billing_modes                = array( 'required', 'optional', 'hidden' );
	foreach ( $billing_defaults as $field => $default_mode ) {
		$mode = $input['billing_fields'][ $field ] ?? $default_mode;
		$clean['billing_fields'][ $field ] = in_array( $mode, $billing_modes, true ) ? $mode : $default_mode;
	}
	$toggles                    = array( 'sticky_header', 'mobile_nav_enabled', 'show_announcement', 'show_pagehead', 'show_woocommerce_breadcrumb', 'shop_sidebar', 'sticky_summary', 'enable_wishlist', 'enable_quick_view', 'show_search', 'show_account', 'show_cart', 'show_catbar' );
	foreach ( $toggles as $key ) {
		$clean[ $key ] = empty( $input[ $key ] ) ? 0 : 1;
	}
	$text = array( 'announcement', 'announcement_en', 'phone', 'email', 'address', 'hours', 'footer_about', 'copyright', 'instagram', 'telegram', 'whatsapp' );
	foreach ( $text as $key ) {
		$clean[ $key ] = sanitize_text_field( $input[ $key ] ?? '' );
	}
	$clean['email'] = sanitize_email( $clean['email'] );
	return $clean;
}

add_action( 'admin_menu', 'orvio_register_menu' );
function orvio_register_menu() {
	add_menu_page(
		'Orvio',
		'Orvio',
		'manage_options',
		'orvio-settings',
		'orvio_render_settings_page',
		'dashicons-store',
		58
	);
}

add_action( 'admin_init', 'orvio_register_setting' );
function orvio_register_setting() {
	register_setting(
		'orvio_settings_group',
		'orvio_settings',
		array(
			'sanitize_callback' => 'orvio_sanitize_settings',
			'default'           => orvio_defaults(),
		)
	);
}

function orvio_render_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$o = orvio_settings();
	$cart_choices = orvio_cart_layout_choices();
	if ( ! isset( $cart_choices[ $o['cart_layout'] ?? '' ] ) ) {
		$o['cart_layout'] = 'saas-split';
	}
	$o['cart_style'] = 'saas';
	$tabs = array(
		'general'    => orvio_t( 'Design', 'طراحی' ),
		'header'     => orvio_t( 'Header', 'هدر' ),
		'mobile-nav' => orvio_t( 'Mobile navigation', 'ناوبری موبایل' ),
		'footer'     => orvio_t( 'Footer', 'فوتر' ),
		'shop'     => orvio_t( 'Shop', 'فروشگاه' ),
		'product'  => orvio_t( 'Product', 'محصول' ),
		'cart'     => orvio_t( 'Cart', 'سبد خرید' ),
		'checkout' => orvio_t( 'Checkout', 'صورتحساب' ),
		'account'  => orvio_t( 'Account', 'حساب کاربری' ),
		'contact'  => orvio_t( 'Contact', 'ارتباط' ),
		'home'     => orvio_t( 'Homepage', 'صفحه اول' ),
	);
	$front_id = (int) get_option( 'page_on_front' );
	$is_el    = $front_id && function_exists( 'orvio_is_elementor' ) && orvio_is_elementor( $front_id );
	$edit_url = ( $is_el && class_exists( '\Elementor\Plugin' ) ) ? admin_url( 'post.php?post=' . $front_id . '&action=elementor' ) : '';
	?>
	<div id="orvio-app">
		<aside class="orvio-side">
			<div class="orvio-brand"><strong>ORVIO</strong><span><?php echo esc_html( orvio_t( 'Theme settings', 'تنظیمات قالب' ) ); ?></span></div>
			<nav class="orvio-nav">
				<?php foreach ( $tabs as $id => $label ) : ?>
					<button type="button" data-tab="<?php echo esc_attr( $id ); ?>" class="<?php echo 'general' === $id ? 'is-on' : ''; ?>"><?php echo esc_html( $label ); ?></button>
				<?php endforeach; ?>
			</nav>
			<p class="orvio-side__note"><?php echo esc_html( orvio_t( 'Changes apply as CSS variables. Elementor widgets keep their own style tab.', 'تغییرها به‌صورت متغیر CSS اعمال می‌شود. استایل هر المان در تب استایل المنتور است.' ) ); ?></p>
		</aside>
		<div class="orvio-main">
			<div class="orvio-top">
				<div>
					<h1><?php echo esc_html( orvio_t( 'Theme settings', 'تنظیمات قالب' ) ); ?></h1>
					<p><?php echo esc_html( orvio_t( 'A quiet control room for color, type, header and shop. The homepage is whichever page you choose in WordPress.', 'اتاق فرمان رنگ، فونت، هدر و فروشگاه. صفحه اصلی همان برگه‌ای است که در وردپرس انتخاب می‌کنید.' ) ); ?></p>
				</div>
			</div>
			<?php if ( isset( $_GET['orvio-imported'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
				<div class="notice notice-success" style="margin:0 28px"><p><?php echo esc_html( orvio_t( 'Demo catalog installed.', 'کاتالوگ دمو نصب شد.' ) ); ?></p></div>
			<?php endif; ?>
			<?php if ( isset( $_GET['orvio-front'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
				<div class="notice notice-success" style="margin:0 28px"><p><?php echo esc_html( orvio_t( 'Homepage built with Elementor.', 'صفحه اول با المنتور ساخته شد.' ) ); ?></p></div>
			<?php endif; ?>
			<?php if ( isset( $_GET['orvio-front-error'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
				<div class="notice notice-error" style="margin:0 28px"><p><?php echo esc_html( orvio_t( 'Elementor is not active, so the homepage could not be built.', 'المنتور فعال نیست و صفحه اول ساخته نشد.' ) ); ?></p></div>
			<?php endif; ?>
			<form method="post" action="options.php">
				<?php settings_fields( 'orvio_settings_group' ); ?>
				<section data-panel="general" class="orvio-panel is-on">
					<div class="orvio-card"><h2><?php echo esc_html( orvio_t( 'Color', 'رنگ' ) ); ?></h2>
						<?php
						orvio_field_color( 'accent', orvio_t( 'Accent', 'رنگ تأکید' ), $o );
						orvio_field_color( 'bg', orvio_t( 'Background', 'پس‌زمینه' ), $o );
						orvio_field_color( 'ink', orvio_t( 'Text', 'متن' ), $o );
						orvio_field_color( 'dark', orvio_t( 'Dark sections', 'بخش‌های تیره' ), $o );
						?>
					</div>
					<div class="orvio-card"><h2><?php echo esc_html( orvio_t( 'Global design tokens', 'توکن‌های سراسری طراحی' ) ); ?></h2>
						<?php
						orvio_field_color( 'surface', orvio_t( 'Surface / cards', 'سطح و کارت‌ها' ), $o );
						orvio_field_color( 'bg_2', orvio_t( 'Secondary background', 'پس‌زمینه دوم' ), $o );
						orvio_field_color( 'muted', orvio_t( 'Muted text', 'متن کم‌رنگ' ), $o );
						orvio_field_color( 'faint', orvio_t( 'Faint text', 'متن خیلی کم‌رنگ' ), $o );
						orvio_field_color( 'line', orvio_t( 'Border', 'حاشیه' ), $o );
						orvio_field_color( 'line_strong', orvio_t( 'Strong border', 'حاشیه قوی' ), $o );
						orvio_field_color( 'accent_dark', orvio_t( 'Accent dark', 'تأکید تیره' ), $o );
						orvio_field_color( 'accent_soft', orvio_t( 'Accent soft', 'تأکید نرم' ), $o );
						orvio_field_color( 'forest', orvio_t( 'Success / forest', 'موفقیت / سبز' ), $o );
						orvio_field_color( 'ok', orvio_t( 'Success semantic', 'رنگ معنایی موفقیت' ), $o );
						orvio_field_color( 'warn', orvio_t( 'Warning semantic', 'رنگ معنایی هشدار' ), $o );
						orvio_field_color( 'info', orvio_t( 'Info semantic', 'رنگ معنایی اطلاعات' ), $o );
						orvio_field_color( 'sale', orvio_t( 'Sale / error', 'تخفیف / خطا' ), $o );
						orvio_field_color( 'star', orvio_t( 'Rating stars', 'ستاره امتیاز' ), $o );
						orvio_field_color( 'button_bg', orvio_t( 'Global button background', 'پس‌زمینه دکمه عمومی' ), $o );
						orvio_field_color( 'button_text', orvio_t( 'Global button text', 'متن دکمه عمومی' ), $o );
						orvio_field_color( 'button_hover', orvio_t( 'Global button hover', 'هاور دکمه عمومی' ), $o );
						orvio_field_color( 'button_hover_text', orvio_t( 'Global button hover text', 'متن هاور دکمه عمومی' ), $o );
						orvio_field_color( 'focus_color', orvio_t( 'Focus outline', 'رنگ فوکوس کیبورد' ), $o );
						orvio_field_color( 'selection_bg', orvio_t( 'Text selection', 'انتخاب متن' ), $o );
						orvio_field_select( 'global_shadow', orvio_t( 'Shadow intensity', 'شدت سایه' ), $o, array( 'none' => orvio_t( 'None', 'بدون سایه' ), 'soft' => orvio_t( 'Soft', 'نرم' ), 'medium' => orvio_t( 'Medium', 'متوسط' ), 'strong' => orvio_t( 'Strong', 'قوی' ) ) );
						orvio_field_number( 'global_control_height', orvio_t( 'Control height (px)', 'ارتفاع کنترل‌ها (پیکسل)' ), $o, 36, 68 );
						orvio_field_number( 'global_section_spacing', orvio_t( 'Section spacing (px)', 'فاصله بخش‌ها (پیکسل)' ), $o, 16, 120 );
						orvio_field_number( 'global_transition', orvio_t( 'Motion speed (ms)', 'سرعت حرکت (میلی‌ثانیه)' ), $o, 80, 600 );
						?>
					</div>
					<div class="orvio-card"><h2><?php echo esc_html( orvio_t( 'Page chrome', 'اجزای بالای محتوا' ) ); ?></h2>
						<?php
						orvio_field_check( 'show_pagehead', orvio_t( 'Orvio page heading', 'سربرگ صفحه Orvio' ), $o );
						orvio_field_check( 'show_woocommerce_breadcrumb', orvio_t( 'WooCommerce breadcrumb', 'بردکرامب ووکامرس' ), $o );
						?>
					</div>
					<div class="orvio-card"><h2><?php echo esc_html( orvio_t( 'Type', 'فونت' ) ); ?></h2>
						<?php
						orvio_field_select( 'body_font', orvio_t( 'Body font', 'فونت متن' ), $o, orvio_font_choices() );
						orvio_field_select( 'heading_font', orvio_t( 'Heading font', 'فونت عنوان' ), $o, orvio_font_choices() );
						orvio_field_select( 'site_style', orvio_t( 'Global visual style', 'استایل بصری کلی' ), $o, array( 'editorial' => orvio_t( 'Orvio editorial', 'ادیتوریال Orvio' ), 'saas' => orvio_t( 'SaaS interface', 'رابط SaaS' ) ) );
						orvio_field_number( 'font_size', orvio_t( 'Base size', 'اندازه پایه' ), $o, 13, 20 );
						orvio_field_number( 'radius', orvio_t( 'Corner radius', 'گردی گوشه‌ها' ), $o, 0, 28 );
						orvio_field_select( 'site_layout', orvio_t( 'Site width', 'عرض سایت' ), $o, array(
							'wide'         => orvio_t( 'Wide', 'عریض' ),
							'boxed'        => orvio_t( 'Boxed', 'جعبه‌ای' ),
							'content-wide' => orvio_t( 'Wide content', 'محتوای عریض' ),
						) );
						orvio_field_number( 'container', orvio_t( 'Box / content width', 'عرض جعبه یا محتوا' ), $o, 960, 1680 );
						?>
					</div>
				</section>
				<section data-panel="header" class="orvio-panel">
					<div class="orvio-card"><h2><?php echo esc_html( orvio_t( 'Layout', 'چیدمان' ) ); ?></h2>
						<?php
						orvio_field_select( 'header_layout', orvio_t( 'Header layout', 'چیدمان هدر' ), $o, array(
							'classic'  => orvio_t( 'Standard', 'استاندارد' ),
							'centered' => orvio_t( 'Centered logo', 'لوگوی وسط' ),
							'split'    => orvio_t( 'Split search', 'جستجوی دوطرفه' ),
							'minimal'  => orvio_t( 'Minimal', 'مینیمال' ),
						) );
						orvio_field_check( 'sticky_header', orvio_t( 'Sticky header', 'هدر چسبان' ), $o );
						orvio_field_color( 'header_bg', orvio_t( 'Background', 'پس‌زمینه' ), $o );
						orvio_field_color( 'header_ink', orvio_t( 'Text', 'متن' ), $o );
						orvio_field_select( 'header_account_style', orvio_t( 'Account button style', 'استایل دکمه حساب' ), $o, array(
							'minimal' => orvio_t( 'Minimal', 'مینیمال' ),
							'pill'    => orvio_t( 'Pill', 'گرد' ),
							'solid'   => orvio_t( 'Solid', 'پر' ),
							'outline' => orvio_t( 'Outline', 'خطی' ),
							'soft'    => orvio_t( 'Soft', 'نرم' ),
						) );
						orvio_field_select( 'header_cart_style', orvio_t( 'Cart button style', 'استایل دکمه سبد' ), $o, array(
							'minimal' => orvio_t( 'Minimal', 'مینیمال' ),
							'pill'    => orvio_t( 'Pill', 'گرد' ),
							'solid'   => orvio_t( 'Solid', 'پر' ),
							'outline' => orvio_t( 'Outline', 'خطی' ),
							'soft'    => orvio_t( 'Soft', 'نرم' ),
						) );
						orvio_field_number( 'menu_size', orvio_t( 'Menu size', 'اندازه منو' ), $o, 12, 20 );

						?>
					</div>
					<div class="orvio-card"><h2><?php echo esc_html( orvio_t( 'Elements', 'المان‌ها' ) ); ?></h2>
						<?php
						orvio_field_check( 'show_search', orvio_t( 'Search', 'جستجو' ), $o );
						orvio_field_check( 'show_account', orvio_t( 'Account', 'حساب' ), $o );
						orvio_field_check( 'show_cart', orvio_t( 'Cart', 'سبد' ), $o );
						orvio_field_check( 'show_catbar', orvio_t( 'Category menu', 'منوی دسته‌ها' ), $o );
						orvio_field_check( 'show_announcement', orvio_t( 'Announcement', 'نوار اعلان' ), $o );
						orvio_field_text( 'announcement', orvio_t( 'Announcement text', 'متن اعلان' ), $o );
						orvio_field_text( 'announcement_en', orvio_t( 'English announcement', 'متن انگلیسی' ), $o );
						?>
					</div>
				</section>
				<section data-panel="mobile-nav" class="orvio-panel">
					<div class="orvio-card"><h2><?php echo esc_html( orvio_t( 'Mobile navigation', 'ناوبری موبایل' ) ); ?></h2>
						<?php
						orvio_field_check( 'mobile_nav_enabled', orvio_t( 'Enable mobile navigation', 'فعال‌سازی ناوبری موبایل' ), $o );
						orvio_field_select( 'mobile_nav_style', orvio_t( 'Navigation style', 'استایل ناوبری' ), $o, array(
							'bar'      => orvio_t( 'Bottom bar', 'نوار پایین' ),
							'floating' => orvio_t( 'Floating panel', 'پنل شناور' ),
							'pill'     => orvio_t( 'Pill', 'کپسولی' ),
							'glass'    => orvio_t( 'Glass', 'شیشه‌ای' ),
							'dark'     => orvio_t( 'Dark', 'تیره' ),
							'minimal'  => orvio_t( 'Minimal', 'مینیمال' ),
						) );
						orvio_field_optional_color( 'mobile_nav_background', orvio_t( 'Background color', 'رنگ پس‌زمینه' ), $o );
						orvio_field_optional_color( 'mobile_nav_text', orvio_t( 'Text and icon color', 'رنگ متن و آیکن' ), $o );
						orvio_field_optional_color( 'mobile_nav_border', orvio_t( 'Border color', 'رنگ حاشیه' ), $o );
						orvio_field_optional_color( 'mobile_nav_active', orvio_t( 'Active color', 'رنگ حالت فعال' ), $o );
						orvio_field_optional_color( 'mobile_nav_active_bg', orvio_t( 'Active background', 'پس‌زمینه فعال' ), $o );
						orvio_field_select( 'mobile_nav_shadow', orvio_t( 'Shadow', 'سایه' ), $o, array( '' => orvio_t( 'Preset default', 'پیش‌فرض استایل' ), 'none' => orvio_t( 'None', 'بدون سایه' ), 'soft' => orvio_t( 'Soft', 'نرم' ), 'strong' => orvio_t( 'Strong', 'قوی' ) ) );
						orvio_field_select( 'mobile_nav_active_style', orvio_t( 'Active state', 'حالت فعال' ), $o, array( 'soft' => orvio_t( 'Soft background', 'پس‌زمینه نرم' ), 'solid' => orvio_t( 'Solid', 'پر' ), 'underline' => orvio_t( 'Underline', 'خط زیر' ), 'dot' => orvio_t( 'Dot', 'نقطه' ) ) );
						orvio_field_number( 'mobile_nav_radius', orvio_t( 'Radius', 'گردی' ), $o, 0, 40 );
						orvio_field_number( 'mobile_nav_spacing', orvio_t( 'Spacing', 'فاصله' ), $o, 0, 20 );
						orvio_field_number( 'mobile_nav_height', orvio_t( 'Height', 'ارتفاع' ), $o, 42, 96 );
						orvio_field_number( 'mobile_nav_icon_size', orvio_t( 'Icon size', 'اندازه آیکن' ), $o, 16, 32 );
						?>
					</div>
					<div class="orvio-card"><h2><?php echo esc_html( orvio_t( 'Mobile navigation buttons', 'دکمه‌های ناوبری موبایل' ) ); ?></h2>
						<?php
						foreach ( orvio_mobile_nav_defaults() as $slot => $default ) {
							orvio_field_mobile_nav_item( $slot, $o['mobile_nav_items'][ $slot ] ?? $default );
						}
						?>
					</div>
				</section>
				<section data-panel="footer" class="orvio-panel">
					<div class="orvio-card"><h2><?php echo esc_html( orvio_t( 'Layout', 'چیدمان' ) ); ?></h2>
						<?php orvio_field_select( 'footer_layout', orvio_t( 'Footer layout', 'چیدمان فوتر' ), $o, array( 'classic' => orvio_t( 'Classic', 'کلاسیک' ), 'centered' => orvio_t( 'Centered', 'مرکزی' ), 'minimal' => orvio_t( 'Minimal', 'مینیمال' ), 'editorial' => orvio_t( 'Editorial', 'ادیتوریال' ) ) ); ?>
					</div>
					<div class="orvio-card"><h2><?php echo esc_html( orvio_t( 'Footer', 'فوتر' ) ); ?></h2>
						<?php
						orvio_field_text( 'footer_about', orvio_t( 'About text', 'متن معرفی' ), $o );
						orvio_field_text( 'copyright', orvio_t( 'Copyright', 'کپی‌رایت' ), $o );
						orvio_field_text( 'instagram', 'Instagram', $o );
						orvio_field_text( 'telegram', 'Telegram', $o );
						orvio_field_text( 'whatsapp', 'WhatsApp', $o );
						?>
					</div>
				</section>
				<section data-panel="shop" class="orvio-panel">
					<div class="orvio-card"><h2><?php echo esc_html( orvio_t( 'Shop', 'فروشگاه' ) ); ?></h2>
						<?php
						orvio_field_number( 'shop_columns_desktop', orvio_t( 'Desktop columns', 'ستون‌های دسکتاپ' ), $o, 2, 6 );
						orvio_field_number( 'shop_columns_mobile', orvio_t( 'Mobile columns', 'ستون‌های موبایل' ), $o, 1, 4 );
						orvio_field_number( 'products_per_page', orvio_t( 'Per page', 'تعداد در صفحه' ), $o, 4, 48 );
						orvio_field_select( 'shop_layout', orvio_t( 'Shop layout', 'چیدمان فروشگاه' ), $o, array(
							'sidebar-grid' => orvio_t( 'Sidebar + grid', 'سایدبار و شبکه' ),
							'wide-grid'    => orvio_t( 'Wide grid', 'شبکه عریض' ),
							'list'         => orvio_t( 'List', 'فهرست' ),
							'masonry'      => orvio_t( 'Masonry cards', 'کارت‌های نامنظم' ),
							'minimal'      => orvio_t( 'Minimal', 'مینیمال' ),
						) );
						orvio_field_select( 'card_style', orvio_t( 'Card', 'کارت کالا' ), $o, array(
							'classic'   => orvio_t( 'Classic', 'کلاسیک' ),
							'minimal'   => orvio_t( 'Minimal', 'مینیمال' ),
							'overlay'   => orvio_t( 'Overlay', 'روی تصویر' ),
							'editorial' => orvio_t( 'Editorial', 'ادیتوریال' ),
							'deal'      => orvio_t( 'Deal', 'تخفیف' ),
							'polaroid'  => orvio_t( 'Polaroid', 'پولاروید' ),
							'magazine'  => orvio_t( 'Magazine', 'مجله‌ای' ),
						) );
						orvio_field_select( 'card_content', orvio_t( 'Product card content', 'چیدمان محتوای کارت کالا' ), $o, array( 'below' => orvio_t( 'Name, price and button below image', 'نام، قیمت و دکمه زیر تصویر' ), 'tile' => orvio_t( 'Tile', 'کاشی' ), 'hover-info' => orvio_t( 'Information on hover', 'اطلاعات در هاور' ), 'hover-overlay' => orvio_t( 'Overlay information on hover', 'اطلاعات روی تصویر در هاور' ) ) );
						orvio_field_check( 'shop_sidebar', orvio_t( 'Filters', 'فیلترها' ), $o );
						orvio_field_check( 'enable_wishlist', orvio_t( 'Wishlist', 'علاقه‌مندی' ), $o );
						orvio_field_check( 'enable_quick_view', orvio_t( 'Quick add', 'افزودن سریع' ), $o );
						?>
					</div>
				</section>
				<section data-panel="product" class="orvio-panel">
					<div class="orvio-card"><h2><?php echo esc_html( orvio_t( 'Product', 'محصول' ) ); ?></h2>
						<?php
						orvio_field_select( 'atc_style', orvio_t( 'Add to cart button', 'دکمه افزودن به سبد' ), $o, array(
							'pill'    => orvio_t( 'Pill', 'گرد' ),
							'block'   => orvio_t( 'Full width', 'تمام‌عرض' ),
							'outline' => orvio_t( 'Outline', 'خطی' ),
							'soft'    => orvio_t( 'Soft', 'نرم' ),
						) );
						orvio_field_select( 'atc_behavior', orvio_t( 'After add to cart', 'رفتار بعد از افزودن به سبد' ), $o, array( 'auto' => orvio_t( 'Theme default', 'پیش‌فرض قالب' ), 'ajax-stay' => orvio_t( 'Stay on page', 'ماندن در صفحه' ), 'cart' => orvio_t( 'Go to cart', 'انتقال به سبد' ), 'checkout' => orvio_t( 'Go to checkout', 'انتقال به تسویه حساب' ) ) );
						orvio_field_select( 'atc_visual', orvio_t( 'Card add-to-cart visual', 'نمایش افزودن به سبد در کارت' ), $o, array( 'text' => orvio_t( 'Text', 'متن' ), 'icon' => orvio_t( 'Icon + text', 'آیکن و متن' ), 'hover' => orvio_t( 'Text on hover', 'متن در هاور' ), 'tile' => orvio_t( 'Tile below image', 'کاشی زیر تصویر' ), 'icon-only' => orvio_t( 'Icon only', 'فقط آیکن' ) ) );
						orvio_field_select( 'product_layout', orvio_t( 'Single product layout', 'چیدمان صفحه محصول' ), $o, array(
							'classic'       => orvio_t( 'Classic gallery', 'گالری کلاسیک' ),
							'gallery-right' => orvio_t( 'Gallery right', 'گالری سمت راست' ),
							'stacked'       => orvio_t( 'Stacked', 'ستونی' ),
							'immersive'     => orvio_t( 'Immersive', 'غوطه‌ور' ),
						) );
							orvio_field_check( 'sticky_summary', orvio_t( 'Sticky summary', 'خلاصه چسبان' ), $o );
							orvio_field_number( 'related_count', orvio_t( 'Related products', 'کالاهای مرتبط' ), $o, 2, 8 );
							?>
						</div>
						<div class="orvio-card"><h2><?php echo esc_html( orvio_t( 'Product typography', 'تایپوگرافی محصول' ) ); ?></h2>
							<?php
							orvio_field_select( 'product_body_font', orvio_t( 'Product body font', 'فونت متن محصول' ), $o, orvio_font_choices() );
							orvio_field_select( 'product_heading_font', orvio_t( 'Product heading font', 'فونت عنوان محصول' ), $o, orvio_font_choices() );
							orvio_field_number( 'product_body_size', orvio_t( 'Body size (px)', 'اندازه متن (پیکسل)' ), $o, 12, 20 );
							orvio_field_number( 'product_title_size', orvio_t( 'Title size (px)', 'اندازه عنوان (پیکسل)' ), $o, 30, 80 );
							orvio_field_number( 'product_price_size', orvio_t( 'Price size (px)', 'اندازه قیمت (پیکسل)' ), $o, 18, 48 );
							orvio_field_number( 'product_button_size', orvio_t( 'Button text size (px)', 'اندازه متن دکمه (پیکسل)' ), $o, 11, 20 );
							?>
						</div>
						<div class="orvio-card"><h2><?php echo esc_html( orvio_t( 'Product colors', 'رنگ‌های صفحه محصول' ) ); ?></h2>
							<?php
							orvio_field_color( 'product_text_color', orvio_t( 'Body text', 'رنگ متن' ), $o );
							orvio_field_color( 'product_heading_color', orvio_t( 'Headings', 'رنگ عنوان‌ها' ), $o );
							orvio_field_color( 'product_accent_color', orvio_t( 'Accent and links', 'رنگ تأکیدی و لینک‌ها' ), $o );
							orvio_field_color( 'product_price_color', orvio_t( 'Price', 'رنگ قیمت' ), $o );
							orvio_field_color( 'product_button_bg', orvio_t( 'Button background', 'پس‌زمینه دکمه' ), $o );
							orvio_field_color( 'product_button_hover', orvio_t( 'Button hover', 'رنگ هاور دکمه' ), $o );
							orvio_field_color( 'product_button_text', orvio_t( 'Button text', 'متن دکمه' ), $o );
							orvio_field_color( 'product_sale_color', orvio_t( 'Sale color', 'رنگ تخفیف' ), $o );
							orvio_field_color( 'product_sale_bg', orvio_t( 'Sale background', 'پس‌زمینه تخفیف' ), $o );
							orvio_field_color( 'product_stock_color', orvio_t( 'Stock color', 'رنگ موجودی' ), $o );
							orvio_field_color( 'product_muted_color', orvio_t( 'Muted text', 'رنگ متن کم‌رنگ' ), $o );
							orvio_field_color( 'product_border_color', orvio_t( 'Borders', 'رنگ حاشیه' ), $o );
							orvio_field_color( 'product_gallery_bg', orvio_t( 'Gallery background', 'پس‌زمینه گالری' ), $o );
							orvio_field_color( 'product_surface_color', orvio_t( 'Cards and buy box', 'کارت‌ها و باکس خرید' ), $o );
							orvio_field_color( 'product_tab_bg', orvio_t( 'Tabs background', 'پس‌زمینه تب‌ها' ), $o );
							orvio_field_color( 'product_perk_bg', orvio_t( 'Benefits background', 'پس‌زمینه مزایا' ), $o );
							?>
						</div>
						<div class="orvio-card"><h2><?php echo esc_html( orvio_t( 'Product details and templates', 'جزئیات و قالب‌های محصول' ) ); ?></h2>
							<?php
							orvio_field_select( 'product_width_mode', orvio_t( 'Product content width', 'عرض محتوای محصول' ), $o, array( 'wide' => orvio_t( 'Wide', 'عریض' ), 'extra-wide' => orvio_t( 'Extra wide', 'عریض‌تر' ), 'inherit' => orvio_t( 'Use site setting', 'پیروی از تنظیمات سایت' ), 'boxed' => orvio_t( 'Boxed', 'جعبه‌ای' ), 'content-wide' => orvio_t( 'Wide content', 'محتوای عریض' ) ) );
							orvio_field_number( 'product_summary_width', orvio_t( 'Summary column width (%)', 'عرض ستون نام و خرید (درصد)' ), $o, 36, 58 );
							orvio_field_number( 'product_gap', orvio_t( 'Gallery / summary gap (px)', 'فاصله گالری و خلاصه (پیکسل)' ), $o, 12, 96 );
							orvio_field_number( 'product_radius', orvio_t( 'Product radius (px)', 'گردی اجزای محصول (پیکسل)' ), $o, 0, 44 );
							orvio_field_select( 'product_gallery_ratio', orvio_t( 'Gallery ratio', 'نسبت تصویر گالری' ), $o, array( 'square' => orvio_t( 'Square', 'مربع' ), 'portrait' => orvio_t( 'Portrait', 'عمودی' ), 'landscape' => orvio_t( 'Landscape', 'افقی' ) ) );
							orvio_field_select( 'product_image_fit', orvio_t( 'Image fit', 'نحوه نمایش تصویر' ), $o, array( 'cover' => orvio_t( 'Cover', 'پرکردن قاب' ), 'contain' => orvio_t( 'Contain', 'نمایش کامل' ) ) );
							orvio_field_select( 'product_tabs_style', orvio_t( 'Tabs style', 'استایل تب‌ها' ), $o, array( 'card' => orvio_t( 'Card', 'کارت' ), 'underline' => orvio_t( 'Underline', 'خط زیر' ), 'minimal' => orvio_t( 'Minimal', 'مینیمال' ) ) );
							orvio_field_check( 'product_show_eyebrow', orvio_t( 'Show category / SKU eyebrow', 'نمایش دسته‌بندی و شناسه' ), $o );
							orvio_field_check( 'product_show_sku', orvio_t( 'Show SKU', 'نمایش شناسه محصول' ), $o );
							orvio_field_check( 'product_show_rating', orvio_t( 'Show rating', 'نمایش امتیاز' ), $o );
							orvio_field_check( 'product_show_excerpt', orvio_t( 'Show short description', 'نمایش توضیح کوتاه' ), $o );
							orvio_field_check( 'product_show_perks', orvio_t( 'Show purchase benefits', 'نمایش مزایای خرید' ), $o );
							orvio_field_check( 'product_show_meta', orvio_t( 'Show product meta', 'نمایش اطلاعات محصول' ), $o );
							orvio_field_check( 'product_show_share', orvio_t( 'Show share links', 'نمایش اشتراک‌گذاری' ), $o );
							orvio_field_check( 'product_show_gallery_note', orvio_t( 'Show gallery note', 'نمایش یادداشت گالری' ), $o );
							orvio_field_check( 'product_show_tabs', orvio_t( 'Show description / review tabs', 'نمایش تب‌های توضیح و دیدگاه' ), $o );
							orvio_field_check( 'product_show_upsells', orvio_t( 'Show upsells', 'نمایش پیشنهادهای ویژه' ), $o );
							orvio_field_check( 'product_show_related', orvio_t( 'Show related products', 'نمایش محصولات مرتبط' ), $o );
							orvio_field_check( 'product_sticky_mobile', orvio_t( 'Mobile sticky add to cart', 'افزودن به سبد چسبان موبایل' ), $o );
							?>
						</div>
					</section>
					<section data-panel="cart" class="orvio-panel">
					<div class="orvio-card"><h2><?php echo esc_html( orvio_t( 'Cart', 'سبد خرید' ) ); ?></h2>
						<?php
						orvio_field_select( 'cart_type', orvio_t( 'Cart behavior', 'رفتار سبد خرید' ), $o, array(
							'drawer' => orvio_t( 'Slide-in drawer', 'کشوی اسلایدی' ),
							'page'   => orvio_t( 'Cart page', 'صفحه سبد' ),
						) );
						orvio_field_select( 'cart_style', orvio_t( 'Cart style', 'استایل صفحه سبد' ), $o, array( 'saas' => orvio_t( 'SaaS cart', 'سبد خرید SaaS' ) ) );
						orvio_field_select( 'cart_layout', orvio_t( 'Cart layout', 'چیدمان سبد خرید' ), $o, orvio_cart_layout_choices() );
						orvio_field_select( 'cart_drawer_side', orvio_t( 'Drawer side', 'سمت باز شدن کشو' ), $o, array( 'right' => orvio_t( 'Right', 'راست' ), 'left' => orvio_t( 'Left', 'چپ' ) ) );
						orvio_field_select( 'cart_drawer_style', orvio_t( 'Drawer style', 'استایل کامل کشوی سبد' ), $o, array( 'saas' => orvio_t( 'SaaS', 'ساس' ), 'soft' => orvio_t( 'Soft', 'نرم' ), 'dark' => orvio_t( 'Dark', 'تیره' ), 'minimal' => orvio_t( 'Minimal', 'مینیمال' ) ) );
						orvio_field_select( 'cart_drawer_font', orvio_t( 'Drawer font', 'فونت کشو' ), $o, orvio_font_choices() );
						orvio_field_select( 'cart_drawer_overlay', orvio_t( 'Drawer overlay', 'حالت لایه رویی' ), $o, array( 'dim' => orvio_t( 'Dim', 'تیره' ), 'soft' => orvio_t( 'Soft', 'نرم' ), 'strong' => orvio_t( 'Strong', 'قوی' ), 'none' => orvio_t( 'None', 'بدون لایه' ) ) );
						orvio_field_number( 'cart_drawer_width', orvio_t( 'Drawer width (px)', 'عرض کشو (پیکسل)' ), $o, 300, 620 );
						orvio_field_number( 'cart_drawer_font_size', orvio_t( 'Drawer font size (px)', 'اندازه فونت کشو (پیکسل)' ), $o, 12, 20 );
						orvio_field_number( 'cart_drawer_item_spacing', orvio_t( 'Item spacing (px)', 'فاصله آیتم‌ها (پیکسل)' ), $o, 4, 32 );
						orvio_field_number( 'cart_drawer_radius', orvio_t( 'Drawer radius (px)', 'گردی کشو (پیکسل)' ), $o, 0, 32 );
						orvio_field_optional_color( 'cart_drawer_background', orvio_t( 'Drawer background', 'پس‌زمینه کشو' ), $o );
						orvio_field_optional_color( 'cart_drawer_text', orvio_t( 'Drawer text', 'متن کشو' ), $o );
						orvio_field_optional_color( 'cart_drawer_accent', orvio_t( 'Drawer accent', 'رنگ تأکیدی کشو' ), $o );
						orvio_field_optional_color( 'cart_drawer_border', orvio_t( 'Drawer border', 'حاشیه کشو' ), $o );
						?>
					</div>
				</section>
				<section data-panel="checkout" class="orvio-panel">
					<div class="orvio-card"><h2><?php echo esc_html( orvio_t( 'Checkout', 'صورتحساب' ) ); ?></h2>
						<?php
						orvio_field_select( 'checkout_layout', orvio_t( 'Checkout layout', 'چیدمان صورتحساب' ), $o, orvio_page_layout_choices() );
						echo '<h3 style="margin-top:18px">' . esc_html( orvio_t( 'Billing fields', 'فیلدهای صورتحساب' ) ) . '</h3>';
						foreach ( orvio_billing_labels() as $field => $label ) {
							orvio_field_billing_mode( $field, $label, $o );
						}
						orvio_field_number( 'free_shipping', orvio_t( 'Free shipping from', 'ارسال رایگان از' ), $o, 0, 999999999 );
						?>
					</div>
				</section>
				<section data-panel="account" class="orvio-panel">
					<div class="orvio-card"><h2><?php echo esc_html( orvio_t( 'Account layout', 'چیدمان ناحیه کاربری' ) ); ?></h2>
						<?php
						orvio_field_select( 'account_layout', orvio_t( 'Layout', 'چیدمان' ), $o, array( 'saas' => orvio_t( 'SaaS workspace', 'چیدمان پنل SaaS' ) ) );
						orvio_field_select( 'account_style', orvio_t( 'Style', 'استایل' ), $o, array( 'saas' => orvio_t( 'SaaS workspace', 'استایل پنل SaaS' ) ) );
						?>
					</div>
				</section>
				<section data-panel="contact" class="orvio-panel">
					<div class="orvio-card"><h2><?php echo esc_html( orvio_t( 'Studio', 'استودیو' ) ); ?></h2>
						<?php
						orvio_field_text( 'phone', orvio_t( 'Phone', 'تلفن' ), $o );
						orvio_field_text( 'email', orvio_t( 'Email', 'ایمیل' ), $o );
						orvio_field_text( 'address', orvio_t( 'Address', 'آدرس' ), $o );
						orvio_field_text( 'hours', orvio_t( 'Hours', 'ساعت کاری' ), $o );
						?>
					</div>
				</section>
				<div class="orvio-save"><?php submit_button( orvio_t( 'Save settings', 'ذخیره تنظیمات' ), 'primary', 'submit', false ); ?></div>
			</form>
			<section data-panel="home" class="orvio-panel">
				<div class="orvio-card" style="padding:18px 20px">
					<h2><?php echo esc_html( orvio_t( 'Homepage', 'صفحه اصلی' ) ); ?></h2>
					<p class="orvio-home-copy"><?php echo esc_html( orvio_t( 'This theme does not create a homepage. The site front is the page you select in Settings → Reading.', 'قالب صفحه اصلی جدا نمی‌سازد. صفحه اول سایت همان برگه‌ای است که در تنظیمات ← خواندن وردپرس انتخاب می‌کنید.' ) ); ?></p>
					<p><span class="orvio-status <?php echo $front_id ? 'is-ok' : ''; ?>"><?php echo esc_html( $front_id ? get_the_title( $front_id ) : orvio_t( 'No static page selected', 'برگه‌ای انتخاب نشده' ) ); ?></span></p>
					<div class="orvio-actions">
						<a class="button button-primary" href="<?php echo esc_url( admin_url( 'options-reading.php' ) ); ?>"><?php echo esc_html( orvio_t( 'Choose the page in WordPress', 'انتخاب برگه در وردپرس' ) ); ?></a>
						<?php if ( $front_id ) : ?>
							<a class="button" href="<?php echo esc_url( get_edit_post_link( $front_id ) ); ?>"><?php echo esc_html( orvio_t( 'Edit that page', 'ویرایش همان برگه' ) ); ?></a>
						<?php endif; ?>
						<?php if ( $edit_url ) : ?>
							<a class="button" href="<?php echo esc_url( $edit_url ); ?>"><?php echo esc_html( orvio_t( 'Edit in Elementor', 'ویرایش در المنتور' ) ); ?></a>
						<?php endif; ?>
						<?php if ( class_exists( 'WooCommerce' ) ) : ?>
							<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
								<?php wp_nonce_field( 'orvio_import_demo' ); ?>
								<input type="hidden" name="action" value="orvio_import_demo">
								<button class="button" type="submit"><?php echo esc_html( orvio_t( 'Install demo catalog', 'نصب کاتالوگ دمو' ) ); ?></button>
							</form>
						<?php endif; ?>
					</div>
				</div>
			</section>
		</div>
	</div>
	<?php
}

function orvio_font_choices() {
	return array(
		'vazirmatn'  => 'Vazirmatn',
		'instrument' => 'Instrument Sans',
		'fraunces'   => 'Fraunces',
		'system'     => orvio_t( 'System', 'سیستمی' ),
	);
}

function orvio_font_stack( $key ) {
	$stacks = array(
		'vazirmatn'  => '"Vazirmatn", system-ui, sans-serif',
		'instrument' => '"Instrument Sans", "Vazirmatn", system-ui, sans-serif',
		'fraunces'   => '"Fraunces", "Vazirmatn", Georgia, serif',
		'system'     => 'system-ui, Tahoma, sans-serif',
	);
	return $stacks[ $key ] ?? $stacks['vazirmatn'];
}

function orvio_field_color( $key, $label, $o ) {
	echo '<label class="orvio-admin__field"><span>' . esc_html( $label ) . '</span><input type="color" name="orvio_settings[' . esc_attr( $key ) . ']" value="' . esc_attr( $o[ $key ] ) . '"></label>';
}
function orvio_field_optional_color( $key, $label, $o ) {
	echo '<label class="orvio-admin__field"><span>' . esc_html( $label ) . '</span><input type="text" name="orvio_settings[' . esc_attr( $key ) . ']" value="' . esc_attr( $o[ $key ] ?? '' ) . '" placeholder="' . esc_attr( orvio_t( 'Preset default', 'پیش‌فرض استایل' ) ) . '"></label>';
}
function orvio_field_text( $key, $label, $o ) {
	echo '<label class="orvio-admin__field orvio-admin__field--wide"><span>' . esc_html( $label ) . '</span><input type="text" class="regular-text" name="orvio_settings[' . esc_attr( $key ) . ']" value="' . esc_attr( $o[ $key ] ) . '"></label>';
}
function orvio_field_number( $key, $label, $o, $min, $max ) {
	echo '<label class="orvio-admin__field"><span>' . esc_html( $label ) . '</span><input type="number" name="orvio_settings[' . esc_attr( $key ) . ']" value="' . esc_attr( $o[ $key ] ) . '" min="' . esc_attr( $min ) . '" max="' . esc_attr( $max ) . '"></label>';
}
function orvio_field_check( $key, $label, $o ) {
	echo '<label class="orvio-admin__check"><input type="checkbox" name="orvio_settings[' . esc_attr( $key ) . ']" value="1" ' . checked( ! empty( $o[ $key ] ), true, false ) . '> ' . esc_html( $label ) . '</label>';
}
function orvio_cart_layout_choices() {
	return array(
		'saas-split'    => orvio_t( 'SaaS split', 'ساس دو بخشی' ),
		'saas-focus'    => orvio_t( 'SaaS focus', 'ساس تمرکز' ),
		'saas-compact'  => orvio_t( 'SaaS compact / list', 'ساس فشرده / لیست' ),
		'saas-bento'    => orvio_t( 'SaaS bento', 'ساس بنتو' ),
	);
}

function orvio_page_layout_choices() {
	return array(
		'split'   => orvio_t( 'Split', 'دو ستونه' ),
		'classic' => orvio_t( 'Classic', 'کلاسیک' ),
		'compact' => orvio_t( 'Compact', 'فشرده' ),
		'focus'   => orvio_t( 'Focus mode', 'حالت تمرکز' ),
		'minimal' => orvio_t( 'Minimal', 'مینیمال' ),
	);
}

function orvio_billing_labels() {
	return array(
		'billing_first_name' => orvio_t( 'First name', 'نام' ),
		'billing_last_name'  => orvio_t( 'Last name', 'نام خانوادگی' ),
		'billing_company'    => orvio_t( 'Company', 'شرکت' ),
		'billing_country'    => orvio_t( 'Country', 'کشور' ),
		'billing_address_1'  => orvio_t( 'Address', 'آدرس' ),
		'billing_address_2'  => orvio_t( 'Address 2', 'آدرس تکمیلی' ),
		'billing_city'       => orvio_t( 'City', 'شهر' ),
		'billing_state'      => orvio_t( 'State', 'استان' ),
		'billing_postcode'   => orvio_t( 'Postcode', 'کد پستی' ),
		'billing_phone'      => orvio_t( 'Phone', 'تلفن' ),
		'billing_email'      => orvio_t( 'Email', 'ایمیل' ),
	);
}

function orvio_field_billing_mode( $key, $label, $o ) {
	$choices = array(
		'required' => orvio_t( 'Required', 'ضروری' ),
		'optional' => orvio_t( 'Optional', 'اختیاری' ),
		'hidden'   => orvio_t( 'Hidden', 'مخفی' ),
	);
	$value = $o['billing_fields'][ $key ] ?? 'optional';
	echo '<label class="orvio-admin__field"><span>' . esc_html( $label ) . '</span><select name="orvio_settings[billing_fields][' . esc_attr( $key ) . ']">';
	foreach ( $choices as $choice => $text ) {
		echo '<option value="' . esc_attr( $choice ) . '" ' . selected( $value, $choice, false ) . '>' . esc_html( $text ) . '</option>';
	}
	echo '</select></label>';
}

function orvio_mobile_nav_type_choices() {
	return array(
		'home'       => orvio_t( 'Home', 'خانه' ),
		'categories' => orvio_t( 'Categories / menu', 'دسته‌ها / منو' ),
		'shop'       => orvio_t( 'Shop', 'فروشگاه' ),
		'cart'       => orvio_t( 'Cart', 'سبد خرید' ),
		'account'    => orvio_t( 'Account', 'ناحیه کاربری' ),
		'wishlist'   => orvio_t( 'Wishlist', 'علاقه‌مندی' ),
		'search'     => orvio_t( 'Search', 'جستجو' ),
		'custom'     => orvio_t( 'Custom link', 'لینک سفارشی' ),
	);
}

function orvio_mobile_nav_icon_choices() {
	return array(
		'home'  => orvio_t( 'Home icon', 'آیکن خانه' ),
		'grid'  => orvio_t( 'Grid icon', 'آیکن شبکه' ),
		'menu'  => orvio_t( 'Menu icon', 'آیکن منو' ),
		'store' => orvio_t( 'Store icon', 'آیکن فروشگاه' ),
		'bag'   => orvio_t( 'Bag icon', 'آیکن سبد' ),
		'user'  => orvio_t( 'User icon', 'آیکن کاربر' ),
		'heart' => orvio_t( 'Heart icon', 'آیکن علاقه‌مندی' ),
		'search'=> orvio_t( 'Search icon', 'آیکن جستجو' ),
	);
}

function orvio_field_mobile_nav_item( $slot, $item ) {
	$number = str_replace( 'item_', '', $slot );
	$types  = orvio_mobile_nav_type_choices();
	$icons  = orvio_mobile_nav_icon_choices();
	$item   = wp_parse_args( is_array( $item ) ? $item : array(), array( 'enabled' => 1, 'order' => (int) $number, 'type' => 'home', 'label' => '', 'icon' => 'home', 'url' => '' ) );
	echo '<div class="orvio-mobile-nav-setting"><h4>' . esc_html( sprintf( orvio_t( 'Button %s', 'دکمه %s' ), $number ) ) . '</h4>';
	echo '<label class="orvio-admin__field"><span>' . esc_html( orvio_t( 'Position', 'جایگاه' ) ) . '</span><select name="orvio_settings[mobile_nav_items][' . esc_attr( $slot ) . '][order]">';
	for ( $position = 1; $position <= 5; $position++ ) {
		echo '<option value="' . esc_attr( $position ) . '" ' . selected( (int) $item['order'], $position, false ) . '>' . esc_html( sprintf( orvio_t( 'Position %s', 'جایگاه %s' ), $position ) ) . '</option>';
	}
	echo '</select></label>';
	echo '<label class="orvio-admin__check"><input type="checkbox" name="orvio_settings[mobile_nav_items][' . esc_attr( $slot ) . '][enabled]" value="1" ' . checked( ! empty( $item['enabled'] ), true, false ) . '> ' . esc_html( orvio_t( 'Enabled', 'فعال' ) ) . '</label>';
	echo '<label class="orvio-admin__field"><span>' . esc_html( orvio_t( 'Action', 'عملکرد' ) ) . '</span><select name="orvio_settings[mobile_nav_items][' . esc_attr( $slot ) . '][type]">';
	foreach ( $types as $value => $label ) {
		echo '<option value="' . esc_attr( $value ) . '" ' . selected( $item['type'], $value, false ) . '>' . esc_html( $label ) . '</option>';
	}
	echo '</select></label>';
	echo '<label class="orvio-admin__field"><span>' . esc_html( orvio_t( 'Label', 'عنوان' ) ) . '</span><input type="text" name="orvio_settings[mobile_nav_items][' . esc_attr( $slot ) . '][label]" value="' . esc_attr( $item['label'] ) . '"></label>';
	echo '<label class="orvio-admin__field"><span>' . esc_html( orvio_t( 'Icon', 'آیکن' ) ) . '</span><select name="orvio_settings[mobile_nav_items][' . esc_attr( $slot ) . '][icon]">';
	foreach ( $icons as $value => $label ) {
		echo '<option value="' . esc_attr( $value ) . '" ' . selected( $item['icon'], $value, false ) . '>' . esc_html( $label ) . '</option>';
	}
	echo '</select></label>';
	echo '<label class="orvio-admin__field orvio-admin__field--wide"><span>' . esc_html( orvio_t( 'Custom URL', 'آدرس سفارشی' ) ) . '</span><input type="url" name="orvio_settings[mobile_nav_items][' . esc_attr( $slot ) . '][url]" value="' . esc_attr( $item['url'] ) . '" placeholder="https://"></label></div>';
}

function orvio_field_select( $key, $label, $o, $choices ) {
	echo '<label class="orvio-admin__field"><span>' . esc_html( $label ) . '</span><select name="orvio_settings[' . esc_attr( $key ) . ']">';
	foreach ( $choices as $value => $text ) {
		echo '<option value="' . esc_attr( $value ) . '" ' . selected( $o[ $key ], $value, false ) . '>' . esc_html( $text ) . '</option>';
	}
	echo '</select></label>';
}

add_action( 'wp_head', 'orvio_print_css_vars', 20 );
function orvio_print_css_vars() {
	$o    = orvio_settings();
	$body = orvio_font_stack( $o['body_font'] );
	$head = orvio_font_stack( $o['heading_font'] );
	$shop_desktop = max( 2, min( 6, absint( $o['shop_columns_desktop'] ?? ( $o['shop_columns'] ?? 3 ) ) ) );
	$shop_mobile  = max( 1, min( 4, absint( $o['shop_columns_mobile'] ?? 2 ) ) );
	$product_body  = orvio_font_stack( $o['product_body_font'] ?? $o['body_font'] );
	$product_head  = orvio_font_stack( $o['product_heading_font'] ?? $o['heading_font'] );
	$product_ratios = array( 'square' => '1 / 1', 'portrait' => '4 / 5', 'landscape' => '4 / 3' );
	$product_ratio  = $product_ratios[ $o['product_gallery_ratio'] ?? 'square' ] ?? '1 / 1';
	$product_width_presets = array( 'inherit' => max( 960, absint( $o['container'] ?? 1220 ) ), 'wide' => 1280, 'extra-wide' => 1440, 'boxed' => 1220, 'content-wide' => 1680 );
	$product_width_mode = $o['product_width_mode'] ?? 'inherit';
	$product_content_width = $product_width_presets[ $product_width_mode ] ?? $product_width_presets['inherit'];
	$css  = ':root{--accent:' . $o['accent'] . ';--accent-dark:' . $o['accent'] . ';--bg:' . $o['bg'] . ';--ink:' . $o['ink'] . ';--dark:' . $o['dark'] . ';--radius:' . intval( $o['radius'] ) . 'px;--radius-sm:' . max( 4, intval( $o['radius'] ) - 4 ) . 'px;--container:' . intval( $o['container'] ) . 'px;--cols:' . $shop_desktop . ';--orvio-shop-cols-desktop:' . $shop_desktop . ';--orvio-shop-cols-mobile:' . $shop_mobile . ';--font:' . $body . ';--display:' . $head . ';--header-bg:' . $o['header_bg'] . ';--header-ink:' . $o['header_ink'] . ';--menu-size:' . intval( $o['menu_size'] ) . 'px;--product-font:' . $product_body . ';--product-display:' . $product_head . ';--product-text:' . $o['product_text_color'] . ';--product-heading:' . $o['product_heading_color'] . ';--product-accent:' . $o['product_accent_color'] . ';--product-price:' . $o['product_price_color'] . ';--product-button-bg:' . $o['product_button_bg'] . ';--product-button-hover:' . $o['product_button_hover'] . ';--product-button-text:' . $o['product_button_text'] . ';--product-sale:' . $o['product_sale_color'] . ';--product-sale-bg:' . $o['product_sale_bg'] . ';--product-stock:' . $o['product_stock_color'] . ';--product-muted:' . $o['product_muted_color'] . ';--product-border:' . $o['product_border_color'] . ';--product-gallery-bg:' . $o['product_gallery_bg'] . ';--product-surface:' . $o['product_surface_color'] . ';--product-tab-bg:' . $o['product_tab_bg'] . ';--product-perk-bg:' . $o['product_perk_bg'] . ';--product-gallery-ratio:' . $product_ratio . ';--product-image-fit:' . $o['product_image_fit'] . ';--product-title-size:' . intval( $o['product_title_size'] ) . 'px;--product-price-size:' . intval( $o['product_price_size'] ) . 'px;--product-button-size:' . intval( $o['product_button_size'] ) . 'px;--product-body-size:' . intval( $o['product_body_size'] ) . 'px;--product-content-width:' . $product_content_width . 'px;--product-summary-width:' . intval( $o['product_summary_width'] ) . '%;--product-gap:' . intval( $o['product_gap'] ) . 'px;--product-radius:' . intval( $o['product_radius'] ) . 'px;}';
	$shadow_presets = array( 'none' => 'none', 'soft' => '0 18px 50px rgba(28,25,22,.10)', 'medium' => '0 24px 70px rgba(28,25,22,.16)', 'strong' => '0 30px 100px rgba(28,25,22,.24)' );
	$shadow_sm_presets = array( 'none' => 'none', 'soft' => '0 8px 24px rgba(28,25,22,.06)', 'medium' => '0 10px 30px rgba(28,25,22,.10)', 'strong' => '0 14px 40px rgba(28,25,22,.16)' );
	$shadow_key = $o['global_shadow'] ?? 'soft';
	$css .= ':root{--bg-2:' . $o['bg_2'] . ';--surface:' . $o['surface'] . ';--muted:' . $o['muted'] . ';--faint:' . $o['faint'] . ';--line:' . $o['line'] . ';--line-strong:' . $o['line_strong'] . ';--accent-dark:' . $o['accent_dark'] . ';--accent-soft:' . $o['accent_soft'] . ';--forest:' . $o['forest'] . ';--sale:' . $o['sale'] . ';--star:' . $o['star'] . ';--dark-2:' . $o['dark_2'] . ';--ok:' . $o['ok'] . ';--warn:' . $o['warn'] . ';--info:' . $o['info'] . ';--button-bg:' . $o['button_bg'] . ';--button-text:' . $o['button_text'] . ';--button-hover:' . $o['button_hover'] . ';--button-hover-text:' . $o['button_hover_text'] . ';--focus-color:' . $o['focus_color'] . ';--selection-bg:' . $o['selection_bg'] . ';--shadow:' . ( $shadow_presets[ $shadow_key ] ?? $shadow_presets['soft'] ) . ';--shadow-sm:' . ( $shadow_sm_presets[ $shadow_key ] ?? $shadow_sm_presets['soft'] ) . ';--control-height:' . intval( $o['global_control_height'] ) . 'px;--section-spacing:' . intval( $o['global_section_spacing'] ) . 'px;--motion:' . intval( $o['global_transition'] ) . 'ms;}';
	$css .= 'body{font-size:' . intval( $o['font_size'] ) . 'px;color:var(--ink);background:var(--bg);} body.orvio-site-style-saas{background:var(--saas-bg);color:var(--saas-text);}';
	$css .= '::selection{background:var(--selection-bg);color:var(--ink);} :focus-visible{outline-color:var(--focus-color);}';
	$css .= 'a:hover{color:var(--accent-dark);} .orvio-btn{min-height:var(--control-height);transition-duration:var(--motion);} .orvio-search input,.orvio-select,.orvio-field input,.orvio-field select,.woocommerce form .form-row input.input-text,.woocommerce form .form-row select{min-height:var(--control-height);} .orvio-panel,.orvio-card{border-color:var(--line);} .orvio-surface{border-color:var(--line);background-color:var(--surface);} .orvio-btn--dark{background:var(--dark);color:var(--button-text);}';
	$css .= 'h1,h2,h3,h4,.orvio-logo__word strong{font-family:var(--display);}';
	$css .= '.orvio-header,.orvio-catbar{background:var(--header-bg);color:var(--header-ink);}';
	$css .= '.orvio-catbar__menu>li>a,.orvio-tool__label,.orvio-logo__word{font-size:var(--menu-size);}';
	$css .= 'body.single-product.orvio-product-width-wide .orvio-main>.orvio-wc{width:calc(100% - 40px)!important;max-width:none!important;}';
	$css .= 'body.single-product.orvio-product-width-extra-wide .orvio-main>.orvio-wc{width:min(1600px,calc(100% - 32px))!important;max-width:none!important;}';
	$css .= 'body.single-product.orvio-product-width-content-wide .orvio-main>.orvio-wc{width:min(1680px,calc(100% - 32px))!important;max-width:none!important;}';
	$css .= 'body.single-product.orvio-product-width-boxed .orvio-main>.orvio-wc{box-sizing:border-box;width:min(var(--container),calc(100% - 24px))!important;margin-inline:auto;padding:clamp(20px,3.5vw,48px);background:var(--product-surface);border:1px solid var(--product-border);border-radius:var(--product-radius);box-shadow:0 16px 48px rgba(23,21,18,.08);}';
	$css .= '@media (max-width:720px){body.single-product.orvio-product-width-boxed .orvio-main>.orvio-wc{width:calc(100% - 20px)!important;padding:14px!important;border-radius:16px;}}';
	$css .= 'body.single-product .orvio-product--premium{max-width:var(--product-content-width);font-family:var(--product-font);font-size:var(--product-body-size);color:var(--product-text);}';
	$css .= 'body.single-product .orvio-product--premium .orvio-product__main{gap:var(--product-gap)!important;}';
	$css .= '@media (min-width:981px){body.single-product .orvio-product--premium .orvio-product__main{grid-template-columns:minmax(0,calc(100% - var(--product-summary-width) - var(--product-gap))) minmax(320px,var(--product-summary-width))!important;}body.single-product.orvio-product-layout-gallery-right .orvio-product--premium .orvio-product__main{grid-template-columns:minmax(320px,var(--product-summary-width)) minmax(0,calc(100% - var(--product-summary-width) - var(--product-gap)))!important;}body.single-product.orvio-product-layout-immersive .orvio-product--premium .orvio-product__main{grid-template-columns:minmax(0,calc(100% - var(--product-summary-width) - var(--product-gap))) minmax(320px,var(--product-summary-width))!important;}body.single-product.orvio-product-layout-stacked .orvio-product--premium .orvio-product__main{grid-template-columns:1fr!important;max-width:980px;}}';
	$css .= 'body.single-product .orvio-product--premium .orvio-product__eyebrow,body.single-product .orvio-product--premium .orvio-product__intro,body.single-product .orvio-product--premium .orvio-product__rating-note,body.single-product .orvio-product--premium .orvio-product__price-wrap>span,body.single-product .orvio-product--premium .orvio-product__perks small,body.single-product .orvio-product--premium .product_meta,body.single-product .orvio-product--premium .orvio-acc,body.single-product .orvio-product--premium .orvio-acc p,body.single-product .orvio-product-after .woocommerce-tabs .panel{color:var(--product-muted)!important;}';
	$css .= 'body.single-product .orvio-product--premium h1,body.single-product .orvio-product--premium h2,body.single-product .orvio-product--premium h3,body.single-product .orvio-product--premium .orvio-product__flag,body.single-product .orvio-product-after .woocommerce-tabs h2,body.single-product .orvio-product-after .woocommerce-tabs .tabs a{font-family:var(--product-display);color:var(--product-heading);}';
	$css .= 'body.single-product .orvio-product--premium .orvio-product__main h1{font-size:clamp(30px,4vw,var(--product-title-size))!important;}';
	$css .= 'body.single-product .orvio-product--premium .orvio-gallery__stage{background:var(--product-gallery-bg)!important;border-color:var(--product-border)!important;border-radius:var(--product-radius)!important;}';
	$css .= 'body.single-product .orvio-product--premium .orvio-gallery__main{aspect-ratio:var(--product-gallery-ratio)!important;}';
	$css .= 'body.single-product .orvio-product--premium .orvio-gallery__main img{object-fit:var(--product-image-fit)!important;}';
	$css .= 'body.single-product .orvio-product--premium .orvio-gallery__zoom,body.single-product .orvio-product--premium .orvio-gallery__thumbs button,body.single-product .orvio-product--premium .orvio-product__buybox,body.single-product .orvio-product--premium .orvio-product__perks div,body.single-product .orvio-product--premium .product_meta,body.single-product .orvio-product-after .woocommerce-tabs{border-color:var(--product-border)!important;border-radius:var(--product-radius)!important;}';
	$css .= 'body.single-product .orvio-product--premium .orvio-gallery__thumbs button,body.single-product .orvio-product--premium .orvio-product__buybox,body.single-product .orvio-product--premium .orvio-product__perks div,body.single-product .orvio-product-after .woocommerce-tabs{background:var(--product-surface)!important;}';
	$css .= 'body.single-product .orvio-product--premium .orvio-product__buybox{background:var(--product-surface)!important;}';
	$css .= 'body.single-product .orvio-product--premium .orvio-product__price-wrap .price,body.single-product .orvio-product--premium .orvio-product__price-wrap .price ins{color:var(--product-price)!important;font-size:var(--product-price-size)!important;}';
	$css .= 'body.single-product .orvio-product--premium .orvio-product__status{color:var(--product-stock)!important;}body.single-product .orvio-product--premium .orvio-product__status.is-out{color:var(--product-sale)!important;}';
	$css .= 'body.single-product .orvio-product--premium .orvio-product__sale{color:var(--product-sale)!important;background:var(--product-sale-bg)!important;}';
	$css .= 'body.single-product .orvio-product--premium a,body.single-product .orvio-product--premium .orvio-gallery__note span{color:var(--product-accent);}';
	$css .= 'body.single-product .orvio-product--premium .orvio-product__perks div{background:var(--product-perk-bg)!important;}';
	$css .= 'body.single-product .orvio-product-after .woocommerce-tabs{background:var(--product-tab-bg)!important;}';
	$css .= 'body.single-product .orvio-product--premium .orvio-product__buybox .button,body.single-product .orvio-product--premium .orvio-product__buybox .single_add_to_cart_button,body.single-product .orvio-sticky-atc .orvio-btn--primary{background:var(--product-button-bg)!important;color:var(--product-button-text)!important;border-color:var(--product-button-bg)!important;border-radius:var(--product-radius)!important;font-size:var(--product-button-size)!important;}';
	$css .= 'body.single-product .orvio-product--premium .orvio-product__buybox .button:hover,body.single-product .orvio-product--premium .orvio-product__buybox .single_add_to_cart_button:hover,body.single-product .orvio-sticky-atc .orvio-btn--primary:hover{background:var(--product-button-hover)!important;color:var(--product-button-text)!important;}';
	$css .= 'body.single-product .orvio-sticky-atc .orvio-price,body.single-product .orvio-sticky-atc .orvio-price ins{color:var(--product-price)!important;}';
	$css .= 'body.single-product .orvio-product--premium .woocommerce-product-rating .star-rating{color:var(--product-accent);}';
	$css .= 'body.single-product.orvio-product-tabs-underline .orvio-product-after .woocommerce-tabs{border:0!important;border-bottom:1px solid var(--product-border)!important;border-radius:0!important;background:transparent!important;}';
	$css .= 'body.single-product.orvio-product-tabs-minimal .orvio-product-after .woocommerce-tabs{border:0!important;border-radius:0!important;background:transparent!important;padding-inline:0;}';
	$css .= 'body.single-product.orvio-product-hide-sku .orvio-product--premium .product_meta .sku_wrapper{display:none!important;}';
	echo '<style id="orvio-vars">' . $css . '</style>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- hex/int/font stacks sanitized.
}

add_filter( 'body_class', 'orvio_body_classes' );
function orvio_body_classes( $classes ) {
	$o = orvio_settings();
	$site_styles = array( 'editorial', 'saas' );
	$classes[] = 'orvio-site-style-' . ( in_array( $o['site_style'] ?? 'editorial', $site_styles, true ) ? $o['site_style'] : 'editorial' );
	$header_layout = in_array( $o['header_layout'], array( 'classic', 'centered', 'split', 'minimal' ), true ) ? $o['header_layout'] : 'classic';
	$classes[] = 'orvio-header-layout-' . $header_layout;
	if ( 'centered' === $header_layout ) {
		$classes[] = 'orvio-h-centered';
	}
	if ( 'classic' !== $o['card_style'] ) {
		$classes[] = 'orvio-cards-' . sanitize_html_class( $o['card_style'] );
	}
	$card_contents = array( 'below', 'tile', 'hover-info', 'hover-overlay' );
	$classes[] = 'orvio-card-content-' . ( in_array( $o['card_content'], $card_contents, true ) ? $o['card_content'] : 'below' );
	if ( empty( $o['sticky_summary'] ) ) {
		$classes[] = 'orvio-summary-static';
	}
	if ( empty( $o['sticky_header'] ) ) {
		$classes[] = 'orvio-header-static';
	}
	$header_styles = array( 'minimal', 'pill', 'solid', 'outline', 'soft' );
	$classes[] = 'orvio-header-account-' . ( in_array( $o['header_account_style'], $header_styles, true ) ? $o['header_account_style'] : 'minimal' );
	$classes[] = 'orvio-header-cart-' . ( in_array( $o['header_cart_style'], $header_styles, true ) ? $o['header_cart_style'] : 'pill' );
	if ( function_exists( 'is_shop' ) && ( is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag() ) ) {
		$shop_layouts = array( 'sidebar-grid', 'wide-grid', 'list', 'masonry', 'minimal' );
		$classes[] = 'orvio-shop-layout-' . ( in_array( $o['shop_layout'], $shop_layouts, true ) ? $o['shop_layout'] : 'sidebar-grid' );
	}
	if ( function_exists( 'is_product' ) && is_product() ) {
		$product_layouts = array( 'classic', 'gallery-right', 'stacked', 'immersive' );
		$classes[] = 'orvio-product-layout-' . ( in_array( $o['product_layout'], $product_layouts, true ) ? $o['product_layout'] : 'classic' );
		$product_tabs = array( 'card', 'underline', 'minimal' );
			$classes[] = 'orvio-product-tabs-' . ( in_array( $o['product_tabs_style'] ?? 'card', $product_tabs, true ) ? $o['product_tabs_style'] : 'card' );
			$product_width_modes = array( 'inherit', 'wide', 'extra-wide', 'boxed', 'content-wide' );
			$product_width_mode = in_array( $o['product_width_mode'] ?? 'inherit', $product_width_modes, true ) ? $o['product_width_mode'] : 'inherit';
			if ( 'inherit' !== $product_width_mode ) {
				$classes[] = 'orvio-product-width-' . $product_width_mode;
			}
			if ( empty( $o['product_show_sku'] ) ) {
			$classes[] = 'orvio-product-hide-sku';
		}
	}
	if ( function_exists( 'is_cart' ) && is_cart() ) {
		$cart_layouts = array( 'saas-split', 'saas-focus', 'saas-compact', 'saas-bento' );
		$classes[] = 'orvio-cart-style-saas';
		$classes[] = 'orvio-cart-layout-' . ( in_array( $o['cart_layout'], $cart_layouts, true ) ? $o['cart_layout'] : 'saas-split' );
	}
	if ( function_exists( 'is_checkout' ) && is_checkout() && ( ! function_exists( 'is_order_received_page' ) || ! is_order_received_page() ) ) {
		$page_layouts = array( 'split', 'classic', 'compact', 'focus', 'minimal' );
		$classes[] = 'orvio-checkout-layout-' . ( in_array( $o['checkout_layout'], $page_layouts, true ) ? $o['checkout_layout'] : 'split' );
	}
	$mobile_styles      = array( 'bar', 'floating', 'pill', 'glass', 'dark', 'minimal' );
	$mobile_nav_has_item = false;
	foreach ( (array) ( $o['mobile_nav_items'] ?? array() ) as $mobile_item ) {
		if ( is_array( $mobile_item ) && ! empty( $mobile_item['enabled'] ) ) {
			$mobile_nav_has_item = true;
			break;
		}
	}
	if ( ! empty( $o['mobile_nav_enabled'] ) && $mobile_nav_has_item ) {
		$classes[] = 'orvio-mobile-nav-on';
		$classes[] = 'orvio-mobile-nav-style-' . ( in_array( $o['mobile_nav_style'], $mobile_styles, true ) ? $o['mobile_nav_style'] : 'bar' );
		if ( ! empty( $o['mobile_nav_height'] ) && (int) $o['mobile_nav_height'] >= 70 ) {
			$classes[] = 'orvio-mobile-nav-tall';
		}
		if ( ! empty( $o['mobile_nav_spacing'] ) && (int) $o['mobile_nav_spacing'] >= 12 ) {
			$classes[] = 'orvio-mobile-nav-roomy';
		}
	}
	if ( function_exists( 'is_account_page' ) && is_account_page() ) {
		$classes[] = 'orvio-account-fullscreen';
		$account_layouts = array( 'saas' );
		$account_styles  = array( 'saas' );
		$classes[] = 'orvio-account-layout-' . ( in_array( $o['account_layout'], $account_layouts, true ) ? $o['account_layout'] : 'saas' );
		$classes[] = 'orvio-account-style-' . ( in_array( $o['account_style'], $account_styles, true ) ? $o['account_style'] : 'saas' );
	}
	$layout = in_array( $o['site_layout'], array( 'wide', 'boxed', 'content-wide' ), true ) ? $o['site_layout'] : 'wide';
	$atc    = in_array( $o['atc_style'], array( 'pill', 'block', 'outline', 'soft' ), true ) ? $o['atc_style'] : 'pill';
	$classes[] = 'orvio-layout-' . $layout;
	$classes[] = 'orvio-atc-' . $atc;
	return $classes;
}
