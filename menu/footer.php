<nav role="navigation" class="menu" id="menu-footer">

	<div class="menu-container">

		<?php
		/* Display menu only if the location is registered */
		if ( tamatebako_is_menu_registered( 'footer' ) ){
			$copy = tamatebako_menu_copyright_item();
			wp_nav_menu(
				array(
					'theme_location'  => 'footer',
					'container'       => '',
					'menu_id'         => 'menu-footer-items',
					'menu_class'      => 'menu-items',
					'depth'           => 1,
					'fallback_cb'     => 'tamatebako_menu_footer_fallback_cb',
					'items_wrap'      => '<div class="wrap"><ul id="%s" class="%s">' . $copy . '%s</ul></div>'
				)
			);
		}
		else{
			tamatebako_menu_footer_fallback_cb();
		}
		?>

	</div><!-- .menu-container -->

</nav><!-- #menu-primary -->