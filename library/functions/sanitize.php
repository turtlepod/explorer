<?php
/**
 * Various Sanitization, Validation, and Related Helper Functions.
**/

/* === CHECKBOX === */

/**
 * Checkbox Sanitization Helper Function
 * return true/false.
 */
function tamatebako_sanitize_checkbox( $input ){
	if ( isset($input) && !empty($input) ){
		return true;
	}
	return false;
}

/* === COLOR === */

/**
 * Utillity function to converts a hex color to RGB.
 * Returns the RGB values as an array.
 *
 * Usage:
 * $color_rgb = join( ', ', tamatebako_hex_to_rgb( $color ) );
 * $css = ".element{ background: rgba({$color_rgb},0.7); }";
 * 
 * @author Justin Tadlock <justintadlock@gmail.com>
 */
function tamatebako_hex_to_rgb( $hex ) {

	/* Remove "#" if it was added. */
	$color = trim( $hex, '#' );

	/* If the color is three characters, convert it to six. */
	if ( 3 === strlen( $color ) ){
		$color = $color[0] . $color[0] . $color[1] . $color[1] . $color[2] . $color[2];
	}

	/* Get the red, green, and blue values. */
	$red   = hexdec( $color[0] . $color[1] );
	$green = hexdec( $color[2] . $color[3] );
	$blue  = hexdec( $color[4] . $color[5] );

	/* Return the RGB colors as an array. */
	return array( 'r' => $red, 'g' => $green, 'b' => $blue );
}


/**
 * Hex Color Sanitization Helper Function
 * This function added to sanitize color in front end, 
 * because wp sanitize_hex_color() only available in customize screen.
 * This is duplicate for sanitize_hex_color() wp-includes/class-wp-customize-manager.php
 * @since 1.0.1
 */
function tamatebako_sanitize_hex_color( $color ){

	/* return empty if empty. */
	if ( '' === $color ){
		return '';
	}

	/* 3 or 6 hex digits, or the empty string. */
	if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ){
		return $color;
	}

	return null;
}


/**
 * Hex Color Sanitization Helper Function
 * This function added to sanitize color in front end,
 * because wp sanitize_hex_color_no_hash() only available in customize screen.
 * This is duplicate for sanitize_hex_color_no_hash() wp-includes/class-wp-customize-manager.php
 * @since 1.0.1
 */
function tamatebako_sanitize_hex_color_no_hash( $color ){

	/* remove hashtag. */
	$color = ltrim( $color, '#' );

	/* return empty if empty. */
	if ( '' === $color ){
		return '';
	}

	/* check using sanitize hex colot. */
	return tamatebako_sanitize_hex_color( '#' . $color ) ? $color : null;
}

/* === FILE === */

/**
 * Sanitize File Type
 * Check if data is an certain file type.
 * example in checking image file:
 * $image_url = tamatebako_sanitize_filetype( $url, 'image' );
 * will return empty if not valid.
 * file type: "application", "audio", "video", "image", "text", etc.
 * @link https://en.wikipedia.org/wiki/Internet_media_type#List_of_common_media_types
 */
function tamatebako_sanitize_file_type( $input, $type = 'image' ){

	/* check file type of input. */
	$filetype = wp_check_filetype( $input );
	$mime_type = $filetype['type'];

	/* if only one type defined. */
	if( is_string( $type ) ){

		/* only file allowed */
		if ( strpos( $mime_type, $type ) !== false ){
			return $input;
		}
	}

	/* multiple file type in array. */
	elseif( is_array( $type ) ){

		/* loop foreach file type allowed. */
		foreach( $type as $single_type ){
			if ( strpos( $mime_type, $single_type ) !== false ){
				return $input;
			}
		}
	}
	return '';
}


/**
 * Sanitize File Extension
 * Check if data have correct file ext.
 * same with tamatebako_sanitize_file_type() but for file ext.
 */
function tamatebako_sanitize_file_ext( $input, $ext = 'css' ){

	/* check file type */
	$filetype = wp_check_filetype( $input );
	$file_ext = $filetype['ext'];

	/* if only one file ext defined. */
	if( is_string( $ext ) ){

		/* if file ext match, return it. */
		if ( $ext == $file_ext ){
			return $input;
		}
	}

	/* multiple file ext in array. */
	elseif( is_array( $ext ) ){

		/* loop foreach file ext allowed. */
		foreach( $ext as $single_ext ){
			if ( $single_ext == $file_ext ){
				return $input;
			}
		}
	}

	return '';
}