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
