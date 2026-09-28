<?php
/**
 * Account navigation.
 *
 * @package Orvio
 */

defined( 'ABSPATH' ) || exit;
?>
<nav class="orvio-account__nav woocommerce-MyAccount-navigation" aria-label="<?php echo esc_attr( orvio_t( 'Account navigation', 'ناوبری حساب کاربری' ) ); ?>">
	<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
		<a class="<?php echo esc_attr( wc_get_account_menu_item_classes( $endpoint ) ); ?><?php echo wc_is_current_account_menu_item( $endpoint ) ? ' is-on' : ''; ?>" href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"<?php echo wc_is_current_account_menu_item( $endpoint ) ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $label ); ?></a>
	<?php endforeach; ?>
</nav>
