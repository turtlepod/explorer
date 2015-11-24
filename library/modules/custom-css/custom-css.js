/**
 * Live-update changes to the Custom CSS.
 * @author Nick Hasley
 * @link http://celloexpressions.com/plugins/modular-custom-css
 */
( function( $ ) {
	wp.customize( 'custom_css', function( value ) {
		value.bind( function( to ) {
			$( '#tamatebako-custom-css' ).html( to );
		} );
	} );
} )( jQuery );