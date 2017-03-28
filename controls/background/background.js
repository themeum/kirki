wp.customize.controlConstructor['kirki-background'] = wp.customize.Control.extend({

	ready: function() {

		var control = this,
		    value   = {},
		    picker  = this.container.find( '.kirki-color-control' );

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
					var uploadedImage = image.state().get('selection').first(),
					    previewImage   = uploadedImage.toJSON().sizes.full.url,
					    imageUrl,
					    imageID,
					    imageWidth,
					    imageHeight,
					    preview,
					    removeButton;

					if ( undefined !== uploadedImage.toJSON().sizes.medium ) {
						previewImage = uploadedImage.toJSON().sizes.medium.url;
					} else if ( undefined !== uploadedImage.toJSON().sizes.thumbnail ) {
						previewImage = uploadedImage.toJSON().sizes.thumbnail.url;
					}

					imageUrl    = uploadedImage.toJSON().sizes.full.url;
					imageID     = uploadedImage.toJSON().id;
					imageWidth  = uploadedImage.toJSON().width;
					imageHeight = uploadedImage.toJSON().height;

					value['background-image'] = imageUrl;
					control.saveValue( value );

					preview      = jQuery( this ).parents( '.background-image-upload' ).find( '.placeholder, .thumbnail' );
					removeButton = jQuery( this ).parents( '.background-image-upload' ).find( '.background-image-upload-remove-button' );

					if ( previewImage.length ) {
						preview.removeClass().addClass( 'thumbnail thumbnail-image' ).html( '<img src="' + previewImage + '" alt="" />' );
					}
					if ( removeButton.length ) {
						removeButton.show();
					}
			    });

			e.preventDefault();
		});

		jQuery( 'background-image-upload-remove-button' ).click( function( e ) {

			var preview;

			e.preventDefault();
			jQuery( this ).parents( '.background-image-upload' ).find( 'input.url' ).val( '' ).trigger( 'change' );
			preview = jQuery( this ).parents( '.background-image-upload' ).find( '.thumbnail' );
			if ( preview.length ) {
				preview.removeClass().addClass( 'placeholder' ).html( 'No file selected' );
			}
			jQuery( this ).hide();
		});
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
