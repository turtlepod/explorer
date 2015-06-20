<?php
/**
 * Text String / Translatable string used in tamatebako
 * @since 0.1.0
 */
function tamatebako_string( $context ){

	/* Open Sesame ! */
	$text = array();

	/* Paged Title Tag
	 * Translators: 1 is the page title and separator. 2 is the page number.
	 * Example Output: "{post title} | Page {page number}"
	 */
	$text['paged'] = _x( '%1$s Page %2$s', 'paged title tag', 'explorer' );

	/* Skip to content (accessibility) */
	$text['skip-to-content'] = _x( 'Skip to content', 'skip to content (accessibility)', 'explorer' );

	/* Read More */
	$text['read-more'] = '';

	/* Entry Permalink */
	$text['permalink'] = '';

	/* Next, Previous */
	$text['next'] = _x( 'Next', 'next in pagination and navigation (accessibility)', 'explorer' );
	$text['previous'] = _x( 'Previous', 'previous in pagination and navigation (accessibility)', 'explorer' );

	/* Search */
	$text['search'] = '';
	$text['search-button'] = '';
	$text['expand-search-form'] = '';

	/* Comments error */
	$text['comments-closed-pings-open'] = _x( 'Comments are closed, but trackbacks and pingbacks are open.', 'comments notice', 'explorer' );
	$text['comments-closed'] = _x( 'Comments are closed.', 'comments notice', 'explorer' );

	/* Content error */
	$text['error'] = _x( '404 Not Found', '404 title', 'explorer' );
	$text['error-msg'] = _x( 'Apologies, but no entries were found.', '404 content', 'explorer' );

	/* Theme Layout */
	$text['global-layout'] = '';
	$text['layout'] = '';

	$text = apply_filters( 'tamatebako_string', $text );

	/* Close Sesame ! */
	if ( isset( $text[$context] ) ){
		return $text[$context];
	}
	return '';
}

/**
 * Explorer Theme String
 * @since 1.0.0
**/
function explorer_string( $context ){

	/* Open Sesame ! */
	$text = array();
	$text['entry_type'] = _x( 'Type:', 'entry post type before', 'explorer' );
	$text['sidebar_primary_name'] = _x( 'Sidebar', 'sidebar name', 'explorer' );
	$text['home_nav_name'] = _x( 'Home Navigation', 'nav menu name', 'explorer' );
	$text['full_size_background'] = _x( 'Full Size Background', 'customizer option', 'explorer' );
	$text['back_to_home'] = _x( 'bottom page link (accessibility)', 'customizer option', 'explorer' );
	$text['about'] = _x( 'About', 'default widget text title', 'explorer' );
	$text['navigation'] = _x( 'Navigation', 'default widget page list title', 'explorer' );
	$text['sidebar_toggle'] = _x( 'Sidebar Toggle', 'sidebar toggle (accessibility)', 'explorer' );
	$text['blog'] = _x( 'Blog', 'front page as blog title bar text', 'explorer' );

	/* Close Sesame ! */
	if ( isset( $text[$context] ) ){
		return $text[$context];
	}
	return '';
}
