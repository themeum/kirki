jQuery( document ).ready( function( $ ) {

	'use strict';

	jQuery( 'a.kirki-reset-section' ).on( 'click', function() {

		var id       = jQuery( this ).data( 'reset-section-id' ),
		    controls = wp.customize.section( id ).controls(),
		    i;

		// Loop controls
		for ( i = 0, len = controls.length; i < len; i++ ) {

			// Set value to default
			kirkiSetValue( controls[ i ].id, controls[ i ].params['default'] );

		}

	});

});
