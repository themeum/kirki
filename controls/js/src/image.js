/* global kirkiControlLoader */
wp.customize.controlConstructor['kirki-image'] = wp.customize.Control.extend({

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

		var control       = this,
		    value         = control.getValue(),
		    saveAs        = ( ! _.isUndefined( control.params.choices ) && ! _.isUndefined( control.params.choices.save_as ) ) ? control.params.choices.save_as : 'url',
		    preview       = control.container.find( '.placeholder, .thumbnail' ),
		    previewImage  = ( 'array' === saveAs ) ? value.url : value,
		    removeButton  = control.container.find( '.image-upload-remove-button' ),
		    defaultButton = control.container.find( '.image-default-button' );

		control.container.find( '.kirki-controls-loading-spinner' ).hide();

		// Tweaks for save_as = id.
		if ( ( 'id' === saveAs || 'ID' === saveAs ) && '' !== value ) {
			wp.media.attachment( value ).fetch().then( function( mediaData ) {
				setTimeout( function() {
					var url = wp.media.attachment( value ).get( 'url' );
					preview.removeClass().addClass( 'thumbnail thumbnail-image' ).html( '<img src="' + url + '" alt="" />' );
				}, 700 );
			} );
		}

		// If value is not empty, hide the "default" button.
		if ( ( 'url' === saveAs && '' !== value ) || ( 'array' === saveAs && ! _.isUndefined( value.url ) && '' !== value.url ) ) {
			control.container.find( 'image-default-button' ).hide();
		}

		// If value is empty, hide the "remove" button.
		if ( ( 'url' === saveAs && '' === value ) || ( 'array' === saveAs && ( _.isUndefined( value.url ) || '' === value.url ) ) ) {
			removeButton.hide();
		}

		// If value is default, hide the default button.
		if ( value === control.params['default'] ) {
			control.container.find( 'image-default-button' ).hide();
		}

		if ( '' !== previewImage ) {
			preview.removeClass().addClass( 'thumbnail thumbnail-image' ).html( '<img src="' + previewImage + '" alt="" />' );
		}

		control.container.on( 'click', '.image-upload-button', function( e ) {
			var image = wp.media({ multiple: false }).open().on( 'select', function() {

					// This will return the selected image from the Media Uploader, the result is an object.
					var uploadedImage = image.state().get( 'selection' ).first(),
					    previewImage  = uploadedImage.toJSON().sizes.full.url;

					if ( ! _.isUndefined( uploadedImage.toJSON().sizes.medium ) ) {
						previewImage = uploadedImage.toJSON().sizes.medium.url;
					} else if ( ! _.isUndefined( uploadedImage.toJSON().sizes.thumbnail ) ) {
						previewImage = uploadedImage.toJSON().sizes.thumbnail.url;
					}

					if ( 'array' === saveAs ) {
						control.saveValue( 'id', uploadedImage.toJSON().id );
						control.saveValue( 'url', uploadedImage.toJSON().sizes.full.url );
						control.saveValue( 'width', uploadedImage.toJSON().width );
						control.saveValue( 'height', uploadedImage.toJSON().height );
					} else if ( 'id' === saveAs ) {
						control.saveValue( 'id', uploadedImage.toJSON().id );
					} else {
						control.saveValue( 'url', uploadedImage.toJSON().sizes.full.url );
					}

					if ( preview.length ) {
						preview.removeClass().addClass( 'thumbnail thumbnail-image' ).html( '<img src="' + previewImage + '" alt="" />' );
					}
					if ( removeButton.length ) {
						removeButton.show();
						defaultButton.hide();
					}
			    });

			e.preventDefault();
		});

		control.container.on( 'click', '.image-upload-remove-button', function( e ) {

			var preview,
			    removeButton,
			    defaultButton;

			e.preventDefault();

			control.saveValue( 'id', '' );
			control.saveValue( 'url', '' );
			control.saveValue( 'width', '' );
			control.saveValue( 'height', '' );

			preview       = control.container.find( '.placeholder, .thumbnail' );
			removeButton  = control.container.find( '.image-upload-remove-button' );
			defaultButton = control.container.find( '.image-default-button' );

			if ( preview.length ) {
				preview.removeClass().addClass( 'placeholder' ).html( 'No file selected' );
			}
			if ( removeButton.length ) {
				removeButton.hide();
				if ( jQuery( defaultButton ).hasClass( 'button' ) ) {
					defaultButton.show();
				}
			}
		});

		control.container.on( 'click', '.image-default-button', function( e ) {

			var preview,
			    removeButton,
			    defaultButton;

			e.preventDefault();

			control.saveValue( 'url', control.params['default'] );

			preview       = control.container.find( '.placeholder, .thumbnail' );
			removeButton  = control.container.find( '.image-upload-remove-button' );
			defaultButton = control.container.find( '.image-default-button' );

			if ( preview.length ) {
				preview.removeClass().addClass( 'thumbnail thumbnail-image' ).html( '<img src="' + control.params['default'] + '" alt="" />' );
			}
			if ( removeButton.length ) {
				removeButton.show();
				defaultButton.hide();
			}
		});
	},

	/**
	 * Gets the value.
	 */
	getValue: function() {
		var control = this,
		    value   = control.setting._value,
		    saveAs  = ( ! _.isUndefined( control.params.choices ) && ! _.isUndefined( control.params.choices.save_as ) ) ? control.params.choices.save_as : 'url';

		if ( 'array' === saveAs && _.isString( value ) ) {
			value = {
				url: value
			};
		}
		return value;
	},

	/**
	 * Saves the value.
	 */
	saveValue: function( property, value ) {
		var control   = this,
		    valueOld  = control.setting._value,
		    saveAs    = ( ! _.isUndefined( control.params.choices ) && ! _.isUndefined( control.params.choices.save_as ) ) ? control.params.choices.save_as : 'url';

		if ( 'array' === saveAs ) {
			if ( _.isString( valueOld ) ) {
				valueOld = {};
			}
			valueOld[ property ] = value;
			control.setting.set( valueOld );
			control.container.find( 'button' ).trigger( 'change' );
			return;
		}
		control.setting.set( value );
		control.container.find( 'button' ).trigger( 'change' );
	}
});
