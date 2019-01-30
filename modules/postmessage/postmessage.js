/* global kirkiPostMessageFields, WebFont */
var kirkiPostMessage = {

	/**
	 * The fields.
	 *
	 * @since 3.0.26
	 */
	fields: {},

	/**
	 * A collection of methods for the <style> tags.
	 *
	 * @since 3.0.26
	 */
	styleTag: {

		/**
		 * Add a <style> tag in <head> if it doesn't already exist.
		 *
		 * @since 3.0.26
		 * @param {string} id - The field-ID.
		 * @returns {void}
		 */
		add: function( id ) {
			if ( null === document.getElementById( 'kirki-postmessage-' + id ) || 'undefined' === typeof document.getElementById( 'kirki-postmessage-' + id ) ) {
				jQuery( 'head' ).append( '<style id="kirki-postmessage-' + id + '"></style>' );
			}
		},

		/**
		 * Add a <style> tag in <head> if it doesn't already exist,
		 * by calling the this.add method, and then add styles inside it.
		 *
		 * @since 3.0.26
		 * @param {string} id - The field-ID.
		 * @param {string} styles - The styles to add.
		 * @returns {void}
		 */
		addData: function( id, styles ) {
			kirkiPostMessage.styleTag.add( id );
			jQuery( '#kirki-postmessage-' + id ).text( styles );
		},
		
		removeData: function( id ) {
			if ( null !== document.getElementById( 'kirki-postmessage-' + id ) || 'undefined' !== typeof document.getElementById( 'kirki-postmessage-' + id ) ) {
				jQuery( '#kirki-postmessage-' + id ).remove();
			}
		}
	},

	/**
	 * Common utilities.
	 *
	 * @since 3.0.26
	 */
	util: {

		/**
		 * Processes the value and applies any replacements and/or additions.
		 *
		 * @since 3.0.26
		 * @param {Object} output - The output (js_vars) argument.
		 * @param {mixed}  value - The value.
		 * @param {string} controlType - The control-type.
		 * @returns {string|false} - Returns false if value is excluded, otherwise a string.
		 */
		processValue: function( output, value ) {
			var self     = this,
				settings = window.parent.wp.customize.get(),
				excluded = false;

			if ( 'string' !== typeof value ) {
				_.each( value, function( subValue, key ) {
					value[ key ] = self.processValue( output, subValue );
				} );
				return value;
			}
			output = _.defaults( output, {
				prefix: '',
				units: '',
				suffix: '',
				value_pattern: '$',
				pattern_replace: {},
				exclude: []
			} );

			if ( 1 <= output.exclude.length ) {
				_.each( output.exclude, function( exclusion ) {
					if ( value == exclusion ) {
						excluded = true;
					}
				} );
			}

			if ( excluded ) {
				return false;
			}

			value = output.value_pattern.replace( new RegExp( '\\$', 'g' ), value );
			_.each( output.pattern_replace, function( id, placeholder ) {
				if ( ! _.isUndefined( settings[ id ] ) ) {
					value = value.replace( placeholder, settings[ id ] );
				}
			} );
			return output.prefix + value + output.units + output.suffix;
		},

		/**
		 * Make sure urls are properly formatted for background-image properties.
		 *
		 * @since 3.0.26
		 * @param {string} url - The URL.
		 * @returns {string}
		 */
		backgroundImageValue: function( url ) {
			return ( -1 === url.indexOf( 'url(' ) ) ? 'url(' + url + ')' : url;
		}
	},

	/**
	 * A collection of utilities for CSS generation.
	 *
	 * @since 3.0.26
	 */
	css: {

		/**
		 * Generates the CSS from the output (js_vars) parameter.
		 *
		 * @since 3.0.26
		 * @param {Object} output - The output (js_vars) argument.
		 * @param {mixed}  value - The value.
		 * @param {string} controlType - The control-type.
		 * @returns {string}
		 */
		fromOutput: function( output, value, controlType ) {
			var styles      = '',
				kirkiParent = window.parent.kirki,
				googleFont  = '',
				mediaQuery  = false,
				processedValue;
			var devices = ['desktop', 'tablet', 'mobile'];
			if ( output.js_callback && 'function' === typeof window[ output.js_callback ] ) {
				value = window[ output.js_callback[0] ]( value, output.js_callback[1] );
			}
			switch ( controlType ) {
				case 'kirki-typography':
					styles += output.element + '{';
					_.each( value, function( val, key ) {
						if ( output.choice && key !== output.choice ) {
							return;
						}
						processedValue = kirkiPostMessage.util.processValue( output, val );
						if ( false !== processedValue ) {
							styles += key + ':' + processedValue + ';';
						}
					} );
					styles += '}';

					// Check if this is a googlefont so that we may load it.
					if ( ! _.isUndefined( WebFont ) && value['font-family'] && 'google' === kirkiParent.util.webfonts.getFontType( value['font-family'] ) ) {

						// Calculate the googlefont params.
						googleFont = value['font-family'].replace( /\"/g, '&quot;' );
						if ( value.variant ) {
							if ( 'regular' === value.variant ) {
								googleFont += ':400';
							} else if ( 'italic' === value.variant ) {
								googleFont += ':400i';
							} else {
								googleFont += ':' + value.variant;
							}
						}
						googleFont += ':cyrillic,cyrillic-ext,devanagari,greek,greek-ext,khmer,latin,latin-ext,vietnamese,hebrew,arabic,bengali,gujarati,tamil,telugu,thai';
						WebFont.load( {
							google: {
								families: [ googleFont ]
							}
						} );
					}
					break;
				case 'kirki-background':
				case 'kirki-dimensions':
				case 'kirki-multicolor':
				case 'kirki-sortable':
					styles += output.element + '{';
					_.each( value, function( val, key ) {
						if ( output.choice && key !== output.choice ) {
							return;
						}
						if ( 'background-image' === key ) {
							val = kirkiPostMessage.util.backgroundImageValue( val );
						}

						processedValue = kirkiPostMessage.util.processValue( output, val );

						if ( false !== processedValue ) {

							// Mostly used for padding, margin & position properties.
							if ( output.property ) {
								styles += output.property;
								if ( '' !== output.property && ( 'top' === key || 'bottom' === key || 'left' === key || 'right' === key ) ) {
									styles += '-' + key;
								}
								styles += ':' + processedValue + ';';
							} else {
								styles += key + ':' + processedValue + ';';
							}
						}
					} );
					styles += '}';
					break;
				case 'kirki-typography-advanced':
					if ( typeof value === 'string' )
						value = JSON.parse( value );
					styles += output.element + '{';
					_.each( value, function( val, key ) {
						//Only output the global values.
						if ( _.contains( devices, key ) )
							return false;
						if ( _.contains([ 'downloadFont', 'variant', 'use_media_queries' ], key ) )
							return false;
						if ( output.choice && key !== output.choice ) {
							return false;
						}
						processedValue = kirkiPostMessage.util.processValue( output, val );
						if ( false !== processedValue ) {
							styles += key + ':' + processedValue + ';';
						}
					} );
					styles += '}';
					
					_.each( devices, function( device_name )
					{
						if ( _.isUndefined( value[device_name] ) )
							return false;
						var device_val = value[device_name],
							media_query = kirkiMediaQueries[device_name];
						if ( media_query === 'desktop' )
							media_query = null;
						if ( media_query )
							styles += media_query + '{';
						var value_keys = Object.keys( device_val );
						_.each( value_keys, function( key )
						{
							var val = device_val[key];
							if ( _.isEmpty( val ) )
								return false;
							styles += output.element + '{';
							if ( output.choice && key !== output.choice ) {
								return false;
							}
							processedValue = kirkiPostMessage.util.processValue( output, val );
							if ( false !== processedValue ) {
								styles += key + ':' + kirkiPostMessage.util.processValue( output, val ) + ';';
							}
							
							styles += '}';
						});
						if ( media_query )
							styles += '}';
					});
					
					// Check if this is a googlefont so that we may load it.
					if ( ! _.isUndefined( WebFont ) && value['font-family'] && 'google' === kirkiParent.util.webfonts.getFontType( value['font-family'] ) ) {
						
						// Calculate the googlefont params.
						googleFont = value['font-family'].replace( /\"/g, '&quot;' );
						if ( value.variant ) {
							if ( 'regular' === value.variant ) {
								googleFont += ':400';
							} else if ( 'italic' === value.variant ) {
								googleFont += ':400i';
							} else {
								googleFont += ':' + value.variant;
							}
						}
						googleFont += ':cyrillic,cyrillic-ext,devanagari,greek,greek-ext,khmer,latin,latin-ext,vietnamese,hebrew,arabic,bengali,gujarati,tamil,telugu,thai';
						WebFont.load( {
							google: {
								families: [ googleFont ]
							}
						} );
					}
					break;
				case 'kirki-border':
					styles += output.element + '{';
					styles += 'border-style: ' + value['style'] + ';';
					if ( value['style'] !== 'none' )
					{
						var border_width = [];
						_.each( ['top', 'right', 'bottom', 'left'], function( side )
						{
							border_width.push( value[side] );
						});
						styles += 'border-width: ' + border_width.join( ' ' ) + ';' ;
						if ( !_.isEmpty( value['color'] ) )
							styles += 'border-color: ' + value['color'] + ';';
					}
					styles += '}';
					break;
				case 'kirki-box-shadow':
					if ( _.isEmpty( value['color'] ) )
						break;
					styles += output.element + '{';
					styles += 'box-shadow: ';
					var props = [];
					_.each( ['h_offset', 'v_offset', 'blur', 'spread', 'color'], function( side )
					{
						props.push( value[side] );
					});
					styles += props.join( ' ' ) + ';';
					styles += '}';
					break;
				case 'kirki-color-gradient':
					styles += output.element + '{';
					var gradient = 'linear-gradient(' + value['direction'] + ', ' + value['color1'] + ' ' + value['location'] + ', ' + value['color2'] + ')';
					styles += 'background-image: ' + gradient + ';';
					styles += 'background: ' + gradient + ';';
					styles += 'background-color: ' + gradient + ';';
					styles += '}';
					break;
				case 'kirki-slider-advanced':
					if ( typeof value === 'object' )
					{
						var keys = Object.keys( value );
						if ( _.contains( keys, 'desktop' ) )
						{
							// Overwrite any possible use of media queries.
							output.media_query = null;
							_.each( devices, function( device_name )
							{
								if ( _.isUndefined( value[device_name] ) )
									return false;
								var device_val = null,
									media_query = kirkiMediaQueries[device_name];
								if ( media_query === 'desktop' )
										media_query = null;
								
								if ( !_.isUndefined( value[device_name]['unit'] ) )
								{
									device_val = value[device_name]['value'];
									output['units'] = value[device_name]['unit'];
								}
								else
								{
									device_val = value[device_name];
								}
								processedValue = kirkiPostMessage.util.processValue( output, device_val );
								if ( media_query )
									styles += media_query + '{';
								styles += output.element + '{'
								styles += output.property + ': ' + processedValue + ';';
								styles += '}';
								if ( media_query )
									styles += '}';
							});
						}
						else
						{
							output['suffix'] = '';
							output['units'] = value['unit'];
							var val = kirkiPostMessage.util.processValue( output, value['value'] );
							styles += output.element + '{'
							styles += output.property + ': ' + val + ';';
							styles += '}';
						}
					}
					else if ( !Number.isNaN( value ) )
					{
						processedValue = kirkiPostMessage.util.processValue( output, value );
						styles += output.element + '{'
						styles += output.property + ': ' + processedValue + ';';
						styles += '}';
					}
					break;
				case 'kirki-spacing-advanced':
					var generate_styles = function( output, device_val )
					{
						var styles = '';
						_.each( ['top', 'right', 'bottom', 'left'], function( side )
						{
							if ( _.isUndefined( device_val[side] ) || _.isEmpty( device_val[side].toString() ) )
								return false;
							var value = device_val[side],
								unit  = device_val['unit'] || '';
							if ( unit )
								output['units'] = unit;
							value = kirkiPostMessage.util.processValue( output, value );
							styles += output.property + '-' + side + ': ' + value + ';';
						});
						return styles;
					};
					var keys = Object.keys( value );
					if ( _.contains( keys, 'desktop' ) )
					{
						// Overwrite any possible use of media queries.
						output.media_query = null;
						_.each( devices, function( device_name )
						{
							if ( _.isUndefined( value[device_name] ) )
								return;
							var device_val = value[device_name],
								media_query = kirkiMediaQueries[device_name];
							if ( media_query === 'desktop' )
								media_query = null;
							if ( media_query )
								styles += media_query + '{';
								
							styles += output.element + '{';
							styles += generate_styles( output, device_val );
							styles += '}';
							if ( media_query )
								styles += '}';
						});
					}
					else
					{
						styles += output.element + '{';
						styles += generate_styles( output, value );
						styles += '}';
					}
					break;
				default:
					if ( 'kirki-image' === controlType ) {
						value = ( ! _.isUndefined( value.url ) ) ? kirkiPostMessage.util.backgroundImageValue( value.url ) : kirkiPostMessage.util.backgroundImageValue( value );
					}
					if ( _.isObject( value ) ) {
						styles += output.element + '{';
						_.each( value, function( val, key ) {
							if ( output.choice && key !== output.choice ) {
								return;
							}
							processedValue = kirkiPostMessage.util.processValue( output, val );
							if ( ! output.property ) {
								output.property = key;
							}
							if ( false !== processedValue ) {
								styles += output.property + ':' + processedValue + ';';
							}
						} );
						styles += '}';
					} else {
						processedValue = kirkiPostMessage.util.processValue( output, value );
						if ( false !== processedValue ) {
							styles += output.element + '{' + output.property + ':' + processedValue + ';}';
						}
					}
					break;
			}

			// Get the media-query.
			if ( output.media_query && 'string' === typeof output.media_query && ! _.isEmpty( output.media_query ) ) {
				mediaQuery = output.media_query;
				if ( -1 === mediaQuery.indexOf( '@media' ) ) {
					mediaQuery = '@media ' + mediaQuery;
				}
			}

			// If we have a media-query, add it and return.
			if ( mediaQuery ) {
				return mediaQuery + '{' + styles + '}';
			}

			// Return the styles.
			return styles;
		}
	},

	/**
	 * A collection of utilities to change the HTML in the document.
	 *
	 * @since 3.0.26
	 */
	html: {

		/**
		 * Modifies the HTML from the output (js_vars) parameter.
		 *
		 * @since 3.0.26
		 * @param {Object} output - The output (js_vars) argument.
		 * @param {mixed}  value - The value.
		 * @returns {string}
		 */
		fromOutput: function( output, value ) {

			if ( output.js_callback && 'function' === typeof window[ output.js_callback ] ) {
				value = window[ output.js_callback[0] ]( value, output.js_callback[1] );
			}

			if ( _.isObject( value ) || _.isArray( value ) ) {
				if ( ! output.choice ) {
					return;
				}
				_.each( value, function( val, key ) {
					if ( output.choice && key !== output.choice ) {
						return;
					}
					value = val;
				} );
			}
			value = kirkiPostMessage.util.processValue( output, value );

			if ( output.attr ) {
				jQuery( output.element ).attr( output.attr, value );
			} else {
				jQuery( output.element ).html( value );
			}
		}
	},

	/**
	 * A collection of utilities to allow toggling a CSS class.
	 *
	 * @since 3.0.26
	 */
	toggleClass: {

		/**
		 * Toggles a CSS class from the output (js_vars) parameter.
		 *
		 * @since 3.0.21
		 * @param {Object} output - The output (js_vars) argument.
		 * @param {mixed}  value - The value.
		 * @returns {string}
		 */
		fromOutput: function( output, value ) {
			if ( 'undefined' === typeof output.class || 'undefined' === typeof output.value ) {
				return;
			}
			if ( value === output.value && ! jQuery( output.element ).hasClass( output.class ) ) {
				jQuery( output.element ).addClass( output.class );
			} else {
				jQuery( output.element ).removeClass( output.class );
			}
		}
	}
};

jQuery( document ).ready( function() {
	/**
	 * Figure out if the 2 values have the relation we want.
	 *
	 * @since 3.0.17
	 * @param {mixed} value1 - The 1st value.
	 * @param {mixed} value2 - The 2nd value.
	 * @param {string} operator - The comparison to use.
	 * @returns {bool}
	 */
	function evaluate( value1, value2, operator ) {
		var found = false;
		if ( '===' === operator ) {
			return value1 === value2;
		}
		if ( '==' === operator || '=' === operator || 'equals' === operator || 'equal' === operator ) {
			return value1 == value2;
		}
		if ( '!==' === operator ) {
			return value1 !== value2;
		}
		if ( '!=' === operator || 'not equal' === operator ) {
			return value1 != value2;
		}
		if ( '>=' === operator || 'greater or equal' === operator || 'equal or greater' === operator ) {
			return value2 >= value1;
		}
		if ( '<=' === operator || 'smaller or equal' === operator || 'equal or smaller' === operator ) {
			return value2 <= value1;
		}
		if ( '>' === operator || 'greater' === operator ) {
			return value2 > value1;
		}
		if ( '<' === operator || 'smaller' === operator ) {
			return value2 < value1;
		}
		if ( 'contains' === operator || 'in' === operator ) {
			if ( _.isArray( value1 ) && _.isArray( value2 ) ) {
				_.each( value2, function( value ) {
					if ( value1.includes( value ) ) {
						found = true;
						return false;
					}
				} );
				return found;
			}
			if ( _.isArray( value2 ) ) {
				_.each( value2, function( value ) {
					if ( value == value1 ) { // jshint ignore:line
						found = true;
					}
				} );
				return found;
			}
			if ( _.isObject( value2 ) ) {
				if ( ! _.isUndefined( value2[ value1 ] ) ) {
					found = true;
				}
				_.each( value2, function( subValue ) {
					if ( value1 === subValue ) {
						found = true;
					}
				} );
				return found;
			}
			if ( _.isString( value2 ) ) {
				if ( _.isString( value1 ) ) {
					return ( -1 < value1.indexOf( value2 ) && -1 < value2.indexOf( value1 ) );
				}
				return -1 < value1.indexOf( value2 );
			}
		}
		return value1 == value2;
	}
	_.each( kirkiPostMessageFields, function( field ) {
		wp.customize( field.settings, function( value ) {
			value.bind( function( newVal ) {
				if ( field.required.length > 0 )
				{
					for ( var i in field.required )
					{
						var requirement = field.required[i];
						var required_value = wp.customize.value( requirement.setting )._value;
						var result = evaluate (
							requirement.value,
							required_value,
							requirement.operator
						);
						
						//If we hit a requirement not met, remove the data.
						if ( !result )
						{
							kirkiPostMessage.styleTag.removeData( field.settings );
							return;
						}
					}
				}
				
				var styles = '';
				_.each( field.js_vars, function( output ) {
					if ( ! output.function || 'undefined' === typeof kirkiPostMessage[ output.function ] ) {
						output.function = 'css';
					}
					if ( 'css' === output.function ) {
						if ( !Array.isArray( output.property ) )
							output.property = [output.property];
						_.each( output.property, function( property ) {
							var prop_output = jQuery.extend({}, output);
							prop_output.property = property;
							styles += kirkiPostMessage.css.fromOutput( prop_output, newVal, field.type );
						});
					} else {
						kirkiPostMessage[ output.function ].fromOutput( output, newVal, field.type );
					}
				} );
				kirkiPostMessage.styleTag.addData( field.settings, styles );
			} );
		} );
	} );
} );
