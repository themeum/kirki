/*jshint -W065 */
wp.customize.controlConstructor['kirki-select'] = wp.customize.Control.extend({

	ready: function() {

		'use strict';

		var control  = this,
		    element  = this.container.find( 'select' ),
		    multiple = parseInt( element.data( 'multiple' ) ),
		    selectValue;

		// If this is a multi-select control,
		// then we'll need to initialize selectize using the appropriate arguments.
		// If this is a single-select, then we can initialize selectize without any arguments.
		if ( multiple > 1 ) {
			jQuery( element ).selectize({
				maxItems: multiple,
				plugins: ['remove_button', 'drag_drop']
			});
		} else {
			jQuery( element ).selectize();
		}

		// Change value
		this.container.on( 'change', 'select', function() {

			selectValue = jQuery( this ).val();

			// If this is a multi-select, then we need to convert the value to an object.
			if ( multiple > 1 ) {
				selectValue = _.extend( {}, jQuery( this ).val() );
			}

			control.setting.set( selectValue );

		});

	}

});
