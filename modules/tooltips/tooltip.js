jQuery( document ).ready( function() {

	_.each( kirkiTooltips, function( tooltip ) {

		var trigger   = '<span class="tooltip-trigger" id="tooltip-' + tooltip.id + '" data-setting="' + tooltip.id + '"><span class="dashicons dashicons-editor-help"></span></span>',
		    controlID = '#customize-control-' + tooltip.id,
		    content   = '<div class="tooltip-content" id="tooltip-content-' + tooltip.id + '">' + tooltip.content + '</div>';

		// Add the trigger & content.
		jQuery( '<div class="tooltip-wrapper">' + trigger + content + '</div>' ).prependTo( controlID );

	});

	// Hide the tooltips content by default.
	jQuery( '.tooltip-content' ).hide();

	// Handle onclick events.
	jQuery( '.tooltip-trigger' ).on( 'click', function() {

		var $setting  = jQuery( this ).data( 'setting' ),
		    contentID = '#tooltip-content-' + kirkiTooltips[ $setting ].id,
		    $this     = jQuery( this );

		$this.toggleClass( 'open' );
		jQuery( contentID ).toggleClass( 'open' );

	});

	// Close tooltips if we click anywhere else.
	jQuery( document ).mouseup( function( e ) {

		var container = jQuery( '.tooltip-content' );

		if ( ! container.is( e.target ) ) {
			container.removeClass( 'open' );
	    }
	});

} );
