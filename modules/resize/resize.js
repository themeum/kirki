jQuery( document ).ready( function() {

	// Initial resizing of the preview area.
	var controlsWidth = jQuery( '#customize-controls' ).width();

	// Change the preview area sizing on initial load.
	jQuery( '.wp-full-overlay.expanded' ).css( 'margin-left', controlsWidth + 'px' );

	// Make sure the footer actions are properly sized on initial load.
	jQuery( '.expanded .wp-full-overlay-footer' ).css( 'width', controlsWidth - 1 + 'px' );

	// Init resizable.
	jQuery( '#customize-controls' ).resizable({
		resize: function() {

			// Add a 50ms delay.
			setTimeout( function() {

				// Get the width of the controls area.
				var controlsWidth = jQuery( '#customize-controls' ).width();

				// Change the preview area sizing.
				jQuery( '.wp-full-overlay.expanded' ).css( 'margin-left', controlsWidth + 'px' );

				// Change the sizing of the footer actions.
				jQuery( '.expanded .wp-full-overlay-footer' ).css( 'width', controlsWidth - 1 + 'px' );
			}, 50 );
		},
		minWidth: 200,
		maxWidth: 700
	});

});
