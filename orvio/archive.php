<?php
/**
 * Archive.
 *
 * @package Orvio
 */
get_header();
?>
<main id="main" class="orvio-main">
	<?php if ( orvio_pagehead_once() ) : ?>
		<div class="orvio-container orvio-pagehead">
			<?php orvio_breadcrumb(); ?>
			<h1><?php the_archive_title(); ?></h1>
			<?php the_archive_description( '<div class="orvio-lead">', '</div>' ); ?>
		</div>
	<?php endif; ?>
	<div class="orvio-container orvio-posts">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<article <?php post_class( 'orvio-post' ); ?>>
				<a href="<?php the_permalink(); ?>">
					<?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'medium_large' ); } ?>
					<div><h2><?php the_title(); ?></h2><p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p></div>
				</a>
			</article>
		<?php endwhile; else : ?>
			<p><?php echo esc_html( orvio_t( 'Nothing found.', 'چیزی پیدا نشد.' ) ); ?></p>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
