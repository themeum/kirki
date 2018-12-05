/* global ajaxurl */
var kirki = kirki || {};
kirki = jQuery.extend( kirki, {
	/**
	 * A collection of utility methods.
	 *
	 * @since 3.0.17
	 */
	util: {
		media_query_devices: { desktop: 'desktop', tablet: 'tablet', mobile: 'mobile' },
		sides: { top: 'top', right: 'right', bottom: 'bottom', left: 'left' },
		sides_array: ['top', 'right', 'bottom', 'left'],
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
			setupMediaQueries: function( control ) {
				var has_units            = !_.isUndefined( control.params.choices.units );
				var desktop_wrappers     = control.container.find( '.control-wrapper-outer' ),
					desktop_unit_wrapper = control.container.find( '.kirki-unit-choices-outer' );
				var device_wrappers = {
					'desktop': [],
					'tablet': [],
					'mobile': []
				},
				unit_wrappers = {};
				//If media queries are not enabled in some way, just return the containers as desktop devices.
				if ( !control.params.use_media_queries && !control.params.choices.use_media_queries )
				{
					return {
						devices: { 'desktop': desktop_wrappers },
						units:   { 'desktop': desktop_unit_wrapper }
					};
				}
				
				desktop_wrappers.each( function(){
					var desktop_wrapper = $( this );
					//If media queries is enabled, we need to clone the containers for each device to keep input separated.
					//Clone the initial wrapper and add tablet/mobile.
					var tablet_wrapper = desktop_wrapper.clone().addClass( 'device-tablet' ).attr( 'device', 'tablet' ),
						mobile_wrapper = desktop_wrapper.clone().addClass( 'device-mobile' ).attr( 'device', 'mobile' );
					//Add desktop to the original wrapper.
					desktop_wrapper.addClass( 'device-desktop active' ).attr( 'device', 'desktop' );
					
					//Append to the container.
					tablet_wrapper.insertAfter( desktop_wrapper );
					mobile_wrapper.insertAfter( tablet_wrapper );
					
					//Add all the wrappers to the array for iterating.
					device_wrappers['desktop'].push( desktop_wrapper );
					device_wrappers['tablet'].push( tablet_wrapper );
					device_wrappers['mobile'].push( mobile_wrapper );
				});
				//If we're using units, we need to do the same thing.
				if ( has_units )
				{
					//Do the same type of duplication as above.
					var tablet_unit_wrapper = desktop_unit_wrapper.clone().addClass( 'device-tablet' ).attr( 'device', 'tablet' ),
						mobile_unit_wrapper = desktop_unit_wrapper.clone().addClass( 'device-mobile' ).attr( 'device', 'mobile' );
					desktop_unit_wrapper.addClass( 'device-desktop active' ).attr( 'device', 'desktop' );
					
					//Append to the container.
					tablet_unit_wrapper.insertAfter( desktop_unit_wrapper );
					mobile_unit_wrapper.insertAfter( tablet_unit_wrapper );
					
					//Append to the unit_wrapper object.
					unit_wrappers['desktop'] = desktop_unit_wrapper;
					unit_wrappers['tablet']  = tablet_unit_wrapper;
					unit_wrappers['mobile']  = mobile_unit_wrapper;
					
					//Normalize the IDs of the unit choices to match the device.
					_.each( unit_wrappers, function( unit_wrapper )
					{
						var choice_wrappers = unit_wrapper.find( '.kirki-unit-choice' ),
							device          = unit_wrapper.attr( 'device' );
						choice_wrappers.each( function()
						{
							var choice_wrapper = $( this ),
								input          = choice_wrapper.find( 'input[type="radio"]' ),
								label          = choice_wrapper.find( 'label' ),
								id             = input.attr( 'id' ),
								name           = input.attr( 'name' )
								new_id         = id + '_' + device,
								new_name       = name + '_' + device;
							input.attr( 'id', new_id ).attr( 'name', new_name );
							label.attr( 'for', new_id );
						});
					});
				}
				
				return {
					devices: device_wrappers,
					units: unit_wrappers
				};
			},
			initUnitSelect: function( control, args )
			{
				var container = control.container,
					unit_radios = jQuery( '.kirki-unit-choice input[type="radio"]', container );
				if ( args.selected_unit )
					unit_radios.filter( '[value="' + args.selected_unit + '"]' ).click();
				else
					unit_radios.first().click();
				unit_radios.on( 'change', function( e )
				{
					e.preventDefault();
					e.stopPropagation();
					var unit_radio = $( this ),
						new_unit = unit_radio.val();
					if ( args.unit_changed )
						args.unit_changed ( new_unit );
				});
			},
			selectUnit: function( unit_wrapper, value ) {
				var radios = unit_wrapper.find( 'input[type="radio"]' );
				if ( !value )
				{
					value = radios.first().val();
				}
				radios.filter( ':checked' ).prop( 'checked', false );
				var wanted_radio = radios.filter( '[value="' + value + '"]' );
				if ( wanted_radio.length )
					wanted_radio.prop( 'checked', true ).trigger( 'change' );
				else
					radios.first().prop( 'checked', true ).trigger( 'change' );
			},
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
		},
		
		parseNumber: function( str ){
			return parseFloat( str );
			// var numberRegex = /[0-9]\d{0,9}(\.\d{1,3})?%?/gm;
			// if ( typeof str === 'undefined' )
			// 	return '';
			// var result = str.toString().match( numberRegex );
			// if ( result )
			// 	return result[0];
			// else
			// 	return null;
		}
	}
} );
