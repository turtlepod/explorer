jQuery( document ).ready( function($) {

	/* === FitVids === */
	$('#content,.entry-content,.entry-summary,.widget').fitVids();

	/* === Menu Search === */

	/* == Search Toggle == */
	$( ".search-toggle" ).click( function(e) {
		e.preventDefault();
		$( this ).parents( ".menu-search" ).toggleClass( "search-toggle-active" );
		$( this ).siblings( ".search-field" ).focus();
	});

	/* == Display search form on search pages == */
	if ( $("body").hasClass("search") ){
		$( ".search-toggle" ).parents( ".menu-search" ).addClass( "search-toggle-active" )
	}

	/* === Sidebar Toggle === */

	/* Open Sidebar */
	$( "#sidebar-toggle a" ).click( function(e) {
		e.preventDefault();
		$("body").toggleClass("sidebar-toggle-active");
	});

	/* Close Sidebar */
	$('#sidebar-primary-wrap').click( function(e) {
		if( e.target !== this ){
			return;
		}
		$("body").toggleClass("sidebar-toggle-active");
	});

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
});

















