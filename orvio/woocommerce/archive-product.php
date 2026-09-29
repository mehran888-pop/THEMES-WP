<?php
/**
 * Shop archive.
 *
 * @package Orvio
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
do_action( 'woocommerce_before_main_content' );
?>
<?php if ( orvio_pagehead_once() ) : ?>
	<div class="orvio-pagehead">
		<?php orvio_breadcrumb(); ?>
		<h1><?php woocommerce_page_title(); ?></h1>
	</div>
<?php endif; ?>
<div class="orvio-shop<?php echo orvio_opt( 'shop_sidebar' ) ? '' : ' orvio-shop--no-sidebar'; ?>">
	<?php if ( orvio_opt( 'shop_sidebar' ) ) : ?>
		<aside class="orvio-filters" data-filters>
			<div style="display:flex;justify-content:space-between;align-items:center">
				<h2><?php echo esc_html( orvio_t( 'Filters', 'فیلترها' ) ); ?></h2>
				<button type="button" class="orvio-drawer__x" data-close aria-label="<?php echo esc_attr( orvio_t( 'Close', 'بستن' ) ); ?>">×</button>
			</div>
			<?php if ( is_active_sidebar( 'shop-filters' ) ) : ?>
				<?php dynamic_sidebar( 'shop-filters' ); ?>
			<?php else : ?>
				<div class="orvio-filter">
					<strong><?php echo esc_html( orvio_t( 'Categories', 'دسته‌ها' ) ); ?></strong>
					<ul>
					<?php
					wp_list_categories( array(
						'taxonomy'   => 'product_cat',
						'title_li'   => '',
						'hide_empty' => true,
					) );
					?>
					</ul>
				</div>
				<?php if ( class_exists( 'WC_Widget_Price_Filter' ) ) : ?>
					<div class="orvio-filter"><?php the_widget( 'WC_Widget_Price_Filter' ); ?></div>
				<?php endif; ?>
			<?php endif; ?>
		</aside>
	<?php endif; ?>
	<div>
		<div class="orvio-toolbar">
			<button type="button" class="orvio-btn orvio-btn--ghost orvio-btn--sm orvio-filter-toggle" data-open="filters"><?php echo esc_html( orvio_t( 'Filters', 'فیلترها' ) ); ?></button>
			<?php do_action( 'woocommerce_before_shop_loop' ); ?>
		</div>
		<?php
		if ( woocommerce_product_loop() ) {
			woocommerce_product_loop_start();
			if ( wc_get_loop_prop( 'total' ) ) {
				while ( have_posts() ) {
					the_post();
					do_action( 'woocommerce_shop_loop' );
					wc_get_template_part( 'content', 'product' );
				}
			}
			woocommerce_product_loop_end();
			do_action( 'woocommerce_after_shop_loop' );
		} else {
			do_action( 'woocommerce_no_products_found' );
		}
		?>
	</div>
</div>
<?php
do_action( 'woocommerce_after_main_content' );
get_footer( 'shop' );
