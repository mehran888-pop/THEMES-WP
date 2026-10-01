<?php
/**
 * Site footer.
 *
 * @package Orvio
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$o = orvio_settings();
$footer_layouts = array( 'classic', 'centered', 'minimal', 'editorial' );
$footer_layout  = ( isset( $args['layout'] ) && in_array( $args['layout'], $footer_layouts, true ) ) ? $args['layout'] : ( in_array( $o['footer_layout'], $footer_layouts, true ) ? $o['footer_layout'] : 'classic' );
?>
<footer class="orvio-footer orvio-footer--<?php echo esc_attr( $footer_layout ); ?>">
	<div class="orvio-container orvio-footer__grid">
		<div class="orvio-footer__brand">
			<a class="orvio-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:#fff"><?php echo orvio_logo_mark(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span class="orvio-logo__word"><strong><?php bloginfo( 'name' ); ?></strong></span></a>
			<p><?php echo esc_html( $o['footer_about'] ); ?></p>
			<div class="orvio-social">
				<?php
				$socials = array(
					'instagram' => $o['instagram'],
					'telegram'  => $o['telegram'],
					'whatsapp'  => $o['whatsapp'],
				);
				foreach ( $socials as $name => $url ) {
					if ( ! $url ) {
						continue;
					}
					echo '<a href="' . esc_url( $url ) . '" aria-label="' . esc_attr( $name ) . '">' . esc_html( strtoupper( substr( $name, 0, 2 ) ) ) . '</a>';
				}
				?>
			</div>
			<div class="orvio-pay"><span>COD</span><span>CARD</span><span>TRANSFER</span><span>GATEWAY</span></div>
		</div>
		<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
			<div>
				<?php if ( is_active_sidebar( 'footer-' . $i ) ) : ?>
					<?php dynamic_sidebar( 'footer-' . $i ); ?>
				<?php elseif ( 1 === $i ) : ?>
					<h3><?php echo esc_html( orvio_t( 'Shop', 'فروشگاه' ) ); ?></h3>
					<ul>
						<?php
						$terms = orvio_product_cats();
						if ( $terms ) {
							foreach ( array_slice( $terms, 0, 6 ) as $term ) {
								echo '<li><a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a></li>';
							}
						} else {
							echo '<li><a href="' . esc_url( orvio_shop_url() ) . '">' . esc_html( orvio_t( 'Shop', 'فروشگاه' ) ) . '</a></li>';
						}
						?>
					</ul>
				<?php elseif ( 2 === $i && has_nav_menu( 'footer' ) ) : ?>
					<h3><?php echo esc_html( orvio_t( 'Help', 'راهنما' ) ); ?></h3>
					<?php
					wp_nav_menu( array(
						'theme_location' => 'footer',
						'container'      => false,
						'menu_class'     => '',
						'depth'          => 1,
					) );
					?>
				<?php else : ?>
					<h3><?php echo esc_html( orvio_t( 'Contact', 'ارتباط با ما' ) ); ?></h3>
					<ul>
						<?php if ( $o['address'] ) : ?><li><?php echo esc_html( $o['address'] ); ?></li><?php endif; ?>
						<?php if ( $o['phone'] ) : ?><li><a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $o['phone'] ) ); ?>"><?php echo esc_html( $o['phone'] ); ?></a></li><?php endif; ?>
						<?php if ( $o['email'] ) : ?><li><a href="mailto:<?php echo esc_attr( $o['email'] ); ?>"><?php echo esc_html( $o['email'] ); ?></a></li><?php endif; ?>
						<?php if ( $o['hours'] ) : ?><li><?php echo esc_html( $o['hours'] ); ?></li><?php endif; ?>
					</ul>
				<?php endif; ?>
			</div>
		<?php endfor; ?>
	</div>
	<div class="orvio-container orvio-footer__bottom">
		<span><?php echo esc_html( $o['copyright'] ); ?></span>
		<span>ORVIO</span>
	</div>
</footer>
