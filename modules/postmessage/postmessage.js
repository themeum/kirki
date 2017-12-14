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
			var styleID = 'kirki-postmessage-' + id;
			if ( null === document.getElementById( styleID ) || 'undefined' === typeof document.getElementById( styleID ) ) {
				jQuery( 'head' ).append( '<style id="' + styleID + '"></style>' );
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
			var self    = this,
			    styleID = 'kirki-postmessage-' + id;

			self.add( id );
			jQuery( '#' + styleID ).text( styles );
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
			var self        = this,
			    styles      = '',
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
						styles += key + ':' + self.processValue( output, val ); +';';
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
					break;
				default:
					if ( 'kirki-image' === controlType ) {
						value = ( ! _.isUndefined( value.url ) ) ? value.url : value;
						value = ( -1 === value.indexOf( 'url(' ) ) ? 'url(' + value + ')' : value;
					}
					styles += output.element + '{' + output.property + ':' + self.processValue( output, value ); +';}';
					break;
			}
			return styles;
		},

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
		}

	}
};

jQuery( document ).ready( function() {

	_.each( kirkiPostMessageFields, function( field ) {
		wp.customize( field.settings, function( value ) {
			value.bind( function( newVal ) {
				var styles = '';
				_.each( field.js_vars, function( output ) {
					styles += kirkiPostMessage.css.fromOutput( output, newVal, field.type );
				} );
				kirkiPostMessage.styleTag.addData( field.settings, styles );
			} );
		} );
	} );
} );

