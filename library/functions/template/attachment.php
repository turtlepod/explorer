<?php
/**
 * Attachment Template Tags
 * @since 3.0.0
**/

/**
 * Display attachment.
 * @author Justin Tadlock <justintadlock@gmail.com>
 * @since  0.1.0
 */
function tamatebako_attachment(){
	$file       = wp_get_attachment_url();
	$mime       = get_post_mime_type();
	$attachment = '';

	$mime_type = '';
	if( false !== strpos( $mime, '/' ) ){
		$mime_type = explode( '/', $mime );
	}
	else{
		$mime_type = array( $mime, '' );
	}

	/* Loop through each mime type. If a function exists for it, call it. Allow users to filter the display. */
	foreach ( $mime_type as $type ) {
		if ( function_exists( "tamatebako_attachment_{$type}" ) ){
			$attachment = call_user_func( "tamatebako_attachment_{$type}", $mime, $file );
		}
	}

	echo $attachment;
}

/**
 * Display Attachment Image with caption if available.
 * @since 0.1.0
 */
function tamatebako_attachment_image( $mime = '', $file = '' ){

	/* If image has excerpt / caption. */
	if ( has_excerpt() ) {

		/* Image URL */
		$src = wp_get_attachment_image_src( get_the_ID(), 'full' );
		/* Display image with caption */
		return img_caption_shortcode( array( 'align' => 'aligncenter', 'width' => esc_attr( $src[1] ), 'caption' => get_the_excerpt() ), wp_get_attachment_image( get_the_ID(), 'full', false ) );

	}
	/* No caption. */
	else {

		/* Display image without caption. */
		return wp_get_attachment_image( get_the_ID(), 'full', false, array( 'class' => 'aligncenter' ) );
	}
}

/**
 * Handles application attachments.
 * @author Justin Tadlock <justintadlock@gmail.com>
 * @since 3.0.0
 */
function tamatebako_attachment_application( $mime = '', $file = '' ) {
	$embed_defaults = wp_embed_defaults();
	$application  = '<object class="text" type="' . esc_attr( $mime ) . '" data="' . esc_url( $file ) . '" width="' . esc_attr( $embed_defaults['width'] ) . '" height="' . esc_attr( $embed_defaults['height'] ) . '">';
	$application .= '<param name="src" value="' . esc_url( $file ) . '" />';
	$application .= '</object>';

	return $application;
}

/**
 * Handles text attachments on their attachment pages.
 * @author Justin Tadlock <justintadlock@gmail.com>
 * @since 3.0.0
 */
function tamatebako_attachment_text( $mime = '', $file = '' ) {
	$embed_defaults = wp_embed_defaults();
	$text  = '<object class="text" type="' . esc_attr( $mime ) . '" data="' . esc_url( $file ) . '" width="' . esc_attr( $embed_defaults['width'] ) . '" height="' . esc_attr( $embed_defaults['height'] ) . '">';
	$text .= '<param name="src" value="' . esc_url( $file ) . '" />';
	$text .= '</object>';

	return $text;
}

/**
 * Handles the output of the media for audio attachment posts.
 * @since 3.0.0
 */
function tamatebako_attachment_audio( $mime = '', $file = '' ) {
	return do_shortcode( '[audio src="' . esc_url( esc_url( $file ) ) . '"]' );
}

/**
 * Handles the output of the media for video attachment posts. This should be used within The Loop.
 * @since  3.0.0
 */
function tamatebako_attachment_video( $mime = '', $file = '' ) {
	return do_shortcode( '[video src="' . esc_url( esc_url( $file ) ) . '"]' );
}