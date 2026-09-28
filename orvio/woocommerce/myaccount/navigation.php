<?php
/**
 * Account navigation.
 *
 * @package Orvio
 */

defined( 'ABSPATH' ) || exit;
$current_user = wp_get_current_user();
?>
<nav class="orvio-account__nav woocommerce-MyAccount-navigation" aria-label="<?php echo esc_attr( orvio_t( 'Account navigation', 'ناوبری حساب کاربری' ) ); ?>">
	<div class="orvio-account-nav__profile">
		<div class="orvio-profile-avatar orvio-profile-avatar--nav"><?php echo orvio_account_avatar_html( $current_user->ID, 64 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
		<div><strong><?php echo esc_html( $current_user->display_name ?: $current_user->user_login ); ?></strong><span><?php echo esc_html( $current_user->user_email ); ?></span></div>
	</div>
	<div class="orvio-account-nav__links">
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
			<a class="<?php echo esc_attr( wc_get_account_menu_item_classes( $endpoint ) ); ?><?php echo wc_is_current_account_menu_item( $endpoint ) ? ' is-on' : ''; ?>" href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"<?php echo wc_is_current_account_menu_item( $endpoint ) ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $label ); ?></a>
		<?php endforeach; ?>
	</div>
</nav>
