wp.customize.controlConstructor['kirki-gradient'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		'use strict';

		var control        = this,
		    value          = control.getValue(),
		    pickerStart    = control.container.find( '.kirki-gradient-control-start' ),
		    pickerEnd      = control.container.find( '.kirki-gradient-control-end' ),
		    angleElement = jQuery( '.angle.gradient-' + control.id );

		// If we have defined any extra choices, make sure they are passed-on to Iris.
		if ( ! _.isUndefined( control.params.choices.iris ) ) {
			pickerStart.wpColorPicker( control.params.choices.iris );
			pickerEnd.wpColorPicker( control.params.choices.iris );
		}

		control.updatePreview( value );

		_.each( { 'start': pickerStart, 'end': pickerEnd }, function( obj, index ) {

			// Saves our settings to the WP API
			obj.wpColorPicker({
				change: function() {
					setTimeout( function() {

						// Add the value to the object.
						value[ index ].color = obj.val();

						// Update the preview.
						control.updatePreview( value );

						// Set the value.
						control.setValue( value );

					}, 100 );
				}
			});
		});

		// Angle (-90° - 90°).
		angleElement.on( 'change', function() {
			value.angle = angleElement.val();

			// Update the preview.
			control.updatePreview( value );

			// Set the value.
			control.setValue( value );
		});

		// Position( 0% - 100%);
		_.each( ['start', 'end'], function( index ) {
			var positionElement = jQuery( '.position.gradient-' + control.id + '-' + index );

			positionElement.on( 'change', function() {
				value[ index ].position = positionElement.val();

				// Update the preview.
				control.updatePreview( value );

				// Set the value.
				control.setValue( value );
			});
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
				if ( ! _.isUndefined( control.setting._value[ param ] ) ) {
					value[ param ] = control.setting._value[ param ];
				}
			}
		});
		_.each( control.setting._value, function( subValue, param ) {
			if ( ! _.isUndefined( value[ param ] ) ) {
				value[ param ] = subValue;
			}
		});
		return value;
	},

	/**
	 * Updates the preview area.
	 */
	updatePreview: function( value ) {
		var control     = this,
		    previewArea = control.container.find( '.gradient-preview' );

		jQuery( previewArea ).css(
			'background',
			'linear-gradient(' + value.angle + 'deg, ' + value.start.color + ' ' + value.start.position + '%,' + value.end.color + ' ' + value.end.position + '%)'
		);
	},

	/**
	 * Saves the value.
	 */
	setValue: function( value ) {

		var control = this;

		wp.customize( control.id, function( obj ) {

			// Reset the setting value, so that the change is triggered
			obj.set( '' );

			// Set the right value
			obj.set( value );

		});

	}
});
