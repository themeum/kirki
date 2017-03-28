wp.customize.controlConstructor['kirki-background'] = wp.customize.Control.extend({

	ready: function() {

		var control = this,
		    value   = control.getValue(),
		    picker  = control.container.find( '.kirki-color-control' );

		// Color.
		picker.wpColorPicker({
			change: function() {
				setTimeout( function() {
					value['background-color'] = picker.val();
					control.saveValue( value );
				}, 100 );
			}
		});

		// Background-Repeat.
		control.container.on( 'change', '.background-repeat select', function() {
			value['background-repeat'] = jQuery( this ).val();
			control.saveValue( value );
		});

		// Background-Repeat.
		control.container.on( 'change', '.background-size select', function() {
			value['background-size'] = jQuery( this ).val();
			control.saveValue( value );
		});

		// Background-Repeat.
		control.container.on( 'change', '.background-position select', function() {
			value['background-position'] = jQuery( this ).val();
			control.saveValue( value );
		});

		// Background-Image.
		jQuery( '.background-image-upload-button' ).click( function( e ) {
			var image = wp.media({ multiple: false }).open().on( 'select', function( e ) {

					// This will return the selected image from the Media Uploader, the result is an object.
					var uploadedImage = image.state().get( 'selection' ).first(),
					    previewImage   = uploadedImage.toJSON().sizes.full.url,
					    imageUrl,
					    imageID,
					    imageWidth,
					    imageHeight,
					    preview,
					    removeButton;

					if ( 'undefined' !== typeof uploadedImage.toJSON().sizes.medium ) {
						previewImage = uploadedImage.toJSON().sizes.medium.url;
					} else if ( 'undefined' !== typeof uploadedImage.toJSON().sizes.thumbnail ) {
						previewImage = uploadedImage.toJSON().sizes.thumbnail.url;
					}

					imageUrl    = uploadedImage.toJSON().sizes.full.url;
					imageID     = uploadedImage.toJSON().id;
					imageWidth  = uploadedImage.toJSON().width;
					imageHeight = uploadedImage.toJSON().height;

					value['background-image'] = imageUrl;
					control.saveValue( value );
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

		jQuery( '.background-image-upload-remove-button' ).click( function( e ) {

			var preview,
			    removeButton;

			e.preventDefault();

			value['background-image'] = '';
			control.saveValue( value );

			preview      = control.container.find( '.placeholder, .thumbnail' );
			removeButton = control.container.find( '.background-image-upload-remove-button' );

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
				if ( 'undefined' !== typeof control.setting._value[ param ] ) {
					value[ param ] = control.setting._value[ param ];
				}
			}
		});
		_.each( control.setting._value, function( subValue, param ) {
			if ( undefined === value[ param ] || 'undefined' === typeof value[ param ] ) {
				value[ param ] = subValue;
			}
		});
		return value;
	},

	/**
	 * Saves the value.
	 */
	saveValue: function( value ) {

		'use strict';

		var control  = this,
			newValue = {};

		_.each( value, function( newSubValue, i ) {
			newValue[ i ] = newSubValue;
		});

		control.setting.set( newValue );
	}

});
