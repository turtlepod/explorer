<?php
/**
 * Theme Functions
** ---------------------------- */

/* Load text string used in theme */
require_once( trailingslashit( get_template_directory() ) . 'includes/string.php' );

/* Load base theme functionality. */
require_once( trailingslashit( get_template_directory() ) . 'includes/tamatebako.php' );

/* Load theme general setup */
add_action( 'after_setup_theme', 'explorer_setup' );

/**
 * General Setup
 * @since 0.1.0
 */
function explorer_setup(){

	/* === Post Formats === */
	$post_formats_args = array(
		'aside',
		'image',
		'gallery',
		'link',
		'quote',
		'status',
		'video',
		'audio',
		'chat'
	);
	add_theme_support( 'post-formats', $post_formats_args );

	/* === Register Sidebars === */
	$sidebars_args = array(
		"primary" => array( "name" => _x( 'Sidebar', 'sidebar name', 'explorer' ), "description" => "" ),
	);
	add_theme_support( 'tamatebako-sidebars', $sidebars_args );

	/* === Load Stylesheet === */
	$style_args = array(
		'theme-open-sans-font',
		'dashicons',
		'theme-reset',
		'theme',
		'media-queries',
		//'debug-media-queries'
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
	$custom_bg_args = array(
		'default-color'          => 'f1f1f1',
		'default-image'          => get_template_directory_uri() . '/css/images/background.jpg',
		'default-repeat'         => 'no-repeat',
		'default-position-x'     => 'center',
		'default-attachment'     => 'fixed',
	);
	add_theme_support( 'custom-background', $custom_bg_args );

	/* === Set Content Width === */
	hybrid_set_content_width( 610 );

	/* === Customizer Option === */
	add_action( 'customize_register', 'explorer_customizer_register' );

	/* Body Class */
	add_action( 'body_class', 'explorer_body_class' );

}

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

/**
 * Customizer Options
 * @since 1.0.0
 */
function explorer_customizer_register( $wp_customize ){

	/* === BACKGROUND === */

	/* Full size bg setting */
	$wp_customize->add_setting( 'full_size_background', array(
    	'default'             => 0,
		'type'                => 'theme_mod',
		'capability'          => 'edit_theme_options',
		'sanitize_callback'   => 'explorer_sanitize_checkbox',
    ));

	/* add it in background image section */
    $wp_customize->add_control( 'explorer_full_size_background', array(
    	'settings'            => 'full_size_background',
		'section'             => 'background_image',
		'label'               => __( 'Full Size Background', 'explorer' ),
		'type'                => 'checkbox',
		'priority'            => 20,
	));

}

/**
 * Add Body Class
 * @since 1.0.0
 */
function explorer_body_class( $classes ){
	/* full size background */
	if ( explorer_sanitize_checkbox( get_theme_mod( 'full_size_background', '' ) ) ){
		$classes[] = 'full-size-background';
	}
	return $classes;
}

/**
 * Utillity: Sanitize Checkbox
 * @since 1.0.0
 */
function explorer_sanitize_checkbox( $input ){
	if ( isset($input) && !empty($input) ){
		return true;
	}
	return false;
}


do_action( 'explorer_after_setup_theme' );