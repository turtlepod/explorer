<?php
/**
 * Logo Module.
 * Easily create logo upload option in customizer.
**/

/**
 * Logo Args
 */
function tamatebako_logo_args(){

	/* Get theme support */
	$logo_support = get_theme_support( 'tamatebako-logo' );
	$theme_args = array();
	if ( isset( $logo_support[0] ) ){
		$theme_args = $logo_support[0];
	}

	/* Default Args */
	$defaults_args = array( 
		'crop'                => true,
		'section'             => 'title_tagline',
		'label'               => 'Logo',
		'description'         => '',
		'flex_width'          => 1,
		'flex_height'         => 1,
		'width'               => 300,
		'height'              => 200,
		'theme_mod_name'      => 'logo',
	);

	/* Logo Args. */
	$args = wp_parse_args( $theme_args, $defaults_args );
	return $args;
}


/* Register Custom CSS to Customizer */
add_action( 'customize_register', 'tamatebako_logo_customize_register' );

/**
 * Register Customizer
 * @since 3.0.0
 */
function tamatebako_logo_customize_register( $wp_customize ){

	/* Args */
	$logo_args = tamatebako_logo_args();

	/* Add Setting: as theme mod. */
	$wp_customize->add_setting(
		sanitize_key( $logo_args['theme_mod_name'] ),
		array(
			'type'                => 'theme_mod',
			'transport'           => 'refresh',
			'capability'          => 'edit_theme_options',
			'sanitize_callback'   => 'esc_html',
		)
	);

	/* Add Control (WP 4.3 with image cropper) */
	if ( class_exists( 'WP_Customize_Cropped_Image_Control' ) && true === $logo_args['crop'] ) {
		$wp_customize->add_control(
			new WP_Customize_Cropped_Image_Control( $wp_customize, sanitize_key( $logo_args['theme_mod_name'] ), $logo_args )
		);
	}
	/* WP 4.2, use image as is. */
	elseif( class_exists( 'WP_Customize_Media_Control' ) ){
		$wp_customize->add_control(
			new WP_Customize_Media_Control( $wp_customize, sanitize_key( $logo_args['theme_mod_name'] ), $logo_args )
		);
	}
}


/* Body Class */
add_filter( 'body_class', 'tamatebako_logo_body_class' );

/**
 * Add body class for styling.
 */
function tamatebako_logo_body_class( $classes ) {
	$logo_args = tamatebako_logo_args();
	$logo_uploaded = get_theme_mod( sanitize_key( $logo_args['theme_mod_name'] ) );
	$classes[] = 'logo-active';
	if( $logo_uploaded ){
		$classes[] = 'logo-uploaded';
	}
	else{
		$classes[] = 'logo-empty';
	}
	return $classes;
}


/**
 * Logo URL
 * @link https://developer.wordpress.org/reference/functions/wp_get_attachment_image_src/
 */
function tamatebako_logo_url(){

	/* Get logo args */
	$logo_args = tamatebako_logo_args();

	/* if theme supports it and logo uploaded, return logo URL */
	if( current_theme_supports( 'tamatebako-logo' ) && get_theme_mod( sanitize_key( $logo_args['theme_mod_name'] ) ) ){
		$image = wp_get_attachment_image_src( absint( get_theme_mod( sanitize_key( $logo_args['theme_mod_name'] ) ) ), 'full' );
		return tamatebako_sanitize_file_type( $image[0], 'image' ); /* image URL */
	}
	return '';
}
