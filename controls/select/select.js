/*jshint -W065 */
wp.customize.controlConstructor['kirki-select'] = wp.customize.Control.extend({

	ready: function() {

		'use strict';

		var control  = this,
		    element  = this.container.find( 'select' ),
			hidden   = this.container.find( 'input' ),
		    multiple = parseInt( element.data( 'multiple' ) );

		// Change value
		this.container.on( 'change', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});

		// Instantiate select2
		jQuery( hidden ).select2({

			// Add the options.
			tags: jQuery.map( control.params.choices, function( value, index ) {
				return [ index ];
		    }),

			// Handle multi-select.
			multiple: ( 1 < multiple ) ? true : false,
			maximumSelectionSize: multiple,

			// Initial values.
			initSelection: function( element, callback ) {
			}
		});

		jQuery( hidden ).on( 'change', function() {
			jQuery( control.container.find( '.target' ) ).html(
				jQuery( hidden ).val()
			);
		});

		// Make sortable.
		if ( 1 < multiple ) {
			jQuery( hidden ).select2( 'container' ).find( 'ul.select2-choices' ).sortable({
				containment: 'parent',
				start: function() {
					jQuery( hidden ).select2( 'onSortStart' );
				},
				update: function() {
					jQuery( hidden ).select2( 'onSortEnd' );
				}
			});
		}
	}
});
