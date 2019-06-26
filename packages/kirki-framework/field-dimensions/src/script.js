/* global kirkiPostMessage */

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
			var processedValue;
			if ( 'kirki-dimensions' === controlType ) {
				styles += output.element + '{';
				_.each( value, function( val, key ) {
					if ( output.choice && key !== output.choice ) {
						return;
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
			}
			return styles;
		}
	);
} );
