<?php
/**
 * Post Formats
**/

$post_formats_args = array(
	'aside',
	'image',
	'gallery',
	'link',
	'quote',
	'status',
	'video',
	'audio',
	'chat',
);
add_theme_support( 'post-formats', $post_formats_args );