// Wp.customize('typography_setting_0', function(value) {
// 	value.bind(function(newval) {
// 		if (null === document.getElementById('kirki-postmessage-typography_setting_0') || 'undefined' === typeof document.getElementById('kirki-postmessage-typography_setting_0')) {
// 			jQuery('head').append('<style id="kirki-postmessage-typography_setting_0"></style>');
// 		}
// 		fontFamily = (_.isUndefined(newval['font-family'])) ? '' : newval['font-family'];
// 		variant = (_.isUndefined(newval.variant)) ? '400' : newval.variant;
// 		subsets = (_.isUndefined(newval.subsets)) ? [] : newval.subsets;
// 		subsetsString = (_.isObject(newval.subsets)) ? ':' + newval.subsets.join(',') : '';
// 		fontSize = (_.isUndefined(newval['font-size'])) ? '' : newval['font-size'];
// 		lineHeight = (_.isUndefined(newval['line-height'])) ? '' : newval['line-height'];
// 		letterSpacing = (_.isUndefined(newval['letter-spacing'])) ? '' : newval['letter-spacing'];
// 		wordSpacing = (_.isUndefined(newval['word-spacing'])) ? '' : newval['word-spacing'];
// 		textAlign = (_.isUndefined(newval['text-align'])) ? '' : newval['text-align'];
// 		textTransform = (_.isUndefined(newval['text-transform'])) ? '' : newval['text-transform'];
// 		textDecoration = (_.isUndefined(newval['text-decoration'])) ? '' : newval['text-decoration'];
// 		color = (_.isUndefined(newval.color)) ? '' : newval.color;
// 		fw = (!_.isString(newval.variant)) ? '400' : newval.variant.match(/\d/g);
// 		fontWeight = (!_.isObject(fw)) ? 400 : fw.join('');
// 		fontStyle = (-1 !== variant.indexOf('italic')) ? 'italic' : 'normal';
// 		css = '';
// 		sc = 'a';
// 		jQuery('head').append(sc.replace('a', '<') + 'script>if(!_.isUndefined(WebFont)&&fontFamily){WebFont.load({google:{families:["' + fontFamily.replace(/\"/g, '&quot;') + ':' + variant + subsetsString + '"]}});}' + sc.replace('a', '<') + '/script>');
// 		fontFamilyCSS = fontFamily;
// 		if (0 < fontFamily.indexOf(' ') && -1 === fontFamily.indexOf('"')) {
// 			fontFamilyCSS = '"' + fontFamily + '"';
// 		}
// 		css += ('' !== fontFamilyCSS) ? 'body, p' + '{font-family:' + fontFamilyCSS + ';}' : '';
// 		css += ('' !== fontSize) ? 'body, p' + '{font-size:' + fontSize + ';}' : '';
// 		css += ('' !== lineHeight) ? 'body, p' + '{line-height:' + lineHeight + ';}' : '';
// 		css += ('' !== letterSpacing) ? 'body, p' + '{letter-spacing:' + letterSpacing + ';}' : '';
// 		css += ('' !== textAlign) ? 'body, p' + '{text-align:' + textAlign + ';}' : '';
// 		css += ('' !== textTransform) ? 'body, p' + '{text-transform:' + textTransform + ';}' : '';
// 		css += ('' !== textDecoration) ? 'body, p' + '{text-decoration:' + textDecoration + ';}' : '';
// 		css += ('' !== color) ? 'body, p' + '{color:' + color + ';}' : '';
// 		css += ('' !== fontWeight) ? 'body, p' + '{font-weight:' + fontWeight + ';}' : '';
// 		css += ('' !== fontStyle) ? 'body, p' + '{font-style:' + fontStyle + ';}' : '';
// 		var cssContent = css;
// 		jQuery('#kirki-postmessage-typography_setting_0').text(cssContent);
// 		jQuery('#kirki-postmessage-typography_setting_0').appendTo('head');
// 	});
// });
// wp.customize('typography_setting_1', function(value) {
// 	value.bind(function(newval) {
// 		if (null === document.getElementById('kirki-postmessage-typography_setting_1') || 'undefined' === typeof document.getElementById('kirki-postmessage-typography_setting_1')) {
// 			jQuery('head').append('<style id="kirki-postmessage-typography_setting_1"></style>');
// 		}
// 		fontFamily = (_.isUndefined(newval['font-family'])) ? '' : newval['font-family'];
// 		variant = (_.isUndefined(newval.variant)) ? '400' : newval.variant;
// 		subsets = (_.isUndefined(newval.subsets)) ? [] : newval.subsets;
// 		subsetsString = (_.isObject(newval.subsets)) ? ':' + newval.subsets.join(',') : '';
// 		fontSize = (_.isUndefined(newval['font-size'])) ? '' : newval['font-size'];
// 		lineHeight = (_.isUndefined(newval['line-height'])) ? '' : newval['line-height'];
// 		letterSpacing = (_.isUndefined(newval['letter-spacing'])) ? '' : newval['letter-spacing'];
// 		wordSpacing = (_.isUndefined(newval['word-spacing'])) ? '' : newval['word-spacing'];
// 		textAlign = (_.isUndefined(newval['text-align'])) ? '' : newval['text-align'];
// 		textTransform = (_.isUndefined(newval['text-transform'])) ? '' : newval['text-transform'];
// 		textDecoration = (_.isUndefined(newval['text-decoration'])) ? '' : newval['text-decoration'];
// 		color = (_.isUndefined(newval.color)) ? '' : newval.color;
// 		fw = (!_.isString(newval.variant)) ? '400' : newval.variant.match(/\d/g);
// 		fontWeight = (!_.isObject(fw)) ? 400 : fw.join('');
// 		fontStyle = (-1 !== variant.indexOf('italic')) ? 'italic' : 'normal';
// 		css = '';
// 		sc = 'a';
// 		jQuery('head').append(sc.replace('a', '<') + 'script>if(!_.isUndefined(WebFont)&&fontFamily){WebFont.load({google:{families:["' + fontFamily.replace(/\"/g, '&quot;') + ':' + variant + subsetsString + '"]}});}' + sc.replace('a', '<') + '/script>');
// 		fontFamilyCSS = fontFamily;
// 		if (0 < fontFamily.indexOf(' ') && -1 === fontFamily.indexOf('"')) {
// 			fontFamilyCSS = '"' + fontFamily + '"';
// 		}
// 		css += ('' !== fontFamilyCSS) ? 'h1,h2,h3,h4,h5,h6' + '{font-family:' + fontFamilyCSS + ';}' : '';
// 		var cssContent = css;
// 		jQuery('#kirki-postmessage-typography_setting_1').text(cssContent);
// 		jQuery('#kirki-postmessage-typography_setting_1').appendTo('head');
// 	});
// });
