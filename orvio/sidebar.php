<?php
/**
 * Sidebar.
 *
 * @package Orvio
 */
if ( ! is_active_sidebar( 'shop-filters' ) ) {
	return;
}
?>
<aside class="orvio-filters" data-filters>
	<?php dynamic_sidebar( 'shop-filters' ); ?>
</aside>
