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

		image: {

			/**
			 * Get the HTML for image inputs.
			 *
			 * @since 3.0.17
			 * @param {Object} data - The arguments.
			 * @returns {string}
			 */
			getTemplate: function( data ) {
				var html   = '',
					saveAs = 'url',
					url;

				data = _.defaults( data, {
					label: '',
					description: '',
					inputAttrs: '',
					'data-id': '',
					choices: {},
					value: ''
				} );

				if ( ! _.isUndefined( data.choices ) && ! _.isUndefined( data.choices.save_as ) ) {
					saveAs = data.choices.save_as;
				}
				url = data.value;
				if ( _.isObject( data.value ) && ! _.isUndefined( data.value.url ) ) {
					url = data.value.url;
				}

				html += '<label>';
				if ( data.label ) {
					html += '<span class="customize-control-title">' + data.label + '</span>';
				}
				if ( data.description ) {
					html += '<span class="description customize-control-description">' + data.description + '</span>';
				}
				html += '</label>';
				html += '<div class="image-wrapper attachment-media-view image-upload">';
				if ( data.value.url || '' !== url ) {
					html += '<div class="thumbnail thumbnail-image"><img src="' + url + '" alt="" /></div>';
				} else {
					html += '<div class="placeholder">' + kirkiL10n.noFileSelected + '</div>';
				}
				html += '<div class="actions">';
				html += '<button class="button image-upload-remove-button' + ( '' === url ? ' hidden' : '' ) + '">' + kirkiL10n.remove + '</button>';
				if ( data.default && '' !== data.default ) {
					html += '<button type="button" class="button image-default-button"';
					if ( data.default === data.value || ( ! _.isUndefined( data.value.url ) && data.default === data.value.url ) ) {
						html += ' style="display:none;"';
					}
					html += '>' + kirkiL10n.default + '</button>';
				}
				html += '<button type="button" class="button image-upload-button">' + kirkiL10n.selectFile + '</button>';
				html += '</div></div>';

				return '<div class="kirki-input-container" data-id="' + data.id + '">' + html + '</div>';
			},

			/**
			 * Init the control.
			 *
			 * @since 3.0.17
			 * @param {Object} control - The control object.
			 * @returns {null}
			 */
			init: function( control ) {
			}
		}
	}
} );
