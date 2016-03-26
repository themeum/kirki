jQuery(document).ready(function($) { "use strict";

	jQuery( 'a.kirki-reset-section' ).on( 'click', function() {
		// var reset = confirm( "Reset all settings in section" );
		// if ( reset == true ) {

			// Get the section ID
			var id = jQuery( this ).data( 'reset-section-id' );
			// Get controls inside the section
			var controls = wp.customize.section( id ).controls();
			// Loop controls
			for ( var i = 0, len = controls.length; i < len; i++ ) {
				// set value to default
				kirkiSetValue( controls[ i ]['id'], controls[ i ]['params']['default'] );
			};

		// }

	});


});
