<?php
/**
 * Configurable mobile navigation.
 *
 * @package Orvio
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$o = orvio_settings();
if ( empty( $o['mobile_nav_enabled'] ) ) {
	return;
}
$styles = array( 'bar', 'floating', 'pill', 'glass', 'dark', 'minimal' );
$style  = in_array( $o['mobile_nav_style'] ?? '', $styles, true ) ? $o['mobile_nav_style'] : 'bar';
$active_styles = array( 'soft', 'solid', 'underline', 'dot' );
$active_style  = in_array( $o['mobile_nav_active_style'] ?? '', $active_styles, true ) ? $o['mobile_nav_active_style'] : 'soft';
$shadow_map    = array(
	'none'   => 'none',
	'soft'   => '0 -8px 24px rgba(28, 25, 22, .08)',
	'strong' => '0 -14px 32px rgba(28, 25, 22, .18)',
);
$items  = is_array( $o['mobile_nav_items'] ?? null ) ? $o['mobile_nav_items'] : orvio_mobile_nav_defaults();
$types  = array( 'home', 'categories', 'shop', 'cart', 'account', 'wishlist', 'search', 'custom' );
$visible_items = array();
foreach ( $items as $slot => $item ) {
	if ( ! empty( $item['enabled'] ) && is_array( $item ) ) {
		if ( ! isset( $item['order'] ) ) {
			$item['order'] = absint( str_replace( 'item_', '', (string) $slot ) ) ?: 99;
		}
		$visible_items[ $slot ] = $item;
	}
}
usort( $visible_items, function ( $left, $right ) {
		return ( (int) ( $left['order'] ?? 99 ) ) <=> ( (int) ( $right['order'] ?? 99 ) );
	} );
if ( empty( $visible_items ) ) {
	return;
}
$nav_style = array( '--mobile-nav-items:' . count( $visible_items ) );
$style_map  = array(
	'mobile_nav_background' => '--mobile-nav-background',
	'mobile_nav_text'       => '--mobile-nav-text',
	'mobile_nav_border'     => '--mobile-nav-border',
	'mobile_nav_active'     => '--mobile-nav-active',
	'mobile_nav_active_bg'  => '--mobile-nav-active-bg',
);
foreach ( $style_map as $setting => $variable ) {
	if ( ! empty( $o[ $setting ] ) ) {
		$nav_style[] = $variable . ':' . sanitize_hex_color( $o[ $setting ] );
	}
}
if ( ! empty( $o['mobile_nav_shadow'] ) && isset( $shadow_map[ $o['mobile_nav_shadow'] ] ) ) {
	$nav_style[] = '--mobile-nav-shadow:' . $shadow_map[ $o['mobile_nav_shadow'] ];
}
$numeric_map = array(
	'mobile_nav_radius'    => '--mobile-nav-radius',
	'mobile_nav_spacing'   => '--mobile-nav-spacing',
	'mobile_nav_height'    => '--mobile-nav-height',
	'mobile_nav_icon_size' => '--mobile-nav-icon-size',
);
foreach ( $numeric_map as $setting => $variable ) {
	if ( '' !== ( $o[ $setting ] ?? '' ) ) {
		$nav_style[] = $variable . ':' . absint( $o[ $setting ] ) . 'px';
	}
}
?>
<nav class="orvio-mobile-nav orvio-mobile-nav--<?php echo esc_attr( $style ); ?> orvio-mobile-nav--active-<?php echo esc_attr( $active_style ); ?>" style="<?php echo esc_attr( implode( ';', $nav_style ) ); ?>" aria-label="<?php echo esc_attr( orvio_t( 'Mobile navigation', 'ناوبری موبایل' ) ); ?>">
	<?php foreach ( $visible_items as $slot => $item ) : ?>
		<?php
		$type   = in_array( $item['type'] ?? '', $types, true ) ? $item['type'] : 'home';
		$label  = ! empty( $item['label'] ) ? $item['label'] : orvio_t( 'Home', 'خانه' );
		$icon   = ! empty( $item['icon'] ) ? $item['icon'] : 'home';
		$tag    = 'a';
		$attrs  = '';
		$url    = '';
		$active = false;
		switch ( $type ) {
			case 'home':
				$url    = home_url( '/' );
				$active = is_front_page() || is_home();
				break;
			case 'categories':
				$tag    = 'button';
				$attrs  = ' type="button" data-open="menu" aria-controls="orvio-menu-drawer" aria-expanded="false"';
				$active = function_exists( 'is_product_category' ) && is_product_category();
				break;
			case 'shop':
				$url    = orvio_shop_url();
				$active = function_exists( 'is_shop' ) && is_shop();
				break;
			case 'cart':
				$url = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '#';
				if ( 'page' !== orvio_opt( 'cart_type', 'drawer' ) ) {
					$attrs = ' data-open="cart" aria-controls="orvio-cart-drawer" aria-expanded="false"';
				}
				$active = function_exists( 'is_cart' ) && is_cart();
				break;
			case 'account':
				$url    = orvio_account_url();
				$active = function_exists( 'is_account_page' ) && is_account_page();
				break;
			case 'wishlist':
				$tag   = 'button';
				$attrs = ' type="button" data-open="wish" aria-controls="orvio-wish-drawer" aria-expanded="false"';
				break;
			case 'search':
				$tag    = 'button';
				$attrs  = ' type="button" data-open="search" aria-controls="orvio-search-panel" aria-expanded="false"';
				$active = is_search();
				break;
			case 'custom':
			default:
				$url = ! empty( $item['url'] ) ? $item['url'] : home_url( '/' );
				break;
		}
		if ( 'a' === $tag ) {
			$attrs .= ' href="' . esc_url( $url ) . '"';
		}
		$classes = array( 'orvio-mobile-nav__item' );
		if ( $active ) {
			$classes[] = 'is-active';
		}
		$cart_count = 'cart' === $type ? orvio_cart_count() : 0;
		?>
		<<?php echo esc_attr( $tag ); ?> class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"<?php echo $attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> aria-label="<?php echo esc_attr( $label ); ?>">
			<span class="orvio-mobile-nav__icon"><?php echo orvio_icon( $icon ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php if ( 'cart' === $type ) : ?><span class="orvio-count<?php echo $cart_count ? '' : ' is-zero'; ?>" data-cart-count><?php echo esc_html( (string) $cart_count ); ?></span><?php endif; ?></span>
			<span class="orvio-mobile-nav__label"><?php echo esc_html( $label ); ?></span>
		</<?php echo esc_attr( $tag ); ?>>
	<?php endforeach; ?>
</nav>
