/* global kirkiWebfonts, WebFont */

// Asyncronously add webfontloader.
( function( document ) {
	let wfScript = document.createElement( 'script' ),
	    scripts  = document.scripts[0];

	wfScript.src   = 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js';
	wfScript.id    = 'webfontloader';
	wfScript.async = true;

	scripts.parentNode.insertBefore( wfScript, scripts );
} )( document );

jQuery( document ).ready( function() {
	let script  = document.querySelector( '#webfontloader' );

	// Check when the webfontloader finishes loading.
	script.addEventListener( 'load', function() {

		// Loop fonts.
		_.each( kirkiWebfonts, function( weights, family ) {

			// Add font.
			WebFont.load( {
				google:{
					families: [ family + ':' + weights.join( ',' ) + 'cyrillic,cyrillic-ext,devanagari,greek,greek-ext,khmer,latin,latin-ext,vietnamese,hebrew,arabic,bengali,gujarati,tamil,telugu,thai' ]
				}
			} );
		} );
	} );
} );
