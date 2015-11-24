<?php
/**
 * Custom Page Template Functions
**/


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
