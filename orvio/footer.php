<?php
/**
 * Footer.
 *
 * @package Orvio
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'footer' ) ) {
	// Elementor Pro footer location.
} else {
	get_template_part( 'template-parts/footer/site-footer' );
}
?>
</div>
<?php
get_template_part( 'template-parts/header/drawers' );
wp_footer();
?>
</body>
</html>
