<?php
/**
 * Orvio theme bootstrap.
 *
 * @package Orvio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ORVIO_VERSION', '1.1.0' );
define( 'ORVIO_DIR', get_template_directory() );
define( 'ORVIO_URI', get_template_directory_uri() );

require ORVIO_DIR . '/inc/options.php';
require ORVIO_DIR . '/inc/icons.php';
require ORVIO_DIR . '/inc/setup.php';
require ORVIO_DIR . '/inc/assets.php';
require ORVIO_DIR . '/inc/template-tags.php';
require ORVIO_DIR . '/inc/woocommerce.php';
require ORVIO_DIR . '/inc/ajax.php';
require ORVIO_DIR . '/inc/elementor.php';
require ORVIO_DIR . '/inc/demo-import.php';
