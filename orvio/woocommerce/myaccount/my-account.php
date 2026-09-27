<?php
/**
 * My account layout.
 *
 * @package Orvio
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="orvio-pagehead">
	<?php orvio_breadcrumb(); ?>
	<h1><?php echo esc_html( orvio_t( 'Account', 'حساب کاربری' ) ); ?></h1>
</div>
<div class="orvio-account">
	<?php do_action( 'woocommerce_account_navigation' ); ?>
	<div class="orvio-account__content woocommerce-MyAccount-content">
		<?php do_action( 'woocommerce_account_content' ); ?>
	</div>
</div>
