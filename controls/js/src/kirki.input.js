/* global kirkiL10n */
var kirki = kirki || {};
kirki = jQuery.extend( kirki, {

	/**
	 * An object containing definitions for input fields.
	 *
	 * @since 3.0.16
	 */
	input: {

		/**
		 * Radio input fields.
		 *
		 * @since 3.0.17
		 */
		radio: {

			/**
			 * Init the control.
			 *
			 * @since 3.0.17
			 * @param {Object} control - The control object.
			 * @param {Object} control.id - The setting.
			 * @returns {null}
			 */
			init: function( control ) {
				var input = jQuery( 'input[data-id="' + control.id + '"]' );

				// Save the value
				input.on( 'change keyup paste click', function() {
					kirki.setting.set( control.id, jQuery( this ).val() );
				} );
			}
		},

		/**
		 * Color input fields.
		 *
		 * @since 3.0.16
		 */
		color: {

			/**
			 * Init the control.
			 *
			 * @since 3.0.16
			 * @param {Object} control - The control object.
			 * @param {Object} control.id - The setting.
			 * @param {Object} control.choices - Additional options for the colorpickers.
			 * @param {Object} control.params - Control parameters.
			 * @param {Object} control.params.choices - alias for control.choices.

			 * @returns {null}
			 */
			init: function( control ) {
				var picker = jQuery( '.kirki-color-control[data-id="' + control.id + '"]' ),
					clear;

				control.choices = control.choices || {};
				if ( _.isEmpty( control.choices ) && control.params.choices ) {
					control.choices = control.params.choices;
				}

				// If we have defined any extra choices, make sure they are passed-on to Iris.
				if ( ! _.isEmpty( control.choices ) ) {
					picker.wpColorPicker( control.choices );
				}

				// Tweaks to make the "clear" buttons work.
				setTimeout( function() {
					clear = jQuery( '.kirki-input-container[data-id="' + control.id + '"] .wp-picker-clear' );
					if ( clear.length ) {
						clear.click( function() {
							kirki.setting.set( control.id, '' );
						} );
					}
				}, 200 );

				// Saves our settings to the WP API
				picker.wpColorPicker( {
					change: function() {

						// Small hack: the picker needs a small delay
						setTimeout( function() {
							kirki.setting.set( control.id, picker.val() );
						}, 20 );
					}
				} );
			}
		},

		/**
		 * Generic input fields.
		 *
		 * @since 3.0.17
		 */
		genericInput: {

			/**
			 * Init the control.
			 *
			 * @since 3.0.17
			 * @param {Object} control - The control object.
			 * @param {Object} control.id - The setting.
			 * @returns {null}
			 */
			init: function( control ) {
				var input = jQuery( 'input[data-id="' + control.id + '"]' );

				// Save the value
				input.on( 'change keyup paste click', function() {
					kirki.setting.set( control.id, jQuery( this ).val() );
				} );
			}
		},

		/**
		 * Generic input fields.
		 *
		 * @since 3.0.17
		 */
		textarea: {

			/**
			 * Init the control.
			 *
			 * @since 3.0.17
			 * @param {Object} control - The control object.
			 * @param {Object} control.id - The setting.
			 * @returns {null}
			 */
			init: function( control ) {
				var textarea = jQuery( 'textarea[data-id="' + control.id + '"]' );

				// Save the value
				textarea.on( 'change keyup paste click', function() {
					kirki.setting.set( control.id, jQuery( this ).val() );
				} );
			}
		},

		select: {

			/**
			 * Init the control.
			 *
			 * @since 3.0.17
			 * @param {Object} control - The control object.
			 * @param {Object} control.id - The setting.
			 * @returns {null}
			 */
			init: function( control ) {
				var element  = jQuery( 'select[data-id="' + control.id + '"]' ),
					multiple = parseInt( element.data( 'multiple' ), 10 ),
					selectValue,
					selectWooOptions = {
						escapeMarkup: function( markup ) {
							return markup;
						}
					};
					if ( control.params.placeholder ) {
						selectWooOptions.placeholder = control.params.placeholder;
						selectWooOptions.allowClear = true;
					}

				if ( 1 < multiple ) {
					selectWooOptions.maximumSelectionLength = multiple;
				}
				jQuery( element ).selectWoo( selectWooOptions ).on( 'change', function() {
					selectValue = jQuery( this ).val();
					selectValue = ( null === selectValue && 1 < multiple ) ? [] : selectValue;
					kirki.setting.set( control.id, selectValue );
				} );
			}
		},

		/**
		 * Number fields.
		 *
		 * @since 3.0.26
		 */
		number: {

			/**
			 * Init the control.
			 *
			 * @since 3.0.17
			 * @param {Object} control - The control object.
			 * @param {Object} control.id - The setting.
			 * @returns {null}
			 */
			init: function( control ) {

				var element = jQuery( 'input[data-id="' + control.id + '"]' ),
					value   = control.setting._value,
					up,
					down;

				// Make sure we use default values if none are define for some arguments.
				control.params.choices = _.defaults( control.params.choices, {
					min: 0,
					max: 100,
					step: 1
				} );

				// Make sure we have a valid value.
				if ( isNaN( value ) || '' === value ) {
					value = ( 0 > control.params.choices.min && 0 < control.params.choices.max ) ? 0 : control.params.choices.min;
				}
				value = parseFloat( value );

				// If step is 'any', set to 0.001.
				control.params.choices.step = ( 'any' === control.params.choices.step ) ? 0.001 : control.params.choices.step;

				// Make sure choices are properly formtted as numbers.
				control.params.choices.min  = parseFloat( control.params.choices.min );
				control.params.choices.max  = parseFloat( control.params.choices.max );
				control.params.choices.step = parseFloat( control.params.choices.step );

				up   = jQuery( '.kirki-input-container[data-id="' + control.id + '"] .plus' );
				down = jQuery( '.kirki-input-container[data-id="' + control.id + '"] .minus' );

				up.click( function() {
					var oldVal = parseFloat( element.val() ),
						newVal;

					newVal = ( oldVal >= control.params.choices.max ) ? oldVal : oldVal + control.params.choices.step;

					element.val( newVal );
					element.trigger( 'change' );
				} );

				down.click( function() {
					var oldVal = parseFloat( element.val() ),
						newVal;

					newVal = ( oldVal <= control.params.choices.min ) ? oldVal : oldVal - control.params.choices.step;

					element.val( newVal );
					element.trigger( 'change' );
				} );

				element.on( 'change keyup paste click', function() {
					kirki.setting.set( control.id, jQuery( this ).val() );
				} );
			}

		},

		/**
		 * Image fields.
		 *
		 * @since 3.0.34
		 */
		image: {

			/**
			 * Init the control.
			 *
			 * @since 3.0.34
			 * @param {Object} control - The control object.
			 * @returns {null}
			 */
			init: function( control ) {
				var value         = kirki.setting.get( control.id ),
					saveAs        = ( ! _.isUndefined( control.params.choices ) && ! _.isUndefined( control.params.choices.save_as ) ) ? control.params.choices.save_as : 'url',
					preview       = control.container.find( '.placeholder, .thumbnail' ),
					previewImage  = ( 'array' === saveAs ) ? value.url : value,
					removeButton  = control.container.find( '.image-upload-remove-button' ),
					defaultButton = control.container.find( '.image-default-button' );

				// Make sure value is properly formatted.
				value = ( 'array' === saveAs && _.isString( value ) ) ? { url: value } : value;

				control.container.find( '.kirki-controls-loading-spinner' ).hide();

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
							jsonImg       = uploadedImage.toJSON(),
							previewImage  = jsonImg.url;

						if ( ! _.isUndefined( jsonImg.sizes ) ) {
							previewImg = jsonImg.sizes.full.url;
							if ( ! _.isUndefined( jsonImg.sizes.medium ) ) {
								previewImage = jsonImg.sizes.medium.url;
							} else if ( ! _.isUndefined( jsonImg.sizes.thumbnail ) ) {
								previewImage = jsonImg.sizes.thumbnail.url;
							}
						}

						if ( 'array' === saveAs ) {
							kirki.setting.set( control.id, {
								id: jsonImg.id,
								url: jsonImg.sizes.full.url,
								width: jsonImg.width,
								height: jsonImg.height
							} );
						} else if ( 'id' === saveAs ) {
							kirki.setting.set( control.id, jsonImg.id );
						} else {
							kirki.setting.set( control.id, ( ( ! _.isUndefined( jsonImg.sizes ) ) ? jsonImg.sizes.full.url : jsonImg.url ) );
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

					var preview,
						removeButton,
						defaultButton;

					e.preventDefault();

					kirki.setting.set( control.id, '' );

					preview       = control.container.find( '.placeholder, .thumbnail' );
					removeButton  = control.container.find( '.image-upload-remove-button' );
					defaultButton = control.container.find( '.image-default-button' );

					if ( preview.length ) {
						preview.removeClass().addClass( 'placeholder' ).html( kirkiL10n.noFileSelected );
					}
					if ( removeButton.length ) {
						removeButton.hide();
						if ( jQuery( defaultButton ).hasClass( 'button' ) ) {
							defaultButton.show();
						}
					}
				} );

				control.container.on( 'click', '.image-default-button', function( e ) {

					var preview,
						removeButton,
						defaultButton;

					e.preventDefault();

					kirki.setting.set( control.id, control.params.default );

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
		}
	}
} );
