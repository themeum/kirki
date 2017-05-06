wp.customize.controlConstructor['kirki-gradient'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		'use strict';

		var control     = this,
		    value       = control.getValue(),
		    picker0     = control.container.find( '.kirki-gradient-control-0' ),
		    picker1     = control.container.find( '.kirki-gradient-control-1' ),
		    previewArea = control.container.find( '.gradient-preview' ),
		    hiddenInput = control.container.find( '.hidden-gradient-input' );

		// If we have defined any extra choices, make sure they are passed-on to Iris.
		if ( 'undefined' !== typeof control.params.choices.iris ) {
			picker0.wpColorPicker( control.params.choices.iris );
			picker1.wpColorPicker( control.params.choices.iris );
		}

		jQuery( previewArea ).css( 'background', 'background: linear-gradient(to bottom, ' + value.colors[0] + ' 0%,' + value.colors[1] + ' 100%)' );

		// Saves our settings to the WP API
		picker0.wpColorPicker({
			change: function( event, ui ) {

				// Small hack: the picker needs a small delay
				setTimeout( function() {
					value.colors[0] = picker0.val();
					hiddenInput.attr( 'value', JSON.stringify( value ) );
					jQuery( hiddenInput ).trigger( 'change' );
				}, 100 );
			}
		});
		picker1.wpColorPicker({
			change: function( event, ui ) {

				// Small hack: the picker needs a small delay
				setTimeout( function() {
					value.colors[1] = picker1.val();
					hiddenInput.attr( 'value', JSON.stringify( value ) );
					jQuery( hiddenInput ).trigger( 'change' );
				}, 100 );
			}
		});
	},

	/**
	 * Gets the value.
	 */
	getValue: function() {

		var control = this,
			value   = {};

		// Make sure everything we're going to need exists.
		_.each( control.params['default'], function( defaultParamValue, param ) {
			if ( false !== defaultParamValue ) {
				value[ param ] = defaultParamValue;
				if ( 'undefined' !== typeof control.setting._value[ param ] ) {
					value[ param ] = control.setting._value[ param ];
				}
			}
		});
		_.each( control.setting._value, function( subValue, param ) {
			if ( 'undefined' === typeof value[ param ] ) {
				value[ param ] = subValue;
			}
		});
		return value;
	}
});
