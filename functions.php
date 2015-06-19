<?php
/**
 * Theme Functions
** ---------------------------- */

/* Load text string used in theme */
require_once( trailingslashit( get_template_directory() ) . 'includes/string.php' );

/* Load base theme functionality. */
require_once( trailingslashit( get_template_directory() ) . 'includes/tamatebako.php' );

/* Load theme general setup */
add_action( 'after_setup_theme', 'daftar_setup' );

/**
 * General Setup
 * @since 0.1.0
 */
function daftar_setup(){

	/* === Register Sidebars === */
	$sidebars_args = array(
		"primary" => array( "name" => _x( 'Sidebar', 'sidebar name', 'daftar' ), "description" => "" ),
	);
	add_theme_support( 'tamatebako-sidebars', $sidebars_args );

	/* === Load Stylesheet === */
	$style_args = array(
		'theme-open-sans-font',
		'dashicons',
		'theme-reset',
		'theme',
		'media-queries',
		'debug-media-queries'
	);
	if ( is_child_theme() ){
		$style_args[] = 'style';
	}
	add_theme_support( 'hybrid-core-styles', $style_args );

	/* === Editor Style === */
	$editor_css = array(
		tamatebako_google_open_sans_font_url(),
		'css/reset.min.css',
		'css/editor.css'
	);
	add_editor_style( $editor_css );

	/* === Customizer Mobile View === */
	add_theme_support( 'tamatebako-customize-mobile-view' );

	/* === Custom Background === */
	///add_theme_support( 'custom-background', array( 'default-color' => 'f9f9f9' ) );

	/* === Set Content Width === */
	hybrid_set_content_width( 1200 );

}

do_action( 'daftar_after_setup_theme' );