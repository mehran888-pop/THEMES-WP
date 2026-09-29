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

$gallery_ids = array_values( array_filter( array_merge( array( $product->get_image_id() ), $product->get_gallery_image_ids() ) ) );
$main_id    = $product->get_image_id();
$main_src   = $main_id ? wp_get_attachment_image_url( $main_id, 'woocommerce_single' ) : '';
$categories = wc_get_product_category_list( $product->get_id(), ' · ' );
$sku        = $product->get_sku();
$stock      = $product->is_in_stock();
$stock_qty  = $product->get_stock_quantity();
$stock_text = $stock ? ( $stock_qty ? sprintf( orvio_t( '%s available', '%s عدد موجود' ), number_format_i18n( $stock_qty ) ) : orvio_t( 'Ready to ship', 'آماده ارسال' ) ) : orvio_t( 'Out of stock', 'ناموجود' );
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'orvio-product orvio-product--premium', $product ); ?>>
	<div class="orvio-product__eyebrow">
		<span><?php echo wp_kses_post( $categories ); ?></span>
		<?php if ( $sku ) : ?><span><?php echo esc_html( orvio_t( 'SKU', 'شناسه' ) . ' ' . $sku ); ?></span><?php endif; ?>
	</div>
	<div class="orvio-product__main">
		<section class="orvio-gallery" data-gallery aria-label="<?php echo esc_attr( orvio_t( 'Product gallery', 'گالری محصول' ) ); ?>">
			<div class="orvio-gallery__stage">
				<div class="orvio-gallery__main">
					<?php if ( $main_id ) : ?>
						<?php echo wp_get_attachment_image( $main_id, 'woocommerce_single', false, array( 'data-main' => '1', 'alt' => $product->get_name(), 'loading' => 'eager' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php else : ?>
						<?php echo $product->get_image( 'woocommerce_single', array( 'data-main' => '1', 'alt' => $product->get_name() ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php endif; ?>
				</div>
				<div class="orvio-gallery__tools">
					<span class="orvio-gallery__count" data-gallery-count>01 / <?php echo esc_html( str_pad( (string) max( 1, count( $gallery_ids ) ), 2, '0', STR_PAD_LEFT ) ); ?></span>
					<?php if ( $main_src ) : ?>
						<button type="button" class="orvio-gallery__zoom" data-gallery-zoom data-gallery-zoom-src="<?php echo esc_url( $main_src ); ?>" aria-label="<?php echo esc_attr( orvio_t( 'Open image', 'باز کردن تصویر' ) ); ?>">↗</button>
					<?php endif; ?>
				</div>
			</div>
			<?php if ( count( $gallery_ids ) > 1 ) : ?>
				<div class="orvio-gallery__thumbs" role="list">
					<?php foreach ( $gallery_ids as $i => $id ) : ?>
						<?php $src = wp_get_attachment_image_url( $id, 'woocommerce_single' ); ?>
						<button type="button" data-thumb data-src="<?php echo esc_url( $src ); ?>" data-index="<?php echo esc_attr( $i + 1 ); ?>" class="<?php echo 0 === $i ? 'is-on' : ''; ?>" role="listitem" aria-label="<?php echo esc_attr( sprintf( orvio_t( 'Image %s', 'تصویر %s' ), $i + 1 ) ); ?>">
							<?php echo wp_get_attachment_image( $id, 'thumbnail', false, array( 'alt' => $product->get_name() ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<div class="orvio-gallery__note"><span aria-hidden="true">✦</span><?php echo esc_html( orvio_t( 'A considered object for everyday rituals.', 'شیئی سنجیده برای آیین‌های هر روز.' ) ); ?></div>
		</section>

		<section class="orvio-summary summary entry-summary">
			<div class="orvio-product__flag">
				<span class="orvio-product__status<?php echo $stock ? '' : ' is-out'; ?>"><i aria-hidden="true"></i><?php echo esc_html( $stock_text ); ?></span>
				<?php if ( $product->is_on_sale() ) : ?><span class="orvio-product__sale"><?php echo esc_html( orvio_t( 'Limited offer', 'پیشنهاد محدود' ) ); ?></span><?php endif; ?>
			</div>
			<?php woocommerce_template_single_title(); ?>
			<div class="orvio-product__rating-row">
				<?php woocommerce_template_single_rating(); ?>
				<span class="orvio-product__rating-note"><?php echo esc_html( orvio_t( 'Trusted by our customers', 'محبوب میان مشتری‌ها' ) ); ?></span>
			</div>
			<div class="orvio-product__price-wrap">
				<?php woocommerce_template_single_price(); ?>
				<span><?php echo esc_html( orvio_t( 'Final price · taxes calculated at checkout', 'قیمت نهایی · مالیات در تسویه محاسبه می‌شود' ) ); ?></span>
			</div>
			<div class="orvio-product__intro">
				<?php woocommerce_template_single_excerpt(); ?>
			</div>
			<div class="orvio-product__buybox">
				<?php woocommerce_template_single_add_to_cart(); ?>
			</div>
			<div class="orvio-product__perks" aria-label="<?php echo esc_attr( orvio_t( 'Shopping benefits', 'مزایای خرید' ) ); ?>">
				<div><span aria-hidden="true">⌁</span><strong><?php echo esc_html( orvio_t( 'Carefully packed', 'بسته‌بندی دقیق' ) ); ?></strong><small><?php echo esc_html( orvio_t( 'Ready for gifting', 'مناسب هدیه' ) ); ?></small></div>
				<div><span aria-hidden="true">↺</span><strong><?php echo esc_html( orvio_t( '30-day returns', 'بازگشت ۳۰ روزه' ) ); ?></strong><small><?php echo esc_html( orvio_t( 'Simple and easy', 'ساده و آسان' ) ); ?></small></div>
				<div><span aria-hidden="true">◌</span><strong><?php echo esc_html( orvio_t( 'Fast dispatch', 'ارسال سریع' ) ); ?></strong><small><?php echo esc_html( orvio_t( '24–48 hours', '۲۴ تا ۴۸ ساعت' ) ); ?></small></div>
			</div>
			<?php woocommerce_template_single_meta(); ?>
			<div class="orvio-product__share"><?php woocommerce_template_single_sharing(); ?></div>
		</section>
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
