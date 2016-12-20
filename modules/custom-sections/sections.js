jQuery( document ).ready( function() {

	wp.customize.section.each( function( section ) {

		// Get the pane element.
		var pane      = jQuery( '#sub-accordion-section-' + section.id ),
		    sectionLi = jQuery( '#accordion-section-' + section.id );

		// Check if the section is expanded.
		if ( sectionLi.hasClass( 'control-section-kirki-expanded' ) ) {

			// Move element.
			pane.appendTo( sectionLi );

		}

	} );

} );
