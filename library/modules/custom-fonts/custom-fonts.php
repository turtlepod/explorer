<?php
/**
 * Custom Fonts Module.
**/

/* === VARS === */

/**
 * Fonts Config Defined By Theme
 */
function tamatebako_fonts_config(){
	$theme_support = get_theme_support( 'tamatebako-custom-fonts' );
	$fonts_config = array();
	if ( isset( $theme_support[0] ) ){
		$fonts_config = $theme_support[0];
	}
	return $fonts_config;
}

/**
 * Fonts Settings
 */
function tamatebako_fonts_settings(){
	$theme_support = get_theme_support( 'tamatebako-custom-fonts' );
	$fonts_settings = array();
	if ( isset( $theme_support[1] ) ){
		$fonts_settings = $theme_support[1];
	}
	return $fonts_settings;
}

/**
 * Font Subsets
 */
function tamatebako_fonts_subsets(){

	/* Add latin and latin-extended as default subset. */
	$subsets = array( 'latin', 'latin-ext' );

	/* Add user defined subset. */
	$settings = tamatebako_fonts_settings();
	if( isset( $settings['font_subset'] ) ){
		$subset = $settings['font_subset'];

		/* add subset. */
		if ( 'cyrillic' == $subset ) {
			$subsets[] = 'cyrillic';
			$subsets[] = 'cyrillic-ext';
		}
		elseif ( 'greek' == $subset ) {
			$subsets[] = 'greek';
			$subsets[] = 'greek-ext';
		}
		elseif ( 'vietnamese' == $subset ) {
			$subsets[] = 'vietnamese';
		}
		elseif( 'no-subset' != $subset ){
			/* do nothing. */
		}
		else{
			$subsets[] = $subset;
		}
	}
	/* sanitize */
	$subsets = array_map( 'sanitize_html_class', $subsets );

	return apply_filters( 'tamatebako_fonts_subsets', $subsets );
}

/**
 * Font Allowed Weight (+style)
 * Set to false to load all available weight/style.
 */
function tamatebako_fonts_allowed_weight(){
	$weights = array( 
		'400',
		'400italic',
		'700',
		'700italic',
	);
	$settings = tamatebako_fonts_settings();
	if( isset( $settings['allowed_weight'] ) ){
		$weights = $settings['allowed_weight'];
	}
	return apply_filters( 'tamatebako_fonts_allowed_weight', $weights );
}


/**
 * Fonts Customizer Label
 */
function tamatebako_fonts_label(){
	$defaults = array( 
		'fonts' => 'Fonts',
	);
	$theme_support = get_theme_support( 'tamatebako-custom-fonts' );
	$args = isset( $theme_support[2] ) ? $theme_support[2] : array();
	return wp_parse_args( $args, $defaults );
}

/* === FONTS AVAILABLE === */

tamatebako_include( 'modules/custom-fonts/fonts', true );

/* === UTILITY === */

tamatebako_include( 'modules/custom-fonts/utility', true );

/* === CUSTOMIZER === */

tamatebako_include( 'modules/custom-fonts/customizer', true );

/* === IMPLEMENTATION === */

/**
 * Return Google Font URL containing all fonts used.
 */
function tamatebako_fonts_all_google_url(){

	/* Get fonts config */
	$config = tamatebako_fonts_config();

	/* Vars: List of all fonts used */
	$fonts = array();
	$fonts_subsets = array();

	/* Foreach setting */
	foreach( $config as $section => $section_data ){

		/* Get font saved. */
		$font = tamatebako_fonts_remove_websafe( get_theme_mod( $section, $section_data['default'] ) );

		if( !empty( $font ) ){
			$fonts[$font] = tamatebako_get_font_weight( $font );

			/* subsets. */
			$get_font_subsets = tamatebako_get_font_subsets( $font );
			if( !empty( $get_font_subsets ) ){
				foreach( $get_font_subsets as $subset ){
					$fonts_subsets[] = $subset;
				}
			}
		}

	}

	if( !empty( $fonts ) ){

		/* get available subset. */
		$subsets_settings = tamatebako_fonts_subsets();
		$subsets = array_intersect( $subsets_settings, $fonts_subsets );

		/* return url */
		return tamatebako_google_fonts_url( $fonts, $subsets );
	}
	return '';
}


/* Load font scripts */
add_action( 'wp_enqueue_scripts', 'tamatebako_fonts_enqueue_scripts' );

/**
 * Enqueue ( Google ) Fonts
 */
function tamatebako_fonts_enqueue_scripts(){
	$google_fonts_url = tamatebako_fonts_all_google_url();
	if( !empty( $google_fonts_url ) ){
		wp_enqueue_style( 'tamatebako-custom-fonts', $google_fonts_url, array(), tamatebako_theme_version(), 'all'  );
	}
}

/* Print Style to wp_head */
add_action( 'wp_head', 'tamatebako_fonts_print_style' );

/**
 * Print CSS to Modify Font
 */
function tamatebako_fonts_print_style(){

	/* CSS */
	$css = '';

	/* Config */
	$config = tamatebako_fonts_config();
	
	/* Foreach setting */
	foreach( $config as $section => $section_data ){

		/* Get font saved. */
		$font = get_theme_mod( $section, $section_data['default'] );

		/* Only add if it's not the default. */
		if( $font ){

			$target_element = $section_data['target'];
			$font_family = tamatebako_get_font_family( $font );

			$css .= "{$target_element}{font-family:{$font_family};}";

		}

		/* Get font weight */
		if( isset( $section_data['font_weight'] ) && $section_data['font_weight'] ){
			$font_weight = get_theme_mod( $section . '_weight', esc_attr( $section_data['font_weight'] ) );

			$target_element = $section_data['target'];
			$css .= "{$target_element}{font-weight:{$font_weight};}";
		}

	}

	/* PRINT CSS */
	if ( !empty( $css ) ){
		echo "\n" . '<style type="text/css" id="tamatebako-custom-fonts-rules-css">' . trim( $css ) . '</style>' . "\n";
	}
}

/* Add body classes */
add_filter( 'body_class', 'tamatebako_fonts_body_class' );

/**
 * Custom Font: Body Class Status
 */
function tamatebako_fonts_body_class( $classes ){

	/* Add active status */
	$classes[] = 'custom-fonts-active';

	/* Get fonts config */
	$config = tamatebako_fonts_config();

	/* Foreach setting */
	foreach( $config as $section => $section_data ){

		/* format font name */
		$font = get_theme_mod( $section, $section_data['default'] );
		$font = 'tf-' . $section . '-' . $font;
		$font = strtolower( $font );
		$font = str_replace( ' ','-', $font );

		/* Add class */
		$classes[] = sanitize_html_class( $font );
	}
	return array_unique( $classes );
}


/* === EDITOR STYLE === */

$settings = tamatebako_fonts_settings();
if ( isset( $settings['editor_styles'] ) && !empty( $settings['editor_styles'] ) ){
	tamatebako_include( 'modules/custom-fonts/editor-style', true );
}
