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
