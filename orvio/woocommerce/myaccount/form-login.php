<?php
/**
 * Login / register.
 *
 * @package Orvio
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_customer_login_form' );
?>
<div class="orvio-auth orvio-panel" id="customer_login">
	<h2><?php esc_html_e( 'Login', 'woocommerce' ); ?></h2>
	<form class="woocommerce-form woocommerce-form-login login" method="post">
		<?php do_action( 'woocommerce_login_form_start' ); ?>
		<label class="orvio-field"><?php esc_html_e( 'Username or email', 'woocommerce' ); ?><input type="text" name="username" autocomplete="username" required></label>
		<label class="orvio-field" style="margin-top:10px"><?php esc_html_e( 'Password', 'woocommerce' ); ?><input type="password" name="password" autocomplete="current-password" required></label>
		<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
		<button type="submit" class="orvio-btn orvio-btn--primary orvio-btn--full" style="margin-top:14px" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
		<p style="margin-top:10px"><a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a></p>
		<?php do_action( 'woocommerce_login_form_end' ); ?>
	</form>
	<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
		<hr style="border:0;border-top:1px solid var(--line);margin:18px 0">
		<h2><?php esc_html_e( 'Register', 'woocommerce' ); ?></h2>
		<form method="post" class="woocommerce-form woocommerce-form-register register">
			<label class="orvio-field"><?php esc_html_e( 'Email address', 'woocommerce' ); ?><input type="email" name="email" required></label>
			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
				<label class="orvio-field" style="margin-top:10px"><?php esc_html_e( 'Password', 'woocommerce' ); ?><input type="password" name="password" required></label>
			<?php endif; ?>
			<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
			<button type="submit" class="orvio-btn orvio-btn--dark orvio-btn--full" style="margin-top:14px" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
		</form>
	<?php endif; ?>
</div>
<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
