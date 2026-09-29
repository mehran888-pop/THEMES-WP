<?php
/**
 * 404.
 *
 * @package Orvio
 */
get_header();
?>
<main id="main" class="orvio-404">
	<p class="orvio-kicker">404</p>
	<h1><?php echo esc_html( orvio_t( 'This page has left the house.', 'این صفحه از خانه رفته است.' ) ); ?></h1>
	<p class="orvio-lead"><?php echo esc_html( orvio_t( 'Try a search, or return to the shop.', 'جستجو کنید یا به فروشگاه برگردید.' ) ); ?></p>
	<form class="orvio-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="max-width:460px;margin:18px auto;display:flex">
		<input type="search" name="s" placeholder="<?php echo esc_attr( orvio_t( 'Search…', 'جستجو…' ) ); ?>">
		<?php if ( class_exists( 'WooCommerce' ) ) : ?>
			<input type="hidden" name="post_type" value="product">
		<?php endif; ?>
		<button type="submit"><?php echo esc_html( orvio_t( 'Search', 'جستجو' ) ); ?></button>
	</form>
	<a class="orvio-btn orvio-btn--primary" href="<?php echo esc_url( orvio_shop_url() ); ?>"><?php echo esc_html( orvio_t( 'Shop', 'فروشگاه' ) ); ?></a>
</main>
<?php
get_footer();
