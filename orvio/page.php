<?php
/**
 * Page.
 *
 * @package Orvio
 */
get_header();
$wc_screen = function_exists( 'is_cart' ) && ( is_cart() || is_checkout() || is_account_page() );
$is_builder = orvio_is_elementor();
if ( $is_builder ) {
	echo '<main id="main">';
	while ( have_posts() ) {
		the_post();
		the_content();
	}
	echo '</main>';
	get_footer();
	return;
}
?>
<main id="main" class="orvio-main">
	<?php if ( ! $wc_screen && ! is_front_page() ) : ?>
		<div class="orvio-container orvio-pagehead">
			<?php orvio_breadcrumb(); ?>
			<h1><?php the_title(); ?></h1>
		</div>
	<?php endif; ?>
	<div class="<?php echo $wc_screen || is_front_page() ? 'orvio-page' : 'orvio-container orvio-content'; ?>">
		<?php
		while ( have_posts() ) :
			the_post();
			if ( is_front_page() && ! trim( wp_strip_all_tags( get_the_content() ) ) ) {
				get_template_part( 'template-parts/home/fallback' );
			} else {
				the_content();
			}
		endwhile;
		?>
	</div>
</main>
<?php
get_footer();
