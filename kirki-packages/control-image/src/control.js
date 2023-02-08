wp.customize.controlConstructor['kirki-image'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function( control ) {
		var value, saveAs, preview, previewImage, removeButton, defaultButton;
		control       = control || this;
		value         = control.setting._value;
		saveAs        = ( ! _.isUndefined( control.params.choices ) && ! _.isUndefined( control.params.choices.save_as ) ) ? control.params.choices.save_as : 'url';
		preview       = control.container.find( '.placeholder, .thumbnail' );
		previewImage  = ( 'array' === saveAs ) ? value.url : value;
		removeButton  = control.container.find( '.image-upload-remove-button' );
		defaultButton = control.container.find( '.image-default-button' );

		// Make sure value is properly formatted.
		value = ( 'array' === saveAs && _.isString( value ) ) ? { url: value } : value;

		// Tweaks for save_as = id.
		if ( ( 'id' === saveAs || 'ID' === saveAs ) && '' !== value ) {
			wp.media.attachment( value ).fetch().then( function() {
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
		if ( value === control.params.default ) {
			control.container.find( 'image-default-button' ).hide();
		}

		if ( '' !== previewImage ) {
			preview.removeClass().addClass( 'thumbnail thumbnail-image' ).html( '<img src="' + previewImage + '" alt="" />' );
		}

		control.container.on( 'click', '.image-upload-button', function( e ) {
			var image = wp.media( { multiple: false } ).open().on( 'select', function() {

				// This will return the selected image from the Media Uploader, the result is an object.
				var uploadedImage = image.state().get( 'selection' ).first(),
					jsonImg       = uploadedImage.toJSON();

				previewImage  = jsonImg.url;

				if ( ! _.isUndefined( jsonImg.sizes ) ) {
					previewImage = jsonImg.sizes.full.url;
					if ( ! _.isUndefined( jsonImg.sizes.medium ) ) {
						previewImage = jsonImg.sizes.medium.url;
					} else if ( ! _.isUndefined( jsonImg.sizes.thumbnail ) ) {
						previewImage = jsonImg.sizes.thumbnail.url;
					}
				}

				if ( 'array' === saveAs ) {
					control.setting.set( {
						id: jsonImg.id,
						url: !_.isUndefined(jsonImg.sizes)
							? jsonImg.sizes.full.url
							: jsonImg.url,
						width: jsonImg.width,
						height: jsonImg.height,
					} );
				} else if ( 'id' === saveAs ) {
					control.setting.set( jsonImg.id );
				} else {
					control.setting.set( ( ! _.isUndefined( jsonImg.sizes ) ) ? jsonImg.sizes.full.url : jsonImg.url );
				}

				if ( preview.length ) {
					preview.removeClass().addClass( 'thumbnail thumbnail-image' ).html( '<img src="' + previewImage + '" alt="" />' );
				}
				if ( removeButton.length ) {
					removeButton.show();
					defaultButton.hide();
				}
			} );

			e.preventDefault();
		} );

		control.container.on( 'click', '.image-upload-remove-button', function( e ) {
			e.preventDefault();

			control.setting.set( '' );

			preview       = control.container.find( '.placeholder, .thumbnail' );
			removeButton  = control.container.find( '.image-upload-remove-button' );
			defaultButton = control.container.find( '.image-default-button' );

			if ( preview.length ) {
				preview.removeClass().addClass( 'placeholder' ).html( wp.i18n.__( 'No image selected', 'kirki' ) );
			}
			if ( removeButton.length ) {
				removeButton.hide();
				if ( jQuery( defaultButton ).hasClass( 'button' ) ) {
					defaultButton.show();
				}
			}
		} );

		control.container.on( 'click', '.image-default-button', function( e ) {
			e.preventDefault();

			control.setting.set( control.params.default );

			preview       = control.container.find( '.placeholder, .thumbnail' );
			removeButton  = control.container.find( '.image-upload-remove-button' );
			defaultButton = control.container.find( '.image-default-button' );

			if ( preview.length ) {
				preview.removeClass().addClass( 'thumbnail thumbnail-image' ).html( '<img src="' + control.params.default + '" alt="" />' );
			}
			if ( removeButton.length ) {
				removeButton.show();
				defaultButton.hide();
			}
		} );
	}
} );
