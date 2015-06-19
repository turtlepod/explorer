<?php
/**
 * Pagination, site Wide
 * Archive: dispay next-prev
 * SIngular: display next-prev, comment, post info.
 * @since 1.0.0
 */
?>
<?php if ( is_singular() ){ ?>

	<div class="page-navigation">

		<div class="page-nav-item page-nav-1 page-nav-prev">

			<?php if( get_previous_post_link() ){ ?>
				<div class="previous-posts-link page-nav-link">
					<?php previous_post_link( '%link', '<span class="screen-reader-text">%title</span>' ); ?>
				</div>
			<?php } else { ?>
				<div class="previous-posts-link page-nav-link">
					<span></span>
				</div>
			<?php } ?>

		</div><!-- .page-nav-1 -->

		<div class="page-nav-item page-nav-2 page-nav-next">

			<?php if( get_next_post_link() ){ ?>
				<div class="next-posts-link page-nav-link">
					<?php next_post_link( '%link', '<span class="screen-reader-text">%title</span>' ); ?>
				</div>
			<?php } else { ?>
				<div class="next-posts-link page-nav-link">
					<span></span>
				</div>
			<?php } ?>

		</div><!-- .page-nav-2 -->

		<div class="page-nav-item page-nav-3 page-nav-comment">
			
		</div><!-- .page-nav-3 -->

		<div class="page-nav-item page-nav-4 page-nav-info">
			
		</div><!-- .page-nav-4 -->

	</div><!-- .page-navigation -->

<?php } // end pagination ?>
