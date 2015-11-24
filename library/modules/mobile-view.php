<?php
/**
 * Customizer Mobile View.
 * Create devices preview in customizer screen by resizing preview screen.
 */

/* Hook to theme setup */
add_action( 'after_setup_theme', 'tamatebako_customizer_mobile_view_setup', 20 );

/**
 * Register Theme Elements
 * @since 0.1.0
 */
function tamatebako_customizer_mobile_view_setup(){

	/* Customize Mobile View do not load if using mobile device */
	if ( !wp_is_mobile() ){
		add_action( 'customize_controls_print_footer_scripts', 'tamatebako_customize_mobile_view_script' );
		add_action( 'customize_controls_print_styles', 'tamatebako_customize_mobile_view_style' );
	}
}

/**
 * Load mobile preview toggle icon
 * @since 0.1.0
 */
function tamatebako_customize_mobile_view_script(){
?>
<div id="devices">
	<div class="devices-container">
		<span id="desktop-preview" title="Desktop" class="current"></span>
		<span id="tablet-preview" title="Tablet" class=""></span>
		<span id="mobile-preview" title="Mobile" class=""></span>
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function ($) {
	$( "#tablet-preview" ).click(function(e){
		e.preventDefault();
		$( '#customize-preview' ).removeClass( "desktop tablet mobile" ).addClass( 'tablet' );
		$( '.devices-container span' ).removeClass();
		$( '#tablet-preview' ).addClass('current');
	});
	$( "#mobile-preview" ).click(function(e){
		e.preventDefault();
		$( '#customize-preview' ).removeClass( "desktop tablet mobile" ).addClass( 'mobile' );
		$( '.devices-container span' ).removeClass();
		$( '#mobile-preview' ).addClass( 'current' );
	});
	$( "#desktop-preview" ).click(function(e){
		e.preventDefault();
		$( '#customize-preview' ).removeClass( "desktop tablet mobile" );
		$( '.devices-container span' ).removeClass();
		$( '#desktop-preview' ).addClass( 'current' );
	});
});
</script>
<?php
}

/**
 * Add custom stylesheet to customizer
 * @since 0.1.0
 */
function tamatebako_customize_mobile_view_style(){
?>
<style id="tamatebako-customize-mobile-view">
@media screen and (max-width: 1000px){
	#devices{
		display: none !important;
	}
}
/* Preview */
#customize-preview{
	text-align: center;
}
#customize-preview iframe{
	display: block;
	margin: 0 auto;
}
#customize-preview.desktop iframe{
	width: 100%;
}
#customize-preview.tablet iframe{
	max-width: 783px;
}
#customize-preview.mobile iframe{
	max-width: 335px;
}
/* Control */
#devices{
	margin-left:-75px;
	position:absolute;
	bottom:20px;
	left:50%;
	z-index:1000000;
	width:150px;
}
#devices .devices-container{
	background:rgba(0,0,0,0.8);
	border-radius:3px;
	margin:0 auto;
	padding:10px 10px 5px;
	text-align:center;
	width:130px;
}
#devices span{
	cursor:pointer;
}
#devices span:before{
	display:inline-block;
	font:normal 30px/1 'dashicons';
	margin:0 5px;
	color:#777;
	position:relative;
	-webkit-font-smoothing:antialiased;
	cursor:pointer;
}
#devices span:hover:before{
	color:#2ea2cc;
}
#devices #desktop-preview:before{
	content:"\f472";
}
#devices #tablet-preview:before{
	content:"\f471";
}
#devices #mobile-preview:before{
	content:"\f470";
}
#devices .current:before,
#devices .current:hover:before{
	color:#fff;
}
#customize-preview.desktop,
#customize-preview.tablet,
#customize-preview.mobile{
	background:#555;
}
</style>
<?php
}