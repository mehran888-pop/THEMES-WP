<?php
/**
 * WooCommerce integration.
 *
 * @package Orvio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'orvio_wc_hooks' );
function orvio_wc_hooks() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
	add_action( 'woocommerce_before_main_content', 'orvio_wc_wrapper_start', 10 );
	add_action( 'woocommerce_after_main_content', 'orvio_wc_wrapper_end', 10 );

	add_filter( 'woocommerce_add_to_cart_fragments', 'orvio_cart_fragments' );
	add_filter( 'loop_shop_columns', function () {
		return (int) orvio_opt( 'shop_columns', 3 );
	} );
	add_filter( 'loop_shop_per_page', function () {
		return (int) orvio_opt( 'products_per_page', 12 );
	} );
	add_filter( 'woocommerce_output_related_products_args', function ( $args ) {
		$args['posts_per_page'] = (int) orvio_opt( 'related_count', 4 );
		$args['columns']        = 4;
		return $args;
	} );
	add_filter( 'woocommerce_product_related_products_heading', function () {
		return orvio_t( 'You may also like', 'کالاهای مرتبط' );
	} );
}

function orvio_wc_wrapper_start() {
	echo '<main id="main" class="orvio-main"><div class="orvio-container orvio-wc">';
}
function orvio_wc_wrapper_end() {
	echo '</div></main>';
}

function orvio_cart_fragments( $fragments ) {
	$count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
	ob_start();
	woocommerce_mini_cart();
	$mini = ob_get_clean();
	$fragments['div.orvio-minicart'] = '<div class="orvio-drawer__body orvio-minicart">' . $mini . '</div>';
	$fragments['span.orvio-count[data-cart-count]'] = '<span class="orvio-count' . ( $count ? '' : ' is-zero' ) . '" data-cart-count>' . esc_html( (string) $count ) . '</span>';
	$fragments['span.orvio-cartbtn__total'] = '<span class="orvio-cartbtn__total" data-cart-total>' . ( WC()->cart ? WC()->cart->get_cart_subtotal() : '' ) . '</span>';
	return $fragments;
}

add_action( 'woocommerce_product_query', 'orvio_sale_query' );
function orvio_sale_query( $q ) {
	if ( empty( $_GET['on_sale'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return;
	}
	$ids = wc_get_product_ids_on_sale();
	$q->set( 'post__in', $ids ? $ids : array( 0 ) );
}

function orvio_wc_card( $product = null ) {
	if ( ! $product instanceof WC_Product ) {
		global $product;
	}
	if ( ! $product || ! $product->is_visible() ) {
		return;
	}
	$permalink = $product->get_permalink();
	$image     = $product->get_image( 'orvio-card', array( 'alt' => $product->get_name() ) );
	$badge     = '';
	if ( $product->is_on_sale() ) {
		$regular = (float) $product->get_regular_price();
		$sale    = (float) $product->get_sale_price();
		$pct     = $regular > 0 ? round( ( 1 - $sale / $regular ) * 100 ) : 0;
		$badge   = '<span class="orvio-badge">−' . esc_html( (string) $pct ) . '%</span>';
	} elseif ( $product->is_featured() ) {
		$badge = '<span class="orvio-badge orvio-badge--new">' . esc_html( orvio_t( 'New', 'جدید' ) ) . '</span>';
	}
	$cats = wc_get_product_category_list( $product->get_id(), ', ' );
	?>
	<article <?php wc_product_class( 'orvio-card', $product ); ?>>
		<div class="orvio-card__media">
			<a href="<?php echo esc_url( $permalink ); ?>" tabindex="-1"><?php echo $image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
			<?php echo $badge; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php if ( orvio_opt( 'enable_wishlist' ) ) : ?>
				<button type="button" class="orvio-card__wish" data-wish="<?php echo esc_attr( $product->get_id() ); ?>" data-wish-name="<?php echo esc_attr( $product->get_name() ); ?>" data-wish-img="<?php echo esc_url( wp_get_attachment_image_url( $product->get_image_id(), 'thumbnail' ) ); ?>" data-wish-url="<?php echo esc_url( $permalink ); ?>" aria-label="<?php echo esc_attr( orvio_t( 'Save', 'ذخیره' ) ); ?>"><?php echo orvio_icon( 'heart' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button>
			<?php endif; ?>
			<?php
			if ( $product->is_purchasable() && $product->is_in_stock() && $product->is_type( 'simple' ) ) {
				echo apply_filters(
					'woocommerce_loop_add_to_cart_link',
					sprintf(
						'<a href="%s" data-quantity="1" class="orvio-card__quick add_to_cart_button ajax_add_to_cart" data-product_id="%s" aria-label="%s" rel="nofollow">%s</a>',
						esc_url( $product->add_to_cart_url() ),
						esc_attr( $product->get_id() ),
						esc_attr( $product->add_to_cart_description() ),
						esc_html( $product->add_to_cart_text() )
					),
					$product
				);
			} else {
				echo '<a class="orvio-card__quick" href="' . esc_url( $permalink ) . '">' . esc_html( orvio_t( 'View', 'مشاهده' ) ) . '</a>';
			}
			?>
		</div>
		<div class="orvio-card__body">
			<div class="orvio-card__cat"><?php echo wp_kses_post( $cats ); ?></div>
			<h3 class="orvio-card__title"><a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $product->get_name() ); ?></a></h3>
			<?php if ( $product->get_average_rating() ) : ?>
				<span class="orvio-stars" style="--v:<?php echo esc_attr( $product->get_average_rating() ); ?>"><span class="orvio-stars__base">★★★★★</span><span class="orvio-stars__fill">★★★★★</span></span>
			<?php endif; ?>
			<div class="orvio-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
		</div>
	</article>
	<?php
}

add_filter( 'woocommerce_product_loop_start', function () {
	$cols = (int) orvio_opt( 'shop_columns', 3 );
	return '<div class="orvio-grid products" style="--cols:' . $cols . '">';
} );
add_filter( 'woocommerce_product_loop_end', function () {
	return '</div>';
} );

add_action( 'wp_enqueue_scripts', function () {
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_script( 'wc-add-to-cart' );
		wp_enqueue_script( 'wc-cart-fragments' );
	}
}, 30 );
