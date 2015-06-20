<div id="sidebar-primary-wrap">

	<aside <?php hybrid_attr( 'sidebar', 'primary' ); ?>>

		<?php if ( is_active_sidebar( 'primary' ) ) : // If the sidebar has widgets. ?>

			<?php dynamic_sidebar( 'primary' ); // Displays the primary sidebar. ?>

		<?php else : // If the sidebar has no widgets. ?>

			<?php the_widget( 'WP_Widget_Text',
				array(
					'title' => explorer_string( 'about' ),
					'text' => get_bloginfo( 'description' )
				),
				array(
					'before_widget' => '<section class="widget widget_text">',
					'after_widget'  => '</section>',
					'before_title'  => '<h3 class="widget-title">',
					'after_title'   => '</h3>'
				)
			); ?>
			<?php the_widget( 'WP_Widget_Pages',
				array(
					'title' => explorer_string( 'navigation' ),
				),
				array(
					'before_widget' => '<section class="widget widget_pages">',
					'after_widget'  => '</section>',
					'before_title'  => '<h3 class="widget-title">',
					'after_title'   => '</h3>'
				)
			); ?>
			<?php the_widget( 'WP_Widget_Search',
				array(),
				array(
					'before_widget' => '<section class="widget widget_search">',
					'after_widget'  => '</section>',
					'before_title'  => '<h3 class="widget-title">',
					'after_title'   => '</h3>'
				)
			); ?>

		<?php endif; // End widgets check. ?>

	</aside><!-- #sidebar-primary -->

</div>