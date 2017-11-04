/* global kirkiTooltips */
jQuery( document ).ready( function() {

	function kirkiTooltipAdd( control ) {
		_.each( kirkiTooltips, function( tooltip ) {
			var trigger,
			    controlID,
			    content;

			if ( tooltip.id !== control.id ) {
				return;
			}

			if ( control.container.find( '.tooltip-content' ).length ) {
				return;
			}

			trigger   = '<span class="tooltip-trigger" data-setting="' + tooltip.id + '"><span class="dashicons dashicons-editor-help"></span></span>';
			controlID = '#customize-control-' + tooltip.id;
			content   = '<div class="tooltip-content hidden" data-setting="' + tooltip.id + '">' + tooltip.content + '</div>';

			// Add the trigger & content.
			jQuery( '<div class="tooltip-wrapper">' + trigger + content + '</div>' ).prependTo( controlID );

			// Handle onclick events.
			jQuery( '.tooltip-trigger[data-setting="' + tooltip.id + '"]' ).on( 'click', function() {
				jQuery( '.tooltip-content[data-setting="' + tooltip.id + '"]' ).toggleClass( 'hidden' );
			});
		});

		// Close tooltips if we click anywhere else.
		jQuery( document ).mouseup( function( e ) {

			if ( ! jQuery( '.tooltip-content' ).is( e.target ) ) {
				if ( ! jQuery( '.tooltip-content' ).hasClass( 'hidden' ) ) {
					jQuery( '.tooltip-content' ).addClass( 'hidden' );
				}
		    }
		});
	}

	wp.customize.control.each( function( control, key ) {
		wp.customize.section( control.section(), function( section ) {
			if ( section.expanded() || wp.customize.settings.autofocus.control === control.id ) {
				kirkiTooltipAdd( control );
			} else {
				section.expanded.bind( function( expanded ) {
					if ( expanded ) {
						kirkiTooltipAdd( control );
					}
				} );
			}
		} );
	});
} );
