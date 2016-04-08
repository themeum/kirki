function kirkiValidateCSSValue( value ) {

	var validUnits = ['rem', 'em', 'ex', '%', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ch', 'vh', 'vw', 'vmin', 'vmax'],
	    numericValue,
	    unit;

	// 0 is always a valid value
	if ( '0' === value ) {
		return true;
	}

	// If we're using calc() just return true.
	if ( 0 <= value.indexOf( 'calc(' ) && 0 <= value.indexOf( ')' ) ) {
		return true;
	}

	// Get the numeric value.
	numericValue = parseFloat( value );

	// Get the unit
	unit = value.replace( numericValue, '' );

	// Check the validity of the numeric value.
	if ( isNaN( numericValue ) ) {
		return false;
	}

	// Check the validity of the units.
	if ( -1 === jQuery.inArray( unit, validUnits ) ) {
		return false;
	}

	return true;

}
