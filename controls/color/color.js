wp.customize.controlConstructor['kirki-color'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		'use strict';

		var control = this,
		    picker  = this.container.find( '.kirki-color-control' ),
		    clear;

		// If we have defined any extra choices, make sure they are passed-on to Iris.
		if ( 'undefined' !== typeof control.params.choices ) {
			picker.wpColorPicker( control.params.choices );
		}

		// Tweaks to make the "clear" buttons work.
		setTimeout( function() {
			clear = control.container.find( '.wp-picker-clear' );
			clear.click( function() {
				control.setting.set( '' );
			});
		}, 500 );

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
