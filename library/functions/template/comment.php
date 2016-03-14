<?php
/**
 * Comments Template Tags.
 * Taken from Hybrid Core v.2 Comment Feature.
 * @author Justin Tadlock <justintadlock@gmail.com>
 * @since 3.0.0
**/

/**
 * Comments Nav
 * @since 0.1.0
 */
function tamatebako_comments_nav(){
?>
<?php if ( get_option( 'page_comments' ) && 1 < get_comment_pages_count() ) { // Check for paged comments. ?>

	<div class="comments-nav">

		<?php previous_comments_link( '<span class="prev-comments"><span class="screen-reader-text">' . tamatebako_string( 'previous_comment' ) . '</span></span>' ); ?>

		<span class="page-numbers"><?php printf( '%1$s / %2$s', get_query_var( 'cpage' ) ? absint( get_query_var( 'cpage' ) ) : 1, get_comment_pages_count() ); ?></span>

		<?php next_comments_link( '<span class="next-comments"><span class="screen-reader-text">' . tamatebako_string( 'next_comment' ) . '</span></span>' ); ?>

	</div><!-- .comments-nav -->

<?php } // End check for paged comments. ?>
<?php
}

/**
 * Comments Error Message.
 * used in "comments.php"
 * @since 0.1.0
 */
function tamatebako_comments_error(){
	echo tamatebako_get_comments_error();
}

/**
 * Get Comments Error.
 * used in "comments.php"
 * @since 3.1.0
 */
function tamatebako_get_comments_error(){
	$out = '';

	if ( pings_open() && !comments_open() ){
		$out .= '<p class="comments-closed pings-open">';
		$out .= tamatebako_string( 'comments_closed_pings_open' );
		$out .= '</p><!-- .comments-closed.pings-open -->';
	}
	elseif( !comments_open() ){
		$out .= '<p class="comments-closed">';
		$out .= tamatebako_string( 'comments_closed' );
		$out .= '</p><!-- .comments-closed -->';
	}
	/* do not add comments error on page post type. */
	if( is_page() ){
		$out =  '';
	}
	return apply_filters( 'tamatebako_get_comments_error', $out );
}

/**
 * Outputs the comment reply link.
 * @author Justin Tadlock <justintadlock@gmail.com>
 * @since 3.0.0
 */
function tamatebako_get_comment_reply_link( $args = array() ) {

	if ( !get_option( 'thread_comments' ) || in_array( get_comment_type(), array( 'pingback', 'trackback' ) ) ){
		return '';
	}

	$args = wp_parse_args(
		$args,
		array(
			'depth'     => intval( $GLOBALS['comment_depth'] ),
			'max_depth' => get_option( 'thread_comments_depth' ),
		)
	);

	return get_comment_reply_link( $args );
}

/**
 * Uses the $comment_type to determine which comment template should be used.
 * @author Justin Tadlock <justintadlock@gmail.com>
 * @since 3.0.0
 */
function tamatebako_comments_callback( $comment, $args, $depth ) {

	/* Get the comment type of the current comment. */
	$comment_type = get_comment_type( $comment->comment_ID );

	/* Create an empty array if the comment template array is not set. */
	if ( !isset( $comment_template ) || !is_array( $comment_template ) ){
		$comment_template = array();
	}

	/* Check if a template has been provided for the specific comment type.  If not, get the template. */
	if ( !isset( $comment_template[$comment_type] ) ) {

		/* Create an array of template files to look for. */
		$templates = array( "comment-{$comment_type}.php", "comment/{$comment_type}.php" );

		/* If the comment type is a 'pingback' or 'trackback', allow the use of 'comment-ping.php'. */
		if ( 'pingback' == $comment_type || 'trackback' == $comment_type ) {
			$templates[] = 'comment-ping.php';
			$templates[] = 'comment/ping.php';
		}

		/* Add the fallback 'comment.php' template. */
		$templates[] = 'comment/comment.php';
		$templates[] = 'comment.php';

		/* Locate the comment template. */
		$template = locate_template( $templates );

		/* Set the template in the comment template array. */
		$comment_template[ $comment_type ] = $template;
	}

	/* If a template was found, load the template. */
	if ( !empty( $comment_template[ $comment_type ] ) ){
		require( $comment_template[ $comment_type ] );
	}
}

/**
 * Ends the display of individual comments. Uses the callback parameter for wp_list_comments().
 * @author Justin Tadlock <justintadlock@gmail.com>
 * @since 3.0.0
 */
function tamatebako_comments_end_callback() {
	echo '</li><!-- .comment -->';
}

/**
 * Comment Moderation Notice
 * Add message in the comment if the comment is submitted but not yet approved.
 * Used to be a filter in 3.1.2 tamatebako_comment_moderation_notice()
 * @since 3.1.9
 */
function tamatebako_comment_moderation_message(){
	?>
	<p class="comment-awaiting-moderation"><?php echo tamatebako_string( 'comment_moderation_message' );?></p>
	<?php
}