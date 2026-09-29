<?php
/**
 * Edit account form.
 *
 * @package Orvio
 */

defined( 'ABSPATH' ) || exit;

$user = wp_get_current_user();
?>
<?php do_action( 'woocommerce_before_edit_account_form' ); ?>
<div class="orvio-edit-profile">
	<div class="orvio-edit-profile__intro">
		<div class="orvio-profile-avatar orvio-profile-avatar--sm"><?php echo orvio_account_avatar_html( $user->ID, 88 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
		<div>
			<p class="orvio-eyebrow"><?php echo esc_html( orvio_t( 'Profile settings', 'تنظیمات پروفایل' ) ); ?></p>
			<h2><?php echo esc_html( orvio_t( 'Make it yours', 'پروفایل خودتان را بسازید' ) ); ?></h2>
			<p><?php echo esc_html( orvio_t( 'Update your details and keep your account information current.', 'مشخصات خود را به‌روز نگه دارید تا تجربه خریدتان بهتر باشد.' ) ); ?></p>
		</div>
	</div>
	<form class="woocommerce-EditAccountForm edit-account orvio-profile-form" action="" method="post">
		<?php do_action( 'woocommerce_edit_account_form_start' ); ?>
		<div class="orvio-form-section">
			<div class="orvio-form-section__head"><span>01</span><div><h3><?php echo esc_html( orvio_t( 'Personal details', 'مشخصات شخصی' ) ); ?></h3><p><?php echo esc_html( orvio_t( 'The basics people see on your account.', 'اطلاعات اصلی حساب شما' ) ); ?></p></div></div>
			<div class="orvio-profile-form__grid">
				<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
					<label for="account_first_name"><?php esc_html_e( 'First name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
					<input type="text" class="woocommerce-Input input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" />
				</p>
				<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
					<label for="account_last_name"><?php esc_html_e( 'Last name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
					<input type="text" class="woocommerce-Input input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" />
				</p>
				<p class="woocommerce-form-row form-row form-row-wide">
					<label for="account_display_name"><?php esc_html_e( 'Display name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
					<input type="text" class="woocommerce-Input input-text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" aria-describedby="account_display_name_description" />
					<span id="account_display_name_description" class="description"><?php echo esc_html( orvio_t( 'This is how your name appears in the account area.', 'این نام در ناحیه کاربری شما نمایش داده می‌شود.' ) ); ?></span>
				</p>
				<p class="woocommerce-form-row form-row form-row-wide">
					<label for="account_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
					<input type="email" class="woocommerce-Input input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" />
				</p>
			</div>
		</div>
		<div class="orvio-form-section">
			<div class="orvio-form-section__head"><span>02</span><div><h3><?php echo esc_html( orvio_t( 'Security', 'امنیت حساب' ) ); ?></h3><p><?php echo esc_html( orvio_t( 'Change your password whenever you need.', 'هر زمان لازم بود رمز عبور خود را تغییر دهید.' ) ); ?></p></div></div>
			<fieldset class="orvio-password-fields">
				<legend><?php esc_html_e( 'Password change', 'woocommerce' ); ?></legend>
				<p class="woocommerce-form-row form-row form-row-wide">
					<label for="password_current"><?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
					<input type="password" class="woocommerce-Input input-text" name="password_current" id="password_current" autocomplete="off" />
				</p>
				<p class="woocommerce-form-row form-row form-row-wide">
					<label for="password_1"><?php esc_html_e( 'New password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
					<input type="password" class="woocommerce-Input input-text" name="password_1" id="password_1" autocomplete="new-password" />
				</p>
				<p class="woocommerce-form-row form-row form-row-wide">
					<label for="password_2"><?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?></label>
					<input type="password" class="woocommerce-Input input-text" name="password_2" id="password_2" autocomplete="new-password" />
				</p>
			</fieldset>
		</div>
		<?php do_action( 'woocommerce_edit_account_form' ); ?>
		<div class="orvio-profile-form__footer">
			<p class="orvio-note"><?php echo esc_html( orvio_t( 'Your information is kept private and used only to manage your account.', 'اطلاعات شما خصوصی است و فقط برای مدیریت حساب استفاده می‌شود.' ) ); ?></p>
			<p>
				<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
				<button type="submit" class="orvio-btn orvio-btn--dark" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php echo esc_html( orvio_t( 'Save changes', 'ذخیره تغییرات' ) ); ?></button>
				<input type="hidden" name="action" value="save_account_details" />
			</p>
		</div>
		<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
	</form>
</div>
<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
