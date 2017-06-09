wp.customize.controlConstructor['kirki-gradient'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		'use strict';

		var control = this,
		    section = control.section.get();

		// Force-load the control if we open the section.
		jQuery( '#accordion-section-' + section ).on( 'click', function() {
			control.initKirkiControl();
		});
		if ( jQuery( '#sub-accordion-section-' + section ).hasClass( 'open' ) ) {
			control.initKirkiControl();
		}

		// Add to the queue.
		control.kirkiLoader();
	},

	// Add control to a queue and load when the time is right.
	kirkiLoader: function( forceLoad ) {
		var control  = this,
		    waitTime = 100,
		    i;

		if ( _.isUndefined( window.kirkiControlsLoader ) ) {
			window.kirkiControlsLoader = {
				queue: [],
				done: [],
				busy: false
			};
		}

		// No need to proceed if this control has already been initialized.
		if ( -1 !== window.kirkiControlsLoader.done.indexOf( control.id ) ) {
			return;
		}

		// Add this control to the queue if it's not already there.
		if ( -1 === window.kirkiControlsLoader.queue.indexOf( control.id ) ) {
			window.kirkiControlsLoader.queue.push( control.id );
		}

		// If we're busy check back again later.
		if ( true === window.kirkiControlsLoader.busy ) {
			setTimeout( function() {
				control.kirkiLoader();
			}, waitTime );
			return;
		}

		// Run if force-loading and not busy.
		if ( true === forceLoad || false === window.kirkiControlsLoader.busy ) {

			// Set to busy.
			window.kirkiControlsLoader.busy = true;

			// Init the control JS.
			control.initKirkiControl();

			// Mark as done and remove from queue.
			window.kirkiControlsLoader.done.push( control.id );
			i = window.kirkiControlsLoader.queue.indexOf( control.id );
			window.kirkiControlsLoader.queue.splice( i, 1 );

			// Set busy to false after waitTime has passed.
			setTimeout( function() {
				window.kirkiControlsLoader.busy = false;
			}, waitTime );
			return;
		}

		if ( control.id === window.kirkiControlsLoader.queue[0] ) {
			control.kirkiLoader( true );
		}
	},

	initKirkiControl: function() {

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
