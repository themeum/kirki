/* global kirkiControlLoader */
wp.customize.controlConstructor['kirki-sortable'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		'use strict';

		var control = this;

		// Init the control.
		if ( ! _.isUndefined( window.kirkiControlLoader ) && _.isFunction( kirkiControlLoader ) ) {
			kirkiControlLoader( control );
		} else {
			control.initKirkiControl();
		}
	},

	initKirkiControl: function() {

		'use strict';

		var control = this;

		control.container.find( '.kirki-controls-loading-spinner' ).hide();

		// Set the sortable container.
		control.sortableContainer = control.container.find( 'ul.sortable' ).first();

		// Init sortable.
		control.sortableContainer.sortable({

			// Update value when we stop sorting.
			stop: function() {
				control.updateValue();
			}
		}).disableSelection().find( 'li' ).each( function() {

			// Enable/disable options when we click on the eye of Thundera.
			jQuery( this ).find( 'i.visibility' ).click( function() {
				jQuery( this ).toggleClass( 'dashicons-visibility-faint' ).parents( 'li:eq(0)' ).toggleClass( 'invisible' );
			});
		}).click( function() {

			// Update value on click.
			control.updateValue();
		});
	},

	/**
	 * Updates the sorting list
	 */
	updateValue: function() {

		'use strict';

		var control = this,
		    newValue = [];

		this.sortableContainer.find( 'li' ).each( function() {
			if ( ! jQuery( this ).is( '.invisible' ) ) {
				newValue.push( jQuery( this ).data( 'value' ) );
			}
		});
		control.setting.set( newValue );
	}
});
