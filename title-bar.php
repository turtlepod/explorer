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
	$title = __( 'Blog', 'explorer' );
	?>
	<div class="loop-meta">
		<div class="loop-title"><?php echo $title; ?></div>
	</div>
	<?php
}
elseif( is_singular() ){
	$title = explorer_get_post_type_name( get_queried_object_id() );
	if( is_page() || is_attachment() ){ ?>
		<header itemtype="http://schema.org/WebPageElement" itemscope="itemscope" class="loop-meta">
			<?php the_title( '<h1 itemprop="headline" class="loop-title">', '</h1>' ); ?>
		</header>
	<?php } else { ?>
		<div class="loop-meta">
			<div class="loop-title"><?php echo $title; ?></div>
		</div>
	<?php }
}
else{
	$title = get_bloginfo( 'name' );
	?>
	<div class="loop-meta">
		<div class="loop-title"><?php echo $title; ?></div>
	</div>
	<?php
}