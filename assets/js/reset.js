jQuery( document ).ready( function() {

	'use strict';

	jQuery( 'a.xtkirki-reset-section' ).on( 'click', function() {

		var id       = jQuery( this ).data( 'reset-section-id' ),
		    controls = wp.customize.section( id ).controls();

		// Loop controls
		_.each( controls, function( control, i ) {

			// Set value to default
			xtkirkiSetSettingValue( controls[ i ].id, control.params['default'] );

		});

	});

});
