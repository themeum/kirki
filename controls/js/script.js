/* jshint -W079 */
/* jshint unused:false */
if ( _.isUndefined( window.kirkiSetSettingValue ) ) {
	var kirkiSetSettingValue = { // eslint-disable-line vars-on-top

		/**
		 * Set the value of the control.
		 *
		 * @since 3.0.0
		 * @param string setting The setting-ID.
		 * @param mixed  value   The value.
		 */
		set: function( setting, value ) {

			/**
			 * Get the control of the sub-setting.
			 * This will be used to get properties we need from that control,
			 * and determine if we need to do any further work based on those.
			 */
			var $this = this,
				subControl = wp.customize.settings.controls[ setting ],
				valueJSON;

			// If the control doesn't exist then return.
			if ( _.isUndefined( subControl ) ) {
				return true;
			}

			// First set the value in the wp object. The control type doesn't matter here.
			$this.setValue( setting, value );

			// Process visually changing the value based on the control type.
			switch ( subControl.type ) {

				case 'kirki-background':
					if ( ! _.isUndefined( value['background-color'] ) ) {
						$this.setColorPicker( $this.findElement( setting, '.kirki-color-control' ), value['background-color'] );
					}
					$this.findElement( setting, '.placeholder, .thumbnail' ).removeClass().addClass( 'placeholder' ).html( 'No file selected' );
					_.each( [ 'background-repeat', 'background-position' ], function( subVal ) {
						if ( ! _.isUndefined( value[ subVal ] ) ) {
							$this.setSelectWoo( $this.findElement( setting, '.' + subVal + ' select' ), value[ subVal ] );
						}
					} );
					_.each( [ 'background-size', 'background-attachment' ], function( subVal ) {
						jQuery( $this.findElement( setting, '.' + subVal + ' input[value="' + value + '"]' ) ).prop( 'checked', true );
					} );
					valueJSON = JSON.stringify( value ).replace( /'/g, '&#39' );
					jQuery( $this.findElement( setting, '.background-hidden-value' ).attr( 'value', valueJSON ) ).trigger( 'change' );
					break;

				case 'kirki-code':
					jQuery( $this.findElement( setting, '.CodeMirror' ) )[0].CodeMirror.setValue( value );
					break;

				case 'checkbox':
				case 'kirki-switch':
				case 'kirki-toggle':
					value = ( 1 === value || '1' === value || true === value ) ? true : false;
					jQuery( $this.findElement( setting, 'input' ) ).prop( 'checked', value );
					wp.customize.instance( setting ).set( value );
					break;

				case 'kirki-select':
				case 'kirki-fontawesome':
					$this.setSelectWoo( $this.findElement( setting, 'select' ), value );
					break;

				case 'kirki-slider':
					jQuery( $this.findElement( setting, 'input' ) ).prop( 'value', value );
					jQuery( $this.findElement( setting, '.kirki_range_value .value' ) ).html( value );
					break;

				case 'kirki-generic':
					if ( _.isUndefined( subControl.choices ) || _.isUndefined( subControl.choices.element ) ) {
						subControl.choices.element = 'input';
					}
					jQuery( $this.findElement( setting, subControl.choices.element ) ).prop( 'value', value );
					break;

				case 'kirki-color':
					$this.setColorPicker( $this.findElement( setting, '.kirki-color-control' ), value );
					break;

				case 'kirki-multicheck':
					$this.findElement( setting, 'input' ).each( function() {
						jQuery( this ).prop( 'checked', false );
					} );
					_.each( value, function( subValue, i ) {
						jQuery( $this.findElement( setting, 'input[value="' + value[ i ] + '"]' ) ).prop( 'checked', true );
					} );
					break;

				case 'kirki-multicolor':
					_.each( value, function( subVal, index ) {
						$this.setColorPicker( $this.findElement( setting, '.multicolor-index-' + index ), subVal );
					} );
					break;

				case 'kirki-radio-buttonset':
				case 'kirki-radio-image':
				case 'kirki-radio':
				case 'kirki-dashicons':
				case 'kirki-color-palette':
				case 'kirki-palette':
					jQuery( $this.findElement( setting, 'input[value="' + value + '"]' ) ).prop( 'checked', true );
					break;

				case 'kirki-typography':
					_.each( [ 'font-family', 'variant' ], function( subVal ) {
						if ( ! _.isUndefined( value[ subVal ] ) ) {
							$this.setSelectWoo( $this.findElement( setting, '.' + subVal + ' select' ), value[ subVal ] );
						}
					} );
					_.each( [ 'font-size', 'line-height', 'letter-spacing', 'word-spacing' ], function( subVal ) {
						if ( ! _.isUndefined( value[ subVal ] ) ) {
							jQuery( $this.findElement( setting, '.' + subVal + ' input' ) ).prop( 'value', value[ subVal ] );
						}
					} );

					if ( ! _.isUndefined( value.color ) ) {
						$this.setColorPicker( $this.findElement( setting, '.kirki-color-control' ), value.color );
					}
					valueJSON = JSON.stringify( value ).replace( /'/g, '&#39' );
					jQuery( $this.findElement( setting, '.typography-hidden-value' ).attr( 'value', valueJSON ) ).trigger( 'change' );
					break;

				case 'kirki-dimensions':
					_.each( value, function( subValue, id ) {
						jQuery( $this.findElement( setting, '.' + id + ' input' ) ).prop( 'value', subValue );
					} );
					break;

				case 'kirki-repeater':

					// Not yet implemented.
					break;

				case 'kirki-custom':

					// Do nothing.
					break;
				default:
					jQuery( $this.findElement( setting, 'input' ) ).prop( 'value', value );
			}
		},

		/**
		 * Set the value for colorpickers.
		 * CAUTION: This only sets the value visually, it does not change it in th wp object.
		 *
		 * @since 3.0.0
		 * @param object selector jQuery object for this element.
		 * @param string value    The value we want to set.
		 */
		setColorPicker: function( selector, value ) {
			selector.attr( 'data-default-color', value ).data( 'default-color', value ).wpColorPicker( 'color', value );
		},

		/**
		 * Sets the value in a selectWoo element.
		 * CAUTION: This only sets the value visually, it does not change it in th wp object.
		 *
		 * @since 3.0.0
		 * @param string selector The CSS identifier for this selectWoo.
		 * @param string value    The value we want to set.
		 */
		setSelectWoo: function( selector, value ) {
			jQuery( selector ).selectWoo().val( value ).trigger( 'change' );
		},

		/**
		 * Sets the value in textarea elements.
		 * CAUTION: This only sets the value visually, it does not change it in th wp object.
		 *
		 * @since 3.0.0
		 * @param string selector The CSS identifier for this textarea.
		 * @param string value    The value we want to set.
		 */
		setTextarea: function( selector, value ) {
			jQuery( selector ).prop( 'value', value );
		},

		/**
		 * Finds an element inside this control.
		 *
		 * @since 3.0.0
		 * @param string setting The setting ID.
		 * @param string element The CSS identifier.
		 */
		findElement: function( setting, element ) {
			return wp.customize.control( setting ).container.find( element );
		},

		/**
		 * Updates the value in the wp.customize object.
		 *
		 * @since 3.0.0
		 * @param string setting The setting-ID.
		 * @param mixed  value   The value.
		 */
		setValue: function( setting, value, timeout ) {
			timeout = ( _.isUndefined( timeout ) ) ? 100 : parseInt( timeout, 10 );
			wp.customize.instance( setting ).set( {} );
			setTimeout( function() {
				wp.customize.instance( setting ).set( value );
			}, timeout );
		}
	};
}
var kirki = {

	initialized: false,

	/**
	 * Initialize the object.
	 *
	 * @since 3.0.17
	 * @returns {null}
	 */
	initialize: function() {
		var self = this;

		// We only need to initialize once.
		if ( self.initialized ) {
			return;
		}

		setTimeout( function() {
			kirki.util.webfonts.standard.initialize();
			kirki.util.webfonts.google.initialize();
		}, 150 );

		// Mark as initialized.
		self.initialized = true;
	}
};

// Initialize the kirki object.
kirki.initialize();
var kirki = kirki || {};
kirki = jQuery.extend( kirki, {

	/**
	 * An object containing definitions for controls.
	 *
	 * @since 3.0.16
	 */
	control: {

		/**
		 * The radio control.
		 *
		 * @since 3.0.17
		 */
		'kirki-radio': {

			/**
			 * Init the control.
			 *
			 * @since 3.0.17
			 * @param {Object} control - The customizer control object.
			 * @returns {null}
			 */
			init: function( control ) {
				var self = this;

				// Render the template.
				self.template( control );

				// Init the control.
				kirki.input.radio.init( control );

			},

			/**
			 * Render the template.
			 *
			 * @since 3.0.17
			 * @param {Object} control - The customizer control object.
			 * @param {Object} control.params - The control parameters.
			 * @param {string} control.params.label - The control label.
			 * @param {string} control.params.description - The control description.
			 * @param {string} control.params.inputAttrs - extra input arguments.
			 * @param {string} control.params.default - The default value.
			 * @param {Object} control.params.choices - Any extra choices we may need.
			 * @param {string} control.id - The setting.
			 * @returns {null}
			 */
			template: function( control ) {
				var template = wp.template( 'kirki-input-radio' );
				control.container.html( template( {
					label: control.params.label,
					description: control.params.description,
					'data-id': control.id,
					inputAttrs: control.params.inputAttrs,
					'default': control.params.default,
					value: kirki.setting.get( control.id ),
					choices: control.params.choices
				} ) );
			}
		},

		/**
		 * The color control.
		 *
		 * @since 3.0.16
		 */
		'kirki-color': {

			/**
			 * Init the control.
			 *
			 * @since 3.0.16
			 * @param {Object} control - The customizer control object.
			 * @returns {null}
			 */
			init: function( control ) {
				var self = this;

				// Render the template.
				self.template( control );

				// Init the control.
				kirki.input.color.init( control );

			},

			/**
			 * Render the template.
			 *
			 * @since 3.0.16
			 * @param {Object}     control - The customizer control object.
			 * @param {Object}     control.params - The control parameters.
			 * @param {string}     control.params.label - The control label.
			 * @param {string}     control.params.description - The control description.
			 * @param {string}     control.params.mode - The colorpicker mode. Can be 'full' or 'hue'.
			 * @param {bool|array} control.params.palette - false if we don't want a palette,
			 *                                              true to use the default palette,
			 *                                              array of custom hex colors if we want a custom palette.
			 * @param {string}     control.params.inputAttrs - extra input arguments.
			 * @param {string}     control.params.default - The default value.
			 * @param {Object}     control.params.choices - Any extra choices we may need.
			 * @param {boolean}    control.params.choices.alpha - should we add an alpha channel?
			 * @param {string}     control.id - The setting.
			 * @returns {null}
			 */
			template: function( control ) {
				var template = wp.template( 'kirki-input-color' );
				control.container.html( template( {
					label: control.params.label,
					description: control.params.description,
					'data-id': control.id,
					mode: control.params.mode,
					inputAttrs: control.params.inputAttrs,
					'data-palette': control.params.palette,
					'data-default-color': control.params.default,
					'data-alpha': control.params.choices.alpha,
					value: kirki.setting.get( control.id )
				} ) );
			}
		},

		/**
		 * The generic control.
		 *
		 * @since 3.0.16
		 */
		'kirki-generic': {

			/**
			 * Init the control.
			 *
			 * @since 3.0.17
			 * @param {Object} control - The customizer control object.
			 * @param {Object} control.params - Control parameters.
			 * @param {Object} control.params.choices - Define the specifics for this input.
			 * @param {string} control.params.choices.element - The HTML element we want to use ('input', 'div', 'span' etc).
			 * @returns {null}
			 */
			init: function( control ) {
				var self = this;

				// Render the template.
				self.template( control );

				// Init the control.
				if ( ! _.isUndefined( control.params ) && ! _.isUndefined( control.params.choices ) && ! _.isUndefined( control.params.choices.element ) && 'textarea' === control.params.choices.element ) {
					kirki.input.textarea.init( control );
					return;
				}
				kirki.input.genericInput.init( control );
			},

			/**
			 * Render the template.
			 *
			 * @since 3.0.17
			 * @param {Object}  control - The customizer control object.
			 * @param {Object}  control.params - The control parameters.
			 * @param {string}  control.params.label - The control label.
			 * @param {string}  control.params.description - The control description.
			 * @param {string}  control.params.inputAttrs - extra input arguments.
			 * @param {string}  control.params.default - The default value.
			 * @param {Object}  control.params.choices - Any extra choices we may need.
			 * @param {boolean} control.params.choices.alpha - should we add an alpha channel?
			 * @param {string}  control.id - The setting.
			 * @returns {null}
			 */
			template: function( control ) {
				var args = {
						label: control.params.label,
						description: control.params.description,
						'data-id': control.id,
						inputAttrs: control.params.inputAttrs,
						choices: control.params.choices,
						value: kirki.setting.get( control.id )
					},
					template;

				if ( ! _.isUndefined( control.params ) && ! _.isUndefined( control.params.choices ) && ! _.isUndefined( control.params.choices.element ) && 'textarea' === control.params.choices.element ) {
					template = wp.template( 'kirki-input-textarea' );
					control.container.html( template( args ) );
					return;
				}
				template = wp.template( 'kirki-input-generic' );
				control.container.html( template( args ) );
			}
		},

		/**
		 * The number control.
		 *
		 * @since 3.0.26
		 */
		'kirki-number': {

			/**
			 * Init the control.
			 *
			 * @since 3.0.26
			 * @param {Object} control - The customizer control object.
			 * @returns {null}
			 */
			init: function( control ) {
				var self = this;

				// Render the template.
				self.template( control );

				// Init the control.
				kirki.input.number.init( control );
			},

			/**
			 * Render the template.
			 *
			 * @since 3.0.27
			 * @param {Object}  control - The customizer control object.
			 * @param {Object}  control.params - The control parameters.
			 * @param {string}  control.params.label - The control label.
			 * @param {string}  control.params.description - The control description.
			 * @param {string}  control.params.inputAttrs - extra input arguments.
			 * @param {string}  control.params.default - The default value.
			 * @param {Object}  control.params.choices - Any extra choices we may need.
			 * @param {string}  control.id - The setting.
			 * @returns {null}
			 */
			template: function( control ) {
				var template = wp.template( 'kirki-input-number' );

				control.container.html(
					template( args = {
						label: control.params.label,
						description: control.params.description,
						'data-id': control.id,
						inputAttrs: control.params.inputAttrs,
						choices: control.params.choices,
						value: kirki.setting.get( control.id )
					} )
				);
			}
		},

		/**
		 * The image control.
		 *
		 * @since 3.0.34
		 */
		'kirki-image': {

			/**
			 * Init the control.
			 *
			 * @since 3.0.34
			 * @param {Object} control - The customizer control object.
			 * @returns {null}
			 */
			init: function( control ) {
				var self = this;

				// Render the template.
				self.template( control );

				// Init the control.
				kirki.input.image.init( control );
			},

			/**
			 * Render the template.
			 *
			 * @since 3.0.34
			 * @param {Object}  control - The customizer control object.
			 * @param {Object}  control.params - The control parameters.
			 * @param {string}  control.params.label - The control label.
			 * @param {string}  control.params.description - The control description.
			 * @param {string}  control.params.inputAttrs - extra input arguments.
			 * @param {string}  control.params.default - The default value.
			 * @param {Object}  control.params.choices - Any extra choices we may need.
			 * @param {string}  control.id - The setting.
			 * @returns {null}
			 */
			template: function( control ) {
				var template = wp.template( 'kirki-input-image' );

				control.container.html(
					template( args = {
						label: control.params.label,
						description: control.params.description,
						'data-id': control.id,
						inputAttrs: control.params.inputAttrs,
						choices: control.params.choices,
						value: kirki.setting.get( control.id )
					} )
				);
			}
		},

		'kirki-select': {

			/**
			 * Init the control.
			 *
			 * @since 3.0.17
			 * @param {Object} control - The customizer control object.
			 * @returns {null}
			 */
			init: function( control ) {
				var self = this;

				// Render the template.
				self.template( control );

				// Init the control.
				kirki.input.select.init( control );
			},

			/**
			 * Render the template.
			 *
			 * @since 3.0.17
			 * @param {Object}  control - The customizer control object.
			 * @param {Object}  control.params - The control parameters.
			 * @param {string}  control.params.label - The control label.
			 * @param {string}  control.params.description - The control description.
			 * @param {string}  control.params.inputAttrs - extra input arguments.
			 * @param {Object}  control.params.default - The default value.
			 * @param {Object}  control.params.choices - The choices for the select dropdown.
			 * @param {string}  control.id - The setting.
			 * @returns {null}
			 */
			template: function( control ) {
				var template = wp.template( 'kirki-input-select' );

				control.container.html( template( {
					label: control.params.label,
					description: control.params.description,
					'data-id': control.id,
					inputAttrs: control.params.inputAttrs,
					choices: control.params.choices,
					value: kirki.setting.get( control.id ),
					multiple: control.params.multiple || 1,
					placeholder: control.params.placeholder
				} ) );
			}
		},
	}
} );
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
var kirki = kirki || {};
kirki = jQuery.extend( kirki, {

	/**
	 * An object containing definitions for settings.
	 *
	 * @since 3.0.16
	 */
	setting: {

		/**
		 * Gets the value of a setting.
		 *
		 * This is a helper function that allows us to get the value of
		 * control[key1][key2] for example, when the setting used in the
		 * customizer API is "control".
		 *
		 * @since 3.0.16
		 * @param {string} setting - The setting for which we're getting the value.
		 * @returns {mixed} Depends on the value.
		 */
		get: function( setting ) {
			var parts        = setting.split( '[' ),
				foundSetting = '',
				foundInStep  = 0,
				currentVal   = '';

			_.each( parts, function( part, i ) {
				part = part.replace( ']', '' );

				if ( 0 === i ) {
					foundSetting = part;
				} else {
					foundSetting += '[' + part + ']';
				}

				if ( ! _.isUndefined( wp.customize.instance( foundSetting ) ) ) {
					currentVal  = wp.customize.instance( foundSetting ).get();
					foundInStep = i;
				}

				if ( foundInStep < i ) {
					if ( _.isObject( currentVal ) && ! _.isUndefined( currentVal[ part ] ) ) {
						currentVal = currentVal[ part ];
					}
				}
			} );

			return currentVal;
		},

		/**
		 * Sets the value of a setting.
		 *
		 * This function is a bit complicated because there any many scenarios to consider.
		 * Example: We want to save the value for my_setting[something][3][something-else].
		 * The control's setting is my_setting[something].
		 * So we need to find that first, then figure out the remaining parts,
		 * merge the values recursively to avoid destroying my_setting[something][2]
		 * and also take into account any defined "key" arguments which take this even deeper.
		 *
		 * @since 3.0.16
		 * @param {object|string} element - The DOM element whose value has changed,
		 *                                  or an ID.
		 * @param {mixed}         value - Depends on the control-type.
		 * @param {string}        key - If we only want to save an item in an object
		 *                                  we can define the key here.
		 * @returns {null}
		 */
		set: function( element, value, key ) {
			var setting,
				parts,
				currentNode   = '',
				foundNode     = '',
				subSettingObj = {},
				currentVal,
				subSetting,
				subSettingParts;

			// Get the setting from the element.
			setting = element;
			if ( _.isObject( element ) ) {
				if ( jQuery( element ).attr( 'data-id' ) ) {
					setting = element.attr( 'data-id' );
				} else {
					setting = element.parents( '[data-id]' ).attr( 'data-id' );
				}
			}

			if ( 'undefined' !== typeof wp.customize.control( setting ) ) {
				wp.customize.control( setting ).setting.set( value );
				return;
			}

			parts = setting.split( '[' );

			// Find the setting we're using in the control using the customizer API.
			_.each( parts, function( part, i ) {
				part = part.replace( ']', '' );

				// The current part of the setting.
				currentNode = ( 0 === i ) ? part : '[' + part + ']';

				// When we find the node, get the value from it.
				// In case of an object we'll need to merge with current values.
				if ( ! _.isUndefined( wp.customize.instance( currentNode ) ) ) {
					foundNode  = currentNode;
					currentVal = wp.customize.instance( foundNode ).get();
				}
			} );

			// Get the remaining part of the setting that was unused.
			subSetting = setting.replace( foundNode, '' );

			// If subSetting is not empty, then we're dealing with an object
			// and we need to dig deeper and recursively merge the values.
			if ( '' !== subSetting ) {
				if ( ! _.isObject( currentVal ) ) {
					currentVal = {};
				}
				if ( '[' === subSetting.charAt( 0 ) ) {
					subSetting = subSetting.replace( '[', '' );
				}
				subSettingParts = subSetting.split( '[' );
				_.each( subSettingParts, function( subSettingPart, i ) {
					subSettingParts[ i ] = subSettingPart.replace( ']', '' );
				} );

				// If using a key, we need to go 1 level deeper.
				if ( key ) {
					subSettingParts.push( key );
				}

				// Converting to a JSON string and then parsing that to an object
				// may seem a bit hacky and crude but it's efficient and works.
				subSettingObj = '{"' + subSettingParts.join( '":{"' ) + '":"' + value + '"' + '}'.repeat( subSettingParts.length );
				subSettingObj = JSON.parse( subSettingObj );

				// Recursively merge with current value.
				jQuery.extend( true, currentVal, subSettingObj );
				value = currentVal;

			} else {
				if ( key ) {
					currentVal = ( ! _.isObject( currentVal ) ) ? {} : currentVal;
					currentVal[ key ] = value;
					value = currentVal;
				}
			}
			wp.customize.control( foundNode ).setting.set( value );
		}
	}
} );
/* global ajaxurl */
var kirki = kirki || {};
kirki = jQuery.extend( kirki, {
	/**
	 * A collection of utility methods.
	 *
	 * @since 3.0.17
	 */
	util: {
		media_query_devices: {
			global: null,
			desktop: 0,
			tablet: 1,
			mobile: 2,
		},
		media_query_device_names: ['global', 'desktop', 'tablet', 'mobile'],
		
		/**
		 * A collection of utility methods for webfonts.
		 *
		 * @since 3.0.17
		 */
		webfonts: {

			/**
			 * Google-fonts related methods.
			 *
			 * @since 3.0.17
			 */
			google: {

				/**
				 * An object containing all Google fonts.
				 *
				 * to set this call this.setFonts();
				 *
				 * @since 3.0.17
				 */
				fonts: {},

				/**
				 * Init for google-fonts.
				 *
				 * @since 3.0.17
				 * @returns {null}
				 */
				initialize: function() {
					var self = this;

					self.setFonts();
				},

				/**
				 * Set fonts in this.fonts
				 *
				 * @since 3.0.17
				 * @returns {null}
				 */
				setFonts: function() {
					var self = this;

					// No need to run if we already have the fonts.
					if ( ! _.isEmpty( self.fonts ) ) {
						return;
					}

					// Make an AJAX call to set the fonts object (alpha).
					jQuery.post( ajaxurl, { 'action': 'kirki_fonts_google_all_get' }, function( response ) {

						// Get fonts from the JSON array.
						self.fonts = JSON.parse( response );
					} );
				},

				/**
				 * Gets all properties of a font-family.
				 *
				 * @since 3.0.17
				 * @param {string} family - The font-family we're interested in.
				 * @returns {Object}
				 */
				getFont: function( family ) {
					var self = this,
						fonts = self.getFonts();

					if ( 'undefined' === typeof fonts[ family ] ) {
						return false;
					}
					return fonts[ family ];
				},

				/**
				 * Gets all properties of a font-family.
				 *
				 * @since 3.0.17
				 * @param {string} order - How to order the fonts (alpha|popularity|trending).
				 * @param {int}    number - How many to get. 0 for all.
				 * @returns {Object}
				 */
				getFonts: function( order, category, number ) {
					var self        = this,
						ordered     = {},
						categorized = {},
						plucked     = {};

					// Make sure order is correct.
					order  = order || 'alpha';
					order  = ( 'alpha' !== order && 'popularity' !== order && 'trending' !== order ) ? 'alpha' : order;

					// Make sure number is correct.
					number = number || 0;
					number = parseInt( number, 10 );

					// Order fonts by the 'order' argument.
					if ( 'alpha' === order ) {
						ordered = jQuery.extend( {}, self.fonts.items );
					} else {
						_.each( self.fonts.order[ order ], function( family ) {
							ordered[ family ] = self.fonts.items[ family ];
						} );
					}

					// If we have a category defined get only the fonts in that category.
					if ( '' === category || ! category ) {
						categorized = ordered;
					} else {
						_.each( ordered, function( font, family ) {
							if ( category === font.category ) {
								categorized[ family ] = font;
							}
						} );
					}

					// If we only want a number of font-families get the 1st items from the results.
					if ( 0 < number ) {
						_.each( _.first( _.keys( categorized ), number ), function( family ) {
							plucked[ family ] = categorized[ family ];
						} );
						return plucked;
					}

					return categorized;
				},

				/**
				 * Gets the variants for a font-family.
				 *
				 * @since 3.0.17
				 * @param {string} family - The font-family we're interested in.
				 * @returns {Array}
				 */
				getVariants: function( family ) {
					var self = this,
						font = self.getFont( family );

					// Early exit if font was not found.
					if ( ! font ) {
						return false;
					}

					// Early exit if font doesn't have variants.
					if ( _.isUndefined( font.variants ) ) {
						return false;
					}

					// Return the variants.
					return font.variants;
				}
			},

			/**
			 * Standard fonts related methods.
			 *
			 * @since 3.0.17
			 */
			standard: {

				/**
				 * An object containing all Standard fonts.
				 *
				 * to set this call this.setFonts();
				 *
				 * @since 3.0.17
				 */
				fonts: {},

				/**
				 * Init for google-fonts.
				 *
				 * @since 3.0.17
				 * @returns {null}
				 */
				initialize: function() {
					var self = this;

					self.setFonts();
				},

				/**
				 * Set fonts in this.fonts
				 *
				 * @since 3.0.17
				 * @returns {null}
				 */
				setFonts: function() {
					var self = this;

					// No need to run if we already have the fonts.
					if ( ! _.isEmpty( self.fonts ) ) {
						return;
					}

					// Make an AJAX call to set the fonts object.
					jQuery.post( ajaxurl, { 'action': 'kirki_fonts_standard_all_get' }, function( response ) {

						// Get fonts from the JSON array.
						self.fonts = JSON.parse( response );
					} );
				},

				/**
				 * Gets the variants for a font-family.
				 *
				 * @since 3.0.17
				 * @returns {Array}
				 */
				getVariants: function() {
					return [ 'regular', 'italic', '700', '700italic' ];
				}
			},

			/**
			 * Figure out what this font-family is (google/standard)
			 *
			 * @since 3.0.20
			 * @param {string} family - The font-family.
			 * @returns {string|false} - Returns string if found (google|standard)
			 *                           and false in case the font-family is an arbitrary value
			 *                           not found anywhere in our font definitions.
			 */
			getFontType: function( family ) {
				var self = this;

				// Check for standard fonts first.
				if (
					'undefined' !== typeof self.standard.fonts[ family ] || (
						'undefined' !== typeof self.standard.fonts.stack &&
						'undefined' !== typeof self.standard.fonts.stack[ family ]
					)
				) {
					return 'standard';
				}

				// Check in googlefonts.
				if ( 'undefined' !== typeof self.google.fonts.items[ family ] ) {
					return 'google';
				}
				return false;
			}
		},

		validate: {
			cssValue: function( value ) {

				var validUnits = [ 'fr', 'rem', 'em', 'ex', '%', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ch', 'vh', 'vw', 'vmin', 'vmax' ],
					numericValue,
					unit;

				// Early exit if value is undefined.
				if ( 'undefined' === typeof value ) {
					return true;
				}

				// Whitelist values.
				if ( 0 === value || '0' === value || 'auto' === value || 'inherit' === value || 'initial' === value ) {
					return true;
				}

				// Skip checking if calc().
				if ( 0 <= value.indexOf( 'calc(' ) && 0 <= value.indexOf( ')' ) ) {
					return true;
				}

				// Get the numeric value.
				numericValue = parseFloat( value );

				// Get the unit
				unit = value.replace( numericValue, '' );

				// Allow unitless.
				if ( ! value ) {
					return;
				}

				// Check the validity of the numeric value and units.
				return ( ! isNaN( numericValue ) && -1 < jQuery.inArray( unit, validUnits ) );
			}
		},
		
		helpers: {
			media_query: function( control, init_enabled, args )
			{
				if ( _.isUndefined( control.params.choices.use_media_queries ) )
					return;
				var container = control.container,
					switcher_containers = container.find( '.kirki-respnsive-switchers' ),
					preview_desktop = jQuery( 'button.preview-desktop' ),
					preview_tablet = jQuery( 'button.preview-tablet' ),
					preview_mobile = jQuery( 'button.preview-mobile' );
				var click_query_btn = function( type )
				{
					var btns = null;
					if ( type === 'global' )
						btns = $( '.kirki-respnsive-switchers[active-device!="global"] li.desktop' );
					else
						btns = $( '.kirki-respnsive-switchers[active-device!="' + type + '"] li.' + type );
					btns.addClass( 'do-not-click' ).click();
				};
				var set_active_device = function( container, device, skip_click )
				{
					container.attr( 'active-device', device );
					if ( !skip_click )
						click_query_btn( device );
				};
				switcher_containers.each( function()
				{
					var container = $( this ),
						desktop_btn = container.find( 'li.desktop' ),
						tablet_btn = container.find( 'li.tablet' ),
						mobile_btn = container.find( 'li.mobile' ),
						active_device = 0,
						enabled = init_enabled;
					
					$( window ).on( 'breakpoint_change', function( e, type )
					{
						if ( enabled )
						{
							container.addClass( 'skip-preview' );
							$( '.kirki-respnsive-switchers[active-device!="' + type + '"] li.' + type )
								.addClass( 'do-not-click' )
								.click();
						}
					});
					
					set_active_device( container, init_enabled ? 'desktop' : 'global', true );
					desktop_btn.click( function( e )
					{
						if ( !container.hasClass( 'skip-preview' ) )
							preview_desktop.click();
						else
							container.removeClass( 'skip-preview' );
						var self = $( this );
						e.preventDefault();
						e.stopImmediatePropagation();
						if ( !tablet_btn.hasClass( 'active' ) && !mobile_btn.hasClass( 'active' ) )
						{
							desktop_btn.toggleClass( 'multiple' );
							if ( desktop_btn.hasClass( 'multiple' ) )
							{
								enabled = true;
								tablet_btn.removeClass( 'hidden' );
								mobile_btn.removeClass( 'hidden' );
							}
							else
							{
								enabled = false;
								tablet_btn.addClass( 'hidden' );
								mobile_btn.addClass( 'hidden' );
							}
							args.device_change( active_device, enabled );
							set_active_device( container, enabled ? 'desktop' : 'global', self.hasClass( 'do-not-click' ) );
						}
						else
						{
							active_device = 0;
							tablet_btn.removeClass( 'active' );
							mobile_btn.removeClass( 'active' );
							set_active_device( container, 'desktop', self.hasClass( 'do-not-click' ) );
							args.device_change( active_device, enabled );
						}
						self.removeClass( 'do-not-click' );
					});
					tablet_btn.click( function(e)
					{
						if ( !container.hasClass( 'skip-preview' ) )
							preview_tablet.click();
						else
							container.removeClass( 'skip-preview' );
						e.preventDefault();
						e.stopImmediatePropagation();
						active_device = 1;
						mobile_btn.removeClass( 'active' );
						tablet_btn.addClass( 'active' );
						set_active_device( container, 'tablet' );
						args.device_change( active_device, enabled );
					});
					mobile_btn.click( function(e)
					{
						if ( !container.hasClass( 'skip-preview' ) )
							preview_mobile.click();
						else
							container.removeClass( 'skip-preview' );
						e.preventDefault();
						e.stopImmediatePropagation();
						active_device = 2;
						mobile_btn.addClass( 'active' );
						tablet_btn.removeClass( 'active' );
						set_active_device( container, 'mobile' );
						args.device_change( active_device, enabled );
					});
					if ( init_enabled )
						desktop_btn.click();
				});
				
				preview_desktop.click( function()
				{
					container.addClass( 'skip-preview' );
					$( window ).trigger( 'breakpoint_change', ['desktop'] );
				});
				preview_tablet.click( function()
				{
					container.addClass( 'skip-preview' );
					$( window ).trigger( 'breakpoint_change', ['tablet'] );
				});
				preview_mobile.click( function()
				{
					container.addClass( 'skip-preview' );
					$( window ).trigger( 'breakpoint_change', ['mobile'] );
				});
			}
		},

		/**
		 * Parses HTML Entities.
		 *
		 * @since 3.0.34
		 * @param {string} str - The string we want to parse.
		 * @returns {string}
		 */
		parseHtmlEntities: function( str ) {
			var parser = new DOMParser,
				dom    = parser.parseFromString(
					'<!doctype html><body>' + str, 'text/html'
				);

			return dom.body.textContent;
		}
	}
} );
/* global kirki */
/**
 * The majority of the code in this file
 * is derived from the wp-customize-posts plugin
 * and the work of @westonruter to whom I am very grateful.
 *
 * @see https://github.com/xwp/wp-customize-posts
 */

( function() {
	'use strict';

	/**
	 * A dynamic color-alpha control.
	 *
	 * @class
	 * @augments wp.customize.Control
	 * @augments wp.customize.Class
	 */
	wp.customize.kirkiDynamicControl = wp.customize.Control.extend( {

		initialize: function( id, options ) {
			var control = this,
				args    = options || {};

			args.params = args.params || {};
			if ( ! args.params.type ) {
				args.params.type = 'kirki-generic';
			}
			if ( ! args.params.content ) {
				args.params.content = jQuery( '<li></li>' );
				args.params.content.attr( 'id', 'customize-control-' + id.replace( /]/g, '' ).replace( /\[/g, '-' ) );
				args.params.content.attr( 'class', 'customize-control customize-control-' + args.params.type );
			}

			control.propertyElements = [];
			wp.customize.Control.prototype.initialize.call( control, id, args );
		},

		/**
		 * Add bidirectional data binding links between inputs and the setting(s).
		 *
		 * This is copied from wp.customize.Control.prototype.initialize(). It
		 * should be changed in Core to be applied once the control is embedded.
		 *
		 * @private
		 * @returns {null}
		 */
		_setUpSettingRootLinks: function() {
			var control = this,
				nodes   = control.container.find( '[data-customize-setting-link]' );

			nodes.each( function() {
				var node = jQuery( this );

				wp.customize( node.data( 'customizeSettingLink' ), function( setting ) {
					var element = new wp.customize.Element( node );
					control.elements.push( element );
					element.sync( setting );
					element.set( setting() );
				} );
			} );
		},

		/**
		 * Add bidirectional data binding links between inputs and the setting properties.
		 *
		 * @private
		 * @returns {null}
		 */
		_setUpSettingPropertyLinks: function() {
			var control = this,
				nodes;

			if ( ! control.setting ) {
				return;
			}

			nodes = control.container.find( '[data-customize-setting-property-link]' );

			nodes.each( function() {
				var node = jQuery( this ),
					element,
					propertyName = node.data( 'customizeSettingPropertyLink' );

				element = new wp.customize.Element( node );
				control.propertyElements.push( element );
				element.set( control.setting()[ propertyName ] );

				element.bind( function( newPropertyValue ) {
					var newSetting = control.setting();
					if ( newPropertyValue === newSetting[ propertyName ] ) {
						return;
					}
					newSetting = _.clone( newSetting );
					newSetting[ propertyName ] = newPropertyValue;
					control.setting.set( newSetting );
				} );
				control.setting.bind( function( newValue ) {
					if ( newValue[ propertyName ] !== element.get() ) {
						element.set( newValue[ propertyName ] );
					}
				} );
			} );
		},

		/**
		 * @inheritdoc
		 */
		ready: function() {
			var control = this;

			control._setUpSettingRootLinks();
			control._setUpSettingPropertyLinks();

			wp.customize.Control.prototype.ready.call( control );

			control.deferred.embedded.done( function() {
				control.initKirkiControl( control );
			} );
		},

		/**
		 * Embed the control in the document.
		 *
		 * Override the embed() method to do nothing,
		 * so that the control isn't embedded on load,
		 * unless the containing section is already expanded.
		 *
		 * @returns {null}
		 */
		embed: function() {
			var control   = this,
				sectionId = control.section();

			if ( ! sectionId ) {
				return;
			}

			wp.customize.section( sectionId, function( section ) {
				if ( 'kirki-expanded' === section.params.type || section.expanded() || wp.customize.settings.autofocus.control === control.id ) {
					control.actuallyEmbed();
				} else {
					section.expanded.bind( function( expanded ) {
						if ( expanded ) {
							control.actuallyEmbed();
						}
					} );
				}
			} );
		},

		/**
		 * Deferred embedding of control when actually
		 *
		 * This function is called in Section.onChangeExpanded() so the control
		 * will only get embedded when the Section is first expanded.
		 *
		 * @returns {null}
		 */
		actuallyEmbed: function() {
			var control = this;
			if ( 'resolved' === control.deferred.embedded.state() ) {
				return;
			}
			control.renderContent();
			control.deferred.embedded.resolve(); // This triggers control.ready().
		},

		/**
		 * This is not working with autofocus.
		 *
		 * @param {object} [args] Args.
		 * @returns {null}
		 */
		focus: function( args ) {
			var control = this;
			control.actuallyEmbed();
			wp.customize.Control.prototype.focus.call( control, args );
		},

		/**
		 * Additional actions that run on ready.
		 *
		 * @param {object} [args] Args.
		 * @returns {null}
		 */
		initKirkiControl: function( control ) {
			if ( 'undefined' !== typeof kirki.control[ control.params.type ] ) {
				kirki.control[ control.params.type ].init( control );
				return;
			}

			// Save the value
			this.container.on( 'change keyup paste click', 'input', function() {
				control.setting.set( jQuery( this ).val() );
			} );
		}
	} );
}() );
_.each( kirki.control, function( obj, type ) {
	wp.customize.controlConstructor[ type ] = wp.customize.kirkiDynamicControl.extend( {} );
} );
/* global kirkiControlLoader */
wp.customize.controlConstructor['kirki-background'] = wp.customize.Control.extend( {

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

		var control = this,
			value   = control.setting._value,
			picker  = control.container.find( '.kirki-color-control' );

		// Hide unnecessary controls if the value doesn't have an image.
		if ( _.isUndefined( value['background-image'] ) || '' === value['background-image'] ) {
			control.container.find( '.background-wrapper > .background-repeat' ).hide();
			control.container.find( '.background-wrapper > .background-position' ).hide();
			control.container.find( '.background-wrapper > .background-size' ).hide();
			control.container.find( '.background-wrapper > .background-attachment' ).hide();
		}

		// Color.
		picker.wpColorPicker( {
			change: function() {
				setTimeout( function() {
					control.saveValue( 'background-color', picker.val() );
				}, 100 );
			}
		} );

		// Background-Repeat.
		control.container.on( 'change', '.background-repeat select', function() {
			control.saveValue( 'background-repeat', jQuery( this ).val() );
		} );

		// Background-Size.
		control.container.on( 'change click', '.background-size input', function() {
			control.saveValue( 'background-size', jQuery( this ).val() );
		} );

		// Background-Position.
		control.container.on( 'change', '.background-position select', function() {
			control.saveValue( 'background-position', jQuery( this ).val() );
		} );

		// Background-Attachment.
		control.container.on( 'change click', '.background-attachment input', function() {
			control.saveValue( 'background-attachment', jQuery( this ).val() );
		} );

		// Background-Image.
		control.container.on( 'click', '.background-image-upload-button', function( e ) {
			var image = wp.media( { multiple: false } ).open().on( 'select', function() {

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
			} );

			e.preventDefault();
		} );

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
		} );
	},

	/**
	 * Saves the value.
	 */
	saveValue: function( property, value ) {

		var control = this,
			input   = jQuery( '#customize-control-' + control.id.replace( '[', '-' ).replace( ']', '' ) + ' .background-hidden-value' ),
			val     = control.setting._value;

		val[ property ] = value;

		jQuery( input ).attr( 'value', JSON.stringify( val ) ).trigger( 'change' );
		control.setting.set( val );
	}
} );
wp.customize.controlConstructor['kirki-border'] = wp.customize.kirkiDynamicControl.extend( {
	
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
		var control = this,
			container = control.container,
			input = jQuery( '.border-hidden-value', container ),
			style = jQuery( '.border-type select', container),
			inputs = jQuery( '.kirki-control-dimension input', container),
			link_dims = jQuery( '.kirki-input-link', container),
			size_container = jQuery( '.size', container ),
			color_container = jQuery( '.color', container ),
			color_picker = jQuery( 'input', color_container ),
			top_input = jQuery( '[data-border-type="top"]', container ),
			right_input = jQuery( '[data-border-type="right"]', container ),
			bottom_input = jQuery( '[data-border-type="bottom"]', container ),
			left_input = jQuery( '[data-border-type="left"]', container ),
			value = control.setting._value;
		
		if ( !value && control.params.default )
		{
			value = control.params.default;
		}
		
		if ( value )
		{
			style.val ( value['border-style'] );
			top_input.val ( value['border-top'] );
			right_input.val ( value['border-right'] );
			bottom_input.val ( value['border-bottom'] );
			left_input.val ( value['border-left'] );
		}
		
		color_picker.attr( 'data-default-color', value['border-color'] )
			.data( 'default-color', value['border-color'] )
			.val( value['border-color'] )
			.wpColorPicker( {
				change: function(e, ui)
				{
					setTimeout(function()
					{
						save();
					}, 100);
				}
			});
		
		style.change( function( e ){
			e.preventDefault();
			toggle_visible();
			save();
		});

		inputs.on( 'keyup change click', function ( e ){
			var input = jQuery( this );
			var cur_val = input.val();
			var last_val = input.attr( 'last-val' );
			if ( cur_val != last_val )
			{
				input.attr( 'last-val', cur_val );
				if ( link_dims.hasClass( 'linked' ) )
				{
					inputs.attr( 'last-val', cur_val );
					inputs.val( cur_val );
				}
				save();
			}
		});

		link_dims.click( function( e )
		{
			e.preventDefault();
			link_dims.toggleClass( 'unlinked' );
			link_dims.toggleClass( 'linked' );
		});
		
		toggle_visible();
		
		function toggle_visible()
		{
			var val = style.val();
			if ( val != '' )
			{
				size_container.show();
				color_container.show();
			}
			else
			{
				size_container.hide();
				color_container.hide();
			}
		}
		
		function save()
		{
			var border_style = style.val(),
				top_val = parseInt( top_input.val() ) || 0,
				right_val = parseInt( right_input.val() ) || 0,
				bottom_val = parseInt( bottom_input.val() ) || 0,
				left_val = parseInt( left_input.val() ) || 0,
				color_val = color_picker.val();
			var new_val = {
				'border-style': border_style,
				'border-top': top_val,
				'border-right': right_val,
				'border-bottom': bottom_val,
				'border-left': left_val,
				'border-color': color_val
			};
			var json = JSON.stringify ( new_val );
			jQuery( input ).attr( 'value', json ).trigger( 'change' );
			control.setting.set( new_val );
		}
	}
} );wp.customize.controlConstructor['kirki-color-palette'] = wp.customize.kirkiDynamicControl.extend( {} );
wp.customize.controlConstructor['kirki-color-gradient'] = wp.customize.kirkiDynamicControl.extend( {
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
		var control = this,
			container = control.container,
			input = jQuery( '.color-gradient-hidden-value', container ),
			color1_picker = jQuery( '.color1 .color-picker', container ),
			color2_picker = jQuery( '.color2 .color-picker', container ),
			location = jQuery( '.location input', container ),
			textInput    = control.container.find( '.slider-wrapper .value input' ),
			sliderReset  = control.container.find( '.slider-reset' ),
			locationChangeAction = ( 'postMessage' === control.setting.transport ) ? 'mousemove change' : 'change',
			direction = container.find( '.direction select' ),
			value = control.setting._value;
		if ( !value )
			value = control.params.default;
		if ( !value )
		{
			value = {
				color1: '',
				color2: '',
				location: '0%',
				direction: ''
			};
		}
		color1_picker.attr( 'data-default-color', value['color1'] )
			.data( 'default-color', value['color1'] )
			.val( value['color1'] )
			.wpColorPicker( {
				change: function(e, ui)
				{
					setTimeout(function()
					{
						save();
					}, 100 );
				}
			});
		color2_picker.attr( 'data-default-color', value['color2'] )
			.data( 'default-color', value['color2'] )
			.val( value['color2'] )
			.wpColorPicker( {
				change: function(e, ui)
				{
					setTimeout(function()
					{
						save();
					}, 100 );
				}
			});
		location.val( value['location'].replace( '%', '' ) );
		direction.val( value['direction'] );
		
		location.on( locationChangeAction, function( e )
		{
			//e.preventDefault();
			textInput.attr( 'value', location.val() );
			save();
		});
		
		textInput.on( 'input paste change', function( e ) {
			//location.val( textInput.val() ).trigger( 'change' );
		} );
		
		direction.on( 'change', function( e ) {
			save();
		});
		
		sliderReset.click( function( e ) {
			var defVal = control.params.default['location'].replace( '%', '') || 0;
			location.val( defVal );
			textInput.val( defVal );
		});
		
		function save()
		{
			var data = {
				color1: color1_picker.val(),
				color2: color2_picker.val(),
				location: location.val() + '%',
				direction: direction.val()
			};
			//console.log( data );
			input.val( JSON.stringify( data ) ).trigger( 'change' );
			control.setting.set( data );
		}
	}
} );
wp.customize.controlConstructor['kirki-dashicons'] = wp.customize.kirkiDynamicControl.extend( {} );
wp.customize.controlConstructor['kirki-date'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function() {
		var control  = this,
			selector = control.selector + ' input.datepicker';

		// Init the datepicker
		jQuery( selector ).datepicker( {
			dateFormat: 'yy-mm-dd'
		} );

		control.container.find( '.kirki-controls-loading-spinner' ).hide();

		// Save the changes
		this.container.on( 'change keyup paste', 'input.datepicker', function() {
			control.setting.set( jQuery( this ).val() );
		} );
	}
} );
/* global dimensionkirkiL10n */
wp.customize.controlConstructor['kirki-dimension'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function() {

		var control = this,
			value;

		// Notifications.
		control.kirkiNotifications();

		// Save the value
		this.container.on( 'change keyup paste', 'input', function() {

			value = jQuery( this ).val();
			control.setting.set( value );
		} );
	},

	/**
	 * Handles notifications.
	 */
	kirkiNotifications: function() {

		var control        = this,
			acceptUnitless = ( 'undefined' !== typeof control.params.choices && 'undefined' !== typeof control.params.choices.accept_unitless && true === control.params.choices.accept_unitless );

		wp.customize( control.id, function( setting ) {
			setting.bind( function( value ) {
				var code = 'long_title';

				if ( false === kirki.util.validate.cssValue( value ) && ( ! acceptUnitless || isNaN( value ) ) ) {
					setting.notifications.add( code, new wp.customize.Notification(
						code,
						{
							type: 'warning',
							message: dimensionkirkiL10n['invalid-value']
						}
					) );
				} else {
					setting.notifications.remove( code );
				}
			} );
		} );
	}
} );
/* global dimensionskirkiL10n */
wp.customize.controlConstructor['kirki-dimensions'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function() {

		var control     = this,
			subControls = control.params.choices.controls,
			value       = {},
			subsArray   = [],
			i;

		_.each( subControls, function( v, i ) {
			if ( true === v ) {
				subsArray.push( i );
			}
		} );

		for ( i = 0; i < subsArray.length; i++ ) {
			value[ subsArray[ i ] ] = control.setting._value[ subsArray[ i ] ];
			control.updateDimensionsValue( subsArray[ i ], value );
		}
	},

	/**
	 * Updates the value.
	 */
	updateDimensionsValue: function( context, value ) {

		var control = this;

		control.container.on( 'change keyup paste', '.' + context + ' input', function() {
			value[ context ] = jQuery( this ).val();

			// Notifications.
			control.kirkiNotifications();

			// Save the value
			control.saveValue( value );
		} );
	},

	/**
	 * Saves the value.
	 */
	saveValue: function( value ) {

		var control  = this,
			newValue = {};

		_.each( value, function( newSubValue, i ) {
			newValue[ i ] = newSubValue;
		} );

		control.setting.set( newValue );
	},

	/**
	 * Handles notifications.
	 */
	kirkiNotifications: function() {

		var control = this;

		wp.customize( control.id, function( setting ) {
			setting.bind( function( value ) {
				var code = 'long_title',
					subs = {},
					message;

				setting.notifications.remove( code );

				_.each( value, function( val, direction ) {
					if ( false === kirki.util.validate.cssValue( val ) ) {
						subs[ direction ] = val;
					} else {
						delete subs[ direction ];
					}
				} );

				if ( ! _.isEmpty( subs ) ) {
					message = dimensionskirkiL10n['invalid-value'] + ' (' + _.values( subs ).toString() + ') ';
					setting.notifications.add( code, new wp.customize.Notification( code, {
						type: 'warning',
						message: message
					} ) );
					return;
				}
				setting.notifications.remove( code );
			} );
		} );
	}
} );
/* global tinyMCE */
wp.customize.controlConstructor['kirki-editor'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function() {

		var control = this,
			element = control.container.find( 'textarea' ),
			id      = 'kirki-editor-' + control.id.replace( '[', '' ).replace( ']', '' ),
			editor;

		wp.editor.initialize( id, {
			tinymce: {
				wpautop: true
			},
			quicktags: true,
			mediaButtons: true
		} );

		editor = tinyMCE.get( id );

		if ( editor ) {
			editor.onChange.add( function( ed ) {
				var content;

				ed.save();
				content = editor.getContent();
				element.val( content ).trigger( 'change' );
				wp.customize.instance( control.id ).set( content );
			} );
		}
	}
} );
/* global fontAwesomeJSON */
wp.customize.controlConstructor['kirki-fontawesome'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function() {

		var control  = this,
			element  = this.container.find( 'select' ),
			icons    = jQuery.parseJSON( fontAwesomeJSON ),
			selectValue,
			selectWooOptions = {
				data: [],
				escapeMarkup: function( markup ) {
					return markup;
				},
				templateResult: function( val ) {
					return '<i class="fa fa-lg fa-' + val.id + '" aria-hidden="true"></i>' + ' ' + val.text;
				},
				templateSelection: function( val ) {
					return '<i class="fa fa-lg fa-' + val.id + '" aria-hidden="true"></i>' + ' ' + val.text;
				}
			},
			select;

		_.each( icons.icons, function( icon ) {
			selectWooOptions.data.push( {
				id: icon.id,
				text: icon.name
			} );
		} );

		select = jQuery( element ).selectWoo( selectWooOptions );

		select.on( 'change', function() {
			selectValue = jQuery( this ).val();
			control.setting.set( selectValue );
		} );
		select.val( control.setting._value ).trigger( 'change' );
	}
} );
wp.customize.controlConstructor['kirki-multicheck'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function() {

		var control = this;

		// Save the value
		control.container.on( 'change', 'input', function() {
			var value = [],
				i = 0;

			// Build the value as an object using the sub-values from individual checkboxes.
			jQuery.each( control.params.choices, function( key ) {
				if ( control.container.find( 'input[value="' + key + '"]' ).is( ':checked' ) ) {
					control.container.find( 'input[value="' + key + '"]' ).parent().addClass( 'checked' );
					value[ i ] = key;
					i++;
				} else {
					control.container.find( 'input[value="' + key + '"]' ).parent().removeClass( 'checked' );
				}
			} );

			// Update the value in the customizer.
			control.setting.set( value );
		} );
	}
} );
/* global kirkiControlLoader */
wp.customize.controlConstructor['kirki-multicolor'] = wp.customize.Control.extend( {

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

		var control = this,
			colors  = control.params.choices,
			keys    = Object.keys( colors ),
			value   = this.params.value,
			i       = 0;

		// Proxy function that handles changing the individual colors
		function kirkiMulticolorChangeHandler( control, value, subSetting ) {

			var picker = control.container.find( '.multicolor-index-' + subSetting ),
				args   = {
					change: function() {

						// Color controls require a small delay.
						setTimeout( function() {

							// Set the value.
							control.saveValue( subSetting, picker.val() );

							// Trigger the change.
							control.container.find( '.multicolor-index-' + subSetting ).trigger( 'change' );
						}, 100 );
					}
				};

			if ( _.isObject( colors.irisArgs ) ) {
				_.each( colors.irisArgs, function( irisValue, irisKey ) {
					args[ irisKey ] = irisValue;
				} );
			}

			// Did we change the value?
			picker.wpColorPicker( args );
		}

		// Colors loop
		while ( i < Object.keys( colors ).length ) {
			kirkiMulticolorChangeHandler( this, value, keys[ i ] );
			i++;
		}
	},

	/**
	 * Saves the value.
	 */
	saveValue: function( property, value ) {

		var control = this,
			input   = control.container.find( '.multicolor-hidden-value' ),
			val     = control.setting._value;

		val[ property ] = value;

		jQuery( input ).attr( 'value', JSON.stringify( val ) ).trigger( 'change' );
		control.setting.set( val );
	}
} );
wp.customize.controlConstructor['kirki-palette'] = wp.customize.kirkiDynamicControl.extend( {} );
wp.customize.controlConstructor['kirki-radio-buttonset'] = wp.customize.kirkiDynamicControl.extend( {} );
wp.customize.controlConstructor['kirki-radio-image'] = wp.customize.kirkiDynamicControl.extend( {} );
/* global kirkiControlLoader */
var RepeaterRow = function( rowIndex, container, label, control ) {

	'use strict';

	var self        = this;
	this.rowIndex   = rowIndex;
	this.container  = container;
	this.label      = label;
	this.header     = this.container.find( '.repeater-row-header' );

	this.header.on( 'click', function() {
		self.toggleMinimize();
	} );

	this.container.on( 'click', '.repeater-row-remove', function() {
		self.remove();
	} );

	this.header.on( 'mousedown', function() {
		self.container.trigger( 'row:start-dragging' );
	} );

	this.container.on( 'keyup change', 'input, select, textarea', function( e ) {
		self.container.trigger( 'row:update', [ self.rowIndex, jQuery( e.target ).data( 'field' ), e.target ] );
	} );

	this.setRowIndex = function( rowIndex ) {
		this.rowIndex = rowIndex;
		this.container.attr( 'data-row', rowIndex );
		this.container.data( 'row', rowIndex );
		this.updateLabel();
	};

	this.toggleMinimize = function() {

		// Store the previous state.
		this.container.toggleClass( 'minimized' );
		this.header.find( '.dashicons' ).toggleClass( 'dashicons-arrow-up' ).toggleClass( 'dashicons-arrow-down' );
	};

	this.remove = function() {
		this.container.slideUp( 300, function() {
			jQuery( this ).detach();
		} );
		this.container.trigger( 'row:remove', [ this.rowIndex ] );
	};

	this.updateLabel = function() {
		var rowLabelField,
			rowLabel,
			rowLabelSelector;

		if ( 'field' === this.label.type ) {
			rowLabelField = this.container.find( '.repeater-field [data-field="' + this.label.field + '"]' );
			if ( _.isFunction( rowLabelField.val ) ) {
				rowLabel = rowLabelField.val();
				if ( '' !== rowLabel ) {
					if ( ! _.isUndefined( control.params.fields[ this.label.field ] ) ) {
						if ( ! _.isUndefined( control.params.fields[ this.label.field ].type ) ) {
							if ( 'select' === control.params.fields[ this.label.field ].type ) {
								if ( ! _.isUndefined( control.params.fields[ this.label.field ].choices ) && ! _.isUndefined( control.params.fields[ this.label.field ].choices[ rowLabelField.val() ] ) ) {
									rowLabel = control.params.fields[ this.label.field ].choices[ rowLabelField.val() ];
								}
							} else if ( 'radio' === control.params.fields[ this.label.field ].type || 'radio-image' === control.params.fields[ this.label.field ].type ) {
								rowLabelSelector = control.selector + ' [data-row="' + this.rowIndex + '"] .repeater-field [data-field="' + this.label.field + '"]:checked';
								rowLabel = jQuery( rowLabelSelector ).val();
							}
						}
					}
					this.header.find( '.repeater-row-label' ).text( rowLabel );
					return;
				}
			}
		}
		this.header.find( '.repeater-row-label' ).text( this.label.value + ' ' + ( this.rowIndex + 1 ) );
	};
	this.updateLabel();
};

