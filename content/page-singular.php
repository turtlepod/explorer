<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="wrap">

		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php edit_post_link(); ?>
			<?php tamatebako_entry_taxonomies(); ?>
		</footer><!-- .entry-footer -->

	</div><!-- .entry > .wrap -->

	<?php get_template_part( 'part/pagination-page' ); ?>

</article><!-- .entry -->

<?php comments_template( '', true ); // Load comments. ?>