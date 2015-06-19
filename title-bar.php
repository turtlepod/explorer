<?php
/**
 * Title Bar
 * Archive: Display archive title
 * 404 : "404 Error"
 * Singular: Post type.
 * @since 1.0.0
**/
$title = get_bloginfo( 'name' );
if ( hybrid_get_loop_title() ){
	$title = hybrid_get_loop_title();
}
elseif( is_singular() ){
	$title = get_post_type_labels( get_post_type_object( get_post_type( get_queried_object_id() ) ) )->singular_name;
}
if( is_front_page() && is_home() ){
	$title = __( 'Blog', 'daftar' );
}
?>

<header itemtype="http://schema.org/WebPageElement" itemscope="itemscope" class="loop-meta">
	<h1 itemprop="headline" class="loop-title"><?php echo $title; ?></h1>
</header>



