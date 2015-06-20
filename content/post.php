<article <?php hybrid_attr( 'post' ); ?>>

	<div class="entry-wrap">

		<div class="entry-title-wrap">

			<?php the_title( '<h2 ' . hybrid_get_attr( 'entry-title' ) . '><a href="' . get_permalink() . '" rel="bookmark" itemprop="url">', '</a></h2>' ); ?>

			<div class="entry-type"><?php _e( 'Type:', 'explorer' ); ?> <?php echo get_post_type_labels( get_post_type_object( get_post_type( get_the_ID() ) ) )->singular_name;?></div>

		</div><!-- .entry-title-wrap -->

		<div class="entry-byline">

			<time <?php hybrid_attr( 'entry-published' ); ?>><?php echo get_the_date(); ?></time>
			<?php comments_popup_link( number_format_i18n( 0 ), number_format_i18n( 1 ), '%', 'comments-link', '' ); ?>

		</div><!-- .entry-byline -->

	</div><!-- .entry-wrap -->

</article><!-- .entry -->
