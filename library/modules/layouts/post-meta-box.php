<?php
/**
 * Layouts Post Meta Box
 */

/* Load the post meta boxes on the new post and edit post screens. */
add_action( 'load-post.php', 'tamatebako_layouts_load_meta_boxes' );
add_action( 'load-post-new.php', 'tamatebako_layouts_load_meta_boxes' );

/**
 * Add Meta Boxes and Save Functions
 */
function tamatebako_layouts_load_meta_boxes() {

	/* Add the layout meta box on the 'add_meta_boxes' hook. */
	add_action( 'add_meta_boxes', 'tamatebako_layouts_add_meta_boxes', 10, 2 );

	/* Saves the post format on the post editing page. */
	add_action( 'save_post', 'tamatebako_layouts_save_post', 10, 2 );

	/* Add script/style */
	$layouts_args = tamatebako_layouts_args();
	if( true == $layouts_args['thumbnail'] ){
		add_action( 'admin_head', 'tamatebako_post_layouts_thumb_style' );
		add_action( 'admin_footer', 'tamatebako_post_layouts_thumb_script' );
	}
}

/**
 * Add Meta Boxes
 */
function tamatebako_layouts_add_meta_boxes( $post_type, $post ) {

	/* Add the meta box if the post type supports 'theme-layouts'. */
	if ( ( in_array( $post_type, tamatebako_layouts_post_types() ) ) && ( current_user_can( 'edit_post_meta', $post->ID ) || current_user_can( 'add_post_meta', $post->ID ) || current_user_can( 'delete_post_meta', $post->ID ) ) ){

		add_meta_box( 'theme-layouts-post-meta-box', tamatebako_layouts_string( 'layout' ), 'tamatebako_layouts_post_meta_box', $post_type, 'side', 'default' );
	}
}

/**
 * Layout Meta Box Callback Function
 */
function tamatebako_layouts_post_meta_box( $post, $box ) {

	/* Vars */
	$layouts_args = tamatebako_layouts_args();
	$layouts = tamatebako_layouts();

	/* Add Default/Global */
	$layout_default = array();
	if( true === $layouts_args['customize'] ){
		$layout_default['default'] = array( 'name' => tamatebako_layouts_string( 'global_layout' ) );
	}
	else{
		$layout_default['default'] = array( 'name' => tamatebako_layouts_string( 'default' ) );
	}
	if( tamatebako_current_layout() ){
		$layout_default['default']['name'] = $layout_default['default']['name'] . ' (' . tamatebako_layout_name( tamatebako_current_layout() ) . ')';
	}
	$layouts = array_merge( $layout_default, $layouts );

	/* Get current post/entry layout */
	$post_layout = tamatebako_get_post_layout( $post->ID );

	$div_class = 'post-layout';
	if( true == $layouts_args['thumbnail'] ){
		$div_class .= ' theme-layouts-thumbnail-wrap';
	}
	if( !empty( $post_layout ) ){
		$div_class .= ' post-layout-selected';
	}
?>

	<div id="post-layout" class="<?php echo esc_attr( $div_class ); ?>">

		<?php wp_nonce_field( basename( __FILE__ ), 'theme-layouts-nonce' ); ?>

		<div class="post-layout-wrap">
			
				<?php foreach ( $layouts as $layout => $layout_data ) {

					/* Set empty value for Layout Global/Default */
					$layout_value = $layout;
					if( 'default' == $layout ){
						$layout_value = '';
					}

					/* Label class */
					$label_class = "theme-layout-label";
					if( 'default' == $layout ){
						$label_class .= " layout-default"; // hide it!
					}
					if( $post_layout == $layout ){
						$label_class .= " layout-selected";
					}

					/* Label */
					if( true === $layouts_args['customize'] ){
						$layout_info = tamatebako_layouts_string( 'global_layout' );
					}
					else{
						$layout_info = tamatebako_layouts_string( 'default' );
					}
					if( tamatebako_current_layout() == $layout ){
						$layout_data['name'] = $layout_data['name'] . ' (' . $layout_info . ')';
						$label_class .= " layout-global";
					}
					$layout_label = $layout_data['name'];

					/* If theme using layout thumbnail, label using image. */
					if( true == $layouts_args['thumbnail'] && isset( $layout_data['thumbnail'] ) ){
						$layout_label = '<img src="' . esc_url( $layout_data['thumbnail'] ) . '" class="layout-thumbnail" title="' . esc_attr( $layout_data['name'] ) . '">' . '<span class="layout-name">' . $layout_data['name'] . '</span>';
					}
					?>

						<label style="display:block;" class="<?php echo esc_attr( $label_class );?>">
							<input type="radio" name="post-layout" class="theme-layout-input" value="<?php echo esc_attr( $layout_value ); ?>" <?php checked( $post_layout, $layout_value ); ?> />
							<?php echo $layout_label; ?>
						</label>

				<?php } // end foreach ?>
			
		</div>
	</div><?php
}

