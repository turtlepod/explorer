<?php
/**
 * Tamatebako Box
 * A WordPress theme library for faster theme development.
 * 
 *  From the sea comes the sad, sweet voice of the princess:
 *  "I told you not to open that box. In it was your old age ..."
 * 
 * @version   3.1.8
 * @author    David Chandra <david@genbu.me>
 * @copyright Copyright (c) 2016, Genbu Media
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
**/

/**
 * Start Tamatebako!
 * Setup empty object to use when needed.
 */
global $tamatebako;
$tamatebako = new stdClass;

/* Add theme name in the object. */
$tamatebako->name = esc_attr( get_template() );
$tamatebako->child = esc_attr( get_stylesheet() );

/* Add tamatebako directory/folder (not path) in the object. */
$tamatebako->dir = basename( dirname( __FILE__ ) );

/* === LOAD FUNCTIONS === */

/* Load File Loader. */
require_once( trailingslashit( get_template_directory() ) . $tamatebako->dir . '/functions/helper.php' );

/* Load text string used within the framework. */
tamatebako_include( 'functions/strings', true );

/* Load various sanitization functions. */
tamatebako_include( 'functions/sanitize', true );

/* Load default setup and helper functions. */
tamatebako_include( 'functions/setup', true );

/* Load template-tag functions on site front end. */
if ( !is_admin() ) {

	/* General */
	tamatebako_include( 'functions/template/general', true );

	/* Navigation Menu */
	tamatebako_include( 'functions/template/menu', true );

	/* Sidebar */
	tamatebako_include( 'functions/template/sidebar', true );

	/* Entry */
	tamatebako_include( 'functions/template/entry', true );

	/* Attachment */
	tamatebako_include( 'functions/template/attachment', true );

	/* Comment */
	tamatebako_include( 'functions/template/comment', true );

	/* Load front-end utility functions for faster development ( min PHP 5.3 ) */
	if ( version_compare( PHP_VERSION, '5.3.0', '>=' ) ) {
		tamatebako_include( 'functions/template/utility', true );
	}
}

/* === LOAD MODULES === */

/* Load custom theme features. */
add_action( 'after_setup_theme', 'tamatebako_load_theme_support', 15 );

/**
 * Load various modules only when theme add supports for it.
 * 
 * @since 3.0.0
 * @return void
 */
function tamatebako_load_theme_support(){

	/* === BACK COMPAT === */
	tamatebako_require_if_theme_supports( 'tamatebako-back-compat', 'modules/back-compat' );

	/* === REGISTER SIDEBARS === */
	tamatebako_require_if_theme_supports( 'tamatebako-sidebars', 'modules/sidebars' );

	/* === CUSTOMIZER MOBILE VIEW === */
	tamatebako_require_if_theme_supports( 'tamatebako-customize-mobile-view', 'modules/mobile-view' );

	/* === POST FORMATS SETUP === */
	if( !is_admin() ) tamatebako_require_if_theme_supports( 'post-formats', 'modules/post-formats' );

	/* === FULL SIZE BACKGROUND === */
	if ( current_theme_supports( 'custom-background' ) ){
		tamatebako_require_if_theme_supports( 'tamatebako-full-size-background', 'modules/full-size-background' );
	}

	/* === MICRODATA FILTERS === */
	if( !is_admin() ) tamatebako_require_if_theme_supports( 'tamatebako-microdata', 'modules/microdata' );

	/* === LOGO === */
	tamatebako_require_if_theme_supports( 'tamatebako-logo', 'modules/logo' );

	/* === LAYOUTS === */
	tamatebako_require_if_theme_supports( 'tamatebako-layouts', 'modules/layouts/layouts' );

	/* === CUSTOM CSS === */
	tamatebako_require_if_theme_supports( 'tamatebako-custom-css', 'modules/custom-css/custom-css' );

	/* === CUSTOM FONTS === */
	tamatebako_require_if_theme_supports( 'tamatebako-custom-fonts', 'modules/custom-fonts/custom-fonts' );

}