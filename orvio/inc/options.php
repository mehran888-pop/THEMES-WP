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
		'site_layout'        => 'wide',
		'atc_style'          => 'pill',
		'body_font'          => 'vazirmatn',
		'heading_font'       => 'vazirmatn',
		'font_size'          => 15,
		'header_layout'      => 'classic',
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
	$clean['header_layout']     = in_array( $input['header_layout'] ?? '', array( 'classic', 'centered' ), true ) ? $input['header_layout'] : 'classic';
	$clean['site_layout']       = in_array( $input['site_layout'] ?? '', array( 'wide', 'boxed', 'content-wide' ), true ) ? $input['site_layout'] : 'wide';
	$clean['atc_style']         = in_array( $input['atc_style'] ?? '', array( 'pill', 'block', 'outline', 'soft' ), true ) ? $input['atc_style'] : 'pill';
	$clean['cart_type']         = in_array( $input['cart_type'] ?? '', array( 'drawer', 'page' ), true ) ? $input['cart_type'] : 'drawer';
	$clean['card_style']        = in_array( $input['card_style'] ?? '', array( 'classic', 'minimal', 'overlay' ), true ) ? $input['card_style'] : 'classic';
	$clean['shop_columns']      = max( 2, min( 5, absint( $input['shop_columns'] ?? 3 ) ) );
	$clean['products_per_page'] = max( 4, min( 48, absint( $input['products_per_page'] ?? 12 ) ) );
	$clean['related_count']     = max( 2, min( 8, absint( $input['related_count'] ?? 4 ) ) );
	$clean['free_shipping']     = max( 0, absint( $input['free_shipping'] ?? 0 ) );
	$toggles                    = array( 'sticky_header', 'show_announcement', 'shop_sidebar', 'sticky_summary', 'enable_wishlist', 'enable_quick_view', 'show_search', 'show_account', 'show_cart', 'show_catbar' );
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
						) );
						orvio_field_check( 'sticky_header', orvio_t( 'Sticky header', 'هدر چسبان' ), $o );
						orvio_field_color( 'header_bg', orvio_t( 'Background', 'پس‌زمینه' ), $o );
						orvio_field_color( 'header_ink', orvio_t( 'Text', 'متن' ), $o );
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
				<section data-panel="footer" class="orvio-panel">
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
						orvio_field_select( 'card_style', orvio_t( 'Card', 'کارت کالا' ), $o, array(
							'classic' => orvio_t( 'Classic', 'کلاسیک' ),
							'minimal' => orvio_t( 'Minimal', 'مینیمال' ),
							'overlay' => orvio_t( 'Overlay', 'روی تصویر' ),
						) );
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
	if ( 'centered' === $o['header_layout'] ) {
		$classes[] = 'orvio-h-centered';
	}
	if ( 'classic' !== $o['card_style'] ) {
		$classes[] = 'orvio-cards-' . sanitize_html_class( $o['card_style'] );
	}
	if ( empty( $o['sticky_summary'] ) ) {
		$classes[] = 'orvio-summary-static';
	}
	if ( empty( $o['sticky_header'] ) ) {
		$classes[] = 'orvio-header-static';
	}
	$layout = in_array( $o['site_layout'], array( 'wide', 'boxed', 'content-wide' ), true ) ? $o['site_layout'] : 'wide';
	$atc    = in_array( $o['atc_style'], array( 'pill', 'block', 'outline', 'soft' ), true ) ? $o['atc_style'] : 'pill';
	$classes[] = 'orvio-layout-' . $layout;
	$classes[] = 'orvio-atc-' . $atc;
	return $classes;
}
