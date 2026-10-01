<?php
/**
 * Header category menu. Also used by the Elementor widget.
 *
 * @package Orvio
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$terms    = orvio_product_cats();
$style    = isset( $args['style'] ) ? $args['style'] : 'bar';
$shop_url = orvio_shop_url();
?>
<div class="orvio-catall">
	<button type="button" class="orvio-catall__btn" data-catall><?php echo orvio_icon( 'grid' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( orvio_t( 'All categories', 'همه دسته‌ها' ) ); ?></span><?php echo orvio_icon( 'chev' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button>
	<div class="orvio-catall__panel">
		<?php if ( $terms ) : ?>
			<?php foreach ( $terms as $term ) : ?>
				<a href="<?php echo esc_url( get_term_link( $term ) ); ?>"><span><?php echo esc_html( $term->name ); ?></span><span><?php echo esc_html( (string) $term->count ); ?></span></a>
			<?php endforeach; ?>
		<?php else : ?>
			<a href="<?php echo esc_url( $shop_url ); ?>"><?php echo esc_html( orvio_t( 'Shop', 'فروشگاه' ) ); ?></a>
		<?php endif; ?>
	</div>
</div>
<ul class="orvio-catbar__menu">
	<?php
	if ( $terms ) :
		foreach ( $terms as $term ) :
			$children = get_terms( array( 'taxonomy' => 'product_cat', 'parent' => $term->term_id, 'hide_empty' => false ) );
			$thumb_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
			$img      = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'medium' ) : ORVIO_URI . '/assets/images/categories/home.jpg';
			?>
			<li>
				<a href="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo esc_html( $term->name ); ?></a>
				<?php if ( 'bar' === $style ) : ?>
					<div class="orvio-mega">
						<div class="orvio-mega__grid">
							<div class="orvio-mega__col">
								<strong><?php echo esc_html( $term->name ); ?></strong>
								<?php if ( ! is_wp_error( $children ) && $children ) : ?>
									<?php foreach ( $children as $child ) : ?>
										<a href="<?php echo esc_url( get_term_link( $child ) ); ?>"><?php echo esc_html( $child->name ); ?></a>
									<?php endforeach; ?>
								<?php else : ?>
									<a href="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo esc_html( orvio_t( 'View all', 'مشاهده همه' ) ); ?></a>
								<?php endif; ?>
							</div>
							<a class="orvio-mega__feature" href="<?php echo esc_url( get_term_link( $term ) ); ?>">
								<img src="<?php echo esc_url( $img ); ?>" alt="">
								<span><?php echo esc_html( $term->name ); ?></span>
							</a>
						</div>
					</div>
				<?php endif; ?>
			</li>
			<?php
		endforeach;
	elseif ( has_nav_menu( 'primary' ) ) :
		wp_nav_menu( array(
			'theme_location' => 'primary',
			'container'      => false,
			'items_wrap'     => '%3$s',
			'fallback_cb'    => false,
			'depth'          => 1,
		) );
	endif;
	?>
</ul>
<a class="orvio-catbar__sale" href="<?php echo esc_url( add_query_arg( 'on_sale', '1', $shop_url ) ); ?>"><?php echo esc_html( orvio_t( 'This week’s edit', 'تخفیف‌های هفته' ) ); ?></a>
