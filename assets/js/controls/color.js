wp.customize.controlConstructor['kirki-color'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		'use strict';

		var control = this,
		    picker  = this.container.find( '.kirki-color-control' );

		// If we have defined any extra choices, make sure they are passed-on to Iris.
		if ( undefined !== control.params.choices ) {
			picker.wpColorPicker( control.params.choices );
		}

		// Saves our settings to the WP API
		picker.wpColorPicker({
			change: function( event, ui ) {

				// Small hack: the picker needs a small delay
				setTimeout( function() {
					control.setting.set( picker.val() );
				}, 100 );

			}

		});

	}

});
