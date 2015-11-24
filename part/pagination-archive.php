<?php
/**
 * Pagination, site Wide
 * Archive: dispay next-prev
 * SIngular: display next-prev, comment, post info.
 * @since 1.0.0
 */
?>
<?php if ( is_home() || is_archive() || is_search() ){ ?>

	<nav class="page-navigation">

		<div class="page-nav-item page-nav-1 page-nav-prev">

			<?php if( get_previous_posts_link() ){ ?>
				<div class="previous-posts-link page-nav-link">
					<?php previous_posts_link( '<span class="screen-reader-text">' . tamatebako_string( 'previous_posts' ) . '</span>' ); ?>
				</div>
			<?php } else { ?>
				<div class="previous-posts-link page-nav-link">
					<span></span>
				</div>
			<?php } ?>

		</div><!-- .page-nav-1 -->

		<div class="page-nav-item page-nav-2 page-nav-next">

			<?php if( get_next_posts_link() ){ ?>
				<div class="next-posts-link page-nav-link">
				<?php next_posts_link( '<span class="screen-reader-text">' . tamatebako_string( 'next_posts' ) . '</span>' ); ?>
				</div>
			<?php } else { ?>
				<div class="next-posts-link page-nav-link">
					<span></span>
				</div>
			<?php } ?>

		</div><!-- .page-nav-2 -->

	</nav><!-- .page-navigation -->

<?php } // end pagination ?>
