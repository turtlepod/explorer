<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="wrap">

		<header class="entry-header">

			<div class="entry-title-wrap">
				<?php tamatebako_entry_title(); ?>
				<span class="entry-author vcard"><?php the_author_posts_link(); ?></span>
			</div><!-- .entry-title-wrap -->

			<div class="entry-byline">
				<?php tamatebako_entry_date(); ?>
				<?php tamatebako_comments_link(); ?>
			</div><!-- .entry-byline -->

		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
		<?php edit_post_link(); ?>
			<?php tamatebako_entry_taxonomies(); ?>
		</footer><!-- .entry-footer -->

	</div><!-- .entry > .wrap -->

	<?php get_template_part( 'part/pagination-post' ); ?>

</article><!-- .entry -->

<?php comments_template( '', true ); // Load comments. ?>