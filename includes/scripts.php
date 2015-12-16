<?php
/**
 * Scripts Setup
**/

/* === EDITOR STYLE === */

$editor_css = array(
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
	wp_enqueue_script( "fitvids", tamatebako_theme_file( "assets/js/jquery.fitvids", "js" ) , array( 'jquery' ), '1.1.0', true );
	wp_enqueue_script( "{$name}-script", tamatebako_theme_file( "assets/js/jquery.theme", "js" ), array( 'jquery', 'fitvids' ), tamatebako_theme_version(), true );

	/* == CSS == */
	wp_enqueue_style( "dashicons" );
	wp_enqueue_style( "{$name}-style" ); /* main css. */
	if( is_child_theme() ) wp_enqueue_style( "{$child}-style" ); /* child theme css. */
	if( tamatebako_is_debug() ) wp_enqueue_style( "{$name}-debug", tamatebako_theme_file( "assets/css/base/debug", "css" ), array() ); /* media queries debug. */
}
