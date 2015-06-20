<?php
/**
 * Content Template for "Page" Post Type in Singular Pages
 * @since 1.0.0
 */
?>
<article <?php hybrid_attr( 'post' ); ?>>

	<div class="entry-wrap">

		<div <?php hybrid_attr( 'entry-content' ); ?>>
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php edit_post_link(); ?>
			<?php tamatebako_entry_terms(); ?>
		</footer><!-- .entry-footer -->

	</div><!-- .entry-wrap -->

	<?php get_template_part( 'pagination/page' ); ?>

</article><!-- .entry -->

<?php comments_template( '', true ); // Load comments. ?>