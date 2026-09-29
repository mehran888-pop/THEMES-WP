<?php
/**
 * Inline icons.
 *
 * @package Orvio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function orvio_icon( $name ) {
	$icons = array(
		'search' => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="6.5"/><path d="M16.2 16.2L20 20"/></svg>',
		'user'   => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="3.2"/><path d="M5.2 19.2c1.3-3 3.7-4.5 6.8-4.5s5.5 1.5 6.8 4.5"/></svg>',
		'heart'  => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 19s-7-4.4-7-8.5A3.5 3.5 0 0 1 12 8a3.5 3.5 0 0 1 7 2.5C19 14.6 12 19 12 19z"/></svg>',
		'home'   => '<svg viewBox="0 0 24 24"><path d="M3.5 11.2L12 4l8.5 7.2"/><path d="M5.5 10.5V20h13v-9.5M9.5 20v-5h5v5"/></svg>',
		'store'  => '<svg viewBox="0 0 24 24"><path d="M4 10h16v10H4zM3 10l2-6h14l2 6"/><path d="M8 10v3M12 10v3M16 10v3"/></svg>',
		'bag'    => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6.5 8h11L16.4 20H7.6L6.5 8z"/><path d="M9 8V7a3 3 0 0 1 6 0v1"/></svg>',
		'menu'   => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h11"/></svg>',
		'grid'   => '<svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><path d="M4 4h6v6H4zM14 4h6v6h-6zM4 14h6v6H4zM14 14h6v6h-6z" fill="none" stroke="currentColor" stroke-width="1.6"/></svg>',
		'chev'   => '<svg viewBox="0 0 24 24" width="14" height="14" aria-hidden="true"><path d="M6 9l6 6 6-6" fill="none" stroke="currentColor" stroke-width="1.8"/></svg>',
		'truck'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M3 7h11v8H3zM14 10h4l3 3v2h-7z"/><circle cx="7" cy="17.5" r="1.4"/><circle cx="17" cy="17.5" r="1.4"/></svg>',
		'back'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M4 12h16M8 8l-4 4 4 4"/></svg>',
		'shield' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M12 3l7 3v6c0 4.5-3 7-7 9-4-2-7-4.5-7-9V6z"/></svg>',
		'check'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="12" r="8"/><path d="M8.5 12.5l2.2 2.2 4.8-5"/></svg>',
	);
	return $icons[ $name ] ?? '';
}

function orvio_logo_mark() {
	return '<span class="orvio-logo__mark" aria-hidden="true"><svg viewBox="0 0 32 32"><circle cx="16" cy="16" r="8" fill="none" stroke="#F4F0EA" stroke-width="1.6"/><circle cx="16" cy="16" r="2.4" fill="#C46A3A"/></svg></span>';
}
