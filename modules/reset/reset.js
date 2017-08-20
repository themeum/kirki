jQuery( document ).ready( function() {
	'use strict';

	// Add reset buttons to sections.
	wp.customize.section.each( function( section ) {
		var link = '<a href="#" class="kirki-reset-section" data-reset-section-id="' + section.id + '">' + kirkiResetButtonLabel['reset-with-icon'] + '</a>';
		jQuery( link ).appendTo( '#sub-accordion-section-' + section.id + ' .customize-section-title > h3' );
	});

	// Reset controls on click.
	jQuery( 'a.kirki-reset-section' ).on( 'click', function() {
		var id       = jQuery( this ).data( 'reset-section-id' ),
		    controls = wp.customize.section( id ).controls();

		_.each( controls, function( control, i ) {

			// Set value to default
			control.setting.set( control.params['default'] );
			if ( _.isFunction( control.kirkiSetValue ) ) {
				control.kirkiSetValue( control.params['default'] );
			}

			// Reset the controls visually.
			if ( _.isFunction( control.kirkiSetControlValue ) ) {
				control.kirkiSetControlValue( control.params['default'] );
			}
		});
	});
});
