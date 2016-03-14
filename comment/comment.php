<li id="comment-<?php comment_ID(); ?>" <?php comment_class()?>>

	<article class="comment-wrap">

		<header class="comment-meta">

			<?php echo get_avatar( $comment ); ?>

			<cite class="comment-author vcard"><?php comment_author_link(); ?></cite><br />

			<a class="comment-permalink" href="<?php echo esc_url( get_comment_link() ); ?>"><time class="comment-published" datetime="<?php echo get_comment_time( 'Y-m-d\TH:i:sP' );?>"><?php printf( '%1$s (%2$s)', get_comment_date(), get_comment_time() ) ?></time></a>

			<?php edit_comment_link(); ?>

		</header><!-- .comment-meta -->

		<div class="comment-content">
			<?php if( '0' == $comment->comment_approved ){ ?>
				<?php tamatebako_comment_moderation_message(); ?>
			<?php } ?>
			<?php comment_text(); ?>
		</div><!-- .comment-content -->

		<?php echo tamatebako_get_comment_reply_link(); ?>

	</article><!-- .comment-wrap -->

<?php /* No closing </li> is needed.  WordPress will know where to add it. */ ?>