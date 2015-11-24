<?php
/**
 * Navigation Menus Template Functions
 * @since 3.0.0
**/

/**
 * Get custom menu name by location
 * Helper function to get menu location and use it as mobile toggle.
 * @access public
 * @link   http://wordpress.stackexchange.com/questions/45700
 * @since  0.1.0
 */
function tamatebako_get_menu_name( $location ){

	/* Get registered nav menu */
	$menus = get_registered_nav_menus();

	/* If no menu available, bail early */
	if ( empty( $menus ) ){
		return false;
	}

	/* Check if menu is set */
	if ( has_nav_menu( $location ) ){

		/* Get menu location */
		$locations = get_nav_menu_locations();

		/* If location not set, return false */
		if( ! isset( $locations[$location] ) ){
			return false;
		}

		/* Return menu name */
		$menu_obj = get_term( $locations[$location], 'nav_menu' );
		return $menu_obj->name;
	}
	return false;
}


/**
 * Check if a custom menu location is registered
 * @since 0.1.0
 */
function tamatebako_is_menu_registered( $location ){
	/* Get registered nav menu */
	$menus = get_registered_nav_menus();
	if ( empty( $menus ) ){
		return false;
	}
	elseif ( isset( $menus[$location] ) ){
		return true;
	}
	return false;
}

/**
 * Menu Toggle
 * @since 0.1.0
 */
function tamatebako_menu_toggle( $location ){
?>
<div id="menu-toggle-<?php echo $location; ?>" class="menu-toggle">
	<a class="menu-toggle-open" href="#menu-<?php echo $location; ?>"><span class="screen-reader-text"><?php echo tamatebako_get_menu_name( $location ); ?></span></a>
	<a class="menu-toggle-close" href="#menu-toggle-<?php echo $location?>"><span class="screen-reader-text"><?php echo tamatebako_get_menu_name( $location ); ?></span></a>
</div><!-- .menu-toggle -->
<?php
}

/**
 * Menu Fallback Callback
 * Generic menu fallback and only display link to home page.
 * @since 0.1.0
 */
function tamatebako_menu_fallback_cb(){
?>
<div class="wrap">
	<ul class="menu-items" id="menu-items">
		<li class="menu-item">
			<a rel="home" href="<?php echo esc_url( user_trailingslashit( home_url() ) ); ?>"><?php echo tamatebako_string('menu_default_home'); ?></a>
		</li>
	</ul>
</div>
<?php
}

/**
 * Menu Footer Fallback Callback
 * Generic menu fallback and only display link to home page.
 * @since 0.1.0
 */
function tamatebako_menu_footer_fallback_cb(){
?>
<div class="wrap">
	<ul class="menu-items" id="menu-items">
		<?php echo tamatebako_menu_copyright_item(); ?>
	</ul>
</div>
<?php
}

/**
 * Menu Footer Fallback Callback
 * Generic menu fallback and only display link to home page.
 * @since 0.1.0
 */
function tamatebako_menu_copyright_item(){
	$copy  = '<li id="menu-copyright" class="menu-item">';
	$copy .= '<span><a class="site-link" rel="home" href="' . esc_url( user_trailingslashit( home_url() ) ) . '">' . get_bloginfo( 'name' ) . '</a> &#169; ' . date_i18n( 'Y' ) . '</span>';
	$copy .= '</li>';
	return $copy;
}

/**
 * Navigation Search Form
 * @since 0.1.0
 */
function tamatebako_menu_search_form( $id = 'search-menu' ){
?>
<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<a href="#<?php echo esc_attr( $id ); ?>" class="search-toggle"><span class="screen-reader-text"><?php echo tamatebako_string( 'menu_search_form_toggle' ); ?></span></a>
	<input id="<?php echo esc_attr( $id ); ?>" type="search" class="search-field" placeholder="<?php echo tamatebako_string( 'menu_search_placeholder' ); ?>" value="<?php if ( is_search() ) echo esc_attr( strip_tags( get_search_query() ) ); else ''; ?>" name="s"/>
	<button class="search-submit button"><span class="screen-reader-text"><?php echo tamatebako_string('menu_search_button'); ?></span></button>
</form>
<?php
}