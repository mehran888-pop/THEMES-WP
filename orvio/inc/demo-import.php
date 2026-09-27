<?php
/**
 * One-click demo catalog.
 *
 * @package Orvio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once ORVIO_DIR . '/inc/sample-catalog.php';

add_action( 'admin_post_orvio_import_demo', 'orvio_import_demo' );
function orvio_import_demo() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html( orvio_t( 'Not allowed.', 'مجاز نیست.' ) ) );
	}
	check_admin_referer( 'orvio_import_demo' );
	if ( ! class_exists( 'WooCommerce' ) ) {
		wp_die( esc_html( orvio_t( 'Activate WooCommerce first.', 'اول ووکامرس را فعال کنید.' ) ) );
	}

	$locale = function_exists( 'determine_locale' ) ? determine_locale() : get_locale();
	$fa     = 0 === strpos( $locale, 'fa' ) || is_rtl();
	$cats   = array();
	foreach ( orvio_sample_categories() as $slug => $cat ) {
		$existing = term_exists( $slug, 'product_cat' );
		if ( $existing ) {
			$cats[ $slug ] = (int) ( is_array( $existing ) ? $existing['term_id'] : $existing );
			continue;
		}
		$made = wp_insert_term( $fa ? $cat['fa'] : $cat['en'], 'product_cat', array( 'slug' => $slug ) );
		if ( is_wp_error( $made ) ) {
			continue;
		}
		$cats[ $slug ] = (int) $made['term_id'];
		$thumb         = orvio_sideload_theme_image( $cat['img'] );
		if ( $thumb ) {
			update_term_meta( $cats[ $slug ], 'thumbnail_id', $thumb );
		}
	}

	foreach ( orvio_sample_catalog() as $item ) {
		$found = wc_get_product_id_by_sku( $item['sku'] );
		if ( $found ) {
			continue;
		}
		$product = new WC_Product_Simple();
		$product->set_name( $fa ? $item['fa'] : $item['en'] );
		$product->set_sku( $item['sku'] );
		$product->set_regular_price( (string) $item['price'] );
		if ( ! empty( $item['sale'] ) ) {
			$product->set_sale_price( (string) $item['sale'] );
		}
		$product->set_status( 'publish' );
		$product->set_catalog_visibility( 'visible' );
		$product->set_manage_stock( true );
		$product->set_stock_quantity( (int) $item['stock'] );
		$product->set_short_description( $fa ? 'قطعه‌ای از ویترین اُرویو.' : 'A piece from the Orvio edit.' );
		$product->set_description( $fa ? 'این کالا با نصب دموی قالب اُرویو ساخته شده است.' : 'Created by the Orvio demo importer.' );
		if ( isset( $cats[ $item['cat'] ] ) ) {
			$product->set_category_ids( array( $cats[ $item['cat'] ] ) );
		}
		$image = orvio_sideload_theme_image( $item['img'] );
		if ( $image ) {
			$product->set_image_id( $image );
		}
		$gallery = array();
		foreach ( $item['gallery'] as $path ) {
			$id = orvio_sideload_theme_image( $path );
			if ( $id ) {
				$gallery[] = $id;
			}
		}
		if ( $gallery ) {
			$product->set_gallery_image_ids( $gallery );
		}
		$product->save();
	}

	orvio_ensure_pages( $fa );
	wp_safe_redirect( admin_url( 'admin.php?page=orvio-settings&orvio-imported=1' ) );
	exit;
}

function orvio_sideload_theme_image( $relative ) {
	$file = ORVIO_DIR . '/' . ltrim( $relative, '/' );
	if ( ! file_exists( $file ) ) {
		return 0;
	}
	$filename = basename( $file );
	$existing = get_posts( array(
		'post_type'      => 'attachment',
		'posts_per_page' => 1,
		'meta_key'       => '_orvio_source',
		'meta_value'     => $relative,
		'fields'         => 'ids',
	) );
	if ( $existing ) {
		return (int) $existing[0];
	}
	$upload = wp_upload_bits( $filename, null, file_get_contents( $file ) );
	if ( ! empty( $upload['error'] ) ) {
		return 0;
	}
	$filetype = wp_check_filetype( $upload['file'] );
	$id       = wp_insert_attachment( array(
		'post_mime_type' => $filetype['type'],
		'post_title'     => sanitize_file_name( pathinfo( $filename, PATHINFO_FILENAME ) ),
		'post_status'    => 'inherit',
	), $upload['file'] );
	if ( is_wp_error( $id ) || ! $id ) {
		return 0;
	}
	require_once ABSPATH . 'wp-admin/includes/image.php';
	wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $upload['file'] ) );
	update_post_meta( $id, '_orvio_source', $relative );
	return (int) $id;
}

function orvio_ensure_pages( $fa ) {
	$pages = array(
		'frontpage' => $fa ? 'صفحه اصلی' : 'Home',
		'about'     => $fa ? 'درباره ما' : 'About',
		'contact'   => $fa ? 'ارتباط با ما' : 'Contact',
	);
	$ids = array();
	foreach ( $pages as $slug => $title ) {
		$found = get_page_by_path( $slug );
		if ( ! $found && 'frontpage' === $slug ) {
			$found = get_page_by_path( 'home' );
		}
		if ( $found ) {
			$ids[ $slug ] = $found->ID;
			$update = array( 'ID' => $found->ID );
			if ( 'frontpage' === $slug && 'home' === $found->post_name ) {
				$update['post_name'] = 'frontpage';
			}
			if ( 'frontpage' === $slug && in_array( $found->post_title, array( 'خانه', 'Home' ), true ) ) {
				$update['post_title'] = $title;
			}
			if ( count( $update ) > 1 ) {
				wp_update_post( $update );
			}
			continue;
		}
		$ids[ $slug ] = wp_insert_post( array(
			'post_title'  => $title,
			'post_name'   => $slug,
			'post_status' => 'publish',
			'post_type'   => 'page',
		) );
	}
	if ( ! empty( $ids['frontpage'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $ids['frontpage'] );
		if ( did_action( 'elementor/loaded' ) && 'builder' !== get_post_meta( $ids['frontpage'], '_elementor_edit_mode', true ) ) {
			orvio_seed_elementor_home( (int) $ids['frontpage'] );
		}
	}
	$menu = wp_get_nav_menu_object( 'Orvio' );
	if ( ! $menu ) {
		$menu_id = wp_create_nav_menu( 'Orvio' );
		if ( ! is_wp_error( $menu_id ) && ! empty( $ids['about'] ) ) {
			wp_update_nav_menu_item( $menu_id, 0, array( 'menu-item-title' => $pages['about'], 'menu-item-object' => 'page', 'menu-item-object-id' => $ids['about'], 'menu-item-type' => 'post_type', 'menu-item-status' => 'publish' ) );
			wp_update_nav_menu_item( $menu_id, 0, array( 'menu-item-title' => $pages['contact'], 'menu-item-object' => 'page', 'menu-item-object-id' => $ids['contact'], 'menu-item-type' => 'post_type', 'menu-item-status' => 'publish' ) );
			$locations            = get_theme_mod( 'nav_menu_locations', array() );
			$locations['footer']  = $menu_id;
			$locations['primary'] = $menu_id;
			set_theme_mod( 'nav_menu_locations', $locations );
		}
	}
}

function orvio_el_id() {
	return substr( md5( uniqid( '', true ) ), 0, 7 );
}

function orvio_seed_elementor_home( $page_id ) {
	$widget = function ( $type, $settings ) {
		return array(
			'id'         => orvio_el_id(),
			'elType'     => 'widget',
			'widgetType' => $type,
			'settings'   => $settings,
			'elements'   => array(),
		);
	};
	$section = function ( $widgets, $full = false ) {
		return array(
			'id'       => orvio_el_id(),
			'elType'   => 'section',
			'settings' => array(
				'layout'        => $full ? 'full_width' : 'boxed',
				'content_width' => array( 'unit' => 'px', 'size' => 1240, 'sizes' => array() ),
				'gap'           => 'no',
				'padding'       => array( 'unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true ),
			),
			'elements' => array(
				array(
					'id'       => orvio_el_id(),
					'elType'   => 'column',
					'settings' => array( '_column_size' => 100 ),
					'elements' => $widgets,
				),
			),
		);
	};
	$data = array(
		$section( array( $widget( 'orvio-hero', array(
			'kicker' => orvio_t( 'Autumn edit', 'مجموعه پاییز' ),
			'title'  => orvio_t( 'Objects for a quieter house', 'اشیائی برای خانه‌ای که آرام است' ),
			'lead'   => orvio_t( 'A considered shop of ceramic, leather, wool and light.', 'ویترینی از سرامیک، چرم، پشم و نور.' ),
			'button' => orvio_t( 'Enter the shop', 'ورود به فروشگاه' ),
		) ) ), true ),
		$section( array( $widget( 'orvio-features', array() ) ) ),
		$section( array( $widget( 'orvio-categories', array( 'heading' => orvio_t( 'Shop by room', 'خرید بر اساس فضا' ), 'limit' => 5 ) ) ) ),
		$section( array( $widget( 'orvio-products', array( 'heading' => orvio_t( 'Just added', 'تازه‌ها' ), 'source' => 'latest', 'limit' => 8, 'columns' => '4', 'layout' => 'grid' ) ) ) ),
		$section( array( $widget( 'orvio-product-banner', array( 'model' => 'split', 'title' => orvio_t( 'Light, oak, and a quiet evening', 'نور، چوب، و یک عصر آرام' ), 'button' => orvio_t( 'Shop home', 'خانه و دکور' ) ) ) ) ),
		$section( array( $widget( 'orvio-products', array( 'heading' => orvio_t( 'Bestsellers', 'پرفروش‌ها' ), 'source' => 'featured', 'layout' => 'carousel', 'limit' => 8, 'columns' => '4' ) ) ) ),
		$section( array( $widget( 'orvio-product-banner', array( 'model' => 'duo', 'title' => orvio_t( 'Apparel', 'پوشاک' ), 'title_2' => orvio_t( 'Audio', 'صدا' ) ) ) ) ),
		$section( array( $widget( 'orvio-about', array( 'title' => orvio_t( 'From a worktable to a shop', 'از یک میز کار تا یک ویترین' ) ) ) ) ),
		$section( array( $widget( 'orvio-newsletter', array() ) ) ),
	);
	update_post_meta( $page_id, '_elementor_edit_mode', 'builder' );
	update_post_meta( $page_id, '_elementor_template_type', 'wp-page' );
	update_post_meta( $page_id, '_elementor_version', defined( 'ELEMENTOR_VERSION' ) ? ELEMENTOR_VERSION : '3.24.0' );
	update_post_meta( $page_id, '_elementor_data', wp_slash( wp_json_encode( $data ) ) );
	update_post_meta( $page_id, '_wp_page_template', 'elementor_header_footer' );
	try {
		if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
			$css = new \Elementor\Core\Files\CSS\Post( $page_id );
			$css->update();
		}
		if ( class_exists( '\Elementor\Plugin' ) && isset( \Elementor\Plugin::$instance->files_manager ) ) {
			\Elementor\Plugin::$instance->files_manager->clear_cache();
		}
	} catch ( \Throwable $e ) { // phpcs:ignore Generic.CodeAnalysis.EmptyStatement.DetectedCatch
		unset( $e );
	}
}

add_action( 'admin_post_orvio_build_front', 'orvio_handle_build_front' );
function orvio_handle_build_front() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html( orvio_t( 'Not allowed.', 'مجاز نیست.' ) ) );
	}
	check_admin_referer( 'orvio_build_front' );
	$result = orvio_build_elementor_front( true );
	$flag   = is_wp_error( $result ) ? 'orvio-front-error' : 'orvio-front';
	wp_safe_redirect( admin_url( 'admin.php?page=orvio-settings&' . $flag . '=1' ) );
	exit;
}

add_action( 'template_redirect', 'orvio_redirect_home_slug' );
function orvio_redirect_home_slug() {
	if ( is_admin() || wp_doing_ajax() ) {
		return;
	}
	$path = trim( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' );
	$base = trim( (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH ), '/' );
	if ( $base && 0 === strpos( $path, $base ) ) {
		$path = trim( substr( $path, strlen( $base ) ), '/' );
	}
	if ( in_array( $path, array( 'home', 'frontpage' ), true ) ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
}

add_action( 'after_switch_theme', 'orvio_assign_front_page' );
add_action( 'admin_init', 'orvio_assign_front_page' );
function orvio_assign_front_page() {
	if ( ! is_admin() || ! current_user_can( 'edit_pages' ) || wp_doing_ajax() ) {
		return;
	}
	$front   = (int) get_option( 'page_on_front' );
	$is_page = $front && 'page' === get_post_type( $front ) && 'publish' === get_post_status( $front );
	if ( 'page' === get_option( 'show_on_front' ) && $is_page ) {
		if ( 'home' === get_post_field( 'post_name', $front ) ) {
			wp_update_post( array( 'ID' => $front, 'post_name' => 'frontpage' ) );
		}
		return;
	}
	$fa = is_rtl() || 0 === strpos( (string) get_locale(), 'fa' );
	orvio_ensure_pages( $fa );
}

add_action( 'admin_init', 'orvio_maybe_build_front' );
function orvio_maybe_build_front() {
	if ( ! current_user_can( 'edit_pages' ) || wp_doing_ajax() || ! class_exists( '\Elementor\Plugin' ) ) {
		return;
	}
	if ( get_option( 'orvio_elementor_front_checked' ) ) {
		return;
	}
	$front = (int) get_option( 'page_on_front' );
	if ( $front && 'builder' === get_post_meta( $front, '_elementor_edit_mode', true ) ) {
		update_option( 'orvio_elementor_front_checked', 1 );
		return;
	}
	$content = $front ? trim( wp_strip_all_tags( (string) get_post_field( 'post_content', $front ) ) ) : '';
	$ours    = $front && in_array( get_post_field( 'post_name', $front ), array( 'home', 'frontpage' ), true );
	if ( $front && $content && ! $ours ) {
		update_option( 'orvio_elementor_front_checked', 1 );
		return;
	}
	$result = orvio_build_elementor_front( (bool) $ours );
	if ( ! is_wp_error( $result ) ) {
		update_option( 'orvio_elementor_front_checked', 1 );
	}
}

function orvio_build_elementor_front( $force = false ) {
	if ( ! class_exists( '\Elementor\Plugin' ) ) {
		return new WP_Error( 'orvio-no-elementor', 'Elementor is not active.' );
	}
	$fa = is_rtl() || 0 === strpos( (string) get_locale(), 'fa' );
	orvio_ensure_pages( $fa );
	$id = (int) get_option( 'page_on_front' );
	if ( ! $id ) {
		return new WP_Error( 'orvio-no-front', 'Front page missing.' );
	}
	$built = 'builder' === get_post_meta( $id, '_elementor_edit_mode', true );
	if ( $built && ! $force ) {
		return $id;
	}
	orvio_seed_elementor_home( $id );
	return $id;
}
