<?php
/**
 * Theme Functions
** ---------------------------- */

/* Load text string used in theme */
require_once( trailingslashit( get_template_directory() ) . 'includes/string.php' );

/* Load base theme functionality. */
require_once( trailingslashit( get_template_directory() ) . 'includes/tamatebako.php' );

/* Load theme general setup */
add_action( 'after_setup_theme', 'explorer_setup' );

/**
 * General Setup
 * @since 0.1.0
 */
function explorer_setup(){

	/* === Post Formats === */
	$post_formats_args = array(
		'aside',
		'image',
		'gallery',
		'link',
		'quote',
		'status',
		'video',
		'audio',
		'chat'
	);
	add_theme_support( 'post-formats', $post_formats_args );

	/* === Register Sidebars === */
	$sidebars_args = array(
		"primary" => array( "name" => _x( 'Sidebar', 'sidebar name', 'explorer' ), "description" => "" ),
	);
	add_theme_support( 'tamatebako-sidebars', $sidebars_args );

	/* === Register Menus === */
	$menus_args = array(
		"home" => _x( 'Home Navigation', 'nav menu', 'explorer' ),
	);
	add_theme_support( 'tamatebako-menus', $menus_args );

	/* === Load Stylesheet === */
	$style_args = array(
		'theme-open-sans-font',
		'dashicons',
		'theme-reset',
		'theme',
		'media-queries',
		//'debug-media-queries'
	);
	if ( is_child_theme() ){
		$style_args[] = 'style';
	}
	add_theme_support( 'hybrid-core-styles', $style_args );

	/* === Editor Style === */
	$editor_css = array(
		tamatebako_google_open_sans_font_url(),
		'css/reset.min.css',
		'css/editor.css'
	);
	add_editor_style( $editor_css );

	/* === Customizer Mobile View === */
	add_theme_support( 'tamatebako-customize-mobile-view' );

	/* === Custom Background === */
	$custom_bg_args = array(
		'default-color'          => 'f1f1f1',
		'default-image'          => get_template_directory_uri() . '/css/images/background.jpg',
		'default-repeat'         => 'no-repeat',
		'default-position-x'     => 'center',
		'default-attachment'     => 'fixed',
	);
	add_theme_support( 'custom-background', $custom_bg_args );

	/* === Set Content Width === */
	hybrid_set_content_width( 610 );

	/* === Customizer Option === */
	add_action( 'customize_register', 'explorer_customizer_register' );

	/* Body Class */
	add_action( 'body_class', 'explorer_body_class' );

}

/**
 * Get Post Type Name
 * @since 1.0.0
 */
function explorer_get_post_type_name( $id = '' ){
	if( !$id ){ $id = get_the_ID(); }
	$name = '';
	$cpt = get_post_type_object( get_post_type( $id ) );
	if( isset( $cpt->labels->name ) ){
		$name = $cpt->labels->name;
	}
	return $name;
}

/**
 * Customizer Options
 * @since 1.0.0
 */
function explorer_customizer_register( $wp_customize ){

	/* === BACKGROUND === */

	/* Full size bg setting */
	$wp_customize->add_setting( 'full_size_background', array(
    	'default'             => 0,
		'type'                => 'theme_mod',
		'capability'          => 'edit_theme_options',
		'sanitize_callback'   => 'explorer_sanitize_checkbox',
    ));

	/* add it in background image section */
    $wp_customize->add_control( 'explorer_full_size_background', array(
    	'settings'            => 'full_size_background',
		'section'             => 'background_image',
		'label'               => __( 'Full Size Background', 'explorer' ),
		'type'                => 'checkbox',
		'priority'            => 20,
	));

}

/**
 * Add Body Class
 * @since 1.0.0
 */
function explorer_body_class( $classes ){
	/* full size background */
	if ( explorer_sanitize_checkbox( get_theme_mod( 'full_size_background', '' ) ) ){
		$classes[] = 'full-size-background';
	}
	return $classes;
}

/**
 * Utillity: Sanitize Checkbox
 * @since 1.0.0
 */
function explorer_sanitize_checkbox( $input ){
	if ( isset($input) && !empty($input) ){
		return true;
	}
	return false;
}

/**
 * Home Navigation Walker
 * @link http://wpbeg.in/V8Sa8i
 * @since 1.0.0
 */
class Explorer_Home_Navigation extends Walker_Nav_Menu {

	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';
		$wrap_class = ! empty( $item->xfn ) ? ' rel-' . esc_attr( $item->xfn ) : '';

		$item_output = $args->before;
		$item_output .= '<div class="home-menu-item-wrap' . $wrap_class . '">';
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		if( !empty( $item->description ) ){
			$item_output .= '<br /><span class="menu-item-desc">' . $item->description . '</span>';
		}
		$item_output .= '</div>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

/**
 * Home Navigation Fallback CB
 * @since 1.0.0
 */
function explorer_home_menu_fallback_cb(){
?>
	<div class="wrap">

		<ul class="menu-items" id="menu-home-items">

			<?php
			/* === List All Category === */
			$cat_loop_args = array(
				'orderby' => 'name',
				'order'   => 'ASC'
			);
			$categories = get_categories( $cat_loop_args );

			/* Loop Category */
			foreach( $categories as $category ){
			?>
				<li class="menu-item menu-item-type-taxonomy menu-item-object-category">
					<div class="home-menu-item-wrap">
						<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>"><?php echo $category->name; ?></a>
						<?php if( isset( $category->description ) && !empty( $category->description ) ){ ?>
							<br><span class="menu-item-desc"><?php echo $category->description; ?></span>
						<?php } ?>
					</div>
				</li>
			<?php } ?>

			<?php
			/* === List All Pages === */
			$page_loop_args = array(
				'post_type' => 'page',
			);
			$pages = new WP_Query( $page_loop_args );

			// The Loop
			if ( $pages->have_posts() ) {
				while ( $pages->have_posts() ) { $pages->the_post();
					?>
					<li class="menu-item menu-item-type-post_type menu-item-object-page">
						<div class="home-menu-item-wrap">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</div>
					</li>
					<?php 
				} // end while 
			} // end if
			wp_reset_postdata();
			?>
		</ul>

	</div>
<?php
}


do_action( 'explorer_after_setup_theme' );