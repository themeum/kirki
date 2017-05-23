var kirkiPostMessage = {

	/**
	 * Helper function to correctly get the font-weight from a variant
	 * when using a typography field.
	 *
	 * @since  3.0.0
	 * @param  object value The value of the setting.
	 * @return int|string
	 */
	getFontWeight: function( value ) {
		var calculated;

		// Return 400 if invalid input.
		if ( ! _.isString( value ) ) {
			return 400;
		}

		// Get only digits. If non-numeric value, then return 400.
		calculated = value.match( /\d/g );
		return ( ! _.isObject( calculated ) ) ? 400 : calculated.join( '' );
	},

	/**
	 * Helper function to correctly get the vars with all defaults set.
	 *
	 * @since  3.0.0
	 * @param  object jsVar The arguments of the jsVars we'll be using.
	 * @return object
	 */
	getVarComplete: function( jsVar ) {
		return _.defaults( jsVar, {
			element: '',
			property: '',
			prefix: '',
			suffix: '',
			units: '',
			'function': 'css',
			value_pattern: '$'
		});
	},

	/**
	 * Make sure images have url("{image}") instead of just the URL.
	 *
	 * @since  3.0.0
	 * @param  string property The CSS property to check against.
	 * @param  string value    The setting value.
	 * @return string
	 */
	applyBackgroundImage: function( property, value ) {
		if ( 'background-image' === property && 0 > value.indexOf( 'url(' ) ) {
			value = 'url("' + value + '")';
		}
		return value;
	},

	/**
	 * Adds google-fonts scripts and returns the CSS for the typography field.
	 *
	 * @since  3.0.0
	 * @param  object value The setting value.
	 * @param  object args  The arguments we're using to auto-calculate the CSS.
	 * @return object
	 */
	applyTypography: function( value, args ) {
		var $this         = this,
		    subsetsString = '',
		    css           = '';

		// Early exit if this is not an object.
		if ( ! _.isObject( value ) ) {
			return;
		}

		// If 'font-family' is not defined then this is not a typography field.
		if ( _.isUndefined( value['font-family'] ) ) {
			return;
		}

		// Make sure variants and subsets are defined.
		value.variant = ( _.isUndefined( value.variant ) ) ? 400 : value.variant;
		value.subsets = ( _.isUndefined( value.subsets ) ) ? [] : value.subsets;
		subsetsString = ( _.isObject( value.subsets ) ) ? ':' + value.subsets.join( ',' ) : '';

		// Load the font using WenFontloader.
		jQuery( 'head' ).append( '<script>if(!_.isUndefined(WebFont)){WebFont.load({google:{families:[\'' + value['font-family'] + ':' + value.variant + subsetsString + '\']}});}</script>' );

		// Add the CSS.
		css += args.element + '{font-weight:' + $this.getFontWeight( value.variant ) + '}';
		css += ( -1 !== value.variant.indexOf( 'italic' ) ) ? args.element + '{font-style:italic;}' : args.element + '{font-style:normal;}';
		return css;
	},

	/**
	 * Generates the CSS.
	 *
	 * @since  3.0.0
	 * @param  mixed  value   The setting value.
	 * @param  object args    The arguments.
	 * @param  string setting The setting we're checking.
	 * @return object
	 */
	generateCSS: function( value, args, setting ) {
		var $this    = this,
		    settings = window.wp.customize.get(),
		    css      = '',
		    regex;


		// Value is string.
		if ( _.isString( value ) ) {

			// No need to proceed if empty.
			if ( '' === value ) {
				return '';
			}

			// WIP. Ignore.
			if ( ! _.isUndefined( args.value_pattern ) && '' !== args.value_pattern && '$' !== args.value_pattern && ! _.isUndefined( args.replacements ) ) {
				_.each( args.replacements, function( replace, search ) {
					var item;
					if ( 'this' === replace ) {
						if ( _.isUndefined( settings ) || _.isUndefined( settings[ setting ] ) ) {
							return; // Continue.
						}
						replace = settings[ setting ];
					} else {
						if ( -1 !== replace.indexOf( '[' ) ) {
							item = replace.replace( ']', '' ).split( '[' );
							if ( _.isUndefined( settings ) || _.isUndefined( settings[ item[0] ] ) || _.isUndefined( settings[ item[0] ][ item[1] ] ) ) {
								return; // Continue.
							}
							replace = settings[ item[0] ][ item[1] ];
						}
						if ( _.isUndefined( settings ) || _.isUndefined( settings[ replace ] ) ) {
							return; // Continue.
						}
						replace = settings[ replace ];
					}
					regex = new RegExp( search, 'g' );
					args.value_pattern = args.value_pattern.replace( regex, replace );
				});
				args.value_pattern.replace( /\$/g, args.prefix + value + args.units + args.suffix );
			}

			// Calculate and return the CSS.
			value = args.value_pattern.replace( /\$/g, args.prefix + value + args.units + args.suffix );
			value = $this.applyBackgroundImage( args.property, value );

			return args.element + '{' + args.property + ':' + value + ';}';

		// Value is an object.
		} else if ( _.isObject( value ) ) {
			_.each( value, function( subVal, subKey ) {

				// Make sure that if 'background-image' is used, it's properly formatted.
				subVal = $this.applyBackgroundImage( subKey, subVal );

				// Apply css and webfonts for typography controls.
				css += $this.applyTypography( value, args );

				// Hack for the "choice" argument.
				if ( ! _.isUndefined( args.choice ) ) {
					if ( args.choice === subKey ) {
						css += args.element + '{' + args.property + ':' + args.prefix + subVal + args.units + args.suffix + ';}';
					}
				} else {

					// Mostly used for padding, margin & position properties.
					if ( _.contains( [ 'top', 'bottom', 'left', 'right' ], subKey ) ) {
						css += args.element + '{' + args.property + '-' + subKey + ':' + args.prefix + subVal + args.units + args.suffix + ';}';
					} else if ( 'subsets' !== subKey && 'variant' !== subKey ) {

						// This is where most object-based fields will go.
						css += args.element + '{' + subKey + ':' + args.prefix + subVal + args.units + args.suffix + ';}';
					}
				}
			});
			return css;
		}
		return '';
	},

	/**
	 * Loops our fields and does what needs to be done.
	 *
	 * @since  3.0.0
	 */
	init: function() {
		var $this = this;
		_.each( jsvars, function( jsVars, setting ) {
			var css      = '',
			    cssArray = {};

			wp.customize( setting, function( value ) {
				value.bind( function( newval ) {
					if ( ! _.isUndefined( jsVars ) && 0 < jsVars.length ) {
						_.each( jsVars, function( jsVar ) {
							var val = newval;

							jsVar = $this.getVarComplete( jsVar );

							_.each( jsVars, function( args, i ) {

								// If we're using "html" instead of "css" then add the HTML.
								if ( _.isString( newval ) && 'html' === args['function'] ) {
									if ( ! _.isUndefined( args.attr ) ) {
										jQuery( args.element ).attr( args.attr, val );
									} else {
										jQuery( args.element ).html( val );
									}
								} else {

									// Generate the CSS.
									cssArray[ i ] = $this.generateCSS( newval, args, setting );
								}
							});
						});

						// Adds the CSS to the document.
						_.each( cssArray, function( singleCSS ) {
							css = '';
							setTimeout( function() {

								if ( '' !== singleCSS ) {
									css += singleCSS;
								}

								// Attach to <head>. Make sure we have a stylesheet with the defined ID,
								// and if we don't then add it.
								if ( ! jQuery( '#kirki-customizer-postmessage' + setting.replace( /\[/g, '-' ).replace( /\]/g, '' ) ).size() ) {
									jQuery( 'head' ).append( '<style id="kirki-customizer-postmessage' + setting.replace( /\[/g, '-' ).replace( /\]/g, '' ) + '"></style>' );
								}
								jQuery( '#kirki-customizer-postmessage' + setting.replace( /\[/g, '-' ).replace( /\]/g, '' ) ).text( css );
							}, 100 );
						});
					}
				});
			});
		});
	}
};

// Init.
jQuery( document ).ready( function() {
	kirkiPostMessage.init();
});
