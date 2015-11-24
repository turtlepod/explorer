<?php
/**
 * Register Sidebar Module.
 * WP Widget Areas should be registered on "widgets_init".
 * this module is wrapper functions to make it easier to register widget area/sidebar
 * on theme setup function without extra functions/hooks to widgets init.
 * @since 1.0.0
**/

/* Hook to theme setup */
add_action( 'after_setup_theme', 'tamatebako_register_sidebars_setup', 20 );

/**
 * Register Sidebar Setup.
 * @since 1.0.0
 */
function tamatebako_register_sidebars_setup(){
	add_action( 'widgets_init', 'tamatebako_register_sidebars' );
}

/**
 * Register Sidebars
 * @since 0.1.0
 */
function tamatebako_register_sidebars(){

	/* Get theme-supported sidebars. */
	$sidebars = get_theme_support( 'tamatebako-sidebars' );

	/* No Support, Return */
	if ( !is_array( $sidebars[0] ) ){
		return;
	}

	/* Foreach sidebar, register it */
	foreach( $sidebars[0] as $sidebar_id => $sidebar_args ){

		/* Add Sidebar ID */
		$sidebar_args['id'] = $sidebar_id;

		/* Defaults */
		$defaults_args = array(
			'id'            => '',
			'name'          => '',
			'description'   => '',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>'
		);

		$sidebar_args = wp_parse_args( $sidebar_args, $defaults_args );

		register_sidebar( $sidebar_args );
	}
}