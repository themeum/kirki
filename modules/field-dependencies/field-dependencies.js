jQuery( document ).ready( function() {

	function kirkiCompareValues( value1, value2, operator, extras ) {
		switch ( operator ) {
			case '===':
				return value1 === value2;
			case '==':
			case '=':
			case 'equals':
			case 'equal':
				return value1 == value2; // jshint ignore:line
			case '!==':
				return value1 !== value2;
			case '!=':
			case 'not equal':
				return value1 != value2; // jshint ignore:line
			case '>=':
			case 'greater or equal':
			case 'equal or greater':
				return value1 >= value2;
			case '<=':
			case 'smaller or equal':
			case 'equal or smaller':
				return value1 <= value2;
			case '>':
			case 'greater':
				return value1 > value2;
			case '<':
			case 'smaller':
				return value1 < value2;
			case 'contains':
			case 'in':
				if ( 'object' === typeof value2 ) {
					if ( 'undefined' !== typeof value2[ value1 ] ) {
						return true;
					}
					window.kirkiControlDependencies[ extras[0] ][ extras[1] ] = false;
					_.each( value2, function( subValue ) {
						if ( value1 === subValue ) {
							window.kirkiControlDependencies[ extras[0] ][ extras[1] ] = true;
						}
					} );
					return window.kirkiControlDependencies[ extras[0] ][ extras[1] ];
				} else if ( 'string' === typeof value2 ) {
					return value2.indexOf( value1 );
				}
				break;
			default:
				return true;

		}
	}

	_.each( fieldDependencies, function( args, targetControlID ) {

		wp.customize( targetControlID, function( setting ) {

			var setupControl = function( control ) {

				setting.bind( function() {
					control.active.set( function() {
						var show = true;
						_.each( args, function( dependency ) {
							if ( show ) {
								show = kirkiCompareValues( dependency.value, setting.get(), dependency.operator, [targetControlID, dependency.setting] );
							}
						} );
						return show;
					} );
				} );

			};
			_.each( args, function( dependency ) {
				wp.customize.control( dependency.setting, setupControl );
			} );
		} );
	} );
});
