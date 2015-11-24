<?php
/**
 * Utility Features
**/

/* === MOBILE VIEW === */
add_theme_support( 'tamatebako-customize-mobile-view' );

/* === CUSTOM CSS === */
$custom_css_args = array(
	'title' => _x( 'Custom CSS', 'customizer', 'explorer' ),
	'label' => _x( 'Custom CSS', 'customizer', 'explorer' ),
);
add_theme_support( 'tamatebako-custom-css', $custom_css_args );

/* === UTILITY FUNCTIONS === */

/**
 * Get Post Type Name
 * @since 1.0.0
 */
function explorer_get_post_type_name( $id = '' ){
	if( !$id ){ $id = get_the_ID(); }
	$name = '';
	$cpt = get_post_type_object( get_post_type( $id ) );
	if( isset( $cpt->labels->name ) ){
		$name = $cpt->labels->name;
	}
	return $name;
}



