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

function orvio_defaults() {
	return array(
		'accent'             => '#A34B2B',
		'bg'                 => '#F3EFE8',
		'ink'                => '#1C1916',
		'dark'               => '#171512',
		'radius'             => 16,
		'container'          => 1220,
		'header_layout'      => 'classic',
		'sticky_header'      => 1,
		'show_announcement'  => 1,
		'announcement'       => 'ارسال رایگان برای سفارش‌های بالای ۲ میلیون تومان  ·  بازگشت آسان تا ۳۰ روز',
		'announcement_en'    => 'Free shipping over the threshold · Easy 30-day returns',
		'free_shipping'      => 2000000,
		'cart_type'          => 'drawer',
		'shop_columns'       => 3,
		'products_per_page'  => 12,
		'card_style'         => 'classic',
		'shop_sidebar'       => 1,
		'related_count'      => 4,
		'sticky_summary'     => 1,
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
	$hex      = array( 'accent', 'bg', 'ink', 'dark' );
	foreach ( $hex as $key ) {
		$clean[ $key ] = sanitize_hex_color( $input[ $key ] ?? '' ) ?: $defaults[ $key ];
	}
	$clean['radius']            = max( 0, min( 28, absint( $input['radius'] ?? $defaults['radius'] ) ) );
	$clean['container']         = max( 960, min( 1600, absint( $input['container'] ?? $defaults['container'] ) ) );
	$clean['header_layout']     = in_array( $input['header_layout'] ?? '', array( 'classic', 'centered' ), true ) ? $input['header_layout'] : 'classic';
	$clean['cart_type']         = in_array( $input['cart_type'] ?? '', array( 'drawer', 'page' ), true ) ? $input['cart_type'] : 'drawer';
	$clean['card_style']        = in_array( $input['card_style'] ?? '', array( 'classic', 'minimal', 'overlay' ), true ) ? $input['card_style'] : 'classic';
	$clean['shop_columns']      = max( 2, min( 5, absint( $input['shop_columns'] ?? 3 ) ) );
	$clean['products_per_page'] = max( 4, min( 48, absint( $input['products_per_page'] ?? 12 ) ) );
	$clean['related_count']     = max( 2, min( 8, absint( $input['related_count'] ?? 4 ) ) );
	$clean['free_shipping']     = max( 0, absint( $input['free_shipping'] ?? 0 ) );
	$toggles                    = array( 'sticky_header', 'show_announcement', 'shop_sidebar', 'sticky_summary', 'enable_wishlist', 'enable_quick_view' );
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
		'general'  => orvio_t( 'General', 'عمومی' ),
		'header'   => orvio_t( 'Header', 'هدر' ),
		'footer'   => orvio_t( 'Footer', 'فوتر' ),
		'shop'     => orvio_t( 'Shop', 'فروشگاه' ),
		'product'  => orvio_t( 'Product', 'محصول' ),
		'checkout' => orvio_t( 'Cart & checkout', 'سبد و صورتحساب' ),
		'contact'  => orvio_t( 'Contact', 'ارتباط' ),
	);
	?>
	<div class="wrap orvio-admin">
		<div class="orvio-admin__hero">
			<div>
				<p class="orvio-admin__kicker">ORVIO</p>
				<h1><?php echo esc_html( orvio_t( 'Theme settings', 'تنظیمات قالب' ) ); ?></h1>
				<p><?php echo esc_html( orvio_t( 'Colors, header, shop, cart and contact — applied as CSS variables, without breaking mobile.', 'رنگ، هدر، فروشگاه، سبد و تماس. به‌صورت متغیر CSS اعمال می‌شود و چیدمان موبایل را به‌هم نمی‌ریزد.' ) ); ?></p>
			</div>
			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<?php wp_nonce_field( 'orvio_import_demo' ); ?>
					<input type="hidden" name="action" value="orvio_import_demo">
					<button class="button button-primary button-hero" type="submit"><?php echo esc_html( orvio_t( 'Install demo catalog', 'نصب کاتالوگ دمو' ) ); ?></button>
				</form>
			<?php else : ?>
				<p class="orvio-admin__warn"><?php echo esc_html( orvio_t( 'Install WooCommerce to import the demo catalog and unlock shop templates.', 'برای واردات کاتالوگ دمو و قالب‌های فروشگاه، ووکامرس را نصب کنید.' ) ); ?></p>
			<?php endif; ?>
		</div>
		<?php if ( isset( $_GET['orvio-imported'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
			<div class="notice notice-success"><p><?php echo esc_html( orvio_t( 'Demo catalog installed.', 'کاتالوگ دمو نصب شد.' ) ); ?></p></div>
		<?php endif; ?>
		<nav class="orvio-admin__tabs" role="tablist">
			<?php foreach ( $tabs as $id => $label ) : ?>
				<button type="button" class="<?php echo 'general' === $id ? 'is-on' : ''; ?>" data-tab="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?></button>
			<?php endforeach; ?>
		</nav>
		<form method="post" action="options.php" class="orvio-admin__form">
			<?php settings_fields( 'orvio_settings_group' ); ?>
			<section data-panel="general" class="orvio-admin__panel">
				<?php
				orvio_field_color( 'accent', orvio_t( 'Accent', 'رنگ تأکید' ), $o );
				orvio_field_color( 'bg', orvio_t( 'Background', 'پس‌زمینه' ), $o );
				orvio_field_color( 'ink', orvio_t( 'Ink', 'متن' ), $o );
				orvio_field_color( 'dark', orvio_t( 'Dark sections', 'بخش‌های تیره' ), $o );
				orvio_field_number( 'radius', orvio_t( 'Corner radius', 'گردی گوشه‌ها' ), $o, 0, 28 );
				orvio_field_number( 'container', orvio_t( 'Container width', 'عرض محتوا' ), $o, 960, 1600 );
				?>
			</section>
			<section data-panel="header" class="orvio-admin__panel" hidden>
				<?php
				orvio_field_select( 'header_layout', orvio_t( 'Header layout', 'چیدمان هدر' ), $o, array(
					'classic'  => orvio_t( 'Standard', 'استاندارد' ),
					'centered' => orvio_t( 'Centered logo', 'لوگوی وسط' ),
				) );
				orvio_field_check( 'sticky_header', orvio_t( 'Sticky header', 'هدر چسبان' ), $o );
				orvio_field_check( 'show_announcement', orvio_t( 'Announcement bar', 'نوار اعلان' ), $o );
				orvio_field_text( 'announcement', orvio_t( 'Announcement (primary)', 'متن اعلان' ), $o );
				orvio_field_text( 'announcement_en', orvio_t( 'Announcement (English)', 'متن اعلان انگلیسی' ), $o );
				?>
			</section>
			<section data-panel="footer" class="orvio-admin__panel" hidden>
				<?php
				orvio_field_text( 'footer_about', orvio_t( 'Footer about', 'معرفی فوتر' ), $o );
				orvio_field_text( 'copyright', orvio_t( 'Copyright', 'کپی‌رایت' ), $o );
				orvio_field_text( 'instagram', 'Instagram', $o );
				orvio_field_text( 'telegram', 'Telegram', $o );
				orvio_field_text( 'whatsapp', 'WhatsApp', $o );
				?>
			</section>
			<section data-panel="shop" class="orvio-admin__panel" hidden>
				<?php
				orvio_field_number( 'shop_columns', orvio_t( 'Shop columns', 'ستون‌های فروشگاه' ), $o, 2, 5 );
				orvio_field_number( 'products_per_page', orvio_t( 'Products per page', 'تعداد در هر صفحه' ), $o, 4, 48 );
				orvio_field_select( 'card_style', orvio_t( 'Product card', 'کارت کالا' ), $o, array(
					'classic' => orvio_t( 'Classic', 'کلاسیک' ),
					'minimal' => orvio_t( 'Minimal', 'مینیمال' ),
					'overlay' => orvio_t( 'Overlay', 'روی تصویر' ),
				) );
				orvio_field_check( 'shop_sidebar', orvio_t( 'Filter sidebar', 'سایدبار فیلتر' ), $o );
				orvio_field_check( 'enable_wishlist', orvio_t( 'Wishlist', 'علاقه‌مندی' ), $o );
				orvio_field_check( 'enable_quick_view', orvio_t( 'Quick view', 'نگاه سریع' ), $o );
				?>
			</section>
			<section data-panel="product" class="orvio-admin__panel" hidden>
				<?php
				orvio_field_check( 'sticky_summary', orvio_t( 'Sticky product summary', 'خلاصه چسبان محصول' ), $o );
				orvio_field_number( 'related_count', orvio_t( 'Related products', 'کالاهای مرتبط' ), $o, 2, 8 );
				?>
			</section>
			<section data-panel="checkout" class="orvio-admin__panel" hidden>
				<?php
				orvio_field_select( 'cart_type', orvio_t( 'Cart button behaviour', 'رفتار دکمه سبد' ), $o, array(
					'drawer' => orvio_t( 'Slide-over drawer', 'کشو' ),
					'page'   => orvio_t( 'Go to cart page', 'رفتن به صفحه سبد' ),
				) );
				orvio_field_number( 'free_shipping', orvio_t( 'Free-shipping threshold', 'آستانه ارسال رایگان' ), $o, 0, 999999999 );
				?>
			</section>
			<section data-panel="contact" class="orvio-admin__panel" hidden>
				<?php
				orvio_field_text( 'phone', orvio_t( 'Phone', 'تلفن' ), $o );
				orvio_field_text( 'email', orvio_t( 'Email', 'ایمیل' ), $o );
				orvio_field_text( 'address', orvio_t( 'Address', 'آدرس' ), $o );
				orvio_field_text( 'hours', orvio_t( 'Hours', 'ساعت کاری' ), $o );
				?>
			</section>
			<?php submit_button( orvio_t( 'Save settings', 'ذخیره تنظیمات' ) ); ?>
		</form>
	</div>
	<?php
}

function orvio_field_color( $key, $label, $o ) {
	echo '<label class="orvio-admin__field"><span>' . esc_html( $label ) . '</span><input type="color" name="orvio_settings[' . esc_attr( $key ) . ']" value="' . esc_attr( $o[ $key ] ) . '"></label>';
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
function orvio_field_select( $key, $label, $o, $choices ) {
	echo '<label class="orvio-admin__field"><span>' . esc_html( $label ) . '</span><select name="orvio_settings[' . esc_attr( $key ) . ']">';
	foreach ( $choices as $value => $text ) {
		echo '<option value="' . esc_attr( $value ) . '" ' . selected( $o[ $key ], $value, false ) . '>' . esc_html( $text ) . '</option>';
	}
	echo '</select></label>';
}

add_action( 'wp_head', 'orvio_print_css_vars', 20 );
function orvio_print_css_vars() {
	$o = orvio_settings();
	$css = ':root{--accent:' . $o['accent'] . ';--accent-dark:' . $o['accent'] . ';--bg:' . $o['bg'] . ';--ink:' . $o['ink'] . ';--dark:' . $o['dark'] . ';--radius:' . intval( $o['radius'] ) . 'px;--radius-sm:' . max( 4, intval( $o['radius'] ) - 4 ) . 'px;--container:' . intval( $o['container'] ) . 'px;--cols:' . intval( $o['shop_columns'] ) . ';}';
	echo '<style id="orvio-vars">' . $css . '</style>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- hex/int sanitized.
}

add_filter( 'body_class', 'orvio_body_classes' );
function orvio_body_classes( $classes ) {
	$o = orvio_settings();
	if ( 'centered' === $o['header_layout'] ) {
		$classes[] = 'orvio-h-centered';
	}
	if ( 'classic' !== $o['card_style'] ) {
		$classes[] = 'orvio-cards-' . sanitize_html_class( $o['card_style'] );
	}
	if ( empty( $o['sticky_summary'] ) ) {
		$classes[] = 'orvio-summary-static';
	}
	return $classes;
}
