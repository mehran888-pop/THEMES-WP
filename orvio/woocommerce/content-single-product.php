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
$stock_text         = $stock ? ( $stock_qty ? sprintf( orvio_t( '%s available', '%s عدد موجود' ), number_format_i18n( $stock_qty ) ) : orvio_t( 'Ready to ship', 'آماده ارسال' ) ) : orvio_t( 'Out of stock', 'ناموجود' );
$show_eyebrow       = ! empty( orvio_opt( 'product_show_eyebrow', 1 ) );
$show_sku           = ! empty( orvio_opt( 'product_show_sku', 1 ) );
$show_rating        = ! empty( orvio_opt( 'product_show_rating', 1 ) );
$show_excerpt       = ! empty( orvio_opt( 'product_show_excerpt', 1 ) );
$show_perks         = ! empty( orvio_opt( 'product_show_perks', 1 ) );
$show_meta          = ! empty( orvio_opt( 'product_show_meta', 1 ) );
$show_share         = ! empty( orvio_opt( 'product_show_share', 1 ) );
$show_gallery_note  = ! empty( orvio_opt( 'product_show_gallery_note', 1 ) );
$show_tabs          = ! empty( orvio_opt( 'product_show_tabs', 1 ) );
$show_upsells       = ! empty( orvio_opt( 'product_show_upsells', 1 ) );
$show_related       = ! empty( orvio_opt( 'product_show_related', 1 ) );
$sticky_mobile      = ! empty( orvio_opt( 'product_sticky_mobile', 1 ) );
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'orvio-product orvio-product--premium', $product ); ?>>
	<?php if ( $show_eyebrow ) : ?>
		<div class="orvio-product__eyebrow">
			<span><?php echo wp_kses_post( $categories ); ?></span>
			<?php if ( $show_sku && $sku ) : ?><span><?php echo esc_html( orvio_t( 'SKU', 'شناسه' ) . ' ' . $sku ); ?></span><?php endif; ?>
		</div>
	<?php endif; ?>
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
				<?php if ( $show_gallery_note ) : ?>
					<div class="orvio-gallery__note"><span aria-hidden="true">✦</span><?php echo esc_html( orvio_t( 'A considered object for everyday rituals.', 'شیئی سنجیده برای آیین‌های هر روز.' ) ); ?></div>
				<?php endif; ?>
			</section>

		<section class="orvio-summary summary entry-summary">
			<div class="orvio-product__flag">
				<span class="orvio-product__status<?php echo $stock ? '' : ' is-out'; ?>"><i aria-hidden="true"></i><?php echo esc_html( $stock_text ); ?></span>
				<?php if ( $product->is_on_sale() ) : ?><span class="orvio-product__sale"><?php echo esc_html( orvio_t( 'Limited offer', 'پیشنهاد محدود' ) ); ?></span><?php endif; ?>
			</div>
			<?php woocommerce_template_single_title(); ?>
			<?php if ( $show_rating ) : ?>
				<div class="orvio-product__rating-row">
					<?php woocommerce_template_single_rating(); ?>
					<span class="orvio-product__rating-note"><?php echo esc_html( orvio_t( 'Trusted by our customers', 'محبوب میان مشتری‌ها' ) ); ?></span>
				</div>
			<?php endif; ?>
			<div class="orvio-product__price-wrap">
				<?php woocommerce_template_single_price(); ?>
				<span><?php echo esc_html( orvio_t( 'Final price · taxes calculated at checkout', 'قیمت نهایی · مالیات در تسویه محاسبه می‌شود' ) ); ?></span>
			</div>
			<?php if ( $show_excerpt ) : ?>
				<div class="orvio-product__intro">
					<?php woocommerce_template_single_excerpt(); ?>
				</div>
			<?php endif; ?>
			<div class="orvio-product__buybox">
				<?php woocommerce_template_single_add_to_cart(); ?>
			</div>
			<?php if ( $show_perks ) : ?>
				<div class="orvio-product__perks" aria-label="<?php echo esc_attr( orvio_t( 'Shopping benefits', 'مزایای خرید' ) ); ?>">
					<div><span aria-hidden="true">⌁</span><strong><?php echo esc_html( orvio_t( 'Carefully packed', 'بسته‌بندی دقیق' ) ); ?></strong><small><?php echo esc_html( orvio_t( 'Ready for gifting', 'مناسب هدیه' ) ); ?></small></div>
					<div><span aria-hidden="true">↺</span><strong><?php echo esc_html( orvio_t( '30-day returns', 'بازگشت ۳۰ روزه' ) ); ?></strong><small><?php echo esc_html( orvio_t( 'Simple and easy', 'ساده و آسان' ) ); ?></small></div>
					<div><span aria-hidden="true">◌</span><strong><?php echo esc_html( orvio_t( 'Fast dispatch', 'ارسال سریع' ) ); ?></strong><small><?php echo esc_html( orvio_t( '24–48 hours', '۲۴ تا ۴۸ ساعت' ) ); ?></small></div>
				</div>
			<?php endif; ?>
			<?php if ( $show_meta ) : ?>
				<?php woocommerce_template_single_meta(); ?>
			<?php endif; ?>
			<?php if ( $show_share ) : ?>
				<div class="orvio-product__share"><?php woocommerce_template_single_sharing(); ?></div>
			<?php endif; ?>
		</section>
	</div>
</div>

<?php if ( $show_tabs || $show_upsells || $show_related ) : ?>
	<div class="orvio-product-after">
		<?php if ( $show_tabs ) : ?>
			<?php woocommerce_output_product_data_tabs(); ?>
		<?php endif; ?>
		<?php if ( $show_upsells ) : ?>
			<?php woocommerce_upsell_display(); ?>
		<?php endif; ?>
		<?php if ( $show_related ) : ?>
			<?php woocommerce_output_related_products(); ?>
		<?php endif; ?>
	</div>
<?php endif; ?>

<?php if ( $sticky_mobile ) : ?>
	<div class="orvio-sticky-atc" data-sticky-atc>
		<div>
			<strong><?php echo esc_html( $product->get_name() ); ?></strong>
			<div class="orvio-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
		</div>
		<button type="button" class="orvio-btn orvio-btn--primary" data-sticky-submit><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
	</div>
<?php endif; ?>
<?php do_action( 'woocommerce_after_single_product' ); ?>
