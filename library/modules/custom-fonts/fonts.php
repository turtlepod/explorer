<?php
/**
 * List of all available fonts.
**/

/**
 * Web Safe Fonts
 * all fonts in this group nned to use "ws_" prefix.
 */
function tamatebako_fonts_websafe(){

	$fonts = array(
		'ws_arial' => array(
			'name' => 'Arial / Helvetica',
			'family' => 'Arial,Helvetica,sans-serif',
		),
		'ws_times' => array(
			'name' => 'Times New Roman',
			'family' => '"Times New Roman",Times,serif',
		),
		'ws_courier' => array(
			'name' => 'Courier New',
			'family' => '"Courier New",Courier,monospace',
		),
	);
	return apply_filters( 'tamatebako_fonts_websafe', $fonts );
}


/**
 * Heading Fonts Choices
 * Google fonts only suitable for headings
**/
function tamatebako_fonts_heading(){

	$fonts = array(
		'Abril Fatface' => array(
			'name'    => 'Abril Fatface',
			'family'  => '"Abril Fatface",cursive',
			'weight'  => array( '400' ),
			'subset'  => array( 'latin', 'latin-ext' ),
		),
		'Cherry Swash' => array(
			'name' => 'Cherry Swash',
			'family' => '"Cherry Swash",cursive',
			'weight'  => array( '400', '700' ),
			'subset'  => array( 'latin', 'latin-ext' ),
		),
		'Fondamento' => array(
			'name' => 'Fondamento',
			'family' => '"Fondamento",cursive',
			'weight'  => array( '400', '400italic' ),
			'subset'  => array( 'latin', 'latin-ext' ),
		),
		'Lobster Two' => array(
			'name' => 'Lobster Two',
			'family' => '"Lobster Two",cursive',
			'weight'  => array( '400', '400italic', '700', '700italic' ),
			'subset'  => array( 'latin' ),
		),
		'Oswald' => array(
			'name' => 'Oswald',
			'family' => '"Oswald",sans-serif',
			'weight'  => array( '300', '400', '700' ),
			'subset'  => array( 'latin', 'latin-ext' ),
		),
		'Playfair Display' => array(
			'name' => 'Playfair Display',
			'family' => '"Playfair Display",serif',
			'weight'  => array( '400', '400italic', '700', '700italic', '900', '900italic' ),
			'subset'  => array( 'latin', 'latin-ext','cyrillic' ),
		),
		'Roboto Slab' => array(
			'name' => 'Roboto Slab',
			'family' => '"Roboto Slab",serif',
			'weight'  => array( '100', '300', '400', '700' ),
			'subset'  => array( 'latin', 'latin-ext','cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'vietnamese' ),
		),
		'Rancho' => array(
			'name' => 'Rancho',
			'family' => '"Rancho",cursive',
			'weight'  => array( '400' ),
			'subset'  => array( 'latin' ),
		),
		'Satisfy' => array(
			'name' => 'Satisfy',
			'family' => '"Satisfy",cursive',
			'weight'  => array( '400' ),
			'subset'  => array( 'latin' ),
		),
	);
	return apply_filters( 'tamatebako_fonts_heading', $fonts );
}


/**
 * Base Fonts Choices
 * Google fonts suitable for base fonts
**/
function tamatebako_fonts_base(){

	$fonts = array(
		'Alegreya Sans' => array(
			'name' => 'Alegreya (Sans)',
			'family' => '"Alegreya Sans",sans-serif',
			'weight'  => array( '100', '100italic', '300', '300italic', '400', '400italic', '500', '500italic', '700', '700italic', '800', '800italic', '900', '900italic' ),
			'subset'  => array( 'latin', 'latin-ext', 'vietnamese' ),
		),
		'Alegreya' => array(
			'name' => 'Alegreya (Serif)',
			'family' => '"Alegreya",serif',
			'weight'  => array( '400', '400italic', '700', '700italic', '900', '900italic' ),
			'subset'  => array( 'latin', 'latin-ext' ),
		),
		'Lato' => array(
			'name' => 'Lato',
			'family' => '"Lato",sans-serif',
			'weight'  => array( '100', '100italic', '300', '300italic', '400', '400italic', '700', '700italic', '900', '900italic' ),
			'subset'  => array( 'latin', 'latin-ext' ),
		),
		'Lora' => array(
			'name' => 'Lora',
			'family' => '"Lora",serif',
			'weight'  => array( '400', '400italic', '700', '700italic' ),
			'subset'  => array( 'latin', 'latin-ext', 'cyrillic' ),
		),
		'Merriweather Sans' => array(
			'name' => 'Merriweather (Sans)',
			'family' => '"Merriweather Sans",sans-serif',
			'weight'  => array( '300', '300italic', '400', '400italic', '700', '700italic', '800', '800italic' ),
			'subset'  => array( 'latin', 'latin-ext' ),
		),
		'Merriweather' => array(
			'name' => 'Merriweather (Serif)',
			'family' => '"Merriweather",serif',
			'weight'  => array( '300', '300italic', '400', '400italic', '700', '700italic', '900', '900italic' ),
			'subset'  => array( 'latin', 'latin-ext' ),
		),
		'Noto Sans' => array(
			'name' => 'Noto (Sans)',
			'family' => '"Noto Sans",sans-serif',
			'weight'  => array( '400', '400italic', '700', '700italic' ),
			'subset'  => array( 'latin', 'latin-ext', 'cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'vietnamese' ),
		),
		'Noto Serif' => array(
			'name' => 'Noto (Serif)',
			'family' => '"Noto Serif",serif',
			'weight'  => array( '400', '400italic', '700', '700italic' ),
			'subset'  => array( 'latin', 'latin-ext', 'cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'vietnamese' ),
		),
		'PT Sans' => array(
			'name' => 'PT (Sans)',
			'family' => '"PT Sans",sans-serif',
			'weight'  => array( '400', '400italic', '700', '700italic' ),
			'subset'  => array( 'latin', 'latin-ext','cyrillic', 'cyrillic-ext' ),
		),
		'PT Serif' => array(
			'name' => 'PT (Serif)',
			'family' => '"PT Serif",serif',
			'weight'  => array( '400', '400italic', '700', '700italic' ),
			'subset'  => array( 'latin', 'latin-ext','cyrillic', 'cyrillic-ext' ),
		),
		'Open Sans' => array(
			'name' => 'Open Sans',
			'family' => '"Open Sans",sans-serif',
			'weight'  => array( '300', '300italic', '400', '400italic', '600', '600italic', '700', '700italic', '800', '800italic' ),
			'subset'  => array( 'latin', 'latin-ext', 'cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'vietnamese' ),
		),
		'Noticia Text' => array(
			'name' => 'Noticia Text',
			'family' => '"Noticia Text",serif',
			'weight'  => array( '400', '400italic', '700', '700italic' ),
			'subset'  => array( 'latin', 'latin-ext', 'vietnamese' ),
		),
		'Ubuntu' => array(
			'name' => 'Ubuntu',
			'family' => '"Ubuntu",sans-serif',
			'weight'  => array( '300', '300italic', '400', '400italic', '700', '700italic' ),
			'subset'  => array( 'latin', 'latin-ext','cyrillic', 'cyrillic-ext', 'greek', 'greek-ext' ),
		),
		'Vollkorn' => array(
			'name' => 'Vollkorn',
			'family' => '"Vollkorn",serif',
			'weight'  => array( '400', '400italic', '700', '700italic' ),
			'subset'  => array( 'latin' ),
		),
	);
	return apply_filters( 'tamatebako_fonts_base', $fonts );
}

/**
 * Merge All Fonts Available
 */
function tamatebako_fonts(){
	$fonts = array_merge( tamatebako_fonts_websafe(), tamatebako_fonts_heading(), tamatebako_fonts_base() );
	return apply_filters( 'tamatebako_fonts', $fonts );
}

/**
 * MErge All Google Fonts
 */
function tamatebako_fonts_google(){
	$fonts = array_merge( tamatebako_fonts_heading(), tamatebako_fonts_base() );
	return apply_filters( 'tamatebako_fonts_google', $fonts );
}