wp.customize.controlConstructor.repeater = wp.customize.Control.extend( {

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

		var control = this,
			limit,
			theNewRow;

		// The current value set in Control Class (set in Kirki_Customize_Repeater_Control::to_json() function)
		var settingValue = this.params.value;

		control.container.find( '.kirki-controls-loading-spinner' ).hide();

		// The hidden field that keeps the data saved (though we never update it)
		this.settingField = this.container.find( '[data-customize-setting-link]' ).first();

		// Set the field value for the first time, we'll fill it up later
		this.setValue( [], false );

		// The DIV that holds all the rows
		this.repeaterFieldsContainer = this.container.find( '.repeater-fields' ).first();

		// Set number of rows to 0
		this.currentIndex = 0;

		// Save the rows objects
		this.rows = [];

		// Default limit choice
		limit = false;
		if ( ! _.isUndefined( this.params.choices.limit ) ) {
			limit = ( 0 >= this.params.choices.limit ) ? false : parseInt( this.params.choices.limit, 10 );
		}

		this.container.on( 'click', 'button.repeater-add', function( e ) {
			e.preventDefault();
			if ( ! limit || control.currentIndex < limit ) {
				theNewRow = control.addRow();
				theNewRow.toggleMinimize();
				control.initColorPicker();
				control.initSelect( theNewRow );
			} else {
				jQuery( control.selector + ' .limit' ).addClass( 'highlight' );
			}
		} );

		this.container.on( 'click', '.repeater-row-remove', function() {
			control.currentIndex--;
			if ( ! limit || control.currentIndex < limit ) {
				jQuery( control.selector + ' .limit' ).removeClass( 'highlight' );
			}
		} );

		this.container.on( 'click keypress', '.repeater-field-image .upload-button,.repeater-field-cropped_image .upload-button,.repeater-field-upload .upload-button', function( e ) {
			e.preventDefault();
			control.$thisButton = jQuery( this );
			control.openFrame( e );
		} );

		this.container.on( 'click keypress', '.repeater-field-image .remove-button,.repeater-field-cropped_image .remove-button', function( e ) {
			e.preventDefault();
			control.$thisButton = jQuery( this );
			control.removeImage( e );
		} );

		this.container.on( 'click keypress', '.repeater-field-upload .remove-button', function( e ) {
			e.preventDefault();
			control.$thisButton = jQuery( this );
			control.removeFile( e );
		} );

		/**
		 * Function that loads the Mustache template
		 */
		this.repeaterTemplate = _.memoize( function() {
			var compiled,

				/*
				 * Underscore's default ERB-style templates are incompatible with PHP
				 * when asp_tags is enabled, so WordPress uses Mustache-inspired templating syntax.
				 *
				 * @see trac ticket #22344.
				 */
				options = {
					evaluate: /<#([\s\S]+?)#>/g,
					interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
					escape: /\{\{([^\}]+?)\}\}(?!\})/g,
					variable: 'data'
				};

			return function( data ) {
				compiled = _.template( control.container.find( '.customize-control-repeater-content' ).first().html(), null, options );
				return compiled( data );
			};
		} );

		// When we load the control, the fields have not been filled up
		// This is the first time that we create all the rows
		if ( settingValue.length ) {
			_.each( settingValue, function( subValue ) {
				theNewRow = control.addRow( subValue );
				control.initColorPicker();
				control.initSelect( theNewRow, subValue );
			} );
		}

		// Once we have displayed the rows, we cleanup the values
		this.setValue( settingValue, true, true );

		this.repeaterFieldsContainer.sortable( {
			handle: '.repeater-row-header',
			update: function() {
				control.sort();
			}
		} );

	},

	/**
	 * Open the media modal.
	 */
	openFrame: function( event ) {

		'use strict';

		if ( wp.customize.utils.isKeydownButNotEnterEvent( event ) ) {
			return;
		}

		if ( this.$thisButton.closest( '.repeater-field' ).hasClass( 'repeater-field-cropped_image' ) ) {
			this.initCropperFrame();
		} else {
			this.initFrame();
		}

		this.frame.open();
	},

	initFrame: function() {

		'use strict';

		var libMediaType = this.getMimeType();

		this.frame = wp.media( {
			states: [
			new wp.media.controller.Library( {
					library: wp.media.query( { type: libMediaType } ),
					multiple: false,
					date: false
				} )
			]
		} );

		// When a file is selected, run a callback.
		this.frame.on( 'select', this.onSelect, this );
	},

	/**
	 * Create a media modal select frame, and store it so the instance can be reused when needed.
	 * This is mostly a copy/paste of Core api.CroppedImageControl in /wp-admin/js/customize-control.js
	 */
	initCropperFrame: function() {

		'use strict';

		// We get the field id from which this was called
		var currentFieldId = this.$thisButton.siblings( 'input.hidden-field' ).attr( 'data-field' ),
			attrs          = [ 'width', 'height', 'flex_width', 'flex_height' ], // A list of attributes to look for
			libMediaType   = this.getMimeType();

		// Make sure we got it
		if ( _.isString( currentFieldId ) && '' !== currentFieldId ) {

			// Make fields is defined and only do the hack for cropped_image
			if ( _.isObject( this.params.fields[ currentFieldId ] ) && 'cropped_image' === this.params.fields[ currentFieldId ].type ) {

				//Iterate over the list of attributes
				attrs.forEach( function( el ) {

					// If the attribute exists in the field
					if ( ! _.isUndefined( this.params.fields[ currentFieldId ][ el ] ) ) {

						// Set the attribute in the main object
						this.params[ el ] = this.params.fields[ currentFieldId ][ el ];
					}
				}.bind( this ) );
			}
		}

		this.frame = wp.media( {
			button: {
				text: 'Select and Crop',
				close: false
			},
			states: [
				new wp.media.controller.Library( {
					library: wp.media.query( { type: libMediaType } ),
					multiple: false,
					date: false,
					suggestedWidth: this.params.width,
					suggestedHeight: this.params.height
				} ),
				new wp.media.controller.CustomizeImageCropper( {
					imgSelectOptions: this.calculateImageSelectOptions,
					control: this
				} )
			]
		} );

		this.frame.on( 'select', this.onSelectForCrop, this );
		this.frame.on( 'cropped', this.onCropped, this );
		this.frame.on( 'skippedcrop', this.onSkippedCrop, this );

	},

	onSelect: function() {

		'use strict';

		var attachment = this.frame.state().get( 'selection' ).first().toJSON();

		if ( this.$thisButton.closest( '.repeater-field' ).hasClass( 'repeater-field-upload' ) ) {
			this.setFileInRepeaterField( attachment );
		} else {
			this.setImageInRepeaterField( attachment );
		}
	},

	/**
	 * After an image is selected in the media modal, switch to the cropper
	 * state if the image isn't the right size.
	 */

	onSelectForCrop: function() {

		'use strict';

		var attachment = this.frame.state().get( 'selection' ).first().toJSON();

		if ( this.params.width === attachment.width && this.params.height === attachment.height && ! this.params.flex_width && ! this.params.flex_height ) {
			this.setImageInRepeaterField( attachment );
		} else {
			this.frame.setState( 'cropper' );
		}
	},

	/**
	 * After the image has been cropped, apply the cropped image data to the setting.
	 *
	 * @param {object} croppedImage Cropped attachment data.
	 */
	onCropped: function( croppedImage ) {

		'use strict';

		this.setImageInRepeaterField( croppedImage );

	},

	/**
	 * Returns a set of options, computed from the attached image data and
	 * control-specific data, to be fed to the imgAreaSelect plugin in
	 * wp.media.view.Cropper.
	 *
	 * @param {wp.media.model.Attachment} attachment
	 * @param {wp.media.controller.Cropper} controller
	 * @returns {Object} Options
	 */
	calculateImageSelectOptions: function( attachment, controller ) {

		'use strict';

		var control    = controller.get( 'control' ),
			flexWidth  = !! parseInt( control.params.flex_width, 10 ),
			flexHeight = !! parseInt( control.params.flex_height, 10 ),
			realWidth  = attachment.get( 'width' ),
			realHeight = attachment.get( 'height' ),
			xInit      = parseInt( control.params.width, 10 ),
			yInit      = parseInt( control.params.height, 10 ),
			ratio      = xInit / yInit,
			xImg       = realWidth,
			yImg       = realHeight,
			x1,
			y1,
			imgSelectOptions;

		controller.set( 'canSkipCrop', ! control.mustBeCropped( flexWidth, flexHeight, xInit, yInit, realWidth, realHeight ) );

		if ( xImg / yImg > ratio ) {
			yInit = yImg;
			xInit = yInit * ratio;
		} else {
			xInit = xImg;
			yInit = xInit / ratio;
		}

		x1 = ( xImg - xInit ) / 2;
		y1 = ( yImg - yInit ) / 2;

		imgSelectOptions = {
			handles: true,
			keys: true,
			instance: true,
			persistent: true,
			imageWidth: realWidth,
			imageHeight: realHeight,
			x1: x1,
			y1: y1,
			x2: xInit + x1,
			y2: yInit + y1
		};

		if ( false === flexHeight && false === flexWidth ) {
			imgSelectOptions.aspectRatio = xInit + ':' + yInit;
		}
		if ( false === flexHeight ) {
			imgSelectOptions.maxHeight = yInit;
		}
		if ( false === flexWidth ) {
			imgSelectOptions.maxWidth = xInit;
		}

		return imgSelectOptions;
	},

	/**
	 * Return whether the image must be cropped, based on required dimensions.
	 *
	 * @param {bool} flexW
	 * @param {bool} flexH
	 * @param {int}  dstW
	 * @param {int}  dstH
	 * @param {int}  imgW
	 * @param {int}  imgH
	 * @return {bool}
	 */
	mustBeCropped: function( flexW, flexH, dstW, dstH, imgW, imgH ) {

		'use strict';

		if ( ( true === flexW && true === flexH ) || ( true === flexW && dstH === imgH ) || ( true === flexH && dstW === imgW ) || ( dstW === imgW && dstH === imgH ) || ( imgW <= dstW ) ) {
			return false;
		}

		return true;
	},

	/**
	 * If cropping was skipped, apply the image data directly to the setting.
	 */
	onSkippedCrop: function() {

		'use strict';

		var attachment = this.frame.state().get( 'selection' ).first().toJSON();
		this.setImageInRepeaterField( attachment );

	},

	/**
	 * Updates the setting and re-renders the control UI.
	 *
	 * @param {object} attachment
	 */
	setImageInRepeaterField: function( attachment ) {

		'use strict';

		var $targetDiv = this.$thisButton.closest( '.repeater-field-image,.repeater-field-cropped_image' );

		$targetDiv.find( '.kirki-image-attachment' ).html( '<img src="' + attachment.url + '">' ).hide().slideDown( 'slow' );

		$targetDiv.find( '.hidden-field' ).val( attachment.id );
		this.$thisButton.text( this.$thisButton.data( 'alt-label' ) );
		$targetDiv.find( '.remove-button' ).show();

		//This will activate the save button
		$targetDiv.find( 'input, textarea, select' ).trigger( 'change' );
		this.frame.close();

	},

	/**
	 * Updates the setting and re-renders the control UI.
	 *
	 * @param {object} attachment
	 */
	setFileInRepeaterField: function( attachment ) {

		'use strict';

		var $targetDiv = this.$thisButton.closest( '.repeater-field-upload' );

		$targetDiv.find( '.kirki-file-attachment' ).html( '<span class="file"><span class="dashicons dashicons-media-default"></span> ' + attachment.filename + '</span>' ).hide().slideDown( 'slow' );

		$targetDiv.find( '.hidden-field' ).val( attachment.id );
		this.$thisButton.text( this.$thisButton.data( 'alt-label' ) );
		$targetDiv.find( '.upload-button' ).show();
		$targetDiv.find( '.remove-button' ).show();

		//This will activate the save button
		$targetDiv.find( 'input, textarea, select' ).trigger( 'change' );
		this.frame.close();

	},

	getMimeType: function() {

		'use strict';

		// We get the field id from which this was called
		var currentFieldId = this.$thisButton.siblings( 'input.hidden-field' ).attr( 'data-field' );

		// Make sure we got it
		if ( _.isString( currentFieldId ) && '' !== currentFieldId ) {

			// Make fields is defined and only do the hack for cropped_image
			if ( _.isObject( this.params.fields[ currentFieldId ] ) && 'upload' === this.params.fields[ currentFieldId ].type ) {

				// If the attribute exists in the field
				if ( ! _.isUndefined( this.params.fields[ currentFieldId ].mime_type ) ) {

					// Set the attribute in the main object
					return this.params.fields[ currentFieldId ].mime_type;
				}
			}
		}
		return 'image';

	},

	removeImage: function( event ) {

		'use strict';

		var $targetDiv,
			$uploadButton;

		if ( wp.customize.utils.isKeydownButNotEnterEvent( event ) ) {
			return;
		}

		$targetDiv = this.$thisButton.closest( '.repeater-field-image,.repeater-field-cropped_image,.repeater-field-upload' );
		$uploadButton = $targetDiv.find( '.upload-button' );

		$targetDiv.find( '.kirki-image-attachment' ).slideUp( 'fast', function() {
			jQuery( this ).show().html( jQuery( this ).data( 'placeholder' ) );
		} );
		$targetDiv.find( '.hidden-field' ).val( '' );
		$uploadButton.text( $uploadButton.data( 'label' ) );
		this.$thisButton.hide();

		$targetDiv.find( 'input, textarea, select' ).trigger( 'change' );

	},

	removeFile: function( event ) {

		'use strict';

		var $targetDiv,
			$uploadButton;

		if ( wp.customize.utils.isKeydownButNotEnterEvent( event ) ) {
			return;
		}

		$targetDiv = this.$thisButton.closest( '.repeater-field-upload' );
		$uploadButton = $targetDiv.find( '.upload-button' );

		$targetDiv.find( '.kirki-file-attachment' ).slideUp( 'fast', function() {
			jQuery( this ).show().html( jQuery( this ).data( 'placeholder' ) );
		} );
		$targetDiv.find( '.hidden-field' ).val( '' );
		$uploadButton.text( $uploadButton.data( 'label' ) );
		this.$thisButton.hide();

		$targetDiv.find( 'input, textarea, select' ).trigger( 'change' );

	},

	/**
	 * Get the current value of the setting
	 *
	 * @return Object
	 */
	getValue: function() {

		'use strict';

		// The setting is saved in JSON
		return JSON.parse( decodeURI( this.setting.get() ) );

	},

	/**
	 * Set a new value for the setting
	 *
	 * @param newValue Object
	 * @param refresh If we want to refresh the previewer or not
	 */
	setValue: function( newValue, refresh, filtering ) {

		'use strict';

		// We need to filter the values after the first load to remove data requrired for diplay but that we don't want to save in DB
		var filteredValue = newValue,
			filter        = [];

		if ( filtering ) {
			jQuery.each( this.params.fields, function( index, value ) {
				if ( 'image' === value.type || 'cropped_image' === value.type || 'upload' === value.type ) {
					filter.push( index );
				}
			} );
			jQuery.each( newValue, function( index, value ) {
				jQuery.each( filter, function( ind, field ) {
					if ( ! _.isUndefined( value[ field ] ) && ! _.isUndefined( value[ field ].id ) ) {
						filteredValue[index][ field ] = value[ field ].id;
					}
				} );
			} );
		}

		this.setting.set( encodeURI( JSON.stringify( filteredValue ) ) );

		if ( refresh ) {

			// Trigger the change event on the hidden field so
			// previewer refresh the website on Customizer
			this.settingField.trigger( 'change' );
		}
	},

	/**
	 * Add a new row to repeater settings based on the structure.
	 *
	 * @param data (Optional) Object of field => value pairs (undefined if you want to get the default values)
	 */
	addRow: function( data ) {

		'use strict';

		var control       = this,
			template      = control.repeaterTemplate(), // The template for the new row (defined on Kirki_Customize_Repeater_Control::render_content() ).
			settingValue  = this.getValue(), // Get the current setting value.
			newRowSetting = {}, // Saves the new setting data.
			templateData, // Data to pass to the template
			newRow,
			i;

		if ( template ) {

			// The control structure is going to define the new fields
			// We need to clone control.params.fields. Assigning it
			// ould result in a reference assignment.
			templateData = jQuery.extend( true, {}, control.params.fields );

			// But if we have passed data, we'll use the data values instead
			if ( data ) {
				for ( i in data ) {
					if ( data.hasOwnProperty( i ) && templateData.hasOwnProperty( i ) ) {
						templateData[ i ].default = data[ i ];
					}
				}
			}

			templateData.index = this.currentIndex;

			// Append the template content
			template = template( templateData );

			// Create a new row object and append the element
			newRow = new RepeaterRow(
				control.currentIndex,
				jQuery( template ).appendTo( control.repeaterFieldsContainer ),
				control.params.row_label,
				control
			);

			newRow.container.on( 'row:remove', function( e, rowIndex ) {
				control.deleteRow( rowIndex );
			} );

			newRow.container.on( 'row:update', function( e, rowIndex, fieldName, element ) {
				control.updateField.call( control, e, rowIndex, fieldName, element );
				newRow.updateLabel();
			} );

			// Add the row to rows collection
			this.rows[ this.currentIndex ] = newRow;

			for ( i in templateData ) {
				if ( templateData.hasOwnProperty( i ) ) {
					newRowSetting[ i ] = templateData[ i ].default;
				}
			}

			settingValue[ this.currentIndex ] = newRowSetting;
			this.setValue( settingValue, true );

			this.currentIndex++;

			return newRow;
		}
	},

	sort: function() {

		'use strict';

		var control     = this,
			$rows       = this.repeaterFieldsContainer.find( '.repeater-row' ),
			newOrder    = [],
			settings    = control.getValue(),
			newRows     = [],
			newSettings = [];

		$rows.each( function( i, element ) {
			newOrder.push( jQuery( element ).data( 'row' ) );
		} );

		jQuery.each( newOrder, function( newPosition, oldPosition ) {
			newRows[ newPosition ] = control.rows[ oldPosition ];
			newRows[ newPosition ].setRowIndex( newPosition );

			newSettings[ newPosition ] = settings[ oldPosition ];
		} );

		control.rows = newRows;
		control.setValue( newSettings );

	},

	/**
	 * Delete a row in the repeater setting
	 *
	 * @param index Position of the row in the complete Setting Array
	 */
	deleteRow: function( index ) {

		'use strict';

		var currentSettings = this.getValue(),
			row,
			i,
			prop;

		if ( currentSettings[ index ] ) {

			// Find the row
			row = this.rows[ index ];
			if ( row ) {

				// Remove the row settings
				delete currentSettings[ index ];

				// Remove the row from the rows collection
				delete this.rows[ index ];

				// Update the new setting values
				this.setValue( currentSettings, true );

			}

		}

		// Remap the row numbers
		i = 1;
		for ( prop in this.rows ) {
			if ( this.rows.hasOwnProperty( prop ) && this.rows[ prop ] ) {
				this.rows[ prop ].updateLabel();
				i++;
			}
		}
	},

	/**
	 * Update a single field inside a row.
	 * Triggered when a field has changed
	 *
	 * @param e Event Object
	 */
	updateField: function( e, rowIndex, fieldId, element ) {

		'use strict';

		var type,
			row,
			currentSettings;

		if ( ! this.rows[ rowIndex ] ) {
			return;
		}

		if ( ! this.params.fields[ fieldId ] ) {
			return;
		}

		type            = this.params.fields[ fieldId].type;
		row             = this.rows[ rowIndex ];
		currentSettings = this.getValue();

		element = jQuery( element );

		if ( _.isUndefined( currentSettings[ row.rowIndex ][ fieldId ] ) ) {
			return;
		}

		if ( 'checkbox' === type ) {
			currentSettings[ row.rowIndex ][ fieldId ] = element.is( ':checked' );
		} else {

			// Update the settings
			currentSettings[ row.rowIndex ][ fieldId ] = element.val();
		}
		this.setValue( currentSettings, true );
	},

	/**
	 * Init the color picker on color fields
	 * Called after AddRow
	 *
	 */
	initColorPicker: function() {

		'use strict';

		var control     = this,
			colorPicker = control.container.find( '.color-picker-hex' ),
			options     = {},
			fieldId     = colorPicker.data( 'field' );

		// We check if the color palette parameter is defined.
		if ( ! _.isUndefined( fieldId ) && ! _.isUndefined( control.params.fields[ fieldId ] ) && ! _.isUndefined( control.params.fields[ fieldId ].palettes ) && _.isObject( control.params.fields[ fieldId ].palettes ) ) {
			options.palettes = control.params.fields[ fieldId ].palettes;
		}

		// When the color picker value is changed we update the value of the field
		options.change = function( event, ui ) {

			var currentPicker   = jQuery( event.target ),
				row             = currentPicker.closest( '.repeater-row' ),
				rowIndex        = row.data( 'row' ),
				currentSettings = control.getValue();

			currentSettings[ rowIndex ][ currentPicker.data( 'field' ) ] = ui.color.toString();
			control.setValue( currentSettings, true );

		};

		// Init the color picker
		if ( 0 !== colorPicker.length ) {
			colorPicker.wpColorPicker( options );
		}
	},

	/**
	 * Init the dropdown-pages field with selectWoo
	 * Called after AddRow
	 *
	 * @param {object} theNewRow the row that was added to the repeater
	 * @param {object} data the data for the row if we're initializing a pre-existing row
	 *
	 */
	initSelect: function( theNewRow, data ) {

		'use strict';

		var control  = this,
			dropdown = theNewRow.container.find( '.repeater-field select' ),
			$select,
			dataField,
			multiple,
			selectWooOptions = {};

		if ( 0 === dropdown.length ) {
			return;
		}

		dataField = dropdown.data( 'field' );
		multiple  = jQuery( dropdown ).data( 'multiple' );
		if ( 'undefed' !== multiple && jQuery.isNumeric( multiple ) ) {
			multiple = parseInt( multiple, 10 );
			if ( 1 < multiple ) {
				selectWooOptions.maximumSelectionLength = multiple;
			}
		}

		data = data || {};
		data[ dataField ] = data[ dataField ] || '';

		$select = jQuery( dropdown ).selectWoo( selectWooOptions ).val( data[ dataField ] || jQuery( dropdown ).val() );

		this.container.on( 'change', '.repeater-field select', function( event ) {

			var currentDropdown = jQuery( event.target ),
				row             = currentDropdown.closest( '.repeater-row' ),
				rowIndex        = row.data( 'row' ),
				currentSettings = control.getValue();

			currentSettings[ rowIndex ][ currentDropdown.data( 'field' ) ] = jQuery( this ).val();
			control.setValue( currentSettings );
		} );
	}
} );
wp.customize.controlConstructor['kirki-slider'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function() {
		var control      = this,
			changeAction = ( 'postMessage' === control.setting.transport ) ? 'mousemove change' : 'change',
			rangeInput   = control.container.find( 'input[type="range"]' ),
			textInput    = control.container.find( 'input[type="text"]' ),
			value        = control.setting._value;

		// Set the initial value in the text input.
		textInput.attr( 'value', value );

		// If the range input value changes copy the value to the text input.
		rangeInput.on( 'mousemove change', function() {
			textInput.attr( 'value', rangeInput.val() );
		} );

		// Save the value when the range input value changes.
		// This is separate from the above because of the postMessage differences.
		// If the control refreshes the preview pane,
		// we don't want a refresh for every change
		// but 1 final refresh when the value is changed.
		rangeInput.on( changeAction, function() {
			control.setting.set( rangeInput.val() );
		} );

		// If the text input value changes,
		// copy the value to the range input
		// and then save.
		textInput.on( 'input paste change', function() {
			rangeInput.attr( 'value', textInput.val() );
			control.setting.set( textInput.val() );
		} );

		// If the reset button is clicked,
		// set slider and text input values to default
		// and hen save.
		control.container.find( '.slider-reset' ).on( 'click', function() {
			textInput.attr( 'value', control.params.default );
			rangeInput.attr( 'value', control.params.default );
			control.setting.set( textInput.val() );
		} );
	}
} );wp.customize.controlConstructor['kirki-slider-advanced'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function() {
		var control           = this,
			changeAction      = ( 'postMessage' === control.setting.transport ) ? 'mousemove change' : 'change',
			rangeInput        = control.container.find( 'input[type="range"]' ),
			textInput         = control.container.find( 'input[type="text"]' ),
			units_radios      = control.container.find( '.kirki-units-choices input[type="radio"]' ),
			resetBtn          = control.container.find( '.slider-reset' ),
			has_units         = units_radios.length > 0,
			use_media_queries = control.params.choices.use_media_queries;
		
		control.selected_device = kirki.util.media_query_devices.global;
		control.selected_unit = '';
		control.rangeInput = rangeInput;
		control.textInput = textInput;
		control.has_units = has_units;
		control.initial_input = false;
		control.initial_media_query = false;
		control.units = [];
		control.use_media_queries = use_media_queries;
		
		units_radios.each(function()
		{
			var radio = $( this );
			control.units.push( radio.val() );
		});
		
		control.initValue();
		control.initMediaQueries();
		
		//If there are units for this slider.
		if ( has_units )
		{
			control.initUnitSelect( units_radios );
			var unit = null;
			//Load the unit
			if ( use_media_queries )
				unit = control.value.desktop.unit;
			else
				unit = control.value.global.unit;
			units_radios.filter( '[value="' + unit + '"]' ).prop( 'checked', true );
			if ( units_radios.filter ( ':checked' ).length == 0)
			{
				var first_unit = units_radios.first();
				first_unit.prop( 'checked', true );
			}
			
			control.selected_unit = units_radios.filter( ':checked' ).val();
		}
		
		control.setRange();
		
		rangeInput.on( changeAction + ' change_visual', function( e ) {
			if ( e.type !== 'change_visual' )
				control.initial_input = true;
			var val = rangeInput.val();
			textInput.val( val );
			control.setValue( val );
			control.save();
		} );
		
		//input paste change
		textInput.on( 'paste change change_visual', function( e ) {
			if ( e.type !== 'change_visual' )
				control.initial_input = true;
			var val = textInput.val(),
				min = rangeInput.attr( 'min' ),
				max = rangeInput.attr( 'max' );
			if ( val > max )
				val = max;
			else if ( val < min )
				val = min;
			rangeInput.attr( 'value', val );
			control.setValue( val );
			control.save();
		} );
		
		resetBtn.click( function()
		{
			control.value[control.getSelectedDeviceName()].loaded = false;
			control.initValue();
			control.rangeInput.trigger( 'change_visual' );
		});
		
		control.rangeInput.trigger( changeAction );
	},
	initValue: function()
	{
		var control = this,
			loadedValue = control.setting._value;
		control.value = {
			use_media_queries: loadedValue.use_media_queries || false,
			global: control.defaultValue(),
			desktop: control.defaultValue(),
			tablet: control.defaultValue(),
			mobile: control.defaultValue()
		};
		
		if ( loadedValue.use_media_queries )
		{
			kirki.util.media_query_device_names.forEach( function( name )
			{
				if ( !control.value[name].loaded && loadedValue[name] )
				{
					var parsed = control.parseValue( loadedValue[name] );
					control.value[name]['value'] = parsed['value'];
					control.value[name]['unit'] = parsed['unit'];
					control.value[name]['loaded'] = true;
				}
			});
			if ( loadedValue['desktop'] )
				control.value['global'] = control.value['desktop'];
		}
		else
		{
			if ( !control.value['global'].loaded && loadedValue['global'] )
			{
				var parsed = control.parseValue( loadedValue['global'] );
				control.value['global'] = loadedValue['global'];
				control.value['global']['value'] = parsed['value'];
				control.value['global']['unit'] = parsed['unit'];
				control.value['global']['loaded'] = true;
			}
		}
		var id = control.value.use_media_queries ? 'desktop' : 'global';
		var value = control.value[id].value;
		if ( !control.value[id].loaded && control.params.default )
		{
			var defs = control.params.default;
			if ( control.has_units && typeof defs === 'object' )
			{
				if ( !control.selected_unit )
					control.selected_unit = control.units[0];
				value = defs[control.selected_unit];
			}
			else
			{
				value = control.parseValue( defs );
				control.selected_unit = value['unit'];
				if ( value['value'] )
					value = value['value'];
				else
					value = control.rangeInput.attr( 'max' );
			}
		}
		control.setRange();
		if ( !value )
			value = control.rangeInput.attr( 'max' );
		if ( control.has_units )
		{
			if ( value )
				value = value.toString().replace( control.textFindRegex, '' );
		}
		control.rangeInput.val( value );
		control.textInput.val( value );
	},
	
	initMediaQueries: function()
	{
		var control = this,
			units_radios = control.container.find( '.kirki-units-choices input[type="radio"]' );
		//If media queries are used, we need to detect device changes.
		if ( control.params.choices.use_media_queries )
		{
			kirki.util.helpers.media_query( control, control.value.use_media_queries, {
				device_change: function( device, enabled )
				{
					control.selected_device = device;
					control.value.use_media_queries = enabled;
					var value = null,
						unit = null;
					if ( enabled && !control.initial_media_query )
					{
						var choices = control.params.choices,
							range = choices.units ? choices.units[control.selected_unit] : control.params.choices;
						
						kirki.util.media_query_device_names.forEach( function( name )
						{
							if ( !control.value[name].value )
							{
								control.value[name].value = range['max'];
								control.value[name].unit = control.selected_unit;
							}
						});
					}
					if ( enabled )
						control.value.desktop = control.value.global;
					if ( !enabled )
					{
						control.value.global = control.value.desktop;
						value = control.value.global.value;
						unit = control.value.global.unit;
					}
					else if ( device == kirki.util.media_query_devices.desktop )
					{
						value = control.value.desktop.value;
						unit = control.value.desktop.unit;
					}
					else if ( device == kirki.util.media_query_devices.tablet )
					{
						value = control.value.tablet.value;
						unit = control.value.tablet.unit;
					}
					else if ( device == kirki.util.media_query_devices.mobile )
					{
						value = control.value.mobile.value;
						unit = control.value.mobile.unit;
					}
					
					if ( control.has_units )
					{
						if ( unit && unit.length > 0 )
						{
							units_radios.filter( ':checked' ).prop( 'checked', false );
							units_radios.filter( '[value="' + unit + '"]' ).prop( 'checked', true );
							if ( units_radios.filter ( ':checked' ).length == 0 )
								units_radios.first().click();
							control.selected_unit = units_radios.filter ( ':checked' ).val();
						}
					}
					control.setRange();
					control.setValue( value );
					control.save();
					control.initial_media_query = true;
				}
			});
		}
	},
	  
	initUnitSelect: function( units )
	{
		var control = this;
		units.on( 'change', function()
		{
			var selected = $( this );
			control.selected_unit = selected.val();
			control.setRange();
			
			var defs = control.params.default;
			if ( !control.value[control.getSelectedDeviceName()].loaded && !control.initial_input && control.params.default )
			{
				var value = '';
				if ( typeof defs === 'object' && defs[control.selected_unit] )
				{
					value = defs[control.selected_unit].replace( control.textFindRegex, '' );
				}
				else
				{
					value = control.parseValue( defs );
					
					if ( value['value'] )
						value = value['value'];
					else
						value = control.rangeInput.attr( 'max' );
				}
				control.rangeInput.val( value );
				control.textInput.val( value );
			}
			
			control.rangeInput.trigger( 'change_visual' );
		});
	},
	
	setValue: function( value )
	{
		var control = this,
			device = control.getSelectedDeviceName();
		
		control.rangeInput.val( value );
		control.textInput.val( value );
		control.value[device]['value'] = value;
		control.value[device]['unit'] = control.selected_unit;
	},
	
	getSelectedDeviceName: function()
	{
		var control = this,
			device = 'global';
		if ( control.selected_device == kirki.util.media_query_devices.desktop )
			device = 'desktop';
		else if ( control.selected_device == kirki.util.media_query_devices.tablet )
			device = 'tablet';
		else if ( control.selected_device == kirki.util.media_query_devices.mobile )
			device = 'mobile';
		return device;
	},
	
	setRange: function()
	{
		var control = this,
			choices = control.params.choices,
			unit = choices.units ? ( control.selected_unit || Object.keys( choices.units )[0] ) : '',
			rangeInput = control.rangeInput,
			textInput = control.textInput,
			suffixElement = control.container.find( '.suffix' );
		
		var range = choices.units ? choices.units[unit] : control.params.choices,
			min = range['min'],
			max = range['max'],
			step = range['step'],
			suffix = choices.units ? unit : ( range['suffix'] || '' ),
			val = rangeInput.val();
		
		rangeInput.attr( 'min', min ).attr( 'max', max ).attr( 'step', step );
		suffixElement.html( suffix );
		var range_clamp = val > max || val < min;
		if ( val > max )
			val = max;
		else if ( val < min )
			val = min;
		if ( range_clamp )
		{
			rangeInput.val( val );
			textInput.val( val );
		}
	},
	
	save: function()
	{
		var control = this,
			input  = control.container.find( '.spacing-hidden-value' ),
			compiled = jQuery.extend( {}, control.value );
		delete compiled.loaded;
		if ( compiled.use_media_queries )
		{
			delete compiled.global;
			
			compiled.desktop = compiled.desktop.value + compiled.desktop.unit;
			compiled.tablet = compiled.tablet.value + compiled.tablet.unit;
			compiled.mobile = compiled.mobile.value + compiled.mobile.unit;
		}
		else
		{
			delete compiled.desktop;
			delete compiled.tablet;
			delete compiled.mobile;
			
			compiled.global = compiled.global.value + compiled.global.unit;
		}
		delete compiled.value;
		input.val( JSON.stringify( compiled ) ).trigger( 'change' );
		control.setting.set( compiled );
	},
	
	parseValue: function( value )
	{
		var control = this,
			parser = /(\d+)(\w+|.)/gm;
		var parsed = parser.exec( value );
		if ( !parsed || parsed.length < 2 )
		{
			if ( !Number.isNaN( value ) )
				return { value: value, unit: '' };
			else
				return { value: 0, unit: '' };
		}
		return {
			value: parsed[1] || '',
			unit: parsed[2] || ''
		};
	},
	
	defaultValue: function()
	{
		return { value: '', unit: '', loaded: false };
	},
} );/* global kirkiControlLoader */
wp.customize.controlConstructor['kirki-sortable'] = wp.customize.Control.extend( {

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

		var control = this;

		control.container.find( '.kirki-controls-loading-spinner' ).hide();

		// Set the sortable container.
		control.sortableContainer = control.container.find( 'ul.sortable' ).first();

		// Init sortable.
		control.sortableContainer.sortable( {

			// Update value when we stop sorting.
			stop: function() {
				control.updateValue();
			}
		} ).disableSelection().find( 'li' ).each( function() {

			// Enable/disable options when we click on the eye of Thundera.
			jQuery( this ).find( 'i.visibility' ).click( function() {
				jQuery( this ).toggleClass( 'dashicons-visibility-faint' ).parents( 'li:eq(0)' ).toggleClass( 'invisible' );
			} );
		} ).click( function() {

			// Update value on click.
			control.updateValue();
		} );
	},

	/**
	 * Updates the sorting list
	 */
	updateValue: function() {

		'use strict';

		var control = this,
			newValue = [];

		this.sortableContainer.find( 'li' ).each( function() {
			if ( ! jQuery( this ).is( '.invisible' ) ) {
				newValue.push( jQuery( this ).data( 'value' ) );
			}
		} );
		control.setting.set( newValue );
	}
} );
wp.customize.controlConstructor['kirki-spacing-advanced'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function() {
		'use strict';
		var control           = this,
			changeAction      = ( 'postMessage' === control.setting.transport ) ? 'keyup change mouseup' : 'change',
			inputs            = control.container.find( '.kirki-control-dimension input' ),
			topInput          = inputs.filter( '[area="top"]' ),
			rightInput        = inputs.filter( '[area="right"]' ),
			bottomInput       = inputs.filter( '[area="bottom"]' ),
			leftInput         = inputs.filter( '[area="left"]' ),
			units_containers   = control.container.find( '.kirki-units-choices' ),
			units_radios      = control.container.find( '.kirki-units-choices input[type="radio"]' ),
			link_inputs_btn   = control.container.find( '.kirki-input-link' ),
			use_media_queries = control.params.choices.use_media_queries || false,
			all_units         = _.isUndefined( control.params.choices.all_units ) ? true : 
				control.params.choices.all_units;
		control.textFindRegex = /\D+/gm;
		control.selected_device = kirki.util.media_query_devices.global;
		control.selected_unit = '';
		control.inputs = {
			top: topInput,
			right: rightInput,
			bottom: bottomInput,
			left: leftInput,
		};
		control.all_units = all_units;
		control.initial_input = false;
		control.areas = ['top','right','bottom','left'];
		control.units = [];
		units_radios.each(function()
		{
			var radio = $( this );
			control.units.push( radio.val() );
		});
		
		if ( all_units )
		{
			units_containers.remove();
			inputs.attr( 'type', 'text' );
		}
		
		//Setup our value to manipulate.
		control.initValue();
		control.initMediaQueries();
		
		if ( !all_units ) //We need to load the initial unit if all_units = false.
		{
			control.initUnitSelect( units_radios );
			var top_value = null;
			//Load the unit
			if ( use_media_queries )
				top_value = control.value.desktop.top;
			else
				top_value = control.value.global.top;
			var unit = control.parseValue( top_value ).unit;
			units_radios.filter( '[value="' + unit + '"]' ).prop( 'checked', true );
			if ( units_radios.filter ( ':checked' ).length == 0)
			{
				var first_unit = units_radios.first();
				first_unit.prop( 'checked', true );
			}
			
			control.selected_unit = units_radios.filter( ':checked' ).val();
		}
		
		link_inputs_btn.click(function(e){
			e.preventDefault();
			e.stopImmediatePropagation();
			link_inputs_btn.toggleClass( 'unlinked linked' );
		});
		
		inputs.on( changeAction + ' change_visual', function( e )
		{
			if ( e.type === 'keyup' )
				control.initial_input = true;
			var input = $( this ),
				val = input.val();
			if ( all_units )
			{
				val += control.selected_unit;
			}
			if ( link_inputs_btn.hasClass( 'linked' ) )
			{
				inputs.filter(':not(' + input.attr( 'id' ) + ')' ).val( val );
			}
			inputs.each( function()
			{
				var input = $( this ),
					type = input.attr( 'area' ),
					device = control.getSelectedDeviceName(),
					val = input.val();
				if ( val.length == 0 )
				{
					input.val( val );
				}
				if ( !all_units )
				{
					val += control.selected_unit;
				}
				control.value[device][type] = val;
			});
			control.save();
		});
		
		inputs.on( 'blur', function()
		{
			var input = $( this );
			if ( input.val() == '' )
				input.val( '0' );
		});
		
		control.inputs.top.trigger( 'change_visual' );
	},
	
	initValue: function()
	{
		var control = this,
			loadedValue = control.setting._value;
		control.value = {
			use_media_queries: loadedValue.use_media_queries || false,
			global: control.defaultValue(),
			desktop: control.defaultValue(),
			tablet: control.defaultValue(),
			mobile: control.defaultValue()
		};
		
		if ( loadedValue.use_media_queries )
		{
			kirki.util.media_query_device_names.forEach( function( name )
			{
				if ( loadedValue[name] )
				{
					control.value[name] = loadedValue[name];
					control.value[name]['loaded'] = true;
				}
			});
			if ( loadedValue['desktop'] )
				control.value['global'] = loadedValue['desktop'];
		}
		else
		{
			if ( loadedValue['global'] )
			{
				control.value['global'] = loadedValue['global'];
				control.value['global']['loaded'] = true;
			}
		}
		var id = control.value.use_media_queries ? 'desktop' : 'global';
		var top    = control.value[id].top,
			right  = control.value[id].right,
			bottom = control.value[id].bottom,
			left   = control.value[id].left;
			if ( !control.value[id].loaded && control.params.default )
			{
				var defs = control.params.default;
				if ( control.all_units )
				{
					top = defs.top || top;
					right = defs.right || right;
					bottom = defs.bottom || bottom;
					left = defs.left || left;
				}
				else
				{
					var unit = control.units[0];
					if ( control.selected_unit )
						unit = control.selected_unit;
					top = defs[unit].top || top;
					right = defs[unit].right || right;
					bottom = defs[unit].bottom || bottom;
					left = defs[unit].left || left;
				}
			}
			if ( !control.all_units )
			{
				top = top.toString().replace( control.textFindRegex, '' );
				right = right.toString().replace( control.textFindRegex, '' );
				bottom = bottom.toString().replace( control.textFindRegex, '' );
				left = left.toString().replace( control.textFindRegex, '' );
			}
			control.inputs.top.val( top );
			control.inputs.right.val( right );
			control.inputs.bottom.val( bottom );
			control.inputs.left.val( left );
	},
	
	initMediaQueries: function()
	{
		var control = this,
			units_radios      = control.container.find( '.kirki-units-choices input[type="radio"]' );
		//If media queries are used, we need to detect device changes.
		if ( control.params.choices.use_media_queries )
		{
			kirki.util.helpers.media_query( control, control.value.use_media_queries, {
				device_change: function( device, enabled )
				{
					control.selected_device = device;
					control.value.use_media_queries = enabled;
					var top,
						right,
						bottom,
						left;
					if ( enabled )
						control.value.desktop = control.value.global;
					if ( !enabled )
					{
						control.value.global = control.value.desktop;
						top = control.value.global.top;
						right = control.value.global.right;
						bottom = control.value.global.bottom;
						left = control.value.global.left;
					}
					else if ( device == kirki.util.media_query_devices.desktop )
					{
						top = control.value.desktop.top;
						right = control.value.desktop.right;
						bottom = control.value.desktop.bottom;
						left = control.value.desktop.left;
					}
					else if ( device == kirki.util.media_query_devices.tablet )
					{
						top = control.value.tablet.top;
						right = control.value.tablet.right;
						bottom = control.value.tablet.bottom;
						left = control.value.tablet.left;
					}
					else if ( device == kirki.util.media_query_devices.mobile )
					{
						top = control.value.mobile.top;
						right = control.value.mobile.right;
						bottom = control.value.mobile.bottom;
						left = control.value.mobile.left;
					}
					
					if ( !control.params.choices.all_units )
					{
						var unit = control.parseValue( top )['unit'] ||
								control.parseValue( right )['unit'] ||
								control.parseValue( bottom )['unit'] ||
								control.parseValue( left )['unit'];
						if ( unit && unit.length > 0 )
						{
							units_radios.filter( ':checked' ).prop( 'checked', false );
							units_radios.filter( '[value="' + unit + '"]' ).prop( 'checked', true );
							if ( units_radios.filter ( ':checked' ).length == 0 )
								units_radios.first().click();
							control.selected_unit = units_radios.filter ( ':checked' ).val();
						}
						top = top.replace( control.textFindRegex, '' );
						right = right.replace( control.textFindRegex, '' );
						bottom = bottom.replace( control.textFindRegex, '' );
						left = left.replace( control.textFindRegex, '' );
					}
					
					control.inputs.top.val( top );
					control.inputs.right.val( right );
					control.inputs.bottom.val( bottom );
					control.inputs.left.val( left );
					
					control.save();
				}
			});
		}
	},
	  
	initUnitSelect: function( units )
	{
		var control = this;
		units.on( 'change', function()
		{
			var selected = $( this );
			control.selected_unit = selected.val();
			
			var defs = control.params.default;
			if ( !control.value.loaded && !control.initial_input && control.params.default && defs[control.selected_unit] )
			{
				if ( defs[control.selected_unit].top )
					control.inputs.top.val( defs[control.selected_unit].top.toString().replace( control.textFindRegex, '' ) );
				if ( defs[control.selected_unit].right )
					control.inputs.right.val( defs[control.selected_unit].right.toString().replace( control.textFindRegex, '' ) );
				if ( defs[control.selected_unit].bottom )
					control.inputs.bottom.val( defs[control.selected_unit].bottom.toString().replace( control.textFindRegex, '' ) );
				if ( defs[control.selected_unit].left )
					control.inputs.left.val( defs[control.selected_unit].left.toString().replace( control.textFindRegex, '' ) );
			}
			
			control.inputs.top.trigger( 'change_visual' );
		});
	},
	
	getSelectedDeviceName: function()
	{
		var control = this,
			device = 'global';
		if ( control.selected_device == kirki.util.media_query_devices.desktop )
			device = 'desktop';
		else if ( control.selected_device == kirki.util.media_query_devices.tablet )
			device = 'tablet';
		else if ( control.selected_device == kirki.util.media_query_devices.mobile )
			device = 'mobile';
		return device;
	},
	
	save: function()
	{
		var control = this,
			input  = control.container.find( '.spacing-hidden-value' ),
			compiled = jQuery.extend( {}, control.value );
		delete compiled.loaded;
		if ( compiled.use_media_queries )
		{
			delete compiled.global;
		}
		else
		{
			delete compiled.desktop;
			delete compiled.tablet;
			delete compiled.mobile;
		}
		input.val( JSON.stringify( compiled ) ).trigger( 'change' );
		control.setting.set( compiled );
	},
	
	parseValue: function( value )
	{
		var control = this,
			parser = /(\d+)(\w+|.)/gm;
		var parsed = parser.exec( value );
		if ( !parsed || parsed.length < 2 )
		{
			if ( !Number.isNaN( value ) )
				return { value: value, unit: '' };
			else
				return { value: 0, unit: '' };
		}
		return {
			value: parsed[1] || '',
			unit: parsed[2] || ''
		};
	},
	
	defaultValue: function()
	{
		return { top: '0', right: '0', bottom: '0', left: '0', loaded: false };
	},
} );
wp.customize.controlConstructor['kirki-switch'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function() {

		'use strict';

		var control       = this,
			checkboxValue = control.setting._value;

		// Save the value
		this.container.on( 'change', 'input', function() {
			checkboxValue = ( jQuery( this ).is( ':checked' ) ) ? true : false;
			control.setting.set( checkboxValue );
		} );
	}
} );
wp.customize.controlConstructor['kirki-toggle'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function() {

		var control = this,
			checkboxValue = control.setting._value;

		// Save the value
		this.container.on( 'change', 'input', function() {
			checkboxValue = ( jQuery( this ).is( ':checked' ) ) ? true : false;
			control.setting.set( checkboxValue );
		} );
	}
} );
/* global kirkiL10n, kirki */
wp.customize.controlConstructor['kirki-typography'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function() {

		'use strict';

		var control = this,
			value   = control.setting._value,
			picker;

		control.renderFontSelector();
		control.renderBackupFontSelector();
		control.renderVariantSelector();
		control.localFontsCheckbox();

		// Font-size.
		if ( 'undefined' !== typeof control.params.default['font-size'] ) {
			this.container.on( 'change keyup paste', '.font-size input', function() {
				control.saveValue( 'font-size', jQuery( this ).val() );
			} );
		}

		// Line-height.
		if ( 'undefined' !== typeof control.params.default['line-height'] ) {
			this.container.on( 'change keyup paste', '.line-height input', function() {
				control.saveValue( 'line-height', jQuery( this ).val() );
			} );
		}

		// Margin-top.
		if ( 'undefined' !== typeof control.params.default['margin-top'] ) {
			this.container.on( 'change keyup paste', '.margin-top input', function() {
				control.saveValue( 'margin-top', jQuery( this ).val() );
			} );
		}

		// Margin-bottom.
		if ( 'undefined' !== typeof control.params.default['margin-bottom'] ) {
			this.container.on( 'change keyup paste', '.margin-bottom input', function() {
				control.saveValue( 'margin-bottom', jQuery( this ).val() );
			} );
		}

		// Letter-spacing.
		if ( 'undefined' !== typeof control.params.default['letter-spacing'] ) {
			value['letter-spacing'] = ( jQuery.isNumeric( value['letter-spacing'] ) ) ? value['letter-spacing'] + 'px' : value['letter-spacing'];
			this.container.on( 'change keyup paste', '.letter-spacing input', function() {
				value['letter-spacing'] = ( jQuery.isNumeric( jQuery( this ).val() ) ) ? jQuery( this ).val() + 'px' : jQuery( this ).val();
				control.saveValue( 'letter-spacing', value['letter-spacing'] );
			} );
		}

		// Word-spacing.
		if ( 'undefined' !== typeof control.params.default['word-spacing'] ) {
			this.container.on( 'change keyup paste', '.word-spacing input', function() {
				control.saveValue( 'word-spacing', jQuery( this ).val() );
			} );
		}

		// Text-align.
		if ( 'undefined' !== typeof control.params.default['text-align'] ) {
			this.container.on( 'change', '.text-align input', function() {
				control.saveValue( 'text-align', jQuery( this ).val() );
			} );
		}

		// Text-transform.
		if ( 'undefined' !== typeof control.params.default['text-transform'] ) {
			jQuery( control.selector + ' .text-transform select' ).selectWoo().on( 'change', function() {
				control.saveValue( 'text-transform', jQuery( this ).val() );
			} );
		}

		// Text-decoration.
		if ( 'undefined' !== typeof control.params.default['text-decoration'] ) {
			jQuery( control.selector + ' .text-decoration select' ).selectWoo().on( 'change', function() {
				control.saveValue( 'text-decoration', jQuery( this ).val() );
			} );
		}

		// Color.
		if ( 'undefined' !== typeof control.params.default.color ) {
			picker = this.container.find( '.kirki-color-control' );
			picker.wpColorPicker( {
				change: function() {
					setTimeout( function() {
						control.saveValue( 'color', picker.val() );
					}, 100 );
				}
			} );
		}
	},

	/**
	 * Adds the font-families to the font-family dropdown
	 * and instantiates selectWoo.
	 */
	renderFontSelector: function() {

		var control         = this,
			selector        = control.selector + ' .font-family select',
			data            = [],
			standardFonts   = [],
			googleFonts     = [],
			value           = control.setting._value,
			fonts           = control.getFonts(),
			fontSelect,
			controlFontFamilies;

		// Format standard fonts as an array.
		if ( ! _.isUndefined( fonts.standard ) ) {
			_.each( fonts.standard, function( font ) {
				standardFonts.push( {
					id: font.family.replace( /&quot;/g, '&#39' ),
					text: font.label
				} );
			} );
		}

		// Format google fonts as an array.
		if ( ! _.isUndefined( fonts.google ) ) {
			_.each( fonts.google, function( font ) {
				googleFonts.push( {
					id: font.family,
					text: font.family
				} );
			} );
		}

		// Do we have custom fonts?
		controlFontFamilies = {};
		if ( ! _.isUndefined( control.params ) && ! _.isUndefined( control.params.choices ) && ! _.isUndefined( control.params.choices.fonts ) && ! _.isUndefined( control.params.choices.fonts.families ) ) {
			controlFontFamilies = control.params.choices.fonts.families;
		}

		// Combine forces and build the final data.
		data = jQuery.extend( {}, controlFontFamilies, {
			default: {
				text: kirkiL10n.defaultCSSValues,
				children: [
					{ id: '', text: kirkiL10n.defaultBrowserFamily },
					{ id: 'initial', text: 'initial' },
					{ id: 'inherit', text: 'inherit' }
				]
			},
			standard: {
				text: kirkiL10n.standardFonts,
				children: standardFonts
			},
			google: {
				text: kirkiL10n.googleFonts,
				children: googleFonts
			}
		} );

		if ( kirkiL10n.isScriptDebug ) {
			console.info( 'Kirki Debug: Font families for control "' + control.id + '":' );
			console.info( data );
		}

		data = _.values( data );

		// Instantiate selectWoo with the data.
		fontSelect = jQuery( selector ).selectWoo( {
			data: data
		} );

		// Set the initial value.
		if ( value['font-family'] || '' === value['font-family'] ) {
			value['font-family'] = kirki.util.parseHtmlEntities( value['font-family'].replace( /'/g, '"' ) );
			fontSelect.val( value['font-family'] ).trigger( 'change' );
		}

		// When the value changes
		fontSelect.on( 'change', function() {

			// Set the value.
			control.saveValue( 'font-family', jQuery( this ).val() );

			// Re-init the font-backup selector.
			control.renderBackupFontSelector();

			// Re-init variants selector.
			control.renderVariantSelector();
		} );
	},

	/**
	 * Adds the font-families to the font-family dropdown
	 * and instantiates selectWoo.
	 */
	renderBackupFontSelector: function() {

		var control       = this,
			selector      = control.selector + ' .font-backup select',
			standardFonts = [],
			value         = control.setting._value,
			fontFamily    = value['font-family'],
			fonts         = control.getFonts(),
			fontSelect;

		if ( _.isUndefined( value['font-backup'] ) || null === value['font-backup'] ) {
			value['font-backup'] = '';
		}

		// Hide if we're not on a google-font.
		if ( 'inherit' === fontFamily || 'initial' === fontFamily || 'google' !== kirki.util.webfonts.getFontType( fontFamily ) ) {
			jQuery( control.selector + ' .font-backup' ).hide();
			return;
		}
		jQuery( control.selector + ' .font-backup' ).show();

		// Format standard fonts as an array.
		if ( ! _.isUndefined( fonts.standard ) ) {
			_.each( fonts.standard, function( font ) {
				standardFonts.push( {
					id: font.family.replace( /&quot;/g, '&#39' ),
					text: font.label
				} );
			} );
		}

		// Instantiate selectWoo with the data.
		fontSelect = jQuery( selector ).selectWoo( {
			data: standardFonts
		} );

		// Set the initial value.
		if ( 'undefined' !== typeof value['font-backup'] ) {
			fontSelect.val( value['font-backup'].replace( /'/g, '"' ) ).trigger( 'change' );
		}

		// When the value changes
		fontSelect.on( 'change', function() {

			// Set the value.
			control.saveValue( 'font-backup', jQuery( this ).val() );
		} );
	},

	/**
	 * Renders the variants selector using selectWoo
	 * Displays font-variants for the currently selected font-family.
	 */
	renderVariantSelector: function() {

		var control    = this,
			value      = control.setting._value,
			fontFamily = value['font-family'],
			selector   = control.selector + ' .variant select',
			data       = [],
			isValid    = false,
			fontType   = kirki.util.webfonts.getFontType( fontFamily ),
			variants   = [ '', 'regular', 'italic', '700', '700italic' ],
			fontWeight,
			variantSelector,
			fontStyle;

		if ( 'google' === fontType ) {
			variants = kirki.util.webfonts.google.getVariants( fontFamily );
		}

		// Check if we've got custom variants defined for this font.
		if ( ! _.isUndefined( control.params ) && ! _.isUndefined( control.params.choices ) && ! _.isUndefined( control.params.choices.fonts ) && ! _.isUndefined( control.params.choices.fonts.variants ) ) {

			// Check if we have variants for this font-family.
			if ( ! _.isUndefined( control.params.choices.fonts.variants[ fontFamily ] ) ) {
				variants = control.params.choices.fonts.variants[ fontFamily ];
			}
		}
		if ( kirkiL10n.isScriptDebug ) {
			console.info( 'Kirki Debug: Font variants for font-family "' + fontFamily + '":' );
			console.info( variants );
		}

		if ( 'inherit' === fontFamily || 'initial' === fontFamily || '' === fontFamily ) {
			value.variant = 'inherit';
			variants      = [ '' ];
			jQuery( control.selector + ' .variant' ).hide();
		}

		if ( 1 >= variants.length ) {
			jQuery( control.selector + ' .variant' ).hide();

			value.variant = variants[0];

			control.saveValue( 'variant', value.variant );

			if ( '' === value.variant || ! value.variant ) {
				fontWeight = '';
				fontStyle  = '';
			} else {
				fontWeight = ( ! _.isString( value.variant ) ) ? '400' : value.variant.match( /\d/g );
				fontWeight = ( ! _.isObject( fontWeight ) ) ? '400' : fontWeight.join( '' );
				fontStyle  = ( -1 !== value.variant.indexOf( 'italic' ) ) ? 'italic' : 'normal';
			}

			control.saveValue( 'font-weight', fontWeight );
			control.saveValue( 'font-style', fontStyle );

			return;
		}

		jQuery( control.selector + ' .font-backup' ).show();

		jQuery( control.selector + ' .variant' ).show();
		_.each( variants, function( variant ) {
			if ( value.variant === variant ) {
				isValid = true;
			}
			data.push( {
				id: variant,
				text: variant
			} );
		} );
		if ( ! isValid ) {
			value.variant = 'regular';
		}

		if ( jQuery( selector ).hasClass( 'select2-hidden-accessible' ) ) {
			jQuery( selector ).selectWoo( 'destroy' );
			jQuery( selector ).empty();
		}

		// Instantiate selectWoo with the data.
		variantSelector = jQuery( selector ).selectWoo( {
			data: data
		} );
		variantSelector.val( value.variant ).trigger( 'change' );
		variantSelector.on( 'change', function() {
			control.saveValue( 'variant', jQuery( this ).val() );
			if ( 'string' !== typeof value.variant ) {
				value.variant = variants[0];
			}

			fontWeight = ( ! _.isString( value.variant ) ) ? '400' : value.variant.match( /\d/g );
			fontWeight = ( ! _.isObject( fontWeight ) ) ? '400' : fontWeight.join( '' );
			fontStyle  = ( -1 !== value.variant.indexOf( 'italic' ) ) ? 'italic' : 'normal';

			control.saveValue( 'font-weight', fontWeight );
			control.saveValue( 'font-style', fontStyle );
		} );
	},

	/**
	 * Get fonts.
	 */
	getFonts: function() {
		var control            = this,
			initialGoogleFonts = kirki.util.webfonts.google.getFonts(),
			googleFonts        = {},
			googleFontsSort    = 'alpha',
			googleFontsNumber  = 0,
			standardFonts      = {};

		// Get google fonts.
		if ( ! _.isEmpty( control.params.choices.fonts.google ) ) {
			if ( 'alpha' === control.params.choices.fonts.google[0] || 'popularity' === control.params.choices.fonts.google[0] || 'trending' === control.params.choices.fonts.google[0] ) {
				googleFontsSort = control.params.choices.fonts.google[0];
				if ( ! isNaN( control.params.choices.fonts.google[1] ) ) {
					googleFontsNumber = parseInt( control.params.choices.fonts.google[1], 10 );
				}
				googleFonts = kirki.util.webfonts.google.getFonts( googleFontsSort, '', googleFontsNumber );

			} else {
				_.each( control.params.choices.fonts.google, function( fontName ) {
					if ( 'undefined' !== typeof initialGoogleFonts[ fontName ] && ! _.isEmpty( initialGoogleFonts[ fontName ] ) ) {
						googleFonts[ fontName ] = initialGoogleFonts[ fontName ];
					}
				} );
			}
		} else {
			googleFonts = kirki.util.webfonts.google.getFonts( googleFontsSort, '', googleFontsNumber );
		}

		// Get standard fonts.
		if ( ! _.isEmpty( control.params.choices.fonts.standard ) ) {
			_.each( control.params.choices.fonts.standard, function( fontName ) {
				if ( 'undefined' !== typeof kirki.util.webfonts.standard.fonts[ fontName ] && ! _.isEmpty( kirki.util.webfonts.standard.fonts[ fontName ] ) ) {
					standardFonts[ fontName ] = {};
					if ( 'undefined' !== kirki.util.webfonts.standard.fonts[ fontName ].stack && ! _.isEmpty( kirki.util.webfonts.standard.fonts[ fontName ].stack ) ) {
						standardFonts[ fontName ].family = kirki.util.webfonts.standard.fonts[ fontName ].stack;
					} else {
						standardFonts[ fontName ].family = googleFonts[ fontName ];
					}
					if ( 'undefined' !== kirki.util.webfonts.standard.fonts[ fontName ].label && ! _.isEmpty( kirki.util.webfonts.standard.fonts[ fontName ].label ) ) {
						standardFonts[ fontName ].label = kirki.util.webfonts.standard.fonts[ fontName ].label;
					} else if ( ! _.isEmpty( standardFonts[ fontName ] ) ) {
						standardFonts[ fontName ].label = standardFonts[ fontName ];
					}
				} else {
					standardFonts[ fontName ] = {
						family: fontName,
						label: fontName
					};
				}
			} );
		} else {
			_.each( kirki.util.webfonts.standard.fonts, function( font, id ) {
				standardFonts[ id ] = {
					family: font.stack,
					label: font.label
				};
			} );
		}
		return {
			google: googleFonts,
			standard: standardFonts
		};
	},

	localFontsCheckbox: function() {
		var control           = this,
			checkboxContainer = control.container.find( '.kirki-host-font-locally' ),
			checkbox          = control.container.find( '.kirki-host-font-locally input' ),
			checked           = jQuery( checkbox ).is( ':checked' );

		if ( control.setting._value && control.setting._value.downloadFont ) {
			jQuery( checkbox ).attr( 'checked', 'checked' );
		}

		jQuery( checkbox ).on( 'change', function() {
			checked = jQuery( checkbox ).is( ':checked' );
			control.saveValue( 'downloadFont', checked );
		} );
	},

	/**
	 * Saves the value.
	 */
	saveValue: function( property, value ) {

		var control = this,
			input   = control.container.find( '.typography-hidden-value' ),
			val     = control.setting._value;

		val[ property ] = value;

		jQuery( input ).attr( 'value', JSON.stringify( val ) ).trigger( 'change' );
		control.setting.set( val );
	}
} );
/* global kirkiL10n, kirki */
wp.customize.controlConstructor['kirki-typography-advanced'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function() {

		'use strict';

		var control = this,
			value   = control.setting._value,
			picker;
		control.global_types = [
			'font-family',
			'font-backup',
			'font-weight',
			'font-style',
			'variant',
			'text-transform',
			'text-decoration',
			'color',
			'text-align'
		],
		control.media_query_types = [
			'font-size',
			'line-height',
			'margin-top',
			'margin-bottom',
			'letter-spacing',
			'word-spacing'
		];
		
		control.selected_device = kirki.util.media_query_devices.global;
		
		control.initValue();
		control.initMediaQueries();
		
		control.renderFontSelector();
		control.renderBackupFontSelector();
		control.renderVariantSelector();
		control.localFontsCheckbox();

		// Font-size.
		if ( control.params.default['font-size'] ) {
			this.container.on( 'change keyup paste', '.font-size input', function() {
				control.saveValue( 'font-size', jQuery( this ).val() );
			} );
		}

		// Line-height.
		if ( control.params.default['line-height'] ) {
			this.container.on( 'change keyup paste', '.line-height input', function() {
				control.saveValue( 'line-height', jQuery( this ).val() );
			} );
		}

		// Margin-top.
		if ( control.params.default['margin-top'] ) {
			this.container.on( 'change keyup paste', '.margin-top input', function() {
				control.saveValue( 'margin-top', jQuery( this ).val() );
			} );
		}

		// Margin-bottom.
		if ( control.params.default['margin-bottom'] ) {
			this.container.on( 'change keyup paste', '.margin-bottom input', function() {
				control.saveValue( 'margin-bottom', jQuery( this ).val() );
			} );
		}

		// Letter-spacing.
		if ( control.params.default['letter-spacing'] ) {
			value['letter-spacing'] = ( jQuery.isNumeric( value['letter-spacing'] ) ) ? value['letter-spacing'] + 'px' : value['letter-spacing'];
			this.container.on( 'change keyup paste', '.letter-spacing input', function() {
				value['letter-spacing'] = ( jQuery.isNumeric( jQuery( this ).val() ) ) ? jQuery( this ).val() + 'px' : jQuery( this ).val();
				control.saveValue( 'letter-spacing', value['letter-spacing'] );
			} );
		}

		// Word-spacing.
		if ( control.params.default['word-spacing'] ) {
			this.container.on( 'change keyup paste', '.word-spacing input', function() {
				control.saveValue( 'word-spacing', jQuery( this ).val() );
			} );
		}

		// Text-align.
		if ( control.params.default['text-align'] ) {
			this.container.on( 'change', '.text-align input', function() {
				control.saveValue( 'text-align', jQuery( this ).val() );
			} );
		}

		// Text-transform.
		if ( control.params.default['text-transform'] ) {
			jQuery( control.selector + ' .text-transform select' ).selectWoo().on( 'change', function() {
				control.saveValue( 'text-transform', jQuery( this ).val() );
			} );
		}

		// Text-decoration.
		if ( control.params.default['text-decoration'] ) {
			jQuery( control.selector + ' .text-decoration select' ).selectWoo().on( 'change', function() {
				control.saveValue( 'text-decoration', jQuery( this ).val() );
			} );
		}

		// Color.
		if ( ! _.isUndefined( control.params.default.color ) ) {
			picker = this.container.find( '.kirki-color-control' );
			picker.wpColorPicker( {
				change: function() {
					setTimeout( function() {
						control.saveValue( 'color', picker.val() );
					}, 100 );
				}
			} );
		}
	},

	/**
	 * Adds the font-families to the font-family dropdown
	 * and instantiates selectWoo.
	 */
	renderFontSelector: function() {

		var control         = this,
			selector        = control.selector + ' .font-family select',
			data            = [],
			standardFonts   = [],
			googleFonts     = [],
			value           = control.setting._value,
			fonts           = control.getFonts(),
			fontSelect,
			controlFontFamilies;

		// Format standard fonts as an array.
		if ( ! _.isUndefined( fonts.standard ) ) {
			_.each( fonts.standard, function( font ) {
				standardFonts.push( {
					id: font.family.replace( /&quot;/g, '&#39' ),
					text: font.label
				} );
			} );
		}

		// Format google fonts as an array.
		if ( ! _.isUndefined( fonts.google ) ) {
			_.each( fonts.google, function( font ) {
				googleFonts.push( {
					id: font.family,
					text: font.family
				} );
			} );
		}

		// Do we have custom fonts?
		controlFontFamilies = {};
		if ( ! _.isUndefined( control.params ) && ! _.isUndefined( control.params.choices ) && ! _.isUndefined( control.params.choices.fonts ) && ! _.isUndefined( control.params.choices.fonts.families ) ) {
			controlFontFamilies = control.params.choices.fonts.families;
		}

		// Combine forces and build the final data.
		data = jQuery.extend( {}, controlFontFamilies, {
			default: {
				text: kirkiL10n.defaultCSSValues,
				children: [
					{ id: '', text: kirkiL10n.defaultBrowserFamily },
					{ id: 'initial', text: 'initial' },
					{ id: 'inherit', text: 'inherit' }
				]
			},
			standard: {
				text: kirkiL10n.standardFonts,
				children: standardFonts
			},
			google: {
				text: kirkiL10n.googleFonts,
				children: googleFonts
			}
		} );

		if ( kirkiL10n.isScriptDebug ) {
			console.info( 'Kirki Debug: Font families for control "' + control.id + '":' );
			console.info( data );
		}

		data = _.values( data );

		// Instantiate selectWoo with the data.
		fontSelect = jQuery( selector ).selectWoo( {
			data: data
		} );

		// Set the initial value.
		if ( value['font-family'] || '' === value['font-family'] ) {
			fontSelect.val( value['font-family'].replace( /'/g, '"' ) ).trigger( 'change' );
		}

		// When the value changes
		fontSelect.on( 'change', function() {

			// Set the value.
			control.saveValue( 'font-family', jQuery( this ).val() );

			// Re-init the font-backup selector.
			control.renderBackupFontSelector();

			// Re-init variants selector.
			control.renderVariantSelector();
		} );
	},

	/**
	 * Adds the font-families to the font-family dropdown
	 * and instantiates selectWoo.
	 */
	renderBackupFontSelector: function() {

		var control       = this,
			selector      = control.selector + ' .font-backup select',
			standardFonts = [],
			value         = control.setting._value,
			fontFamily    = value['font-family'],
			fonts         = control.getFonts(),
			fontSelect;

		if ( _.isUndefined( value['font-backup'] ) || null === value['font-backup'] ) {
			value['font-backup'] = '';
		}

		// Hide if we're not on a google-font.
		if ( 'inherit' === fontFamily || 'initial' === fontFamily || 'google' !== kirki.util.webfonts.getFontType( fontFamily ) ) {
			jQuery( control.selector + ' .font-backup' ).hide();
			return;
		}
		jQuery( control.selector + ' .font-backup' ).show();

		// Format standard fonts as an array.
		if ( ! _.isUndefined( fonts.standard ) ) {
			_.each( fonts.standard, function( font ) {
				standardFonts.push( {
					id: font.family.replace( /&quot;/g, '&#39' ),
					text: font.label
				} );
			} );
		}

		// Instantiate selectWoo with the data.
		fontSelect = jQuery( selector ).selectWoo( {
			data: standardFonts
		} );

		// Set the initial value.
		if ( 'undefined' !== typeof value['font-backup'] ) {
			fontSelect.val( value['font-backup'].replace( /'/g, '"' ) ).trigger( 'change' );
		}

		// When the value changes
		fontSelect.on( 'change', function() {

			// Set the value.
			control.saveValue( 'font-backup', jQuery( this ).val() );
		} );
	},

	/**
	 * Renders the variants selector using selectWoo
	 * Displays font-variants for the currently selected font-family.
	 */
	renderVariantSelector: function() {
		
		var control    = this,
			value      = control.value,
			fontFamily = value['font-family'],
			selector   = control.selector + ' .variant select',
			data       = [],
			isValid    = false,
			fontType   = kirki.util.webfonts.getFontType( fontFamily ),
			variants   = [ '', 'regular', 'italic', '700', '700italic' ],
			fontWeight,
			variantSelector,
			fontStyle;

		if ( 'google' === fontType ) {
			variants = kirki.util.webfonts.google.getVariants( fontFamily );
		}

		// Check if we've got custom variants defined for this font.
		if ( ! _.isUndefined( control.params ) && ! _.isUndefined( control.params.choices ) && ! _.isUndefined( control.params.choices.fonts ) && ! _.isUndefined( control.params.choices.fonts.variants ) ) {

			// Check if we have variants for this font-family.
			if ( ! _.isUndefined( control.params.choices.fonts.variants[ fontFamily ] ) ) {
				variants = control.params.choices.fonts.variants[ fontFamily ];
			}
		}
		if ( kirkiL10n.isScriptDebug ) {
			console.info( 'Kirki Debug: Font variants for font-family "' + fontFamily + '":' );
			console.info( variants );
		}

		if ( 'inherit' === fontFamily || 'initial' === fontFamily || '' === fontFamily ) {
			value.variant = 'inherit';
			variants      = [ '' ];
			jQuery( control.selector + ' .variant' ).hide();
		}

		if ( 1 >= variants.length ) {
			jQuery( control.selector + ' .variant' ).hide();

			value.variant = variants[0];

			control.saveValue( 'variant', value.variant );

			if ( '' === value.variant || ! value.variant ) {
				fontWeight = '';
				fontStyle  = '';
			} else {
				fontWeight = ( ! _.isString( value.variant ) ) ? '400' : value.variant.match( /\d/g );
				fontWeight = ( ! _.isObject( fontWeight ) ) ? '400' : fontWeight.join( '' );
				fontStyle  = ( -1 !== value.variant.indexOf( 'italic' ) ) ? 'italic' : 'normal';
			}

			control.saveValue( 'font-weight', fontWeight );
			control.saveValue( 'font-style', fontStyle );

			return;
		}

		jQuery( control.selector + ' .font-backup' ).show();

		jQuery( control.selector + ' .variant' ).show();
		_.each( variants, function( variant ) {
			if ( value.variant === variant ) {
				isValid = true;
			}
			data.push( {
				id: variant,
				text: variant
			} );
		} );
		if ( ! isValid ) {
			value.variant = 'regular';
		}

		if ( jQuery( selector ).hasClass( 'select2-hidden-accessible' ) ) {
			jQuery( selector ).selectWoo( 'destroy' );
			jQuery( selector ).empty();
		}

		// Instantiate selectWoo with the data.
		variantSelector = jQuery( selector ).selectWoo( {
			data: data
		} );
		variantSelector.val( value.variant ).trigger( 'change' );
		variantSelector.on( 'change', function() {
			control.saveValue( 'variant', jQuery( this ).val() );
			if ( 'string' !== typeof value.variant ) {
				value.variant = variants[0];
			}

			fontWeight = ( ! _.isString( value.variant ) ) ? '400' : value.variant.match( /\d/g );
			fontWeight = ( ! _.isObject( fontWeight ) ) ? '400' : fontWeight.join( '' );
			fontStyle  = ( -1 !== value.variant.indexOf( 'italic' ) ) ? 'italic' : 'normal';

			control.saveValue( 'font-weight', fontWeight );
			control.saveValue( 'font-style', fontStyle );
		} );
	},

	/**
	 * Get fonts.
	 */
	getFonts: function() {
		var control            = this,
			initialGoogleFonts = kirki.util.webfonts.google.getFonts(),
			googleFonts        = {},
			googleFontsSort    = 'alpha',
			googleFontsNumber  = 0,
			standardFonts      = {};

		// Get google fonts.
		if ( ! _.isEmpty( control.params.choices.fonts.google ) ) {
			if ( 'alpha' === control.params.choices.fonts.google[0] || 'popularity' === control.params.choices.fonts.google[0] || 'trending' === control.params.choices.fonts.google[0] ) {
				googleFontsSort = control.params.choices.fonts.google[0];
				if ( ! isNaN( control.params.choices.fonts.google[1] ) ) {
					googleFontsNumber = parseInt( control.params.choices.fonts.google[1], 10 );
				}
				googleFonts = kirki.util.webfonts.google.getFonts( googleFontsSort, '', googleFontsNumber );

			} else {
				_.each( control.params.choices.fonts.google, function( fontName ) {
					if ( 'undefined' !== typeof initialGoogleFonts[ fontName ] && ! _.isEmpty( initialGoogleFonts[ fontName ] ) ) {
						googleFonts[ fontName ] = initialGoogleFonts[ fontName ];
					}
				} );
			}
		} else {
			googleFonts = kirki.util.webfonts.google.getFonts( googleFontsSort, '', googleFontsNumber );
		}

		// Get standard fonts.
		if ( ! _.isEmpty( control.params.choices.fonts.standard ) ) {
			_.each( control.params.choices.fonts.standard, function( fontName ) {
				if ( 'undefined' !== typeof kirki.util.webfonts.standard.fonts[ fontName ] && ! _.isEmpty( kirki.util.webfonts.standard.fonts[ fontName ] ) ) {
					standardFonts[ fontName ] = {};
					if ( 'undefined' !== kirki.util.webfonts.standard.fonts[ fontName ].stack && ! _.isEmpty( kirki.util.webfonts.standard.fonts[ fontName ].stack ) ) {
						standardFonts[ fontName ].family = kirki.util.webfonts.standard.fonts[ fontName ].stack;
					} else {
						standardFonts[ fontName ].family = googleFonts[ fontName ];
					}
					if ( 'undefined' !== kirki.util.webfonts.standard.fonts[ fontName ].label && ! _.isEmpty( kirki.util.webfonts.standard.fonts[ fontName ].label ) ) {
						standardFonts[ fontName ].label = kirki.util.webfonts.standard.fonts[ fontName ].label;
					} else if ( ! _.isEmpty( standardFonts[ fontName ] ) ) {
						standardFonts[ fontName ].label = standardFonts[ fontName ];
					}
				} else {
					standardFonts[ fontName ] = {
						family: fontName,
						label: fontName
					};
				}
			} );
		} else {
			_.each( kirki.util.webfonts.standard.fonts, function( font, id ) {
				standardFonts[ id ] = {
					family: font.stack,
					label: font.label
				};
			} );
		}
		return {
			google: googleFonts,
			standard: standardFonts
		};
	},

	localFontsCheckbox: function() {
		var control           = this,
			checkboxContainer = control.container.find( '.kirki-host-font-locally' ),
			checkbox          = control.container.find( '.kirki-host-font-locally input' ),
			checked           = jQuery( checkbox ).is( ':checked' );

		if ( control.setting._value && control.setting._value.downloadFont ) {
			jQuery( checkbox ).attr( 'checked', 'checked' );
		}

		jQuery( checkbox ).on( 'change', function() {
			checked = jQuery( checkbox ).is( ':checked' );
			control.saveValue( 'downloadFont', checked );
		} );
	},
	
	initValue: function()
	{
		var control = this,
		defs = control.params.default,
			loadedValue = control.setting._value;
		control.value = {
			use_media_queries: loadedValue.use_media_queries || false,
			loaded: !_.isUndefined( loadedValue ),
			global: control.defaultValue(),
			desktop: control.defaultValue(),
			tablet: control.defaultValue(),
			mobile: control.defaultValue(),
		};
		control.value = control.defaultGlobalValue( control.value );
		
		if ( loadedValue.use_media_queries )
		{
			kirki.util.media_query_device_names.forEach( function( name )
			{
				if ( !control.value[name].loaded && loadedValue[name] )
				{
					control.value[name] = loadedValue[name];
					control.value[name]['loaded'] = true;
				}
			});
			if ( loadedValue['desktop'] )
				control.value['global'] = control.value['desktop'];
		}
		else
		{
			if ( !control.value['global'].loaded && loadedValue['global'] )
			{
				control.value['global'] = loadedValue['global'];
				control.value['global']['loaded'] = true;
			}
		}
		
		var id = control.value.use_media_queries ? 'desktop' : 'global';
		//Set global values
		control.global_types.forEach( function( name )
		{
			if ( _.isUndefined( defs[name] ) )
				return false;
			control.value[name] = control.value.loaded ? loadedValue[name] : defs[name];
			switch ( name )
			{
				case 'font-family':
				case 'font-backup':
				case 'variant':
				case 'text-transform':
					var select = control.container.find( 'div.font-family select,div.font-backup select,div.variant select,div.text-transform select' );
					select.val( control.value[name] );
					break;
				case 'text-align':
					var radio = control.container.find( 'div.text-align input[value="' + value + '"]' );
					radio.prop( 'checked', true );
					break;
				default:
					var input = control.container.find( 'div.' + name + ' input' );
					input.val( control.value[name] );
					break;
			}
		});
		//Set media query values
		control.media_query_types.forEach( function( name )
		{
			if ( _.isUndefined( defs[name] ) )
				return false;
			control.value[id][name] = control.value[id].loaded ? loadedValue[id][name] : defs[name];
			switch ( name )
			{
				case 'font-family':
				case 'font-backup':
				case 'variant':
				case 'text-transform':
					var select = control.container.find( 'div.font-family select,div.font-backup select,div.variant select,div.text-transform select' );
					select.val( control.value[id][name] );
					break;
				case 'text-align':
					var radio = control.container.find( 'div.text-align input[value="' + value + '"]' );
					radio.prop( 'checked', true );
					break;
				default:
					var input = control.container.find( 'div.' + name + ' input' );
					input.val( control.value[id][name] );
					break;
			}
		});
		control.value['downloadFont'] = loadedValue.downloadFont || false;
	},
	
	initMediaQueries: function()
	{
		var control = this;
		//If media queries are used, we need to detect device changes.
		if ( control.params.choices.use_media_queries )
		{
			kirki.util.helpers.media_query( control, control.value.use_media_queries, {
				device_change: function( device, enabled )
				{
					control.selected_device = device;
					control.value.use_media_queries = enabled;
					var device_name = control.getSelectedDeviceName(),
						value_to_set = null;
					if ( enabled && !control.initial_media_query )
					{
						kirki.util.media_query_device_names.forEach( function( name )
						{
							if ( !control.value[device_name] )
							{
								control.value[device_name] = control.defaultValue();
							}
						});
					}
					if ( enabled )
						control.value.desktop = control.value.global;
					else
						control.value.global = control.value.desktop;
					var value_to_set = control.value[device_name];
					var defs = control.params.default;
					//Set media query values
					control.media_query_types.forEach( function( name )
					{
						if ( _.isUndefined( defs[name] ) )
							return false;
						var value = value_to_set[name];
						var input = control.container.find( 'div.' + name + ' input' );
						input.val( value );
					});
					
					control.save();
					control.initial_media_query = true;
				}
			});
		}
	},
	
	getSelectedDeviceName: function()
	{
		var control = this,
			device = 'global';
		if ( control.selected_device == kirki.util.media_query_devices.desktop )
			device = 'desktop';
		else if ( control.selected_device == kirki.util.media_query_devices.tablet )
			device = 'tablet';
		else if ( control.selected_device == kirki.util.media_query_devices.mobile )
			device = 'mobile';
		return device;
	},
	
	/**
	 * Saves the value.
	 */
	saveValue: function( property, value ) {

		var control = this,
			val     = control.value;
		if ( control.media_query_types.includes( property ) )
			val[control.getSelectedDeviceName()][ property ] = value;
		else
			val[ property ] = value;
		control.save();
	},
	
	save: function()
	{
		var control = this,
			input   = control.container.find( '.typography-hidden-value' ),
			compiled = jQuery.extend( {}, control.value );
		delete compiled.loaded;
		if ( compiled.use_media_queries )
		{
			delete compiled.global;
			delete compiled.desktop.loaded;
			delete compiled.tablet.loaded;
			delete compiled.mobile.loaded;
		}
		else
		{
			delete compiled.desktop;
			delete compiled.tablet;
			delete compiled.mobile;
		}
		input.val( JSON.stringify( compiled ) ).trigger( 'change' );
		control.setting.set( compiled );
	},
	
	defaultValue: function() {
		var control = this,
			value = { loaded: false };
		control.media_query_types.forEach( function( type )
		{
			if ( _.isUndefined( control.params.default[type] ) )
				return false;
			value[type] = '';
		});
		return value;
	},
	
	defaultGlobalValue: function( value ) {
		var control = this;
		control.global_types.forEach( function( type )
		{
			if ( _.isUndefined( control.params.default[type] ) )
				return false;
			value[type] = '';
		});
		value['font-weight'] = '';
		value['font-style'] = '';
		value['variant'] = '';
		value['downloadFont'] = false;
		value['text-align'] = 'left';
		return value;
	}
} );
