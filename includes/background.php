<?php
/**
 * Custom Background
**/

/* === Custom Background === */
$custom_backgound_args = array(
	'default-color'          => 'f1f1f1',
	'default-image'          => get_template_directory_uri() . '/assets/images/background.jpg',
	'default-repeat'         => 'no-repeat',
	'default-position-x'     => 'center',
	'default-attachment'     => 'fixed',
	'wp-head-callback'       => '_custom_background_cb',
);
add_theme_support( 'custom-background', $custom_backgound_args );

/* Full Size Background (Cover) */
$full_size_bg_args = array(
	'label'                  => _x( 'Full Size Background', 'customizer', 'explorer' ),
);
add_theme_support( 'tamatebako-full-size-background', $full_size_bg_args );

