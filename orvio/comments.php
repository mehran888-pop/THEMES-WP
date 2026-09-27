<?php
/**
 * Comments.
 *
 * @package Orvio
 */
if ( post_password_required() ) {
	return;
}
?>
<section class="orvio-comments">
	<?php if ( have_comments() ) : ?>
		<h2><?php echo esc_html( orvio_t( 'Comments', 'نظرها' ) ); ?></h2>
		<ol class="orvio-comment-list">
			<?php wp_list_comments( array( 'style' => 'ol', 'short_ping' => true ) ); ?>
		</ol>
		<?php the_comments_pagination(); ?>
	<?php endif; ?>
	<?php comment_form(); ?>
</section>
