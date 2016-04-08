function kirkiObjectToArray( obj ) {
	var arr = [];
	if ( null !== obj ) {
		_.each( obj, function( value ) {
			if ( undefined !== value ) {
				arr.push( value );
			}
		});
	}
	return arr;
}
