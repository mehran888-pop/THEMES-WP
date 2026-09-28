<?php
/**
 * My account layout.
 *
 * @package Orvio
 */

defined( 'ABSPATH' ) || exit;
$account_back_url = wp_validate_redirect( wp_get_referer(), home_url( '/' ) );
?>
<div class="orvio-pagehead">
	<div class="orvio-account-pagehead__top">
		<a class="orvio-account-back" href="<?php echo esc_url( $account_back_url ); ?>"><span aria-hidden="true">←</span><?php echo esc_html( orvio_t( 'Back', 'بازگشت' ) ); ?></a>
		<?php orvio_breadcrumb(); ?>
	</div>
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
