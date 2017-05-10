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
					});
					return window.kirkiControlDependencies[ extras[0] ][ extras[1] ];
				} else if ( 'string' === typeof value2 ) {
					return value2.indexOf( value1 );
				}
				break;
			default:
				return true;

		}
	}

	_.each( fieldDependencies, function( args, slaveControlID ) {

		// An array of all master controls for this slave.
		var kirkiControlDependenciesMasterControls = [],

		    slaveControl = wp.customize.control( slaveControlID ),
			showControl  = {};

		// Populate the kirkiControlDependenciesMasterControls array.
		_.each( args, function( dependency ) {
			kirkiControlDependenciesMasterControls.push( dependency.setting );
		});

		_.each( kirkiControlDependenciesMasterControls, function( masterControlID ) {

			wp.customize( masterControlID, function( masterSetting ) {

				// Listen for changes to the master control values.
				masterSetting.bind( function() {
					var show = true;
					_.each( args, function( dependency, index ) {
						showControl[ masterControlID ] = kirkiCompareValues(
							dependency.value,
							masterSetting.get(),
							dependency.operator,
							[slaveControlID, dependency.setting]
						);
					});
					_.each( showControl, function( val ) {
						if ( false === val ) {
							show = false;
						}
					});
					if ( false === show ) {
						wp.customize.control( slaveControlID ).deactivate();
					} else {
						wp.customize.control( slaveControlID ).activate();
					}
				});
			});
		});
	});
});
