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
		'radius'             => 16,
		'container'          => 1220,
		'site_layout'        => 'wide',
		'atc_style'          => 'pill',
		'atc_behavior'       => 'auto',
		'atc_visual'         => 'text',
		'body_font'          => 'vazirmatn',
		'heading_font'       => 'vazirmatn',
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
		'announcement'       => 'ارسال رایگان برای سفارش‌های بالای ۲ میلیون تومان  ·  بازگشت آسان تا ۳۰ روز',
		'announcement_en'    => 'Free shipping over the threshold · Easy 30-day returns',
		'free_shipping'      => 2000000,
		'cart_type'          => 'drawer',
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
		'shop_columns'       => 3,
		'products_per_page'  => 12,
		'shop_layout'        => 'sidebar-grid',
		'card_style'         => 'classic',
		'card_content'       => 'below',
		'shop_sidebar'       => 1,
		'product_layout'     => 'classic',
		'related_count'      => 4,
		'sticky_summary'     => 1,
		'cart_layout'        => 'split',
		'checkout_layout'    => 'split',
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
	return wp_parse_args( $saved, orvio_defaults() );
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
	$hex      = array( 'accent', 'bg', 'ink', 'dark', 'header_bg', 'header_ink' );
	foreach ( $hex as $key ) {
		$clean[ $key ] = sanitize_hex_color( $input[ $key ] ?? '' ) ?: $defaults[ $key ];
	}
	$clean['radius']            = max( 0, min( 28, absint( $input['radius'] ?? $defaults['radius'] ) ) );
	$clean['container']         = max( 960, min( 1680, absint( $input['container'] ?? $defaults['container'] ) ) );
	$clean['font_size']         = max( 13, min( 20, absint( $input['font_size'] ?? $defaults['font_size'] ) ) );
	$clean['menu_size']         = max( 12, min( 20, absint( $input['menu_size'] ?? $defaults['menu_size'] ) ) );
	$fonts                      = array( 'vazirmatn', 'instrument', 'fraunces', 'system' );
	$clean['body_font']         = in_array( $input['body_font'] ?? '', $fonts, true ) ? $input['body_font'] : 'vazirmatn';
	$clean['heading_font']      = in_array( $input['heading_font'] ?? '', $fonts, true ) ? $input['heading_font'] : 'vazirmatn';
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
	$clean['cart_layout']         = in_array( $input['cart_layout'] ?? '', $page_layouts, true ) ? $input['cart_layout'] : 'split';
	$clean['checkout_layout']     = in_array( $input['checkout_layout'] ?? '', $page_layouts, true ) ? $input['checkout_layout'] : 'split';
	$card_styles                  = array( 'classic', 'minimal', 'overlay', 'editorial', 'deal', 'polaroid', 'magazine' );
	$clean['card_style']           = in_array( $input['card_style'] ?? '', $card_styles, true ) ? $input['card_style'] : 'classic';
	$card_contents                = array( 'below', 'tile', 'hover-info', 'hover-overlay' );
	$clean['card_content']         = in_array( $input['card_content'] ?? '', $card_contents, true ) ? $input['card_content'] : 'below';
	$clean['shop_columns']      = max( 2, min( 5, absint( $input['shop_columns'] ?? 3 ) ) );
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
	$toggles                    = array( 'sticky_header', 'mobile_nav_enabled', 'show_announcement', 'shop_sidebar', 'sticky_summary', 'enable_wishlist', 'enable_quick_view', 'show_search', 'show_account', 'show_cart', 'show_catbar' );
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
	$tabs = array(
		'general'  => orvio_t( 'Design', 'طراحی' ),
		'header'   => orvio_t( 'Header', 'هدر' ),
		'footer'   => orvio_t( 'Footer', 'فوتر' ),
		'shop'     => orvio_t( 'Shop', 'فروشگاه' ),
		'product'  => orvio_t( 'Product', 'محصول' ),
		'checkout' => orvio_t( 'Cart & checkout', 'سبد و صورتحساب' ),
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
					<div class="orvio-card"><h2><?php echo esc_html( orvio_t( 'Type', 'فونت' ) ); ?></h2>
						<?php
						orvio_field_select( 'body_font', orvio_t( 'Body font', 'فونت متن' ), $o, orvio_font_choices() );
						orvio_field_select( 'heading_font', orvio_t( 'Heading font', 'فونت عنوان' ), $o, orvio_font_choices() );
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
						orvio_field_check( 'mobile_nav_enabled', orvio_t( 'Mobile navigation', 'ناوبری موبایل' ), $o );
						orvio_field_select( 'mobile_nav_style', orvio_t( 'Mobile nav style', 'استایل ناوبری موبایل' ), $o, array(
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
						echo '<h3 style="margin-top:18px">' . esc_html( orvio_t( 'Mobile navigation buttons', 'دکمه‌های ناوبری موبایل' ) ) . '</h3>';
						foreach ( orvio_mobile_nav_defaults() as $slot => $default ) {
							orvio_field_mobile_nav_item( $slot, $o['mobile_nav_items'][ $slot ] ?? $default );
						}
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
						orvio_field_number( 'shop_columns', orvio_t( 'Columns', 'ستون‌ها' ), $o, 2, 5 );
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
				</section>
				<section data-panel="checkout" class="orvio-panel">
					<div class="orvio-card"><h2><?php echo esc_html( orvio_t( 'Cart', 'سبد' ) ); ?></h2>
						<?php
						orvio_field_select( 'cart_type', orvio_t( 'Cart button', 'دکمه سبد' ), $o, array(
							'drawer' => orvio_t( 'Drawer', 'کشو' ),
							'page'   => orvio_t( 'Cart page', 'صفحه سبد' ),
						) );
						orvio_field_select( 'cart_layout', orvio_t( 'Cart layout', 'چیدمان سبد خرید' ), $o, orvio_page_layout_choices() );
						orvio_field_select( 'checkout_layout', orvio_t( 'Checkout layout', 'چیدمان صورتحساب' ), $o, orvio_page_layout_choices() );
						echo '<h3 style="margin-top:18px">' . esc_html( orvio_t( 'Billing fields', 'فیلدهای صورتحساب' ) ) . '</h3>';
						foreach ( orvio_billing_labels() as $field => $label ) {
							orvio_field_billing_mode( $field, $label, $o );
						}
						orvio_field_number( 'free_shipping', orvio_t( 'Free shipping from', 'ارسال رایگان از' ), $o, 0, 999999999 );
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
	$css  = ':root{--accent:' . $o['accent'] . ';--accent-dark:' . $o['accent'] . ';--bg:' . $o['bg'] . ';--ink:' . $o['ink'] . ';--dark:' . $o['dark'] . ';--radius:' . intval( $o['radius'] ) . 'px;--radius-sm:' . max( 4, intval( $o['radius'] ) - 4 ) . 'px;--container:' . intval( $o['container'] ) . 'px;--cols:' . intval( $o['shop_columns'] ) . ';--font:' . $body . ';--display:' . $head . ';--header-bg:' . $o['header_bg'] . ';--header-ink:' . $o['header_ink'] . ';--menu-size:' . intval( $o['menu_size'] ) . 'px;}';
	$css .= 'body{font-size:' . intval( $o['font_size'] ) . 'px;}';
	$css .= 'h1,h2,h3,h4,.orvio-logo__word strong{font-family:var(--display);}';
	$css .= '.orvio-header,.orvio-catbar{background:var(--header-bg);color:var(--header-ink);}';
	$css .= '.orvio-catbar__menu>li>a,.orvio-tool__label,.orvio-logo__word{font-size:var(--menu-size);}';
	echo '<style id="orvio-vars">' . $css . '</style>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- hex/int/font stacks sanitized.
}

add_filter( 'body_class', 'orvio_body_classes' );
function orvio_body_classes( $classes ) {
	$o = orvio_settings();
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
	}
	if ( function_exists( 'is_cart' ) && is_cart() ) {
		$page_layouts = array( 'split', 'classic', 'compact', 'focus', 'minimal' );
		$classes[] = 'orvio-cart-layout-' . ( in_array( $o['cart_layout'], $page_layouts, true ) ? $o['cart_layout'] : 'split' );
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
	$layout = in_array( $o['site_layout'], array( 'wide', 'boxed', 'content-wide' ), true ) ? $o['site_layout'] : 'wide';
	$atc    = in_array( $o['atc_style'], array( 'pill', 'block', 'outline', 'soft' ), true ) ? $o['atc_style'] : 'pill';
	$classes[] = 'orvio-layout-' . $layout;
	$classes[] = 'orvio-atc-' . $atc;
	return $classes;
}
