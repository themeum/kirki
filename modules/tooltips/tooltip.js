jQuery( document ).ready( function() {
	wp.customize.control.each( function( control, key ) {
		// Console.log( control );
		if ( ! _.isUndefined( kirkiTooltips[ control.id ] ) || ! _.isUndefined( kirkiTooltips[ control.id.replace( '[', '-' ).replace( ']', '' ) ] ) ) {
			control.initKirkiControl = function() {
				var control = this,
				    tooltip = false,
				    trigger,
				    content;

				// First of all, call the parent method.
				wp.customize.kirkiDynamicControl.prototype.initKirkiControl.call( control );

				if ( ! _.isUndefined( kirkiTooltips[ control.id ] ) ) {
					tooltip = kirkiTooltips[ control.id ];
				} else if ( ! _.isUndefined( kirkiTooltips[ control.id.replace( '[', '-' ).replace( ']', '' ) ] ) ) {
					tooltip = kirkiTooltips[ control.id.replace( '[', '-' ).replace( ']', '' ) ];
				}

				if ( tooltip ) {
				    trigger   = '<span class="tooltip-trigger"><span class="dashicons dashicons-editor-help"></span></span>',
				    content   = '<div class="tooltip-content">' + tooltip.content + '</div>';

					// Add the trigger & content.
					jQuery( '<div class="tooltip-wrapper">' + trigger + content + '</div>' ).prependTo( '#customize-control-' + tooltip.id );

					// Handle onclick events.
					jQuery( '#customize-control-' + tooltip.id + ' .tooltip-trigger' ).on( 'click', function() {
						jQuery( '#customize-control-' + tooltip.id + ' .tooltip-content' ).toggleClass( 'open' );
					});

					// Close tooltips if we click anywhere else.
					jQuery( document ).mouseup( function( e ) {
						jQuery( '.tooltip-content.open' ).removeClass( 'open' );
					});
				}
			};
		}
	});
} );
