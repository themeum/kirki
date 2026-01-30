wp.customize.controlConstructor['kirki-image'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function( control ) {
		var value, saveAs, preview, previewImage, removeButton, defaultButton, container;
		control       = control || this;
		container     = control.container[0] || control.container;
		value         = control.setting._value;
		saveAs        = ( ! _.isUndefined( control.params.choices ) && ! _.isUndefined( control.params.choices.save_as ) ) ? control.params.choices.save_as : 'url';
		preview       = container.querySelector( '.placeholder, .thumbnail' );
		previewImage  = ( 'array' === saveAs ) ? value.url : value;
		removeButton  = container.querySelector( '.image-upload-remove-button' );
		defaultButton = container.querySelector( '.image-default-button' );

		// Helper function to update preview element.
		var updatePreview = function( element, imageUrl, className ) {
			if ( element ) {
				element.className = className;
				element.innerHTML = '<img src="' + imageUrl + '" alt="" />';
			}
		};

		// Helper function to show/hide elements (matching jQuery .show()/.hide() behavior).
		var toggleElement = function( element, show ) {
			if ( element ) {
				if ( show ) {
					// Remove hidden class if present (from template).
					element.classList.remove( 'hidden' );
					// Remove inline display style to show element.
					element.style.display = '';
				} else {
					// Add hidden class for consistency with template.
					element.classList.add( 'hidden' );
					// Also set inline display to ensure it's hidden.
					element.style.display = 'none';
				}
			}
		};

		// Make sure value is properly formatted.
		value = ( 'array' === saveAs && _.isString( value ) ) ? { url: value } : value;

		// Tweaks for save_as = id.
		if ( ( 'id' === saveAs || 'ID' === saveAs ) && '' !== value ) {
			wp.media.attachment( value ).fetch().then( function() {
				setTimeout( function() {
					var url = wp.media.attachment( value ).get( 'url' );
					updatePreview( preview, url, 'thumbnail thumbnail-image' );
				}, 700 );
			} );
		}

		// If value is not empty, hide the "default" button.
		if ( ( 'url' === saveAs && '' !== value ) || ( 'array' === saveAs && ! _.isUndefined( value.url ) && '' !== value.url ) ) {
			var defaultBtn = container.querySelector( '.image-default-button' );
			toggleElement( defaultBtn, false );
		}

		// If value is empty, hide the "remove" button.
		if ( ( 'url' === saveAs && '' === value ) || ( 'array' === saveAs && ( _.isUndefined( value.url ) || '' === value.url ) ) ) {
			toggleElement( removeButton, false );
		}

		// If value is default, hide the default button.
		if ( value === control.params.default ) {
			var defaultBtn = container.querySelector( '.image-default-button' );
			toggleElement( defaultBtn, false );
		}

		if ( '' !== previewImage ) {
			updatePreview( preview, previewImage, 'thumbnail thumbnail-image' );
		}

		// Handle image upload button click using event delegation.
		container.addEventListener( 'click', function( e ) {
			var uploadButton = e.target.closest( '.image-upload-button' );
			if ( uploadButton ) {
				e.preventDefault();

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

					// Update preview after setting value.
					preview = container.querySelector( '.placeholder, .thumbnail' );
					removeButton = container.querySelector( '.image-upload-remove-button' );
					defaultButton = container.querySelector( '.image-default-button' );

					if ( preview ) {
						updatePreview( preview, previewImage, 'thumbnail thumbnail-image' );
					}
					if ( removeButton ) {
						toggleElement( removeButton, true );
						toggleElement( defaultButton, false );
					}
				} );
			}
		} );

		// Handle remove button click using event delegation.
		container.addEventListener( 'click', function( e ) {
			var removeBtn = e.target.closest( '.image-upload-remove-button' );
			if ( removeBtn ) {
				e.preventDefault();

				control.setting.set( '' );

				preview       = container.querySelector( '.placeholder, .thumbnail' );
				removeButton  = container.querySelector( '.image-upload-remove-button' );
				defaultButton = container.querySelector( '.image-default-button' );

				if ( preview ) {
					preview.className = 'placeholder';
					preview.innerHTML = wp.i18n.__( 'No image selected', 'kirki' );
				}
				if ( removeButton ) {
					toggleElement( removeButton, false );
					if ( defaultButton && defaultButton.classList.contains( 'button' ) ) {
						toggleElement( defaultButton, true );
					}
				}
			}
		} );

		// Handle default button click using event delegation.
		container.addEventListener( 'click', function( e ) {
			var defaultBtn = e.target.closest( '.image-default-button' );
			if ( defaultBtn ) {
				e.preventDefault();

				control.setting.set( control.params.default );

				preview       = container.querySelector( '.placeholder, .thumbnail' );
				removeButton  = container.querySelector( '.image-upload-remove-button' );
				defaultButton = container.querySelector( '.image-default-button' );

				if ( preview ) {
					updatePreview( preview, control.params.default, 'thumbnail thumbnail-image' );
				}
				if ( removeButton ) {
					toggleElement( removeButton, true );
					toggleElement( defaultButton, false );
				}
			}
		} );
	}
} );
