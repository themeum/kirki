/* global fieldDependencies */
jQuery( document ).ready( function() {

	function kirkiCompareValues( value1, value2, operator, extras ) {
		var found = false,
		    value;

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
				return value2 >= value1;
			case '<=':
			case 'smaller or equal':
			case 'equal or smaller':
				return value2 <= value1;
			case '>':
			case 'greater':
				return value2 > value1;
			case '<':
			case 'smaller':
				return value2 < value1;
			case 'contains':
			case 'in':
				if ( _.isArray( value2 ) ) {
					_.each( value2, function( index, value ) {
						if ( _.isNumber( value ) ) {
							value = parseInt( value, 10 );
						}
						if ( value1.indexOf( value ) > -1 ) {
							return true;
						}
					} );
					return false;
				} else if ( _.isObject( value2 ) ) {
					if ( ! _.isUndefined( value2[ value1 ] ) ) {
						return true;
					}
					
					_.each( value2, function( subValue ) {
						if ( value1 === subValue ) {
							return true;
						}
					});
					return false;
				} else if ( _.isString( value2 ) ) {
					return value1.indexOf( value2 ) > -1;
				}
				break;
			default:
				return true;

		}
	}

	_.each( fieldDependencies, function( args, slaveControlID ) {

		// An array of all master controls for this slave.
		var DependenciesMasterControls = [],
			showControl                = {};

		// Populate the DependenciesMasterControls array.
		_.each( args, function( dependency ) {
			if ( _.isObject( dependency ) ) {
				_.each( dependency, function( subDependency ) {
					if ( ! _.isUndefined( subDependency.setting ) ) {
						DependenciesMasterControls.push( subDependency.setting );
					}
				});
			}
			DependenciesMasterControls.push( dependency.setting );
		});

		_.each( DependenciesMasterControls, function( masterControlID ) {

			wp.customize( masterControlID, function( masterSetting ) {

				// Listen for changes to the master control values.
				masterSetting.bind( function() {
					var show = true;
					_.each( args, function( dependency ) {
						if ( ! _.isUndefined( dependency[0] ) && ! _.isUndefined( dependency[0].setting ) ) {

							// Var orConditionShow = {},
							//     orConditionID   = '';
							//
							// _.each( dependency, function( subDependency, subIndex ) {
							// 	orConditionShow[ masterControlID ] = kirkiCompareValues(
							// 		subDependency.value,
							// 		masterSetting.get(),
							// 		subDependency.operator,
							// 		[slaveControlID, subDependency.setting]
							// 	);
							// });
							// _.each( dependency, function( subDependency ) {
							// 	orConditionID += subDependency.setting;
							// });
							//
							// _.each( orConditionShow, function( val ) {
							// 	console.log( val );
							// 	if ( true === val ) {
							// 		showControl[ orConditionID ] = true;
							// 	}
							// });
						} else {
							showControl[ masterControlID ] = kirkiCompareValues(
								dependency.value,
								masterSetting.get(),
								dependency.operator,
								[slaveControlID, dependency.setting]
							);
						}
					});
					_.each( showControl, function( val ) {
						if ( false === val ) {
							show = false;
						}
					});
					if ( false === show ) {
						if ( ! _.isUndefined( wp.customize.control( slaveControlID ) ) && _.isFunction( wp.customize.control( slaveControlID ).deactivate ) ) {
							wp.customize.control( slaveControlID ).deactivate();
						}
					} else {
						if ( ! _.isUndefined( wp.customize.control( slaveControlID ) ) && _.isFunction( wp.customize.control( slaveControlID ).activate ) ) {
							wp.customize.control( slaveControlID ).activate();
						}
					}
				});
			});
		});
	});
});
