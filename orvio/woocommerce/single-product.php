<?php
/**
 * Single product.
 *
 * @package Orvio
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
do_action( 'woocommerce_before_main_content' );
if ( ! empty( orvio_opt( 'show_woocommerce_breadcrumb', 1 ) ) && orvio_pagehead_once() ) {
	echo '<div class="orvio-pagehead">';
	orvio_breadcrumb();
	echo '</div>';
}
while ( have_posts() ) :
	the_post();
	wc_get_template_part( 'content', 'single-product' );
endwhile;
do_action( 'woocommerce_after_main_content' );
get_footer( 'shop' );
