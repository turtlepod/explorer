<?php
/**
 * Setup Theme Elements
**/

/* === Maximum Content Width === */

global $content_width;
if ( ! isset( $content_width ) ){
	$content_width = 610;
}

/* === Register Sidebars === */

$sidebars_args = array(
	"primary"   => array( "name" => _x( 'Primary Sidebar', 'sidebar name', 'explorer' ), "description" => "" ),
);
add_theme_support( 'tamatebako-sidebars', $sidebars_args );

/* === Register Menus === */

$nav_menus_args = array(
	"home" => _x( 'Home Navigation Page Template', 'nav menu name', 'explorer' ),
);
register_nav_menus( $nav_menus_args );