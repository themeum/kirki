/* global  */
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
		}

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

		}
	}
};
jQuery( document ).ready( function() {

	console.log( kirkiPostMessage );

	_.each( kirkiPostMessage, function( field ) {
		wp.customize( field.settings, function( value ) {
			value.bind( function( newVal ) {
				console.log( newVal );
			} );
		} );
		console.log( field );
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
