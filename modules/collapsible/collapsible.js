/* global collapsible */
( function() {

	_.each( collapsible, function( label, setting ) {

		setTimeout( function() {
			var control = jQuery( '#customize-control-' + setting ),
			    controlTitleElement;

			// Collapse field.
			control.addClass( 'kirki-collapsible kirki-collapsed-control' );

			// Add the header before the field.
			control.before( '<div class="kirki-collapsed-control-header kirki-collapsible-header-' + setting + '"><span class="customize-control-title"><span class="dashicons dashicons-arrow-down-alt2"></span> ' + label + '</span></div>' );

			// Add an (x) before the field title.
			controlTitleElement = control.find( '.customize-control-title' );
			controlTitleElement.prepend( '<span class="dashicons dashicons-arrow-up-alt2"></span>' );

			// Show/hide the field when the header is clicked.
			jQuery( '.kirki-collapsible-header-' + setting ).click( function() {
				if ( control.hasClass( 'kirki-collapsed-control' ) ) {
					control.removeClass( 'kirki-collapsed-control' );
					control.addClass( 'kirki-expanded-control' );
					control.show();
					jQuery( '.kirki-collapsible-header-' + setting ).hide();
				} else {
					control.addClass( 'kirki-collapsed-control' );
					control.removeClass( 'kirki-expanded-control' );
					control.hide();
					jQuery( '.kirki-collapsible-header-' + setting ).show();
				}
			});

			controlTitleElement.click( function() {
				if ( control.hasClass( 'kirki-collapsed-control' ) ) {
					control.removeClass( 'kirki-collapsed-control' );
					control.addClass( 'kirki-expanded-control' );
					control.show();
					jQuery( '.kirki-collapsible-header-' + setting ).hide();
				} else {
					control.addClass( 'kirki-collapsed-control' );
					control.removeClass( 'kirki-expanded-control' );
					control.hide();
					jQuery( '.kirki-collapsible-header-' + setting ).show();
				}
			});

		}, 300 );

	});

})( jQuery );
