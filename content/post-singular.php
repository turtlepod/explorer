<?php
/**
 * Content Template for "Post" Post Type in Singular Pages
 * @since 1.0.0
 */
?>
<article <?php hybrid_attr( 'post' ); ?>>

	<div class="entry-wrap">

		<header class="entry-header">

			<div class="entry-title-wrap">

				<?php the_title( '<h1 ' . hybrid_get_attr( 'entry-title' ) . '><a href="' . get_permalink() . '" rel="bookmark" itemprop="url">', '</a></h1>' ); ?>

				<span <?php hybrid_attr( 'entry-author' ); ?>><?php the_author_posts_link(); ?></span>

			</div><!-- .entry-title-wrap -->

			<div class="entry-byline">

				<time <?php hybrid_attr( 'entry-published' ); ?>><?php echo get_the_date(); ?></time>
				<?php comments_popup_link( number_format_i18n( 0 ), number_format_i18n( 1 ), '%', 'comments-link', '' ); ?>

			</div><!-- .entry-byline -->

		</header><!-- .entry-header -->

		<div <?php hybrid_attr( 'entry-content' ); ?>>
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php tamatebako_entry_terms(); ?>
		</footer><!-- .entry-footer -->

	</div><!-- .entry-wrap -->

	<?php get_template_part( 'pagination/post' ); ?>

</article><!-- .entry -->

<?php comments_template( '', true ); // Load comments. ?>