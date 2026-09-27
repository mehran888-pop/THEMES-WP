<?php
/**
 * Off-canvas menu, cart and wishlist.
 *
 * @package Orvio
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$terms = orvio_product_cats();
?>
<div class="orvio-overlay" data-overlay></div>
<aside class="orvio-drawer orvio-drawer--menu" data-drawer="menu" aria-hidden="true">
	<div class="orvio-drawer__head">
		<h2><?php echo esc_html( orvio_t( 'Menu', 'منو' ) ); ?></h2>
		<button type="button" class="orvio-drawer__x" data-close aria-label="<?php echo esc_attr( orvio_t( 'Close', 'بستن' ) ); ?>">×</button>
	</div>
	<div class="orvio-drawer__body">
		<form class="orvio-search" style="display:flex;margin-bottom:12px" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input type="search" name="s" placeholder="<?php echo esc_attr( orvio_t( 'Search…', 'جستجو…' ) ); ?>">
			<?php if ( class_exists( 'WooCommerce' ) ) : ?><input type="hidden" name="post_type" value="product"><?php endif; ?>
			<button type="submit"><?php echo esc_html( orvio_t( 'Search', 'جستجو' ) ); ?></button>
		</form>
		<div class="orvio-menu-acc">
			<?php if ( $terms ) : foreach ( $terms as $term ) : ?>
				<details>
					<summary><?php echo esc_html( $term->name ); ?></summary>
					<a href="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo esc_html( orvio_t( 'View all', 'مشاهده همه' ) ); ?></a>
					<?php
					$children = get_terms( array( 'taxonomy' => 'product_cat', 'parent' => $term->term_id, 'hide_empty' => true ) );
					if ( ! is_wp_error( $children ) ) {
						foreach ( $children as $child ) {
							echo '<a href="' . esc_url( get_term_link( $child ) ) . '">' . esc_html( $child->name ) . '</a>';
						}
					}
					?>
				</details>
			<?php endforeach; endif; ?>
		</div>
		<div class="orvio-menu-links">
			<a href="<?php echo esc_url( orvio_shop_url() ); ?>"><?php echo esc_html( orvio_t( 'Shop', 'فروشگاه' ) ); ?></a>
			<a href="<?php echo esc_url( orvio_account_url() ); ?>"><?php echo esc_html( orvio_t( 'Account', 'حساب' ) ); ?></a>
			<?php
			$about = get_page_by_path( 'about' );
			$contact = get_page_by_path( 'contact' );
			if ( $about ) {
				echo '<a href="' . esc_url( get_permalink( $about ) ) . '">' . esc_html( orvio_t( 'About', 'درباره ما' ) ) . '</a>';
			}
			if ( $contact ) {
				echo '<a href="' . esc_url( get_permalink( $contact ) ) . '">' . esc_html( orvio_t( 'Contact', 'ارتباط با ما' ) ) . '</a>';
			}
			?>
		</div>
	</div>
</aside>
<aside class="orvio-drawer orvio-drawer--cart" data-drawer="cart" aria-hidden="true">
	<div class="orvio-drawer__head">
		<h2><?php echo esc_html( orvio_t( 'Bag', 'سبد' ) ); ?></h2>
		<button type="button" class="orvio-drawer__x" data-close>×</button>
	</div>
	<div class="orvio-shipbar">
		<div class="orvio-shipbar__track"><span data-ship-fill style="width:0"></span></div>
		<p data-ship-text></p>
	</div>
	<div class="orvio-drawer__body orvio-minicart">
		<?php
		if ( function_exists( 'woocommerce_mini_cart' ) ) {
			woocommerce_mini_cart();
		} else {
			echo '<p class="orvio-note">' . esc_html( orvio_t( 'Activate WooCommerce to use the bag.', 'برای سبد خرید، ووکامرس را فعال کنید.' ) ) . '</p>';
		}
		?>
	</div>
	<div class="orvio-drawer__foot">
		<div class="orvio-drawer__total"><span><?php echo esc_html( orvio_t( 'Subtotal', 'جمع جزء' ) ); ?></span><strong class="orvio-cartbtn__total" data-cart-total><?php echo wp_kses_post( orvio_cart_total_html() ); ?></strong></div>
		<?php if ( function_exists( 'wc_get_cart_url' ) ) : ?>
			<a class="orvio-btn orvio-btn--ghost orvio-btn--full" href="<?php echo esc_url( wc_get_cart_url() ); ?>"><?php echo esc_html( orvio_t( 'View bag', 'مشاهده سبد' ) ); ?></a>
			<a class="orvio-btn orvio-btn--primary orvio-btn--full" href="<?php echo esc_url( wc_get_checkout_url() ); ?>"><?php echo esc_html( orvio_t( 'Checkout', 'تسویه و صورتحساب' ) ); ?></a>
		<?php endif; ?>
	</div>
</aside>
<aside class="orvio-drawer orvio-drawer--wish" data-drawer="wish" aria-hidden="true">
	<div class="orvio-drawer__head">
		<h2><?php echo esc_html( orvio_t( 'Saved', 'علاقه‌مندی' ) ); ?></h2>
		<button type="button" class="orvio-drawer__x" data-close>×</button>
	</div>
	<div class="orvio-drawer__body" data-wish-items></div>
</aside>
<div class="orvio-toast" data-toast role="status"></div>
