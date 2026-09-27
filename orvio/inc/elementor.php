<?php
/**
 * Elementor bootstrap.
 *
 * @package Orvio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'elementor/elements/categories_registered', 'orvio_elementor_category' );
function orvio_elementor_category( $elements_manager ) {
	$elements_manager->add_category( 'orvio', array(
		'title' => 'Orvio',
		'icon'  => 'fa fa-plug',
	) );
}

add_action( 'elementor/widgets/register', 'orvio_register_elementor_widgets' );
function orvio_register_elementor_widgets( $widgets_manager ) {
	require_once ORVIO_DIR . '/inc/elementor-widgets.php';
	foreach ( orvio_elementor_widget_list() as $class ) {
		if ( class_exists( $class ) ) {
			$widgets_manager->register( new $class() );
		}
	}
}

add_action( 'elementor/theme/register_locations', 'orvio_elementor_locations' );
function orvio_elementor_locations( $elementor_theme_manager ) {
	$elementor_theme_manager->register_all_core_location();
}
