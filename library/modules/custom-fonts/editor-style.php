<?php
/**
 * Custom Fonts: Editor Style Functions.
 * Ajax CSS in editor style is taken from "Stargazer" theme by Justin Tadlock.
 * @author David Chandra <david@genbu.me>
 * @author Justin Tadlock <justintadlock@gmail.com>
**/

/**
 * Editor Styles Setting
 */
function tamatebako_fonts_mce_setting(){
	$settings = tamatebako_fonts_settings();
	return $settings['editor_styles'];
}

/**
 * Fonts used in tinymce editor.
 */
function tamatebako_fonts_mce_fonts(){

	/* Var */
	$settings = tamatebako_fonts_mce_setting();
	$config = tamatebako_fonts_config();
	$fonts = array();

	foreach( $settings as $setting ){
		$font = get_theme_mod( $setting, $config[$setting]['default'] );
		$fonts[$font] = tamatebako_get_font_weight( $font );
	}
	return $fonts;
}

/**
 * Get Base Font (Google Font)
 */
function tamatebako_fonts_mce_google_fonts_url(){

	/* var */
	$google_fonts = array();
	$fonts_subsets = array();
	$fonts = tamatebako_fonts_mce_fonts();

	/* Foreach fonts get data. */
	foreach( $fonts as $font_name => $font_data ){
		$font = tamatebako_fonts_remove_websafe( $font_name );
		if( !empty( $font ) ){
			$google_fonts[$font_name] = $font_data;

			/* subsets. */
			$get_font_subsets = tamatebako_get_font_subsets( $font_name );
			if( !empty( $get_font_subsets ) ){
				foreach( $get_font_subsets as $subset ){
					$fonts_subsets[] = $subset;
				}
			}
		}
	}

	/* get available subset. */
	$subsets_settings = tamatebako_fonts_subsets();
	$subsets = array_intersect( $subsets_settings, $fonts_subsets );

	$url = tamatebako_google_fonts_url( $google_fonts, $subsets );

	return $url;

}

/* Add Editor Style */
add_filter( 'mce_css', 'tamatebako_fonts_mce_css' );

/**
 * WP Editor Styles
 */
function tamatebako_fonts_mce_css( $mce_css ){

	$url = tamatebako_fonts_mce_google_fonts_url();

	/* Add google font */
	if( !empty( $url ) ){
		$mce_css .= ', ' . $url;
	}

	/* add font rules. */
	$mce_css .= ', ' . add_query_arg( array( 'action' => 'tamatebako_fonts_mce_css', '_nonce' => wp_create_nonce( 'tamatebako-fonts-mce-nonce', __FILE__ ) ), admin_url( 'admin-ajax.php' ) );
	return $mce_css;
}


/* Ajax: editor style CSS */
add_action( 'wp_ajax_tamatebako_fonts_mce_css', 'tamatebako_fonts_mce_css_ajax_callback' );
add_action( 'wp_ajax_no_priv_tamatebako_fonts_mce_css', 'tamatebako_fonts_mce_css_ajax_callback' );

/**
 * Ajax Callback
 */
function tamatebako_fonts_mce_css_ajax_callback(){

	/* Check Nonce */
	$nonce = isset( $_REQUEST['_nonce'] ) ? $_REQUEST['_nonce'] : '';
	if( ! wp_verify_nonce( $nonce, 'tamatebako-fonts-mce-nonce' ) ){
		die();
	}

	/* Var */
	$css = '';
	$settings = tamatebako_fonts_mce_setting();
	$config = tamatebako_fonts_config();

	foreach( $settings as $setting ){
		$font = get_theme_mod( $setting, $config[$setting]['default'] );

		$target_element = $config[$setting]['target'];
		$font_family = tamatebako_get_font_family( $font );

		$css .= "{$target_element}{font-family:{$font_family};}";
	}

	header( 'Content-type: text/css' );
	echo $css;
	die();
}

