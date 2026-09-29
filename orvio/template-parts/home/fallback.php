<?php
/**
 * Homepage when Elementor has not built the front page yet.
 *
 * @package Orvio
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
require_once ORVIO_DIR . '/inc/sample-catalog.php';
$hero = ORVIO_URI . '/assets/images/hero.jpg';
?>
	<section class="orvio-hero"><div class="orvio-container orvio-hero__grid">
		<div class="orvio-hero__copy">
			<p class="orvio-kicker"><?php echo esc_html( orvio_t( 'Autumn edit', 'مجموعه پاییز' ) ); ?></p>
			<h1><?php echo esc_html( orvio_t( 'Objects for a quieter house', 'اشیائی برای خانه‌ای که آرام است' ) ); ?></h1>
			<p class="orvio-lead"><?php echo esc_html( orvio_t( 'A considered shop of ceramic, leather, wool and light.', 'ویترینی از سرامیک، چرم، پشم و نور. انتخاب‌شده برای دوام و سکوت.' ) ); ?></p>
			<div class="orvio-hero__actions">
				<a class="orvio-btn orvio-btn--primary" href="<?php echo esc_url( orvio_shop_url() ); ?>"><?php echo esc_html( orvio_t( 'Enter the shop', 'ورود به فروشگاه' ) ); ?></a>
			</div>
		</div>
		<div class="orvio-hero__media"><img src="<?php echo esc_url( $hero ); ?>" alt="" width="1600" height="900"></div>
	</div></section>
	<section class="orvio-container"><?php echo do_shortcode( '' ); ?>
		<div class="orvio-trust">
			<div class="orvio-trust__item"><span class="orvio-trust__ico"><?php echo orvio_icon( 'truck' ); // phpcs:ignore ?></span><div><strong><?php echo esc_html( orvio_t( 'Shipping', 'ارسال سراسری' ) ); ?></strong><span><?php echo esc_html( orvio_t( 'Most cities in 48 hours', 'تا ۴۸ ساعت' ) ); ?></span></div></div>
			<div class="orvio-trust__item"><span class="orvio-trust__ico"><?php echo orvio_icon( 'back' ); // phpcs:ignore ?></span><div><strong><?php echo esc_html( orvio_t( 'Returns', 'بازگشت' ) ); ?></strong><span><?php echo esc_html( orvio_t( '30 days', '۳۰ روز' ) ); ?></span></div></div>
			<div class="orvio-trust__item"><span class="orvio-trust__ico"><?php echo orvio_icon( 'shield' ); // phpcs:ignore ?></span><div><strong><?php echo esc_html( orvio_t( 'Secure payment', 'پرداخت امن' ) ); ?></strong></div></div>
			<div class="orvio-trust__item"><span class="orvio-trust__ico"><?php echo orvio_icon( 'check' ); // phpcs:ignore ?></span><div><strong><?php echo esc_html( orvio_t( 'Checked by hand', 'بررسی دستی' ) ); ?></strong></div></div>
		</div>
	</section>
	<section class="orvio-section"><div class="orvio-container">
		<div class="orvio-section__head"><h2><?php echo esc_html( orvio_t( 'The edit', 'ویترین' ) ); ?></h2></div>
		<div class="orvio-grid" style="--cols:4">
			<?php
			if ( function_exists( 'wc_get_products' ) ) {
				$products = wc_get_products( array( 'limit' => 8, 'status' => 'publish' ) );
				foreach ( $products as $product ) {
					orvio_wc_card( $product );
				}
			}
			if ( empty( $products ) ) {
				foreach ( array_slice( orvio_sample_catalog(), 0, 8 ) as $item ) {
					$img = ORVIO_URI . '/' . $item['img'];
					$name = is_rtl() ? $item['fa'] : $item['en'];
					echo '<article class="orvio-card"><div class="orvio-card__media"><img src="' . esc_url( $img ) . '" alt="' . esc_attr( $name ) . '"></div><div class="orvio-card__body"><h3 class="orvio-card__title">' . esc_html( $name ) . '</h3></div></article>';
				}
			}
			?>
		</div>
	</div></section>
