jQuery( document ).ready( function() {
	wp.customize.control.each( function( control, key ) {
		// Console.log( control );
		if ( ! _.isUndefined( kirkiTooltips[ control.id ] ) || ! _.isUndefined( kirkiTooltips[ control.id.replace( '[', '-' ).replace( ']', '' ) ] ) ) {
			control.kirkiControlHook = function() {
				var control = this,
				    tooltip = false,
				    trigger,
				    controlID,
				    content;

				if ( ! _.isUndefined( kirkiTooltips[ control.id ] ) ) {
					tooltip = kirkiTooltips[ control.id ];
				} else if ( ! _.isUndefined( kirkiTooltips[ control.id.replace( '[', '-' ).replace( ']', '' ) ] ) ) {
					tooltip = kirkiTooltips[ control.id.replace( '[', '-' ).replace( ']', '' ) ];
				}

				if ( tooltip ) {
				    trigger   = '<span class="tooltip-trigger" id="tooltip-' + tooltip.id + '" data-setting="' + tooltip.id + '"><span class="dashicons dashicons-editor-help"></span></span>',
				    controlID = '#customize-control-' + tooltip.id,
				    content   = '<div class="tooltip-content" id="tooltip-content-' + tooltip.id + '">' + tooltip.content + '</div>';

					// Add the trigger & content.
					jQuery( '<div class="tooltip-wrapper">' + trigger + content + '</div>' ).prependTo( controlID );

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
				}
			};
		}
	});
} );
