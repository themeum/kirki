var kirki = kirki || {};
/**
 * A collection of utility functions.
 *
 * @since 3.1.0
 */
kirki.util = {

	/**
	 * Returns the wrapper element of the control.
	 *
	 * @since 3.1.0
	 * @param {object} [control] The control arguments.
	 * @returns {array}
	 */
	controlContainer: function( control ) {
		return jQuery( '#kirki-control-wrapper-' + control.id );
	},

	/**
	 * Gets the control-type, with or without the 'kirki-' prefix.
	 *
	 * @since 3.1.0
	 * @param {string}      [controlType] The control-type.
	 * @param {bool|string} [prefix]      If false, return without prefix.
	 *                                    If true, return with 'kirki-' as prefix.
	 *                                    If string, add custom prefix.
	 * @returns {string}
	 */
	getControlType: function( controlType, prefix ) {

		controlType = controlType.replace( 'kirki-', '' );
		if ( _.isUndefined( prefix ) || false === prefix ) {
			return controlType;
		}
		if ( true === prefix ) {
			return 'kirki-' + controlType;
		}
		return prefix + controlType;
	},

	/**
	 * Validates dimension css values.
	 *
	 * @param {string} [value] The value we want to validate.
	 * @returns {bool}
	 */
	kirkiValidateCSSValue: function( value ) {
		var validUnits = ['rem', 'em', 'ex', '%', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ch', 'vh', 'vw', 'vmin', 'vmax'],
			numericValue,
			unit;

		// 0 is always a valid value, and we can't check calc() values effectively.
		if ( '0' === value || ( 0 <= value.indexOf( 'calc(' ) && 0 <= value.indexOf( ')' ) ) ) {
			return true;
		}

		// Get the numeric value.
		numericValue = parseFloat( value );

		// Get the unit
		unit = value.replace( numericValue, '' );

		// Check the validity of the numeric value and units.
		if ( isNaN( numericValue ) || 0 > _.indexOf( validUnits, unit ) ) {
			return false;
		}
		return true;
	}
};
