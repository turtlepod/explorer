<?php
/**
 * Custom Fonts: Utility Functions
**/

/**
 * Format Choices Array From Fonts Group
 */
function tamatebako_fonts_format_choices( $font_groups ){

	/* Output */
	$output = array();

	/* For each group, add it in array. */
	foreach( $font_groups as $font_group ){

		/* Add websafe font */
		if( 'websafe' == $font_group ){
			$fonts = tamatebako_fonts_websafe();
			foreach( $fonts as $font_name => $font_data ){
				$output[$font_name] = $font_data['name'];
			}
		}

		/* Headings Fonts */
		elseif( 'heading' == $font_group ){
			$fonts = tamatebako_fonts_heading();
			foreach( $fonts as $font_name => $font_data ){
				$output[$font_name] = $font_data['name'];
			}
		}

		/* Base Fonts */
		elseif( 'base' == $font_group ){
			$fonts = tamatebako_fonts_base();
			foreach( $fonts as $font_name => $font_data ){
				$output[$font_name] = $font_data['name'];
			}
		}
	}
	return $output;
}

/**
 * Get Google Font Weight + Style available (as string)
 * after compating with allowed weight/style.
 */
function tamatebako_get_font_weight( $font_name, $return_array = false ){

	/* get all fonts data. */
	$fonts = tamatebako_fonts();

	/* get font weight. */
	if( isset( $fonts[$font_name]['weight'] ) ){

		/* Allowed weight+style. */
		$allowed_weight = tamatebako_fonts_allowed_weight();

		/* available weight */
		$available_weigth = $fonts[$font_name]['weight'];

		/* set allowed weight to "false" to load all available font. */
		if( false === $allowed_weight ){
			$weight = $available_weigth;
		}
		else{
			$weight = array_intersect( $allowed_weight, $available_weigth );
		}

		if( $return_array ){
			return $weight;
		}
		else{
			return implode( ",", $weight );
		}
	}

	return '';
}


/**
 * Get Font Family (used in CSS) by Font Name
 */
function tamatebako_get_font_family( $font_name ){
	$fonts = tamatebako_fonts();
	if( isset( $fonts[$font_name]['family'] ) ){
		return $fonts[$font_name]['family'];
	}
	return 'sans-serif';
}

/**
 * Get Font Subsets
 */
function tamatebako_get_font_subsets( $font_name ){
	$fonts = tamatebako_fonts();
	if( isset( $fonts[$font_name]['subset'] ) ){
		return $fonts[$font_name]['subset'];
	}
	return '';
}


/**
 * Return empty if it's a websafe font.
 */
function tamatebako_fonts_remove_websafe( $font ){
	if ( strpos( $font, 'ws_' ) !== false ) {
		return '';
	}
	return $font;
}

/**
 * Font Weight Options
 */
function tamatebako_fonts_font_weight_choices(){
	$choices = array(
		'lighter'   => 'lighter',
		'normal'    => 'normal',
		'bold'      => 'bold',
		'bolder'    => 'bolder',
	);
	return apply_filters( 'tamatebako_fonts_font_weight_choices', $choices );
}