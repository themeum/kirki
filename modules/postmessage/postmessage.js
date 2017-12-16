/* global kirkiPostMessageFields, WebFont */
var kirkiPostMessage = {

	/**
	 * The fields.
	 *
	 * @since 3.0.20
	 */
	fields: {},

	/**
	 * A collection of methods for the <style> tags.
	 *
	 * @since 3.0.20
	 */
	styleTag: {

		/**
		 * Add a <style> tag in <head> if it doesn't already exist.
		 *
		 * @since 3.0.20
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
		 * @since 3.0.20
		 * @param {string} id - The field-ID.
		 * @param {string} styles - The styles to add.
		 * @returns {void}
		 */
		addData: function( id, styles ) {
			kirkiPostMessage.styleTag.add( id );
			jQuery( '#kirki-postmessage-' + id ).text( styles );
		}
	},

	/**
	 * Common utilities.
	 *
	 * @since 3.0.21
	 */
	util: {

		/**
		 * Processes the value and applies any replacements and/or additions.
		 *
		 * @since 3.0.21
		 * @param {Object} output - The output (js_vars) argument.
		 * @param {mixed}  value - The value.
		 * @param {string} controlType - The control-type.
		 * @returns {string}
		 */
		processValue: function( output, value ) {
			var settings = window.parent.wp.customize.get();

			if ( 'string' !== typeof value ) {
				return value;
			}
			output = _.defaults( output, {
				prefix: '',
				units: '',
				suffix: '',
				value_pattern: '$',
				pattern_replace: {}
			} );

			value = output.value_pattern.replace( /$/g, value );
			_.each( output.pattern_replace, function( placeholder, id ) {
				if ( ! _.isUndefined( settings[ id ] ) ) {
					value = value.replace( placeholder, settings[ id ] );
				}
			} );
			return output.prefix + output.units + value + output.suffix;
		},

		/**
		 * Make sure urls are properly formatted for background-image properties.
		 *
		 * @since 3.0.21
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
	 * @since 3.0.21
	 */
	css: {

		/**
		 * Generates the CSS from the output (js_vars) parameter.
		 *
		 * @since 3.0.21
		 * @param {Object} output - The output (js_vars) argument.
		 * @param {mixed}  value - The value.
		 * @param {string} controlType - The control-type.
		 * @returns {string}
		 */
		fromOutput: function( output, value, controlType ) {
			var styles      = '',
			    kirkiParent = window.parent.kirki,
			    googleFont  = '';

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
						styles += key + ':' + kirkiPostMessage.util.processValue( output, val ); +';';
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
						if ( value.subsets && ! _.isEmpty( value.subsets ) ) {
							googleFont += ':' + value.subsets.join( ',' );
						}
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

						// Mostly used for padding, margin & position properties.
						if ( output.property && '' !== output.property && ( 'top' === key || 'bottom' === key || 'left' === key || 'right' === key ) ) {
							styles += output.element + '{' + output.property + '-' + key + ':' + kirkiPostMessage.util.processValue( output, val ) + ';';
						} else {
							styles += key + ':' + kirkiPostMessage.util.processValue( output, val ); +';';
						}
					} );
					styles += '}';
					break;
				default:
					if ( 'kirki-image' === controlType ) {
						value = ( ! _.isUndefined( value.url ) ) ? kirkiPostMessage.util.backgroundImageValue( value.url ) : kirkiPostMessage.util.backgroundImageValue( value );
					}
					styles += output.element + '{' + output.property + ':' + kirkiPostMessage.util.processValue( output, value ); +';}';
					break;
			}
			return styles;
		}
	},

	/**
	 * A collection of utilities to change the HTML in the document.
	 *
	 * @since 3.0.21
	 */
	html: {

		/**
		 * Generates the CSS from the output (js_vars) parameter.
		 *
		 * @since 3.0.21
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
	}
};

jQuery( document ).ready( function() {

	_.each( kirkiPostMessageFields, function( field ) {
		wp.customize( field.settings, function( value ) {
			value.bind( function( newVal ) {
				var styles = '';
				_.each( field.js_vars, function( output ) {
					if ( ! output['function'] || 'undefined' === typeof kirkiPostMessage[ output['function'] ] ) {
						output['function'] = 'css';
					}
					if ( 'css' === output['function'] ) {
						styles += kirkiPostMessage.css.fromOutput( output, newVal, field.type );
					} else {
						kirkiPostMessage[ output['function'] ].fromOutput( output, newVal, field.type );
					}
				} );
				kirkiPostMessage.styleTag.addData( field.settings, styles );
			} );
		} );
	} );
} );
