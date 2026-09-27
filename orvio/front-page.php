<?php
/**
 * Front page.
 *
 * @package Orvio
 */
get_header();
$is_builder = is_singular() && orvio_is_elementor( get_queried_object_id() );
if ( $is_builder ) {
	echo '<main id="main">';
	while ( have_posts() ) {
		the_post();
		the_content();
	}
	echo '</main>';
} elseif ( is_page() && trim( wp_strip_all_tags( get_post_field( 'post_content', get_queried_object_id() ) ) ) ) {
	echo '<main id="main" class="orvio-main"><div class="orvio-container orvio-content">';
	while ( have_posts() ) {
		the_post();
		the_content();
	}
	echo '</div></main>';
} else {
	get_template_part( 'template-parts/home/fallback' );
}
get_footer();
