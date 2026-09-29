<?php
/**
 * Single post.
 *
 * @package Orvio
 */
get_header();
?>
<main id="main" class="orvio-main">
	<div class="orvio-container orvio-pagehead">
		<?php orvio_breadcrumb(); ?>
		<h1><?php the_title(); ?></h1>
		<?php orvio_posted_on(); ?>
	</div>
	<div class="orvio-container orvio-content">
		<?php
		while ( have_posts() ) :
			the_post();
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'large' );
			}
			the_content();
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		endwhile;
		?>
	</div>
</main>
<?php
get_footer();
