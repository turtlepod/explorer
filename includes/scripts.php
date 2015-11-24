<?php
/**
 * Scripts Setup
**/

/* === EDITOR STYLE === */

$editor_css = array(
	tamatebako_google_fonts_url( array( 'Open Sans' => '400,400italic,700,700italic,800,800italic' ) ),
	'assets/css/editor.css',
);
add_editor_style( $editor_css );


/* === ENQUEUE SCRIPTS === */

add_action( 'wp_enqueue_scripts', 'explorer_enqueue_scripts' );

/**
 * Enqueue Scripts
 */
function explorer_enqueue_scripts(){
	global $tamatebako;
	$name = $tamatebako->name;
	$child = $tamatebako->child;

	/* == JS == */
	wp_enqueue_script( "fitvids" );
	wp_enqueue_script( "{$name}-script" );

	/* == CSS == */
	wp_enqueue_style( "dashicons" );
	wp_enqueue_style( "{$name}-google-fonts" );
	wp_enqueue_style( "{$name}-style" ); /* main css. */

	if( is_child_theme() ) wp_enqueue_style( "{$child}-style" ); /* child theme css. */
	if( tamatebako_is_debug() ) wp_enqueue_style( "{$name}-debug" ); /* media queries debug. */
}


/* === REGISTER SCRIPTS === */

add_action( 'wp_enqueue_scripts', 'explorer_register_scripts', 1 );

/**
 * Register Scripts
 */
function explorer_register_scripts(){
	global $tamatebako;
	$name = $tamatebako->name;

	/* FitVids (JS) */
	wp_register_script( "fitvids", tamatebako_theme_file( "assets/js/jquery.fitvids", "js" ) , array( 'jquery' ), '1.1.0', true );

	/* Theme Custom (JS) */
	wp_register_script( "{$name}-script", tamatebako_theme_file( "assets/js/jquery.theme", "js" ), array( 'jquery', 'fitvids' ), tamatebako_theme_version(), true );

	/* === CSS === */

	/* Google Fonts */
	wp_register_style( "{$name}-google-fonts", tamatebako_google_fonts_url( array( 'Open Sans' => '400,400italic,700,700italic,800,800italic' ) ) );

	/* Theme Debug */
	wp_register_style( "{$name}-debug", tamatebako_theme_file( "assets/css/base/debug", "css" ), array() );

}
