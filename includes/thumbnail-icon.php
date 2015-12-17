<?php
/**
 * Customizer Options to display thumbnail instead of icons.
 * @since 2.1.0
**/

/* Register Customizer Option */
add_action( 'customize_register', 'explorer_customizer_register' );

/**
 * Customizer Register.
 * @since 2.1.0
 */
function explorer_customizer_register( $wp_customize ){

	/* Add Section in the Panel. */
	$wp_customize->add_section( 'thumbnail_option', array(
		'title' => esc_html_x( 'Thumbnail Options', 'customizer', 'explorer' ),
	));

	/* Add Setting. */
	$wp_customize->add_setting( 'thumbnail_option', array(
    	'default'             => 'image_icon',
		'type'                => 'theme_mod',
		'capability'          => 'edit_theme_options',
		'sanitize_callback'   => 'explorer_sanitize_thumbnail_option',
    ));

	/* Add control to section. */
    $wp_customize->add_control( 'thumbnail_option', array(
    	'settings'            => 'thumbnail_option',
		'section'             => 'thumbnail_option',
		'label'               => esc_html_x( 'Thumbnail Options', 'customizer', 'explorer' ),
		'type'                => 'radio',
		'choices'             => array(
			'icon'       => _x( 'Show icons, never thumbnails.', 'customizer', 'explorer' ),
			'image'      => _x( 'Display featured image.', 'customizer', 'explorer' ),
			'image_icon' => _x( 'Display icon on featured image.', 'customizer', 'explorer' ),
		),
	));
}


/**
 * Sanitize Thumbnail Options
 * @return string
 */
function explorer_sanitize_thumbnail_option( $input ){
	$choices = array( 'icon', 'image', 'image_icon' );
	if( in_array( $input, $choices ) ){
		return $input;
	}
	return 'image_icon';
}


/**
 * Check thumbnail to display in a post/entry:
 * - icon
 * - image
 * - image_icon
 * this function need to be used in the loop.
 * @return string
 */
function explorer_thumbnail_display(){
	$display = get_theme_mod( 'thumbnail_option' );
	if ( ! has_post_thumbnail() ) {
		$display = 'icon';
	}
	return explorer_sanitize_thumbnail_option( apply_filters( 'explorer_thumbnail_display', $display ) );
}


/* Add Post Class */
add_filter( 'post_class', 'explorer_thumbnail_display_post_class' );

/**
 * Filter post class to add dynamic thumbnail option for easier styling.
 */
function explorer_thumbnail_display_post_class( $classes ){
	$classes[] = sanitize_html_class( 'explorer-thumbnail-' . explorer_thumbnail_display() );
	return $classes;
}


/**
 * Display the thumbnail HTML
 * @return string
 */
function explorer_thumbnail_html(){
	$display = explorer_thumbnail_display();
	if( 'image' == $display ){
		echo '<div class="thumbnail-wrap">';
		the_post_thumbnail( 'thumbnail', array( 'class' => 'thumbnail-image' ) );
		echo '</div>';
	}
	elseif( 'image_icon' == $display ){
		echo '<div class="thumbnail-wrap">';
		the_post_thumbnail( 'thumbnail', array( 'class' => 'thumbnail-image' ) );
		echo '<span class="image-icon-small"></span>';
		echo '</div>';
	}
}
