<?php
/**
 * Post Formats Filters
 * @author Justin Tadlock <justintadlock@gmail.com>
**/

/* Add support for structured post formats. */
add_action( 'wp_loaded', 'tamatebako_structured_post_formats', 1 );

/**
 * Theme compatibility for post formats.
 */
function tamatebako_structured_post_formats() {

	/* Add infinity symbol to aside posts. */
	if ( current_theme_supports( 'post-formats', 'aside' ) ){
		add_filter( 'the_content', 'tamatebako_post_format_aside_infinity', 9 ); // run before wpautop
	}

	/* Adds the link to the content if it's not in the post. */
	if ( current_theme_supports( 'post-formats', 'link' ) ){
		add_filter( 'the_content', 'tamatebako_post_format_link_content', 9 ); // run before wpautop
	}

	/* Wraps <blockquote> around quote posts. */
	if ( current_theme_supports( 'post-formats', 'quote' ) ){
		add_filter( 'the_content', 'tamatebako_post_format_quote_content' );
	}

	/* Filter the content of chat posts. */
	if ( current_theme_supports( 'post-formats', 'chat' ) ) {
		add_filter( 'the_content', 'tamatebako_post_format_chat_content' );
	}
}

/* === Asides === */

/**
 * Adds an infinity character "&#8734;" to the end of the post content on 'aside' posts.
 */
function tamatebako_post_format_aside_infinity( $content ) {

	if ( has_post_format( 'aside' ) && !is_singular() && !post_password_required() ) {
		$infinity = '<a class="permalink" href="' . esc_url( get_permalink() ) . '">&#8734;</a>';
		if ( have_comments() || comments_open() ){
			$infinity = '<a class="comments-link" href="' . esc_url( get_permalink() ) . '">' . number_format_i18n( get_comments_number() ) . '</a>';
		}
		$content .= apply_filters( 'tamatebako_post_format_aside_infinity', ' ' . $infinity );
	}

	return $content;
}

/* === Links === */

/**
 * Filters the content of the link format posts.  Wraps the content in the make_clickable() function 
 * so that users can enter just a URL into the post content editor.
 */
