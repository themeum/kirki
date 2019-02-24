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
		}
	}
} );
