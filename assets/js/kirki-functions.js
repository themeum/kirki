function kirkiArrayToObject( arr ) {
	var obj = {};
	if ( null !== arr ) {
		for ( var i = 0; i < arr.length; ++i ) {
			if ( undefined !== arr[ i ] ) {
				obj[ i ] = arr[ i ];
			}
		}
	}
	return obj;
}

function kirkiObjectToArray( obj ) {
	var arr = [];
	if ( null !== obj ) {
		for ( var i = 0; i < obj.length; ++i ) {
			if ( undefined !== obj[ i ] ) {
				arr.push( obj[ i ] );
			}
		}
	}
	return arr;
}

function kirkiValidateCSSValue( value ) {
	var valueIsValid = true;

	if ( '0' == value ) {
		return true;
	}

	var validUnits   = ['rem', 'em', 'ex', '%', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ch', 'vh', 'vw', 'vmin', 'vmax'];
	// Get the numeric value
	var numericValue = parseFloat( value );
	// Get the unit
	var unit = value.replace( numericValue, '' );
	// Check the validity of the numeric value
	if ( NaN === numericValue ) {
		valueIsValid = false;
	}
	// Check the validity of the units
	if ( -1 === jQuery.inArray( unit, validUnits ) ) {
		valueIsValid = false;
	}

	return valueIsValid;
}
