<?php get_header(); ?>

<div id="container">

	<?php tamatebako_skip_to_content(); ?>

	<?php get_template_part( 'site-header' ); ?>

	<div id="main">

		<div class="main-inner">

			<div class="main-wrap">

				<main <?php hybrid_attr( 'content' ); ?>>

					<?php if ( have_posts() ){ /* Posts Found */ ?>

						<?php get_template_part( 'title-bar' ); ?>

						<div class="content-entry-wrap">

							<?php while ( have_posts() ) {  /* Start Loop */ ?>

								<?php the_post(); /* Load Post Data */ ?>

								<?php /* Start Content */ ?>
								<?php tamatebako_get_template( 'content' ); // Loads the content/*.php template. ?>
								<?php /* End Content */ ?>

							<?php } /* End Loop */ ?>

						</div><!-- .content-entry-wrap-->

						<?php if( !is_singular() ) get_template_part( 'pagination/archive' ); ?>

					<?php } else { /* No Posts Found */ ?>

						<?php tamatebako_content_error(); ?>

					<?php } /* End Posts Found Check */ ?>

				</main><!-- #content -->

			</div><!-- .main-wrap -->

		</div><!-- .main-inner -->

	</div><!-- #main -->

</div><!-- #container -->

<?php hybrid_get_sidebar( 'primary' ); ?>

<?php get_footer(); // Loads the footer.php template. ?>