function tamatebako_post_format_link_content( $content ) {

	if ( has_post_format( 'link' ) && !preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', $content ) )
		$content = make_clickable( $content );

	return $content;
}

/* === Quotes === */

/**
 * Checks if the quote post has a <blockquote> tag within the content.  If not, wraps the entire post 
 * content with one.
 */
function tamatebako_post_format_quote_content( $content ) {

	if ( has_post_format( 'quote' ) && !post_password_required() ) {
		preg_match( '/<blockquote.*?>/', $content, $matches );

		if ( empty( $matches ) )
			$content = "<blockquote>{$content}</blockquote>";
	}

	return $content;
}

/* === Chats === */

/**
 * Separates the post content into an array of arrays for further formatting of the chat content.
 */
function tamatebako_get_the_post_format_chat( $content ) {

	/* Allow the separator (separator for speaker/text) to be filtered. */
	$separator = ':';

	/* Split the content to get individual chat rows. */
	$chat_rows = preg_split( "/(\r?\n)+|(<br\s*\/?>\s*)+/", trim( $content ) );

	/* Loop through each row and format the output. */
	foreach ( $chat_rows as $chat_row ) {

		/* Set up a new, empty array of this stanza. */
		$stanza = array();

		/* If a speaker is found, create a new chat row with speaker and text. */
		if ( preg_match( '/(?<!http|https)' . $separator . '/', $chat_row ) ) {

			/* Set up a new, empty array for this row. */
			$row = array();

			/* Split the chat row into author/text. */
			$chat_row_split = explode( $separator, trim( $chat_row ), 2 );

			/* Get the chat author and strip tags. */
			$row['author'] = strip_tags( trim( $chat_row_split[0] ) );

			/* Get the chat text. */
			$row['message'] = trim( $chat_row_split[1] );

			/* Add the row to the stanza. */
			$stanza[] = $row;
		}

		/* If no speaker is found. */
		else {

			/* Make sure we have text. */
			if ( !empty( $chat_row ) ) {
				$stanza[] = array( 'message' => trim( $chat_row ) );
			}
		}

		$stanzas[] = $stanza;
	}

	return $stanzas;
}

/**
 * This function filters the post content when viewing a post with the "chat" post format.
 */
function tamatebako_post_format_chat_content( $content ) {

	/* If this isn't a chat, return. */
	if ( !has_post_format( 'chat' ) || post_password_required() ){
		return $content;
	}

	/* Open the chat transcript div and give it a unique ID based on the post ID. */
	$chat_output = "\n\t\t\t" . '<div class="chat-transcript">';

	/* Allow the separator (separator for speaker/text) to be filtered. */
	$separator = ':';

	/* Get the stanzas from the post content. */
	$stanzas = tamatebako_get_the_post_format_chat( $content );

	/* Loop through the stanzas that were returned. */
	foreach ( $stanzas as $stanza ) {

		/* Loop through each row of the stanza and format. */
		foreach ( $stanza as $row ) {

			/* Get the chat author and message. */
			$chat_author = !empty( $row['author'] ) ? $row['author'] : '';
			$chat_text   = $row['message'];

			/* Get the speaker/row ID. */
			global $_tamatebako_chat_id;
			$speaker_id = tamatebako_chat_row_id( $chat_author );

			/* Open the chat row. */
			$chat_output .= "\n\t\t\t\t" . '<div class="chat-row ' . sanitize_html_class( "chat-speaker-{$speaker_id}" ) . '">';

			/* Add the chat row author. */
			if ( !empty( $chat_author ) ){
				if( isset( $_tamatebako_chat_id ) && $_tamatebako_chat_id == $speaker_id ){
					$chat_output .= "\n\t\t\t\t\t" . '<div class="chat-author chat-author-repeat ' . sanitize_html_class( strtolower( "chat-author-{$chat_author}" ) ) . ' vcard"><cite class="fn">' . $chat_author . '</cite><span class="chat-sep">:</span></div>';
				}
				else{
					$chat_output .= "\n\t\t\t\t\t" . '<div class="chat-author ' . sanitize_html_class( strtolower( "chat-author-{$chat_author}" ) ) . ' vcard"><cite class="fn">' . $chat_author . '</cite><span class="chat-sep">:</span></div>';
				}
			}

			/* Add the chat row text. */
			$chat_output .= "\n\t\t\t\t\t" . '<div class="chat-text">' . str_replace( array( "\r", "\n", "\t" ), '', wpautop( $chat_text )  ) . '</div>';

			/* Close the chat row. */
			$chat_output .= "\n\t\t\t\t" . '</div><!-- .chat-row -->';

			$_tamatebako_chat_id = $speaker_id;
		}
	}

	/* Close the chat transcript div. */
	$chat_output .= "\n\t\t\t</div><!-- .chat-transcript -->\n";

	/* Reset Chat ID for new post */
	global $_tamatebako_chat_ids, $_tamatebako_chat_id;
	$_tamatebako_chat_ids = array();
	$_tamatebako_chat_id = '';

	/* Return the chat content. */
	return $chat_output;
}


/**
 * This function returns an ID based on the provided chat author name. 
 */
function tamatebako_chat_row_id( $chat_author ) {
	global $_tamatebako_chat_ids;

	if ( !empty( $chat_author ) ){

		/* Let's sanitize the chat author to avoid craziness and differences like "John" and "john". */
		$chat_author = strtolower( strip_tags( $chat_author ) );

		/* Add the chat author to the array. */
		$_tamatebako_chat_ids[] = $chat_author;

		/* Make sure the array only holds unique values. */
		$_tamatebako_chat_ids = array_unique( $_tamatebako_chat_ids );

		/* Return the array key for the chat author and add "1" to avoid an ID of "0". */
		return absint( array_search( $chat_author, $_tamatebako_chat_ids ) ) + 1;

	}
	else{
		return '0';
	}
}