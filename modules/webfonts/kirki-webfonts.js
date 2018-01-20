/* global kirkiWebfonts, WebFont */

// Asyncronously add webfontloader.
( function( document ) {
	var wf      = document.createElement( 'script' ),
	    scripts = document.scripts[0];

	wf.src   = 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js';
	wf.id    = 'webfontloader',
	wf.async = true;

	scripts.parentNode.insertBefore( wf, scripts );
} )( document );

jQuery( document ).ready( function() {
	var script = document.querySelector( '#webfontloader' );

	// Check when the webfontloader finishes loading.
	script.addEventListener( 'load', function() {

		// Loop fonts.
		_.each( kirkiWebfonts, function( weights, family ) {

			// Add font.
			WebFont.load( {
				google:{
					families: [ family + ':' + weights.join( ',' )]
				}
			} );
		} );
	} );
} );
