<?php
/**
 * Account navigation.
 *
 * @package Orvio
 */

defined( 'ABSPATH' ) || exit;
$current_user  = wp_get_current_user();
$account_items = wc_get_account_menu_items();
$account_icons = array(
	'dashboard'       => 'grid',
	'orders'          => 'bag',
	'downloads'       => 'grid',
	'edit-account'    => 'user',
	'payment-methods' => 'shield',
	'customer-logout' => 'back',
	'view-order'      => 'bag',
);
$edit_url     = wc_get_account_endpoint_url( 'edit-account' );
$avatar_id    = orvio_account_avatar_id( $current_user->ID );
$display_name = $current_user->display_name ?: $current_user->user_login;
?>
<div class="orvio-account-nav-wrap">
	<div class="orvio-account-nav-mobile" aria-label="<?php echo esc_attr( orvio_t( 'Account shortcuts', 'میانبرهای حساب کاربری' ) ); ?>">
		<div class="orvio-account-nav-mobile__identity">
			<button type="button" class="orvio-account-nav-mobile__avatar" data-open="account-nav" aria-controls="orvio-account-navigation" aria-expanded="false" aria-label="<?php echo esc_attr( orvio_t( 'Open account menu', 'باز کردن منوی حساب کاربری' ) ); ?>">
				<?php echo orvio_account_avatar_html( $current_user->ID, 56 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</button>
			<div><strong><?php echo esc_html( $display_name ); ?></strong><span><?php echo esc_html( orvio_t( 'Account', 'حساب کاربری' ) ); ?></span></div>
		</div>
		<div class="orvio-account-nav-mobile__links">
			<?php foreach ( $account_items as $endpoint => $label ) : $icon = $account_icons[ $endpoint ] ?? 'grid'; ?>
				<a class="<?php echo esc_attr( wc_get_account_menu_item_classes( $endpoint ) ); ?><?php echo wc_is_current_account_menu_item( $endpoint ) ? ' is-on' : ''; ?>" href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" aria-label="<?php echo esc_attr( $label ); ?>" title="<?php echo esc_attr( $label ); ?>"<?php echo wc_is_current_account_menu_item( $endpoint ) ? ' aria-current="page"' : ''; ?>>
					<span class="orvio-account-nav-mobile__icon"><?php echo orvio_icon( $icon ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><span class="orvio-account-nav-mobile__label"><?php echo esc_html( $label ); ?></span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>

	<nav id="orvio-account-navigation" class="orvio-account__nav woocommerce-MyAccount-navigation" data-account-nav aria-label="<?php echo esc_attr( orvio_t( 'Account navigation', 'ناوبری حساب کاربری' ) ); ?>">
		<div class="orvio-account-nav__drawer-head">
			<strong><?php echo esc_html( orvio_t( 'Account menu', 'منوی حساب کاربری' ) ); ?></strong>
			<button type="button" class="orvio-account-nav__close" data-close aria-label="<?php echo esc_attr( orvio_t( 'Close account menu', 'بستن منوی حساب کاربری' ) ); ?>">×</button>
		</div>
		<div class="orvio-account-nav__profile">
			<div class="orvio-profile-avatar orvio-profile-avatar--nav" data-avatar-preview-wrap><?php echo orvio_account_avatar_html( $current_user->ID, 96 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
			<div>
				<strong><?php echo esc_html( $display_name ); ?></strong>
				<span><?php echo esc_html( $current_user->user_email ); ?></span>
				<a class="orvio-account-nav__edit" href="<?php echo esc_url( $edit_url ); ?>"><?php echo esc_html( orvio_t( 'Edit profile', 'ویرایش پروفایل' ) ); ?></a>
			</div>
		</div>
		<div class="orvio-account-nav__links">
			<?php foreach ( $account_items as $endpoint => $label ) : $icon = $account_icons[ $endpoint ] ?? 'grid'; ?>
				<a class="<?php echo esc_attr( wc_get_account_menu_item_classes( $endpoint ) ); ?><?php echo wc_is_current_account_menu_item( $endpoint ) ? ' is-on' : ''; ?>" href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"<?php echo wc_is_current_account_menu_item( $endpoint ) ? ' aria-current="page"' : ''; ?>>
					<span class="orvio-account-nav__icon"><?php echo orvio_icon( $icon ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><span class="orvio-account-nav__label"><?php echo esc_html( $label ); ?></span>
				</a>
			<?php endforeach; ?>
		</div>
		<details class="orvio-account-nav__photo-tools">
			<summary><?php echo esc_html( $avatar_id ? orvio_t( 'Change profile photo', 'تغییر عکس پروفایل' ) : orvio_t( 'Add profile photo', 'افزودن عکس پروفایل' ) ); ?></summary>
			<form class="orvio-avatar-form" method="post" enctype="multipart/form-data">
				<label class="orvio-upload-drop" for="orvio-avatar-input">
					<span class="orvio-upload-drop__icon" aria-hidden="true">+</span>
					<span><strong><?php echo esc_html( orvio_t( 'Choose a photo', 'انتخاب عکس' ) ); ?></strong><small data-avatar-name><?php echo esc_html( orvio_t( 'JPG, PNG, WEBP · max 5 MB', 'JPG، PNG، WEBP · حداکثر ۵ مگابایت' ) ); ?></small></span>
					<input id="orvio-avatar-input" type="file" name="orvio_avatar" accept="image/jpeg,image/png,image/webp,image/gif" data-avatar-input>
				</label>
				<input type="hidden" name="orvio_avatar_action" value="upload">
				<?php wp_nonce_field( 'orvio_avatar', 'orvio_avatar_nonce' ); ?>
				<div class="orvio-avatar-form__actions">
					<button type="submit" class="orvio-btn orvio-btn--light orvio-btn--sm"><?php echo esc_html( orvio_t( 'Upload', 'بارگذاری' ) ); ?></button>
					<?php if ( $avatar_id ) : ?><button type="submit" class="orvio-avatar-remove" name="orvio_avatar_remove" value="1"><?php echo esc_html( orvio_t( 'Remove', 'حذف' ) ); ?></button><?php endif; ?>
				</div>
			</form>
		</details>
	</nav>
</div>
