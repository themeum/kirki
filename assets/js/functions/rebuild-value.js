function kirkiRebuildValue( value ) {
	var newValue = {};
	_.each( value, function( newSubValue, i ) {
		newValue[ i ] = newSubValue;
	});

	return newValue;
}
