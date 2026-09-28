<?php
/**
 * Mini cart drawer contents.
 *
 * @package Orvio
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_mini_cart' );
if ( WC()->cart && ! WC()->cart->is_empty() ) :
	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
		$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] <= 0 || ! apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
			continue;
		}
		$permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
		?>
		<div class="orvio-line <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
			<a href="<?php echo esc_url( $permalink ); ?>"><?php echo $_product->get_image( 'thumbnail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
			<div class="orvio-line__content">
				<div class="orvio-line__top">
					<h3><a href="<?php echo esc_url( $permalink ); ?>"><?php echo wp_kses_post( $_product->get_name() ); ?></a></h3>
					<strong class="orvio-line__price"><?php echo wp_kses_post( WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ) ); ?></strong>
				</div>
				<div class="orvio-line__meta"><?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
				<form class="orvio-mini-cart-qty" data-orvio-mini-cart-qty action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
					<button type="button" data-mini-cart-step="-1" aria-label="<?php echo esc_attr( orvio_t( 'Decrease quantity', 'کاهش تعداد' ) ); ?>">−</button>
					<input type="number" name="cart[<?php echo esc_attr( $cart_item_key ); ?>][qty]" value="<?php echo esc_attr( $cart_item['quantity'] ); ?>" min="1" max="<?php echo esc_attr( $_product->get_max_purchase_quantity() ?: '' ); ?>" data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>" aria-label="<?php echo esc_attr( orvio_t( 'Quantity', 'تعداد' ) ); ?>">
					<button type="button" data-mini-cart-step="1" aria-label="<?php echo esc_attr( orvio_t( 'Increase quantity', 'افزایش تعداد' ) ); ?>">+</button>
					<input type="hidden" name="update_cart" value="1">
					<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
				</form>
				<?php
				echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'woocommerce_cart_item_remove_link',
					sprintf(
						'<a href="%s" class="orvio-line__remove" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><span aria-hidden="true">×</span><span class="screen-reader-text">%s</span></a>',
						esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
						esc_attr__( 'Remove this item', 'woocommerce' ),
						esc_attr( $cart_item['product_id'] ),
						esc_attr( $cart_item_key ),
						esc_attr( $_product->get_sku() ),
						esc_html__( 'Remove', 'woocommerce' ),
						esc_html__( 'Remove', 'woocommerce' )
					),
					$cart_item_key
				);
				?>
			</div>
		</div>
		<?php
	endforeach;
else :
	echo '<div class="orvio-empty"><p>' . esc_html( orvio_t( 'Your bag is empty.', 'سبد شما خالی است.' ) ) . '</p></div>';
endif;
do_action( 'woocommerce_after_mini_cart' );
