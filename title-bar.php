<?php
/**
 * Title Bar
 * Archive: Display archive title
 * 404 : "404 Error"
 * Singular: Post type.
 * @since 1.0.0
**/
if ( hybrid_get_loop_title() ){
	$title = hybrid_get_loop_title();
	?>
	<header itemtype="http://schema.org/WebPageElement" itemscope="itemscope" class="loop-meta">
		<h1 itemprop="headline" class="loop-title"><?php echo $title; ?></h1>
	</header>
	<?php
}
elseif( is_front_page() && is_home() ){
	$title = __( 'Blog', 'daftar' );
	?>
	<div class="loop-meta">
		<div class="loop-title"><?php echo $title; ?></div>
	</div>
	<?php
}
elseif( is_singular() ){
	$title = get_post_type_labels( get_post_type_object( get_post_type( get_queried_object_id() ) ) )->singular_name;
	?>
	<div class="loop-meta">
		<div class="loop-title"><?php echo $title; ?></div>
	</div>
	<?php
}
else{
	$title = get_bloginfo( 'name' );
	?>
	<div class="loop-meta">
		<div class="loop-title"><?php echo $title; ?></div>
	</div>
	<?php
}