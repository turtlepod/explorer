<?php
/**
 * Theme Layouts
 * Based on Hybrid Core 2.0 Theme Layouts Ext.
 * @author    David Chandra <david@shellcreeper.com>
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
**/

/* === VARS === */

/**
 * Layouts Defined By Theme
 */
function tamatebako_theme_layouts(){
	return get_theme_support( 'tamatebako-layouts' );
}

/**
 * List Of Layouts
 */
function tamatebako_layouts() {

	/* Get theme-supported layouts. */
	$theme_layouts = tamatebako_theme_layouts();

	/* Assign the strings passed in by the theme author. */
	$layouts = array();
	if ( isset( $theme_layouts[0] ) ){
		$layouts = $theme_layouts[0];
	}

	return $layouts;
}

/**
 * Get Specific Layout Name From Layout Slug
 */
function tamatebako_layout_name( $layout ) {
	$layouts = tamatebako_layouts();
	if( isset( $layouts[ $layout ]['name'] ) ){
		return $layouts[ $layout ]['name'];
	}
	return $layout;
}

/**
 * Array of arguments for layouts.
 */
function tamatebako_layouts_args() {

	$defaults = array( 
		'customize'   => true, 
		'post_meta'   => true, 
		'default'     => '',
		'thumbnail'   => false,
		'post_types'  => array(),
	);

	$layouts = tamatebako_theme_layouts();
	$args = isset( $layouts[1] ) ? $layouts[1] : array();
	return wp_parse_args( $args, $defaults );
}

/**
 * Texts String Used in Layouts Feature
 */
function tamatebako_layouts_strings(){
	$defaults = array( 
		'default'       => 'Default',
		'layout'        => 'Layout',
		'global_layout' => 'Global Layout',
	);
	$layouts = tamatebako_theme_layouts();
	$args = isset( $layouts[2] ) ? $layouts[2] : array();
	return wp_parse_args( $args, $defaults );
}

/**
 * Get String
 */
function tamatebako_layouts_string( $context ){
	$strings = tamatebako_layouts_strings();
	if ( isset( $strings[$context] ) ){
		return $strings[$context];
	}
	return $context;
}

/**
 * Default Layout
 */
function tamatebako_layout_default( $return = 'slug' ){

	/* Vars */
	$layouts = array_keys( tamatebako_layouts() );
	$args = tamatebako_layouts_args();

	/* Validate Layout */
	if( in_array( $args['default'], $layouts ) ){
		if( 'slug' == $return ){
			return $args['default'];
		}
		if( 'name' == $return ){
			return tamatebako_layout_name( $args['default'] );
		}
	}
	return '';
}

/**
 * Supported Post Types
 */
function tamatebako_layouts_post_types(){
	$layouts_args = tamatebako_layouts_args();
	return apply_filters( 'tamatebako_layouts_post_types', $layouts_args['post_types'] );
}

/* === SET DEFAULT LAYOUT === */

/* Filters the theme layout mod. */
add_filter( 'theme_mod_theme_layout', 'tamatebako_set_default_layout' );


/**
 * Filters the 'theme_mods_theme_layout'.
 */
function tamatebako_set_default_layout( $layout ) {

	/* Vars */
	$layouts = array_keys( tamatebako_layouts() );
	$layouts_args = tamatebako_layouts_args();

	/* If customizer enabled, use user set global layout. */
	if( true === $layouts_args['customize'] ){
		if ( empty( $layout ) ) {
			return tamatebako_layout_default();
		}
		else{
			return $layout;
		}
	}
	/* No customizer, use default. */
	else{
		return tamatebako_layout_default();
	}
}

/* === GET CURRENT LAYOUT === */

/**
 * Get Current Layout
 */
function tamatebako_current_layout() {
	return get_theme_mod( 'theme_layout', tamatebako_layout_default() );
}

/* === ADD BODY CLASS === */

/* Filters the body_class hook to add a custom class. */
add_filter( 'body_class', 'tamatebako_layouts_body_class' );


/**
 * Adds the post layout class to the body class in the form of "layout-$layout".
 */
function tamatebako_layouts_body_class( $classes ) {
	$current_layout = tamatebako_current_layout();
	if( !empty( $current_layout ) ){
		$classes[] = sanitize_html_class( 'layout-' . tamatebako_current_layout() );
	}
	return array_unique( $classes );
}

/* === LOAD === */

/* Get Features */
$layouts_args = tamatebako_layouts_args();

/**
 * Load Layouts Post Meta
 */
if( true === $layouts_args['post_meta'] ){
	tamatebako_include( 'modules/layouts/post-meta', true );
}

/**
 * Load Layouts Customizer
 */
if( true === $layouts_args['customize'] ){
	tamatebako_include( 'modules/layouts/customizer', true );
}

