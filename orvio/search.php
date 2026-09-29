<?php
/**
 * Search results.
 *
 * @package Orvio
 */
get_header();
?>
<main id="main" class="orvio-main">
	<?php if ( orvio_pagehead_once() ) : ?>
		<div class="orvio-container orvio-pagehead">
			<h1><?php printf( esc_html( orvio_t( 'Search: %s', 'جستجو: %s' ) ), esc_html( get_search_query() ) ); ?></h1>
		</div>
	<?php endif; ?>
	<div class="orvio-container">
		<?php if ( have_posts() ) : ?>
			<div class="orvio-grid" style="--cols:3">
				<?php
				while ( have_posts() ) :
					the_post();
					if ( 'product' === get_post_type() && function_exists( 'wc_get_template_part' ) ) {
						wc_get_template_part( 'content', 'product' );
					} else {
						echo '<article class="orvio-card"><div class="orvio-card__body"><h3 class="orvio-card__title"><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></h3><p>' . esc_html( wp_trim_words( get_the_excerpt(), 18 ) ) . '</p></div></article>';
					}
				endwhile;
				?>
			</div>
			<div class="orvio-pager"><?php the_posts_pagination(); ?></div>
		<?php else : ?>
			<div class="orvio-empty"><h2><?php echo esc_html( orvio_t( 'No results.', 'نتیجه‌ای نیست.' ) ); ?></h2></div>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
