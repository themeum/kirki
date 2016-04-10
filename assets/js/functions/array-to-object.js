function kirkiArrayToObject( arr ) {
	var obj = {};
	if ( null !== arr ) {
		_.each( arr, function( item, i ) {
			if ( undefined !== item ) {
				obj.i = item;
			}
		});
	}
	return obj;
}