/**
 * Saves the post layout metadata.
 */
function tamatebako_layouts_save_post( $post_id, $post = '' ) {

	/* Fix for attachment save issue in WordPress 3.5. @link http://core.trac.wordpress.org/ticket/21963 */
	if ( !is_object( $post ) ){
		$post = get_post();
	}

	/* Verify the nonce for the post formats meta box. */
	if ( !isset( $_POST['theme-layouts-nonce'] ) || !wp_verify_nonce( $_POST['theme-layouts-nonce'], basename( __FILE__ ) ) ){
		return $post_id;
	}

	/* Get the meta key. */
	$meta_key = tamatebako_layout_meta_key();

	/* Get the previous post layout. */
	$meta_value = tamatebako_get_post_layout( $post_id );

	/* Get the submitted post layout. */
	$new_meta_value = $_POST['post-layout'];

	/* If there is no new meta value but an old value exists, delete it. */
	if ( current_user_can( 'delete_post_meta', $post_id, $meta_key ) && '' == $new_meta_value && $meta_value ){
		delete_post_meta( $post_id, $meta_key );
	}

	/* If a new meta value was added and there was no previous value, add it. */
	elseif ( current_user_can( 'add_post_meta', $post_id, $meta_key ) && $new_meta_value && '' == $meta_value ){
		update_post_meta( $post_id, $meta_key, $new_meta_value );
	}

	/* If the old layout doesn't match the new layout, update the post layout meta. */
	elseif ( current_user_can( 'edit_post_meta', $post_id, $meta_key ) && $meta_value !== $new_meta_value ){
		update_post_meta( $post_id, $meta_key, $new_meta_value );
	}
}

/**
 * Style for layout thumbnail.
 * @since 3.0.0
 */
function tamatebako_post_layouts_thumb_style(){
	global $post_type;
	if ( in_array( $post_type, tamatebako_layouts_post_types() ) ){
?>
<style id="tamatebako-customize-layouts">
.theme-layouts-thumbnail-wrap{
	margin-top: 20px;
}
.theme-layouts-thumbnail-wrap:after{
	content:".";display:block;height:0;clear:both;visibility:hidden;
}
.theme-layouts-thumbnail-wrap .theme-layout-input{
	display: none;
}
.theme-layouts-thumbnail-wrap .layout-name{
	display: none;
}
.theme-layouts-thumbnail-wrap .customize-control-title{
	margin-bottom: 10px;
}
.theme-layouts-thumbnail-wrap .theme-layout-label{
	width: 60px;
	display: block;
	float: left;
	margin: 0 10px 5px;
	padding: 0;
}
.theme-layouts-thumbnail-wrap .theme-layout-label.layout-default{
	display: none !important;
}
.layout-thumbnail{
	width: 100%;
	height: auto;
	border: 5px solid #ccc;
}
.layout-default .layout-thumbnail{
}
.layout-global .layout-thumbnail{
	border: 5px solid #b6cfdb;
}
.post-layout-selected .layout-global .layout-thumbnail{
	border: 5px solid #ccc;
}
.post-layout .layout-selected .layout-thumbnail{
	border: 5px solid #298cba;
}
.theme-layout-label:hover .layout-thumbnail{
	opacity: 0.8;
}
/* No JS Compat */
body.no-js .theme-layouts-thumbnail-wrap .theme-layout-label.layout-default{
	display: block !important;
	width: 100%;
}
body.no-js .theme-layouts-thumbnail-wrap .theme-layout-input{
	display: block !important;
}
</style>
<?php
	}
}

/**
 * Script for layout thumbnail
 * use jQuery .click() and not .change() because it's too late(?)
 * @since 3.0.0
 */
function tamatebako_post_layouts_thumb_script(){
	global $post_type;
	if ( in_array( $post_type, tamatebako_layouts_post_types() ) ){
?>
<script type="text/javascript">
jQuery(document).ready(function ($) {
	$( ".theme-layout-input" ).click( function(){
		/* if it's already selected, remove it and select default. */
		if( $( this ).parent( '.theme-layout-label' ).hasClass( 'layout-selected' ) ){
			$( '.layout-default .theme-layout-input' ).attr('checked', 'checked');
			$( this ).parent( '.theme-layout-label' ).removeClass( 'layout-selected' );
		}
		/* not yet selected, select it! */
		else{
			$( this ).parent( '.theme-layout-label' ).siblings( '.theme-layout-label' ).removeClass( 'layout-selected' );
			$( this ).parent( '.theme-layout-label' ).addClass( 'layout-selected' );
		}
		/* if a layout is selected, add wrapper class */
		if ( $( ".layout-selected" ).length ) {
			$( '.post-layout' ).addClass( 'post-layout-selected' );
		}
		else{
			$( '.post-layout' ).removeClass( 'post-layout-selected' );
		}
	});
});
</script>
<?php
	}
}
