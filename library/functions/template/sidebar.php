<?php
/**
 * Sidebar Tamplate Tags.
**/

/**
 * This is a replacement function for the WordPress `get_sidebar()` function
 * with the ability to add sidebar templates to a sub-directory.  
 * @author Justin Tadlock <justintadlock@gmail.com>
 */
function tamatebako_get_sidebar( $name = null ) {

	do_action( 'get_sidebar', $name ); // Core WordPress hook

	$templates = array();

	if ( '' !== $name ) {
		$templates[] = "sidebar-{$name}.php";
		$templates[] = "sidebar/{$name}.php";
	}

	$templates[] = 'sidebar.php';
	$templates[] = 'sidebar/sidebar.php';

	locate_template( $templates, true );
}

/**
 * Get Sidebar Name by ID
 * Helper function to get sidebar name by sidebar ID and use it as sidebar toggle.
 * @since 0.1.0
 */
function tamatebako_get_sidebar_name( $id ){

	/* Get registered sidebar */
	global $wp_registered_sidebars;

	/* If no sidebar registered, bail early */
	if ( empty( $wp_registered_sidebars ) ){
		return false;
	}

	/* Check if sidebar is set */
	if ( isset( $wp_registered_sidebars[$id] ) ){
		if( isset( $wp_registered_sidebars[$id]['name'] ) ){
			return $wp_registered_sidebars[$id]['name'];
		}
		return false;
	}

	return false;
}
