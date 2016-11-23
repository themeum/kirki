jQuery( document ).ready( function() {

	'use strict';

	jQuery( 'a.kirki-reset-section' ).on( 'click', function() {

		var id       = jQuery( this ).data( 'reset-section-id' ),
		    controls = wp.customize.section( id ).controls();

		// Loop controls
		_.each( controls, function( control, i ) {

			// Set value to default
			kirkiSetSettingValue( controls[ i ].id, control.params['default'] );

		});

	});

});
