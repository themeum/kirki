import "./control.scss";

wp.customize.controlConstructor['kirki-sortable'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		var control = this;

		// Init sortable.
		jQuery( control.container.find( 'ul.sortable' ).first() ).sortable({

			// Update value when we stop sorting.
			update: function() {
				control.setting.set( control.getNewVal() );
			}
		}).disableSelection().find( 'li' ).each( function() {

			// Enable/disable options when we click on the eye of Thundera.
			jQuery( this ).find( 'i.visibility' ).click( function() {
				jQuery( this ).toggleClass( 'dashicons-visibility-faint' ).parents( 'li:eq(0)' ).toggleClass( 'invisible' );
			});
		}).click( function() {

			// Update value on click.
			control.setting.set( control.getNewVal() );
		});
	},

	/**
	 * Getss thhe new vvalue.
	 *
	 * @since 3.0.35
	 * @returns {Array} - Returns the value as an array.
	 */
	getNewVal: function() {
		var items  = jQuery( this.container.find( 'li' ) ),
			newVal = [];
		_.each( items, function( item ) {
			if ( ! jQuery( item ).hasClass( 'invisible' ) ) {
				newVal.push( jQuery( item ).data( 'value' ) );
			}
		});
		return newVal;
	}
});
