<!DOCTYPE html>
<html <?php language_attributes( 'html' ); ?> class="no-js">

<head>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<div id="container">

		<?php tamatebako_skip_to_content(); ?>

		<?php get_header(); ?>

		<div class="wrap">

			<div id="main">

				<div class="wrap">

					<main id="content" class="content" role="main">

						<?php if ( have_posts() ){ /* Posts Found */ ?>

							<?php get_template_part( 'part/title-bar' ); ?>

							<div class="wrap">

								<?php while ( have_posts() ) {  /* Start Loop */ ?>

									<?php the_post(); /* Load Post Data */ ?>

									<?php /* Start Content */ ?>
									<?php tamatebako_get_template( 'content' ); ?>
									<?php /* End Content */ ?>

								<?php } /* End Loop */ ?>

							</div><!-- #content > .wrap -->

							<?php if( !is_singular() ) get_template_part( 'part/pagination-archive' ); ?>

						<?php } else { /* No Posts Found */ ?>

							<div class="wrap">
								<?php tamatebako_content_error(); ?>
							</div><!-- #content > .wrap -->

						<?php } /* End Posts Found Check */ ?>

					</main><!-- #content -->

				</div><!-- #main > .wrap -->

			</div><!-- #main -->

		</div><!-- #container > .wrap -->


	</div><!-- #container -->

	<?php tamatebako_get_sidebar( 'primary' ); ?>

	<?php get_footer(); ?>

</body>
</html>