<?php
/**
 * Single product content.
 *
 * @package Orvio
 */

defined( 'ABSPATH' ) || exit;

global $product;
if ( ! $product instanceof WC_Product ) {
	return;
}
do_action( 'woocommerce_before_single_product' );
if ( post_password_required() ) {
	echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	return;
}
$gallery = array_filter( array_merge( array( $product->get_image_id() ), $product->get_gallery_image_ids() ) );
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'orvio-product', $product ); ?>>
	<div class="orvio-gallery" data-gallery>
		<div class="orvio-gallery__main">
			<?php echo $product->get_image( 'woocommerce_single', array( 'data-main' => '1', 'alt' => $product->get_name() ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<?php if ( count( $gallery ) > 1 ) : ?>
			<div class="orvio-gallery__thumbs">
				<?php foreach ( $gallery as $i => $id ) : ?>
					<button type="button" data-thumb data-src="<?php echo esc_url( wp_get_attachment_image_url( $id, 'woocommerce_single' ) ); ?>" class="<?php echo 0 === $i ? 'is-on' : ''; ?>">
						<?php echo wp_get_attachment_image( $id, 'thumbnail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
	<div class="orvio-summary summary entry-summary">
		<?php
		woocommerce_template_single_title();
		woocommerce_template_single_rating();
		woocommerce_template_single_price();
		woocommerce_template_single_excerpt();
		woocommerce_template_single_add_to_cart();
		woocommerce_template_single_meta();
		?>
		<div class="orvio-micro">
			<div><strong><?php echo esc_html( orvio_t( 'Shipping', 'ارسال' ) ); ?></strong><?php echo esc_html( orvio_t( '24–48 hours on in-stock pieces', '۲۴ تا ۴۸ ساعت برای کالای موجود' ) ); ?></div>
			<div><strong><?php echo esc_html( orvio_t( 'Returns', 'بازگشت' ) ); ?></strong><?php echo esc_html( orvio_t( '30 days', '۳۰ روز' ) ); ?></div>
		</div>
		<?php woocommerce_template_single_sharing(); ?>
	</div>
</div>
<div class="orvio-product-after">
	<?php
	woocommerce_output_product_data_tabs();
	woocommerce_upsell_display();
	woocommerce_output_related_products();
	?>
</div>
<div class="orvio-sticky-atc" data-sticky-atc>
	<div>
		<strong><?php echo esc_html( $product->get_name() ); ?></strong>
		<div class="orvio-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
	</div>
	<button type="button" class="orvio-btn orvio-btn--primary" data-sticky-submit><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
</div>
<?php do_action( 'woocommerce_after_single_product' ); ?>
