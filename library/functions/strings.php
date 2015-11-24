<?php
/**
 * Load Strings To Global Object.
 * Need to be added in setup function.
 * @since 3.0.0
 */
function tamatebako_load_strings( $texts ){
	global $tamatebako;
	foreach( $texts as $text_key => $text ){
		$tamatebako->strings[$text_key] = $text;
	}
}

/**
 * Texts string / translatable string used in tamatebako.
 * To make this string translatable, theme need to filter it using "tamatebako_strings",
 * and wrap it using translation functions.
 * @since  3.0.0
 * @param  string  $context   Text identifier.
 * @access private
 * @return string
 */
function tamatebako_string( $context ){

	/* tamatebako object */
	global $tamatebako;

	/* If text found, return it. */
	if ( isset( $tamatebako->strings[$context] ) ){
		return $tamatebako->strings[$context];
	}
	/* Not found, use default. */
	else{
		$texts = tamatebako_strings();
		if ( isset( $texts[$context] ) ){
			return $texts[$context];
		}
		return $context;
	}
}

/**
 * Lists of translatable texts string used in the framework
 * @since 3.0.0
 */
function tamatebako_strings(){

	/* Open sesame! */
	$texts = array(

		/* functions/template/accessibility.php */
		'skip_to_content' => 'Skip to content',

		/* functions/template/general.php */
		'next_posts' => 'Next',
		'previous_posts' => 'Previous',

		/* functions/template/menu.php */
		'menu_search_placeholder' => 'Search&hellip;',
		'menu_search_button' => 'Search',
		'menu_search_form_toggle' => 'Expand Search Form',
		'menu_default_home' => 'Home',

		/* functions/template/entry.php */
		'error_title' => '404 Not Found',
		'error_message' => 'Apologies, but no entries were found.',
		'next_post' => 'Next',
		'previous_post' => 'Previous',

		/* functions/template/comment.php */
		'next_comment' => 'Next',
		'previous_comment' => 'Previous',
		'comments_closed_pings_open' => 'Comments are closed, but trackbacks and pingbacks are open.',
		'comments_closed' => 'Comments are closed.',

		/* functions/setup.php */
		'untitled' => '(Untitled)',
		'read_more' => 'Read More',
		'search_title_prefix' => 'Search:',
		'comment_moderation_message' => 'Your comment is awaiting moderation.',

	);

	/* Close sesame. */
	return $texts;
}