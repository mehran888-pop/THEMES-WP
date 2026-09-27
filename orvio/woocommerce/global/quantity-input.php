<?php
/**
 * Quantity input.
 *
 * @package Orvio
 */

defined( 'ABSPATH' ) || exit;

if ( $max_value && $min_value === $max_value ) {
	echo '<input type="hidden" name="' . esc_attr( $input_name ) . '" value="' . esc_attr( $min_value ) . '">';
	return;
}
?>
<div class="orvio-qty quantity">
	<button type="button" data-qty="minus" aria-label="<?php echo esc_attr( orvio_t( 'Decrease', 'کم' ) ); ?>">−</button>
	<input type="number" class="input-text qty text" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $input_value ); ?>" min="<?php echo esc_attr( $min_value ); ?>" <?php echo ( 0 < $max_value ) ? 'max="' . esc_attr( $max_value ) . '"' : ''; ?> step="<?php echo esc_attr( $step ); ?>" inputmode="numeric" autocomplete="off">
	<button type="button" data-qty="plus" aria-label="<?php echo esc_attr( orvio_t( 'Increase', 'زیاد' ) ); ?>">+</button>
</div>
