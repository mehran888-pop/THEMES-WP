<?php
/**
 * Cart page.
 *
 * @package Orvio
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' );
?>
<div class="orvio-pagehead">
	<?php orvio_breadcrumb(); ?>
	<h1><?php echo esc_html( orvio_t( 'Bag', 'سبد خرید' ) ); ?></h1>
</div>
<div class="orvio-cartpage">
	<form class="woocommerce-cart-form orvio-panel" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
		<?php do_action( 'woocommerce_before_cart_table' ); ?>
		<?php
		do_action( 'woocommerce_before_cart_contents' );
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
			if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] <= 0 || ! apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				continue;
			}
			$permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
			?>
			<article class="orvio-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
				<a class="orvio-cart-item__image" href="<?php echo esc_url( $permalink ); ?>"><?php echo $_product->get_image( 'woocommerce_thumbnail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				<div class="orvio-cart-item__content">
					<h3><a href="<?php echo esc_url( $permalink ); ?>"><?php echo wp_kses_post( $_product->get_name() ); ?></a></h3>
					<?php do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key ); ?>
					<div class="orvio-line__meta"><?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
				</div>
				<div class="orvio-cart-item__qty">
					<?php
					if ( $_product->is_sold_individually() ) {
						$min = 1;
						$max = 1;
					} else {
						$min = 0;
						$max = $_product->get_max_purchase_quantity();
					}
					woocommerce_quantity_input( array(
						'input_name'   => "cart[{$cart_item_key}][qty]",
						'input_value'  => $cart_item['quantity'],
						'max_value'    => $max,
						'min_value'    => $min,
						'product_name' => $_product->get_name(),
					), $_product, true );
					do_action( 'woocommerce_after_cart_item_quantity', $cart_item, $cart_item_key );
					?>
				</div>
				<strong class="orvio-cart-item__price"><?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				<?php
				echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'woocommerce_cart_item_remove_link',
					sprintf(
						'<a href="%s" class="orvio-line__remove orvio-cart-item__remove" aria-label="%s"><span aria-hidden="true">×</span><span class="screen-reader-text">%s</span></a>',
						esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
						esc_attr__( 'Remove this item', 'woocommerce' ),
						esc_html__( 'Remove', 'woocommerce' )
					),
					$cart_item_key
				);
				?>
			</article>
			<?php
		}
		do_action( 'woocommerce_cart_contents' );
		do_action( 'woocommerce_after_cart_contents' );
		?>
		<div class="orvio-coupon">
			<input type="text" name="coupon_code" id="coupon_code" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>">
			<button type="submit" class="orvio-btn orvio-btn--dark orvio-btn--sm" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply coupon', 'woocommerce' ); ?></button>
			<button type="submit" class="orvio-btn orvio-btn--ghost orvio-btn--sm" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>
			<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
			<?php do_action( 'woocommerce_cart_actions' ); ?>
		</div>
		<?php do_action( 'woocommerce_after_cart_table' ); ?>
	</form>
	<aside class="orvio-panel cart-collaterals">
		<?php
		// WooCommerce hooks the native totals template to this action. Keep the
		// action as the single source of totals so extensions remain compatible.
		do_action( 'woocommerce_cart_collaterals' );
		?>
	</aside>
</div>
<?php do_action( 'woocommerce_after_cart' ); ?>
