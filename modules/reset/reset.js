jQuery( document ).ready( function() {

	'use strict';

	wp.customize.section.each( function( section ) {

		var link = '<a href="#" class="kirki-reset-section" data-reset-section-id="' + section.id + '">' + kirkiResetButtonLabel['reset-with-icon'] + '</a>';

		jQuery( link ).appendTo( '#sub-accordion-section-' + section.id + ' .customize-section-title > h3' );

	});

	jQuery( 'a.kirki-reset-section' ).on( 'click', function() {

		var id       = jQuery( this ).data( 'reset-section-id' ),
		    controls = wp.customize.section( id ).controls();

		// Loop controls
		_.each( controls, function( control, i ) {

			// Set value to default
			kirkiSetSettingValue.set( controls[ i ].id, control.params['default'] );

		});

	});

});
