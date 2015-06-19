<?php
if ( strpos( get_theme_mod( 'theme_layout' ),'sidebar1' ) === false) {
	return false;
}
?>

<div id="sidebar-primary-wrap">

	<aside <?php hybrid_attr( 'sidebar', 'primary' ); ?>>

		<?php if ( is_active_sidebar( 'primary' ) ) : // If the sidebar has widgets. ?>

			<?php dynamic_sidebar( 'primary' ); // Displays the primary sidebar. ?>

		<?php else : // If the sidebar has no widgets. ?>

			<?php the_widget( 'WP_Widget_Text',
				array(
					'title' => 'Site Name',
					'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas a tortor quam. Vestibulum aliquet, diam eget dignissim vehicula, sapien sapien tempor velit, a ultrices tellus turpis nec nunc. Duis porta dapibus ligula vel semper.',
				),
				array(
					'before_widget' => '<section class="widget widget_recent_entries">',
					'after_widget'  => '</section>',
					'before_title'  => '<h3 class="widget-title">',
					'after_title'   => '</h3>'
				)
			); ?>

		<?php endif; // End widgets check. ?>

	</aside><!-- #sidebar-primary -->

</div>