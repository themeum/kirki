wp.customize.controlConstructor['kirki-background'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		'use strict';

		var control = this,
		    section = control.section.get();

		// Add to the queue.
		control.kirkiLoader();
	},

	// Add control to a queue and load when the time is right.
	kirkiLoader: function( forceLoad ) {
		var control  = this,
		    waitTime = 10,
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

		var control = this,
		    value   = control.getValue(),
		    picker  = control.container.find( '.kirki-color-control' );

		// Hide unnecessary controls if the value doesn't have an image.
		if ( _.isUndefined( value['background-image'] ) || '' === value['background-image'] ) {
			control.container.find( '.background-wrapper > .background-repeat' ).hide();
			control.container.find( '.background-wrapper > .background-position' ).hide();
			control.container.find( '.background-wrapper > .background-size' ).hide();
			control.container.find( '.background-wrapper > .background-attachment' ).hide();
		}

		// Color.
		picker.wpColorPicker({
			change: function() {
				setTimeout( function() {
					control.saveValue( 'background-color', picker.val() );
				}, 100 );
			}
		});

		// Background-Repeat.
		control.container.on( 'change', '.background-repeat select', function() {
			control.saveValue( 'background-repeat', jQuery( this ).val() );
		});

		// Background-Size.
		control.container.on( 'change click', '.background-size input', function() {
			control.saveValue( 'background-size', jQuery( this ).val() );
		});

		// Background-Position.
		control.container.on( 'change', '.background-position select', function() {
			control.saveValue( 'background-position', jQuery( this ).val() );
		});

		// Background-Attachment.
		control.container.on( 'change click', '.background-attachment input', function() {
			control.saveValue( 'background-attachment', jQuery( this ).val() );
		});

		// Background-Image.
		control.container.on( 'click', '.background-image-upload-button', function( e ) {
			var image = wp.media({ multiple: false }).open().on( 'select', function() {

					// This will return the selected image from the Media Uploader, the result is an object.
					var uploadedImage = image.state().get( 'selection' ).first(),
					    previewImage   = uploadedImage.toJSON().sizes.full.url,
					    imageUrl,
					    imageID,
					    imageWidth,
					    imageHeight,
					    preview,
					    removeButton;

					if ( ! _.isUndefined( uploadedImage.toJSON().sizes.medium ) ) {
						previewImage = uploadedImage.toJSON().sizes.medium.url;
					} else if ( ! _.isUndefined( uploadedImage.toJSON().sizes.thumbnail ) ) {
						previewImage = uploadedImage.toJSON().sizes.thumbnail.url;
					}

					imageUrl    = uploadedImage.toJSON().sizes.full.url;
					imageID     = uploadedImage.toJSON().id;
					imageWidth  = uploadedImage.toJSON().width;
					imageHeight = uploadedImage.toJSON().height;

					// Show extra controls if the value has an image.
					if ( '' !== imageUrl ) {
						control.container.find( '.background-wrapper > .background-repeat, .background-wrapper > .background-position, .background-wrapper > .background-size, .background-wrapper > .background-attachment' ).show();
					}

					control.saveValue( 'background-image', imageUrl );
					preview      = control.container.find( '.placeholder, .thumbnail' );
					removeButton = control.container.find( '.background-image-upload-remove-button' );

					if ( preview.length ) {
						preview.removeClass().addClass( 'thumbnail thumbnail-image' ).html( '<img src="' + previewImage + '" alt="" />' );
					}
					if ( removeButton.length ) {
						removeButton.show();
					}
			    });

			e.preventDefault();
		});

		control.container.on( 'click', '.background-image-upload-remove-button', function( e ) {

			var preview,
			    removeButton;

			e.preventDefault();

			control.saveValue( 'background-image', '' );

			preview      = control.container.find( '.placeholder, .thumbnail' );
			removeButton = control.container.find( '.background-image-upload-remove-button' );

			// Hide unnecessary controls.
			control.container.find( '.background-wrapper > .background-repeat' ).hide();
			control.container.find( '.background-wrapper > .background-position' ).hide();
			control.container.find( '.background-wrapper > .background-size' ).hide();
			control.container.find( '.background-wrapper > .background-attachment' ).hide();

			if ( preview.length ) {
				preview.removeClass().addClass( 'placeholder' ).html( 'No file selected' );
			}
			if ( removeButton.length ) {
				removeButton.hide();
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
				if ( ! _.isUndefined( control.setting._value[ param ] ) ) {
					value[ param ] = control.setting._value[ param ];
				}
			}
		});
		_.each( control.setting._value, function( subValue, param ) {
			if ( _.isUndefined( value[ param ] ) ) {
				value[ param ] = subValue;
			}
		});
		return value;
	},

	/**
	 * Saves the value.
	 */
	saveValue: function( property, value ) {

		'use strict';

		var control   = this,
		    input     = jQuery( '#customize-control-' + control.id.replace( '[', '-' ).replace( ']', '' ) + ' .background-hidden-value' ),
		    valueJSON = jQuery( input ).val(),
		    valueObj  = JSON.parse( valueJSON );

		valueObj[ property ] = value;
		control.setting.set( valueObj );
		jQuery( input ).attr( 'value', JSON.stringify( valueObj ) ).trigger( 'change' );

	}

});
