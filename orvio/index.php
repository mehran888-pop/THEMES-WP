<?php
/**
 * Main template.
 *
 * @package Orvio
 */
get_header();
?>
<main id="main" class="orvio-main">
	<div class="orvio-container orvio-pagehead">
		<?php orvio_breadcrumb(); ?>
		<h1><?php echo esc_html( is_home() ? orvio_t( 'Journal', 'یادداشت‌ها' ) : wp_get_document_title() ); ?></h1>
	</div>
	<div class="orvio-container orvio-posts">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class( 'orvio-post' ); ?>>
					<a href="<?php the_permalink(); ?>">
						<?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'medium_large' ); } ?>
						<div>
							<?php orvio_posted_on(); ?>
							<h2><?php the_title(); ?></h2>
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
						</div>
					</a>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<p><?php echo esc_html( orvio_t( 'Nothing here yet.', 'هنوز چیزی این‌جا نیست.' ) ); ?></p>
		<?php endif; ?>
	</div>
	<div class="orvio-container orvio-pager"><?php the_posts_pagination(); ?></div>
</main>
<?php
get_footer();
