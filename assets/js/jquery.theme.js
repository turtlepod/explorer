jQuery( document ).ready( function($) {

	/* === FitVids === */
	$('#content,.entry-content,.entry-summary,.widget').fitVids();

	/* === Sidebar Toggle === */

	/* Open Sidebar */
	$( "#sidebar-toggle a" ).click( function(e) {
		e.preventDefault();
		$("body").toggleClass("sidebar-toggle-active");
	});

	/* Close Sidebar */
	$('#sidebar-primary').click( function(e) {
		if( e.target !== this ){
			return;
		}
		$("body").toggleClass("sidebar-toggle-active");
	});

});