<?php
/**
 * Make Framework Translatable
**/

/* Load Text Domain */
load_theme_textdomain( 'explorer', get_template_directory() . '/assets/languages' );

/* Make all string in the framework translatable. */
$texts = array(

	/* functions/template/accessibility.php */
	'skip_to_content'             => _x( 'Skip to content', 'accessibility', 'explorer' ),

	/* functions/template/general.php */
	'next_posts'                  => _x( 'Next', 'pagination', 'explorer' ),
	'previous_posts'              => _x( 'Previous', 'pagination', 'explorer' ),

	/* functions/template/menu.php */
	'menu_search_placeholder'     => _x( 'Search&hellip;', 'nav menu', 'explorer' ),
	'menu_search_button'          => _x( 'Search', 'nav menu', 'explorer' ),
	'menu_search_form_toggle'     => _x( 'Expand Search Form', 'nav menu', 'explorer' ),
	'menu_default_home'           => _x( 'Home', 'nav menu', 'explorer' ),

	/* functions/template/entry.php */
	'error_title'                 => _x( '404 Not Found', 'entry', 'explorer' ),
	'error_message'               => _x( 'Apologies, but no entries were found.', 'entry', 'explorer' ),
	'next_post'                   => _x( 'Next', 'entry', 'explorer' ),
	'previous_post'               => _x( 'Previous', 'entry', 'explorer' ),

	/* functions/template/comment.php */
	'next_comment'                => _x( 'Next', 'comment', 'explorer' ),
	'previous_comment'            => _x( 'Previous', 'comment', 'explorer' ),
	'comments_closed_pings_open'  => _x( 'Comments are closed, but trackbacks and pingbacks are open.', 'comment', 'explorer' ),
	'comments_closed'             => _x( 'Comments are closed.', 'comment', 'explorer' ),

	/* functions/setup.php */
	'untitled'                    => _x( '(Untitled)', 'entry', 'explorer' ),
	'read_more'                   => _x( 'Read More', 'entry', 'explorer' ),
	'search_title_prefix'         => _x( 'Search:', 'archive title', 'explorer' ),
	'comment_moderation_message'  => _x( 'Your comment is awaiting moderation.', 'comment', 'explorer' ),

);

/* Add text to tamatebako */
tamatebako_load_strings( $texts );