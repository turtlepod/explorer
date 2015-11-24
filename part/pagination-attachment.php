<?php
/**
 * Attachment
 * - Parent Page/Post If Exist
 * - Download Link
 * @since 1.0.0
 */
global $post;
?>
<?php if ( is_singular() ){ ?>

	<div class="page-navigation">

		<div class="page-nav-item page-nav-1 page-nav-parent">

			<?php if ( $post->post_parent ) { ?>
				<div class="parent-page-link page-nav-link">
					<a href="<?php echo get_permalink( $post->post_parent ); ?>" >
						<span class="screen-reader-text"><?php echo get_the_title( $post->post_parent ); ?></span>
					</a>
				</div>
			<?php } else { ?>
				<div class="parent-page-link page-nav-link">
					<span></span>
				</div>
			<?php } ?>

		</div><!-- .page-nav-1 -->

		<div class="page-nav-item page-nav-2 page-nav-download">

			<div class="download-file-link page-nav-link">
				<a href="<?php echo esc_url( wp_get_attachment_url( get_the_ID() ) ); ?>"><span class="screen-reader-text"><?php _ex( 'Back to Home', 'home button pagination (accessibility)', 'explorer' ); ?></span></a>
			</div>

		</div><!-- .page-nav-2 -->

	</div><!-- .page-navigation -->

<?php } // end pagination ?>
