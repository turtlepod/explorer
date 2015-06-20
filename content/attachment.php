<article <?php hybrid_attr( 'post' ); ?>>

	<div class="entry-wrap">

		<div class="entry-content">
			<?php tamatebako_attachment(); ?>
			<?php the_content(); ?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php edit_post_link(); ?>
			<?php tamatebako_entry_terms(); ?>
		</footer><!-- .entry-footer -->

	</div><!-- .entry-wrap -->

	<?php if ( is_attachment() ) get_template_part( 'pagination/attachment' ); ?>

</article><!-- .entry -->

<?php if ( is_attachment() ) comments_template( '', true ); // Load comments. ?>