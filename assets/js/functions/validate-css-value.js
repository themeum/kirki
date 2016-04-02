function kirkiValidateCSSValue( value ) {
	// 0 is always a valid value
	if ( '0' == value ) {
		return true;
	}
	// if we're using calc() just return true.
	if ( 0 <= value.indexOf( 'calc(' ) && 0 <= value.indexOf( ')' ) ) {
		return true;
	}

	var validUnits   = ['rem', 'em', 'ex', '%', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ch', 'vh', 'vw', 'vmin', 'vmax'];
	// Get the numeric value
	var numericValue = parseFloat( value );
	// Get the unit
	var unit = value.replace( numericValue, '' );
	// Check the validity of the numeric value
	if ( NaN === numericValue ) {
		return false;
	}
	// Check the validity of the units
	if ( -1 === jQuery.inArray( unit, validUnits ) ) {
		return false;
	}
	return true;
}
