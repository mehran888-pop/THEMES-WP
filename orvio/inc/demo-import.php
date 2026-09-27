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
		'home'    => $fa ? 'خانه' : 'Home',
		'about'   => $fa ? 'درباره ما' : 'About',
		'contact' => $fa ? 'ارتباط با ما' : 'Contact',
	);
	$ids = array();
	foreach ( $pages as $slug => $title ) {
		$found = get_page_by_path( $slug );
		if ( $found ) {
			$ids[ $slug ] = $found->ID;
			continue;
		}
		$ids[ $slug ] = wp_insert_post( array(
			'post_title'  => $title,
			'post_name'   => $slug,
			'post_status' => 'publish',
			'post_type'   => 'page',
		) );
	}
	if ( ! empty( $ids['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $ids['home'] );
		if ( did_action( 'elementor/loaded' ) ) {
			orvio_seed_elementor_home( (int) $ids['home'] );
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
	$section = function ( $widgets ) {
		return array(
			'id'       => orvio_el_id(),
			'elType'   => 'section',
			'settings' => array(),
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
		$section( array( $widget( 'orvio-features', array() ) ) ),
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
}
