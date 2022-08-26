<?php
/**
 * Mill includes
 *
 * The $mill_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @since Mill 1.0.0
 * @link https://github.com/roots/sage/pull/1042
 */
// define( 'WP_DEBUG', true );
$mill_includes = [
	'inc/class-configuration.php',
	'inc/markup.php',
	// 'inc/template-tags.php',
	// 'inc/breadcrumbs/breadcrumbs.php',
	// 'inc/entry-meta/entry-meta.php',
	// 'inc/related-posts/related-posts.php',
	// 'inc/author-box/author-box.php',
];

array_walk( $mill_includes, function ( $file ) {
	if ( ! locate_template( $file, true, true) ) {
		trigger_error( sprintf( __( 'Error locating %s for inclusion', 'mill' ), $file ), E_USER_ERROR );
	}
} );
