<?php
/**
 * Page.
 *
 * @package Orvio
 */
get_header();
?>
<?php
$wc_screen = function_exists( 'is_cart' ) && ( is_cart() || is_checkout() || is_account_page() );
?>
<main id="main" class="orvio-main">
	<?php if ( ! $wc_screen && ! orvio_is_elementor() ) : ?>
		<div class="orvio-container orvio-pagehead">
			<?php orvio_breadcrumb(); ?>
			<h1><?php the_title(); ?></h1>
		</div>
	<?php endif; ?>
	<div class="orvio-container<?php echo $wc_screen || orvio_is_elementor() ? '' : ' orvio-content'; ?>">
		<?php
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
		?>
	</div>
</main>
<?php
get_footer();
