<?php
/**
 * Entry (content) Tamplate Tags.
 * @since 3.0.0
**/

/**
 * Entry Title.
 * this template tags is only for the main loop.
 * Use <h1> for singular page without link, and <h2> for archive with permalink to post.
 */
function tamatebako_entry_title(){
	if( is_singular() ){
		the_title( '<h1 class="entry-title">', '</h1>' );
	}
	else{
		the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
	}
}


/**
 * Entry Date: display post date.
 * this template tags is only for the main loop.
 * @param $data_format string the date format of the date, default using date format set on general settings.
 * @param $force_permalink bool to force use/not use permalink. default is conditional.
 */
function tamatebako_entry_date( $date_format = '', $force_permalink = '' ){

	/* Default time markup */
	$time_string = '<time class="published updated" datetime="%1$s">%2$s</time>';

	/* If the post has been modified, display "updated" time. */
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	/* Format it. */
	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		get_the_date( $date_format ),
		esc_attr( get_the_modified_date( 'c' ) ),
		get_the_modified_date( $date_format )
	);

	$permalink = is_singular() ? false : true;
	if( false === $force_permalink || true === $force_permalink ){
		$permalink = $force_permalink;
	}

	if( $permalink ){
		echo '<span class="entry-date entry-date-permalink"><a href=" ' . esc_url( get_permalink() ) . '" rel="bookmark">'  . $time_string . '</a></span>';
	}
	else{
		echo '<span class="entry-date">' . $time_string . '</span>';
	}
}


/**
 * Comments Link
 * Link to #comments or #respond with number of comments info.
 * this is just wrapper function for comments_popup_link().
 * TODO: make it more accessible.
 * @param $args array formatted comments popup link arguments.
 */
function tamatebako_comments_link( $args = array() ){

	/* Vars */
	$title = get_the_title();
	$number = get_comments_number( get_the_ID() );

	/* Args */
	$defaults = array(
		'zero'      => number_format_i18n( 0 ), /* string to display for no comments */
		'one'       => number_format_i18n( 1 ), /* string to display for 1 comments */
		'more'      => '%', /* string to display for more than one comments */
		'none'      => '', /* string to display if no comments available. */
		'css_class' => 'comments-link', /* css classes */
	);
	$args = wp_parse_args( $args, $defaults );

	/* If no comment added, and comments is closed do not display link to comment. */
	if ( 0 == $number && !comments_open() && !pings_open() ) {
		return;
	}

	/* In Password Protected Post, add span wrapper. */
	 if ( post_password_required() ) {
		echo '<span class="comments-link"><span class="screen-reader-text">';
		comments_popup_link( number_format_i18n( 0 ), number_format_i18n( 1 ), '%', 'comments-link', '' );
		echo '</span></span>';
		return;
	}

	/* Display comments link as default. */
	comments_popup_link( $args['zero'], $args['one'], $args['more'], $args['css_class'], $args['none'] );
}


/**
 * Content Error: a basic error 404 page.
 * used in "index.php"
 * @since 0.1.0
 */
function tamatebako_content_error(){
?>
	<article id="post-0" class="entry">
		<div class="wrap">

			<header class="entry-header">
				<h1 class="entry-title"><?php echo tamatebako_string( 'error_title' ); ?></h1>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<?php echo wpautop( tamatebako_string( 'error_message' ) ); ?>
			</div><!-- .entry-content -->

		</div><!-- .entry > .wrap -->
	</article><!-- .entry -->
<?php
}

/**
 * Entry Taxonomies
 * a helper function to print all taxonomy/term attach to a post.
 * @see tamatebako_entry_taxonomy()
 * @param $args array this arguments is passed to `tamatebako_entry_taxonomy()` except for `$args['taxonomy']`.
 * @param $taxonomies array list of taxonomies to display.
 * @since 3.0.0
 */
function tamatebako_entry_taxonomies( $taxonomies = array(), $args = array() ){

	/* Entry Taxonomies */
	$entry_taxonomies = $taxonomies;

	/* if no taxonomies defined, list all taxonomies. */
	if( empty( $taxonomies ) ){
		/* Get Taxonomies Object */
		$entry_taxonomies_obj = get_object_taxonomies( get_post_type(), 'object' );
		foreach ( $entry_taxonomies_obj as $entry_tax_id => $entry_tax_obj ){

			/* Only for public taxonomy */
			if ( 1 == $entry_tax_obj->public ){
				$entry_taxonomies[] = $entry_tax_id;
			}
		}
	}

	/* If taxonomies not empty, display it. */
	if ( !empty( $entry_taxonomies ) ){ ?>
		<div class="entry-taxonomies">
			<?php foreach ( $entry_taxonomies as $entry_taxonomy ){
				$args['taxonomy'] = $entry_taxonomy;
				tamatebako_entry_taxonomy( $args );
			} //end foreach ?>
		</div><!-- .entry-taxonomies -->

	<?php } //end empty check
}

/**
 * This template tag is meant to replace template tags like `the_category()`, `the_terms()`, etc.
 $ @param $args array list of arguments for separator, taxonomy, and text format.
 * @since 3.0.0
 */
function tamatebako_entry_taxonomy( $args = array() ) {

	/* Args */
	$defaults = array(
		'post_id'    => get_the_ID(),
		'taxonomy'   => 'category',
		'text'       => '%s', /* %s will be replaced with taxonomy name (label) */
		'sep'        => ', ',
	);
	$args = wp_parse_args( $args, $defaults );

	/* Get Terms List */
	$terms = get_the_term_list( $args['post_id'], $args['taxonomy'], '', $args['sep'], '' );

	/* Display output only if terms available. */
	if ( !empty( $terms ) ) {
		$tax_object = get_taxonomy( $args['taxonomy'] );
		$tax_name = $tax_object->labels->name;
		$text = sprintf( $args['text'], $tax_name );
	?>
		<span class="entry-taxonomy <?php echo sanitize_html_class( $args['taxonomy'] ); ?>">
			<?php if( !empty( $text ) ){ ?>
			<span class="entry-taxonomy-text"><?php echo $text;?></span> 
			<?php } ?>
			<?php echo $terms; ?>
		</span>
	<?php
	}
}

/**
 * Next Previous Post (Loop Nav)
 * @since 0.1.0
 */
function tamatebako_entry_nav(){
?>
<nav class="post-navigation">
	<?php previous_post_link( '<div class="nav-prev"><span class="screen-reader-text">' . tamatebako_string( 'previous_post' ) . ':</span> %link</div>', '%title' ); ?>
	<?php next_post_link( '<div class="nav-next"><span class="screen-reader-text">' . tamatebako_string( 'next_post' ) . ':</span> %link</div>', '%title' ); ?>
</nav><!-- .post-navigation -->
<?php
}

/**
 * Tamatebako Read More
 * Can be added after "the_excerpt()".
 * this element is wrapped using span for flexibility, so can be added inside paragraph elements.
 * @since 0.1.0
 */
function tamatebako_read_more() {
	$string = tamatebako_string( 'read_more' );
	$read_more = '';
	if ( !empty( $string ) ){
		$read_more = '<span class="more-link-wrap"><a class="more-link" href="' . esc_url( get_permalink() ) . '"><span class="more-text">' . $string . '</span> <span class="screen-reader-text">' . get_the_title() . '</span></a></span>';
	}
	echo $read_more;
}