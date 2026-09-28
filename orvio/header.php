<?php
/**
 * Header.
 *
 * @package Orvio
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="<?php echo esc_url( ORVIO_URI . '/assets/images/favicon.svg' ); ?>" type="image/svg+xml">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="orvio-skip" href="#main"><?php echo esc_html( orvio_t( 'Skip to content', 'پرش به محتوا' ) ); ?></a>
<div class="orvio-frame">
<?php
if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'header' ) ) {
	// Elementor Pro header location.
} else {
	get_template_part( 'template-parts/header/site-header' );
}
get_template_part( 'template-parts/header/mobile-nav' );
