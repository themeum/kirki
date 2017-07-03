wp.customize.controlConstructor['kirki-gradient'] = wp.customize.Control.extend({

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

		var control      = this,
		    value        = control.getValue(),
		    pickerStart  = control.container.find( '.kirki-gradient-control-start' ),
		    pickerEnd    = control.container.find( '.kirki-gradient-control-end' ),
		    angleElement = jQuery( '.angle.gradient-' + control.id ),
		    throttledAngleChange,
		    throttledPositionStartChange,
		    throttledPositionEndChange,
		    startPositionElement = jQuery( '.position.gradient-' + control.id + '-start' ),
		    endPositionElement   = jQuery( '.position.gradient-' + control.id + '-end' );

		// If we have defined any extra choices, make sure they are passed-on to Iris.
		if ( ! _.isUndefined( control.params.choices.iris ) ) {
			pickerStart.wpColorPicker( control.params.choices.iris );
			pickerEnd.wpColorPicker( control.params.choices.iris );
		}

		control.container.find( '.kirki-controls-loading-spinner' ).hide();

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

		jQuery( control.container.find( '.global .angle' ) ).show();
		if ( ! _.isUndefined( value.mode && 'radial' === value.mode ) ) {
			jQuery( control.container.find( '.global .angle' ) ).hide();
		}

		// Mode (linear/radial).
		jQuery( control.container.find( '.mode .switch-input' ) ).on( 'click input', function() {
			value.mode = jQuery( this ).val();
			control.updatePreview( value );
			control.setValue( value );
			jQuery( control.container.find( '.global .angle' ) ).show();
			if ( 'radial' === value.mode ) {
				jQuery( control.container.find( '.global .angle' ) ).hide();
			}
		});

		// Angle (-90° -to 90°).
		throttledAngleChange = _.throttle( function() {
			value.angle = angleElement.val();

			// Update the preview.
			control.updatePreview( value );

			// Set the value.
			control.setValue( value );
		}, 20 );
		angleElement.on( 'input change oninput', function() {
			throttledAngleChange();
		});

		// Start Position( 0% - 100%);
		throttledPositionStartChange = _.throttle( function() {
			value.start.position = startPositionElement.val();

			// Update the preview.
			control.updatePreview( value );

			// Set the value.
			control.setValue( value );
		}, 20 );
		startPositionElement.on( 'input change oninput', function() {
			throttledPositionStartChange();
		});

		// End Position( 0% - 100%);
		throttledPositionEndChange = _.throttle( function() {
			value.end.position = endPositionElement.val();

			// Update the preview.
			control.updatePreview( value );

			// Set the value.
			control.setValue( value );
		}, 20 );
		endPositionElement.on( 'input change oninput', function() {
			throttledPositionEndChange();
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

		if ( ! _.isUndefined( value.mode ) && 'radial' === value.mode ) {
			jQuery( previewArea ).css(
				'background',
				'radial-gradient(ellipse at center, ' + value.start.color + ' ' + value.start.position + '%,' + value.end.color + ' ' + value.end.position + '%)'
			);
		} else {
			jQuery( previewArea ).css(
				'background',
				'linear-gradient(' + value.angle + 'deg, ' + value.start.color + ' ' + value.start.position + '%,' + value.end.color + ' ' + value.end.position + '%)'
			);
		}
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
