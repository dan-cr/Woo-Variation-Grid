/**
 * Javascript for public facing side of the site to be placed here
 */
 
 /* global jQuery */
(function( $ ) {
	
	'use strict';

	$(function() {
		$('#wvg-table-main').DataTable( {
			"paging": false,
			"info": false,
			"language": {
				"search": "Filter Records: ",
				"searchPlaceholder": "Term..."
			}
		});
	});

})( jQuery );
