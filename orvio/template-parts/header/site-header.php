<?php
/**
 * Site header.
 *
 * @package Orvio
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$o          = orvio_settings();
$header_layouts = array( 'classic', 'centered', 'split', 'minimal' );
$header_layout  = ( isset( $args['layout'] ) && in_array( $args['layout'], $header_layouts, true ) ) ? $args['layout'] : ( in_array( $o['header_layout'], $header_layouts, true ) ? $o['header_layout'] : 'classic' );
$terms      = orvio_product_cats();
$cart_count = orvio_cart_count();
$cart_open  = 'page' === $o['cart_type'] ? '' : ' data-open="cart"';
$cart_aria  = 'page' === $o['cart_type'] ? '' : ' aria-controls="orvio-cart-drawer" aria-expanded="false"';
/* Keep the native cart URL on the trigger so the drawer has a no-JavaScript fallback. */
$cart_tag   = 'a';
$cart_href  = ' href="' . esc_url( function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '#' ) . '"';
?>
<?php if ( ! empty( $o['show_announcement'] ) && orvio_announcement_text() ) : ?>
	<div class="orvio-announce" data-announce>
		<div class="orvio-container orvio-announce__inner">
			<p><?php echo esc_html( orvio_announcement_text() ); ?></p>
			<button type="button" class="orvio-announce__x" data-announce-close aria-label="<?php echo esc_attr( orvio_t( 'Close', 'بستن' ) ); ?>">×</button>
		</div>
	</div>
<?php endif; ?>
<header class="orvio-header orvio-header--<?php echo esc_attr( $header_layout ); ?>" data-header>
	<div class="orvio-container orvio-header__row">
		<button type="button" class="orvio-iconbtn orvio-burger" data-open="menu" aria-controls="orvio-menu-drawer" aria-expanded="false" aria-label="<?php echo esc_attr( orvio_t( 'Menu', 'منو' ) ); ?>"><?php echo orvio_icon( 'menu' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button>
		<?php if ( has_custom_logo() ) : ?>
			<?php the_custom_logo(); ?>
		<?php else : ?>
			<a class="orvio-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php echo orvio_logo_mark(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span class="orvio-logo__word"><strong><?php bloginfo( 'name' ); ?></strong><small><?php bloginfo( 'description' ); ?></small></span>
			</a>
		<?php endif; ?>
		<?php if ( ! empty( $o['show_search'] ) ) : ?>
		<form class="orvio-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<span class="orvio-search__icon"><?php echo orvio_icon( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
			<input type="search" name="s" data-search placeholder="<?php echo esc_attr( orvio_t( 'Search the edit…', 'جستجو میان اشیاء…' ) ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" autocomplete="off">
			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<input type="hidden" name="post_type" value="product">
			<?php endif; ?>
			<button type="submit"><?php echo esc_html( orvio_t( 'Search', 'جستجو' ) ); ?></button>
			<div class="orvio-suggest" data-suggest hidden></div>
		</form>
		<button type="button" class="orvio-iconbtn orvio-search-toggle" data-open="search" aria-controls="orvio-search-panel" aria-expanded="false" aria-label="<?php echo esc_attr( orvio_t( 'Search', 'جستجو' ) ); ?>"><?php echo orvio_icon( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button>
		<?php endif; ?>
		<div class="orvio-tools">
			<?php if ( ! empty( $o['show_account'] ) ) : ?>
			<a class="orvio-tool orvio-accountbtn orvio-headerbtn--<?php echo esc_attr( orvio_opt( 'header_account_style', 'minimal' ) ); ?>" href="<?php echo esc_url( orvio_account_url() ); ?>"><span class="orvio-tool__icon"><?php echo orvio_icon( 'user' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><span class="orvio-tool__label"><?php echo esc_html( orvio_t( 'Account', 'حساب' ) ); ?></span></a>
			<?php endif; ?>
			<?php if ( ! empty( $o['enable_wishlist'] ) ) : ?>
				<button type="button" class="orvio-tool" data-open="wish" aria-controls="orvio-wish-drawer" aria-expanded="false"><span class="orvio-tool__icon"><?php echo orvio_icon( 'heart' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span class="orvio-count is-zero" data-wish-count>0</span></span><span class="orvio-tool__label"><?php echo esc_html( orvio_t( 'Saved', 'علاقه‌مندی' ) ); ?></span></button>
			<?php endif; ?>
			<?php if ( ! empty( $o['show_cart'] ) ) : ?>
			<<?php echo esc_attr( $cart_tag ); ?> class="orvio-tool orvio-cartbtn orvio-headerbtn--<?php echo esc_attr( orvio_opt( 'header_cart_style', 'pill' ) ); ?>"<?php echo $cart_href . $cart_open . $cart_aria; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<span class="orvio-tool__icon"><?php echo orvio_icon( 'bag' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span class="orvio-count<?php echo $cart_count ? '' : ' is-zero'; ?>" data-cart-count><?php echo esc_html( (string) $cart_count ); ?></span></span>
				<span class="orvio-tool__meta"><span class="orvio-tool__label"><?php echo esc_html( orvio_t( 'Bag', 'سبد' ) ); ?></span><span class="orvio-cartbtn__total" data-cart-total><?php echo wp_kses_post( orvio_cart_total_html() ); ?></span></span>
			</<?php echo esc_attr( $cart_tag ); ?>>
			<?php endif; ?>
		</div>
	</div>
	<div class="orvio-searchpanel" id="orvio-search-panel" data-searchpanel>
		<form class="orvio-container" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<div class="orvio-search" style="display:flex">
				<input type="search" name="s" placeholder="<?php echo esc_attr( orvio_t( 'Search the edit…', 'جستجو میان اشیاء…' ) ); ?>">
				<?php if ( class_exists( 'WooCommerce' ) ) : ?><input type="hidden" name="post_type" value="product"><?php endif; ?>
				<button type="submit"><?php echo esc_html( orvio_t( 'Search', 'جستجو' ) ); ?></button>
			</div>
		</form>
	</div>
	<?php if ( ! empty( $o['show_catbar'] ) ) : ?>
	<nav class="orvio-catbar" aria-label="<?php echo esc_attr( orvio_t( 'Categories', 'دسته‌ها' ) ); ?>">
		<div class="orvio-container orvio-catbar__row">
			<?php get_template_part( 'template-parts/header/category-menu' ); ?>
		</div>
	</nav>
	<?php endif; ?>
</header>
