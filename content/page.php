<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="wrap">

		<div class="entry-title-wrap">
			<?php tamatebako_entry_title(); ?>
			<div class="entry-type"><?php _x( 'Type:', 'entry post type prefix', 'explorer' ); ?> <?php echo explorer_get_post_type_name( get_the_ID() ); ?></div>
		</div><!-- .entry-title-wrap -->

		<div class="entry-byline">
			<?php tamatebako_entry_date(); ?>
			<?php tamatebako_comments_link(); ?>
		</div><!-- .entry-byline -->

	</div><!-- .entry > .wrap -->

</article><!-- .entry -->