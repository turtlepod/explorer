<?php
/**
 * Content For Home Navigation Page Template
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php 
	/* Display menu only if the location is registered */
	if ( tamatebako_is_menu_registered( 'home' ) ){
		wp_nav_menu(
			array(
				'theme_location'  => 'home',
				'container'       => '',
				'depth'           => 1,
				'menu_id'         => 'menu-home-items',
				'menu_class'      => 'menu-items',
				'fallback_cb'     => 'explorer_home_menu_fallback_cb',
				'items_wrap'      => '<div class="wrap"><ul id="%s" class="%s">%s</ul></div>',
				'walker'          => new Explorer_Home_Navigation,
			)
		);
	} ?>

</article><!-- .entry -->


<?php comments_template( '', true ); // Load comments. ?>