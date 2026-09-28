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
<?php
$account_layouts = array( 'saas' );
$account_styles  = array( 'saas' );
$layout_setting  = orvio_opt( 'account_layout', 'saas' );
$style_setting   = orvio_opt( 'account_style', 'saas' );
$account_layout  = in_array( $layout_setting, $account_layouts, true ) ? $layout_setting : 'saas';
$account_style   = in_array( $style_setting, $account_styles, true ) ? $style_setting : 'saas';
?>
<div class="orvio-account orvio-account--layout-<?php echo esc_attr( $account_layout ); ?> orvio-account--style-<?php echo esc_attr( $account_style ); ?>">
	<?php do_action( 'woocommerce_account_navigation' ); ?>
	<div class="orvio-account__content woocommerce-MyAccount-content">
		<?php do_action( 'woocommerce_account_content' ); ?>
	</div>
</div>
