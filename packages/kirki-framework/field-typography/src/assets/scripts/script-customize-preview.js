/**
 * Hook in the kirkiPostMessageStylesOutput filter.
 *
 * Handles postMessage styles for typography controls.
 */
jQuery( document ).ready( function() {
	wp.hooks.addFilter(
		'kirkiPostMessageStylesOutput',
		'kirki',

		/**
		 * Append styles for this control.
		 *
		 * @param {string} styles      - The styles.
		 * @param {Object} value       - The control value.
		 * @param {Object} output      - The control's "output" argument.
		 * @param {string} controlType - The control type.
		 * @returns {string} - Returns the CSS as a string.
		 */
		function( styles, value, output, controlType ) {
			var googleFont = '',
				processedValue;

			if ( 'kirki-typography' === controlType ) {
				styles += output.element + '{';
				_.each( value, function( val, key ) {
					if ( output.choice && key !== output.choice ) {
						return;
					}
					processedValue = window.kirkiPostMessage.util.processValue( output, val );
					if ( false !== processedValue ) {
						styles += key + ':' + processedValue + ';';
					}
				} );
				styles += '}';

				// Check if this is a googlefont so that we may load it.
				if ( ! _.isUndefined( window.WebFont ) && value['font-family'] ) {

					// Calculate the googlefont params.
					googleFont = value['font-family'].replace( /\"/g, '&quot;' ); // eslint-disable-line no-useless-escape
					if ( value['font-weight'] && value['font-style'] ) {
						googleFont += ':' + value['font-weight'];
						if ( 'italic' === value['font-style'] ) {
							googleFont += 'i';
						}
					} else if ( value.variant ) {
						if ( 'regular' === value.variant ) {
							googleFont += ':400';
						} else if ( 'italic' === value.variant ) {
							googleFont += ':400i';
						} else {
							googleFont += ':' + value.variant;
						}
					}
					googleFont += ':cyrillic,cyrillic-ext,devanagari,greek,greek-ext,khmer,latin,latin-ext,vietnamese,hebrew,arabic,bengali,gujarati,tamil,telugu,thai';
					window.WebFont.load( {
						google: {
							families: [ googleFont ]
						}
					} );
				}
			}
			return styles;
		}
	);
} );
