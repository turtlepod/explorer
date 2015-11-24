<?php
/**
 * Backward compat. functionality
 * Prevent fatal error when using the theme.
 * Note: PHP compat will still produce fatal error.
**/

/**
 * Back Compat Args
 */
function tamatebako_back_compat_args(){

	/* Get theme support */
	$back_compat_support = get_theme_support( 'tamatebako-back-compat' );
	$theme_args = array();
	if ( isset( $back_compat_support[0] ) ){
		$theme_args = $back_compat_support[0];
	}

	/*
	Notice Tags:
	%theme_name% = theme name
	%wp_requires% = wp version.
	%php_requires% = php version.
	%wp_current% = current wp version
	%php_current% = current php version
	*/

	/* Default */
	$defaults_args = array(
		'theme_name' => 'This',
		'wp_requires' => '4.1',
		'php_requires' => '5.2.4',
		'wp_requires_notice' => '%theme_name% theme requires at least WordPress %wp_requires%. You are running WordPress %wp_current%. Please upgrade and try again.',
		'php_requires_notice' => '%theme_name% theme requires at least PHP %php_requires%. You are running PHP %php_current%. Please upgrade and try again.',
		'requires_notice' => '%theme_name% theme requires at least WordPress %wp_requires% and PHP %php_requires%. You are running WordPress %wp_current% and PHP %php_current%. Please upgrade and try again.',
	);

	/* Back compat args. */
	return wp_parse_args( $theme_args, $defaults_args );
}


/**
 * Notice.
 */
function tamatebako_back_compat_notice(){

	/* Vars */
	global $wp_version;
	$args  = tamatebako_back_compat_args();
	$notice = '';

	/* WP version incompatible */
	if ( version_compare( $wp_version, $args['wp_requires'], '<' ) ) {
		$notice = $args['wp_requires_notice'];
	}

	/* PHP version incompatible */
	if ( version_compare( PHP_VERSION, $args['php_requires'], '<' ) ) {
		$notice = $args['php_requires_notice'];
	}

	/* Both incompatible.  */
	if ( version_compare( $wp_version, $args['wp_requires'], '<' ) && version_compare( PHP_VERSION, $args['php_requires'], '<' ) ) {
		$notice = $args['requires_notice'];
	}

	/* Parse tags */
	if( !empty( $notice ) ){
		$notice = str_replace( '%theme_name%', $args['theme_name'], $notice );
		$notice = str_replace( '%wp_requires%', $args['wp_requires'], $notice );
		$notice = str_replace( '%php_requires%', $args['php_requires'], $notice );
		$notice = str_replace( '%wp_current%', $wp_version, $notice );
		$notice = str_replace( '%php_current%', PHP_VERSION, $notice );
	}

	return $notice;
}

/* Vars */
global $wp_version;
$args  = tamatebako_back_compat_args();

/* If using old system, prevent theme activation and switch to default theme. */
if ( version_compare( $wp_version, $args['wp_requires'], '<' ) || version_compare( PHP_VERSION, $args['php_requires'], '<' ) ) {

	/* Switch to default theme */
	add_action( 'after_switch_theme', 'tamatebako_back_compat_switch_theme' );

	/* Prevent Customize */
	add_action( 'load-customize.php', 'tamatebako_back_compat_disable_customize' );

	/* Disable Preview */
	add_action( 'template_redirect', 'tamatebako_back_compat_disable_preview' );

}


/**
 * Prevent theme activation, and force switch to the default theme.
 */
function tamatebako_back_compat_switch_theme() {

	/* Force switch to default theme. */
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
	unset( $_GET['activated'] );

	/* Admin notice */
	add_action( 'admin_notices', 'tamatebako_back_compat_admin_notice' );
}

/**
 * Add notice message for unsuccessful theme switch.
 */
function tamatebako_back_compat_admin_notice() {
?>
	<div class="error">
		<p><?php echo tamatebako_back_compat_notice(); ?></p>
	</div>
<?php
}


/**
 * Prevent the Customizer from being loaded.
 */
function tamatebako_back_compat_disable_customize(){
	wp_die( tamatebako_back_compat_notice(), '', array( 'back_link' => true ) );
}


/**
 * Prevent the Theme Preview from being loaded.
 */
function tamatebako_back_compat_disable_preview(){
	if ( isset( $_GET['preview'] ) ) {
		wp_die( tamatebako_back_compat_notice() );
	}
}