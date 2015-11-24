<?php
/**
 * Microdata Modules (unmaintained)
 * This module will filter WP default output using schema.org microdata markup.
**/

/* Link to author archive */
remove_filter( 'the_author_posts_link',       'tamatebako_the_author_posts_link',                    5 );
add_filter( 'the_author_posts_link',          'tamatebako_microdata_the_author_posts_link',          6 );

/* Comments link */
add_filter( 'comments_popup_link_attributes', 'tamatebako_microdata_comments_popup_link_attributes', 6 );

/* Comment author link */
remove_filter( 'get_comment_author_link',     'tamatebako_get_comment_author_link',                  5 );
add_filter( 'get_comment_author_link',        'tamatebako_microdata_get_comment_author_link',        6 );

/* Comment author URL */
remove_filter( 'get_comment_author_url_link', 'tamatebako_microdata_get_comment_author_url_link',    5 );
add_filter( 'get_comment_author_url_link',    'tamatebako_microdata_get_comment_author_url_link',    6 );

/* Comment reply link */
add_filter( 'comment_reply_link',             'tamatebako_microdata_comment_reply_link_filter',      6 );

/* Avatar output */
add_filter( 'get_avatar',                     'tamatebako_microdata_get_avatar',                     6 );

/* Post thumbnail output */
add_filter( 'post_thumbnail_html',            'tamatebako_microdata_post_thumbnail_html',            6 );


/**
 * Adds microdata to the author posts link.
 * @author Justin Tadlock <justintadlock@gmail.com>
 * @since  3.0.0
 * @access public
 * @param  string  $link
 * @return string
 */
function tamatebako_microdata_the_author_posts_link( $link ) {
	$pattern = array(
		"/(<a.*?)(>)/i",
		'/(<a.*?>)(.*?)(<\/a>)/i'
	);
	$replace = array(
		'$1 class="url fn n" itemprop="url"$2',
		'$1<span class="author-name" itemprop="name">$2</span>$3'
	);
	return preg_replace( $pattern, $replace, $link );
}


/**
 * Adds microdata to the comments popup link.
 * @author Justin Tadlock <justintadlock@gmail.com>
 * @since  3.0.0
 * @access public
 * @param  string  $attr
 * @return string
 */
function tamatebako_microdata_comments_popup_link_attributes( $attr ) {
	return 'itemprop="discussionURL"';
}


/**
 * Adds microdata to the comment author link.
 * @author Justin Tadlock <justintadlock@gmail.com>
 * @since  3.0.0
 * @access private
 * @param  string  $link
 * @return string
 */
function tamatebako_microdata_get_comment_author_link( $link ) {

	$patterns = array(
		'/(class=[\'"])(.+?)([\'"])/i',
		"/(<a.*?)(>)/i",
		'/(<a.*?>)(.*?)(<\/a>)/i'
	);
	$replaces = array(
		'$1$2 fn n$3',
		'$1 itemprop="url"$2',
		'$1<span class="comment-author-name" itemprop="name">$2</span>$3'
	);

	return preg_replace( $patterns, $replaces, $link );
}


/**
 * Adds microdata to the comment author URL link.
 * @author Justin Tadlock <justintadlock@gmail.com>
 * @since  3.0.0
 * @access private
 * @param  string  $link
 * @return string
 */
function tamatebako_microdata_get_comment_author_url_link( $link ) {

	$patterns = array(
		'/(class=[\'"])(.+?)([\'"])/i',
		"/(<a.*?)(>)/i"
	);
	$replaces = array(
		'$1$2 fn n$3',
		'$1 itemprop="url"$2'
	);

	return preg_replace( $patterns, $replaces, $link );
}


/**
 * Adds microdata to the comment reply link.
 * @author Justin Tadlock <justintadlock@gmail.com>
 * @since  3.0.0
 * @access private
 * @param  string  $link
 * @return string
 */
function tamatebako_microdata_comment_reply_link_filter( $link ) {
	return preg_replace( '/(<a\s)/i', '$1itemprop="replyToUrl"', $link );
}


/**
 * Adds microdata to avatars.
 * @author Justin Tadlock <justintadlock@gmail.com>
 * @since  3.0.0
 * @access private
 * @param  string  $avatar
 * @return string
 */
function tamatebako_microdata_get_avatar( $avatar ) {
	return preg_replace( '/(<img.*?)(\/>)/i', '$1itemprop="image" $2', $avatar );
}


/**
 * Adds microdata to the post thumbnail HTML.
 * @author Justin Tadlock <justintadlock@gmail.com>
 * @since  3.0.0
 * @access public
 * @param  string  $html
 * @return string
 */
function tamatebako_microdata_post_thumbnail_html( $html ) {
	return function_exists( 'get_the_image' ) ? $html : preg_replace( '/(<img.*?)(\/>)/i', '$1itemprop="image" $2', $html );
}

