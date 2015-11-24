<?php
/**
 * Custom CSS
 * It's using postMessage because using refresh method is not user friendly.
 * @since 3.0.0
**/

/**
 * Custom CSS Args
 */
function tamatebako_custom_css_args(){

	/* Get theme support */
	$custom_css_support = get_theme_support( 'tamatebako-custom-css' );
	$theme_args = array();
	if ( isset( $custom_css_support[0] ) ){
		$theme_args = $custom_css_support[0];
	}

	/* Default Args */
	$defaults_args = array( 
		'title'       => 'Custom CSS',
		'label'       => 'Custom CSS',
		'type'        => 'textarea',
		'section'     => 'custom_css',
	);

	/* Logo Args. */
	return wp_parse_args( $theme_args, $defaults_args );
}


/* Register Custom CSS to Customizer */
add_action( 'customize_register', 'tamatebako_custom_css_customize_register', 15 );

/**
 * Register Customizer
 * @since 3.0.0
 */
function tamatebako_custom_css_customize_register( $wp_customize ){

	/* Args */
	$custom_css_args = tamatebako_custom_css_args();

	/* Add Section */
	$wp_customize->add_section(
		'custom_css',
		array(
			'title' => esc_html( $custom_css_args['title'] ),
		)
	);

	/* Add Setting: as theme mod. */
	$wp_customize->add_setting(
		'custom_css',
		array(
			'type'                => 'theme_mod',
			'transport'           => 'postMessage',
			'capability'          => 'edit_theme_options',
			'sanitize_callback'   => 'esc_html',
		)
	);

	// Uses the `textarea` type added in WordPress 4.0.
	$wp_customize->add_control( 'custom_css', tamatebako_custom_css_args() );
}


/* Preview Script */
add_action( 'customize_preview_init', 'tamatebako_custom_css_customizer_js' );

/**
 * JS to load changes asynchronously.
 */
function tamatebako_custom_css_customizer_js() {
	global $tamatebako;
	$js = trailingslashit( get_template_directory_uri() ) . $tamatebako->dir . '/modules/custom-css/custom-css.js';
	wp_enqueue_script( 'tamatebako_custom_css_preview', $js, array( 'customize-preview' ), tamatebako_theme_version(), true );
}


/* Print CSS to WP Head */
add_action( 'wp_head', 'tamatebako_custom_css_wp_head', 99 );

/**
 * Add CSS to Head.
 */
function tamatebako_custom_css_wp_head() {
	global $wp_customize, $tamatebako;
	if( get_theme_mod( 'custom_css' ) ){
?>
<style id="tamatebako-custom-css" type="text/css">
<?php echo tamatebako_parse_css( get_theme_mod( 'custom_css' ) );?>
</style>
<?php
	}
	/* Always add empty style in customizer. */
	elseif( isset( $wp_customize ) ){
?>
<style id="tamatebako-custom-css" type="text/css"></style>
<?php
	}
}

/**
 * Tamatebako Restore CSS
 * restore several character from esc_html().
 * @access Private
 */
function tamatebako_parse_css( $css ){
	$css = esc_html( $css );
	$css = wp_kses( $css, array() ); /* why not striptags? who knows? */
	$css = str_replace( '&gt;', '>', $css );
	$css = str_replace( '&quot;', '"', $css );
	$css = str_replace( '&amp;', "&", $css );
	$css = str_replace( '&amp;#039;', "'", $css );
	$css = str_replace( '&#039;', "'", $css );
	return $css;
}