var kirkiDependencies = {

	listenTo: {},

	init: function() {
		var self = this;

		_.each( window.kirkiControlDependencies, function( requires, controlID ) {
			var control = wp.customize.control( controlID );
			if ( control ) {
				wp.customize.control( controlID ).params.required = requires;
				self.showKirkiControl( control );
			}
		} );

		_.each( self.listenTo, function( slaves, master ) {
			_.each( slaves, function( slave ) {
				wp.customize( master, function( setting ) {
					var setupControl = function( control ) {
						var setActiveState,
							isDisplayed;

						isDisplayed = function() {
							return self.showKirkiControl( wp.customize.control( slave ) );
						};
						setActiveState = function() {
							control.active.set( isDisplayed() );
						};

						setActiveState();
						setting.bind( setActiveState );
						control.active.validate = isDisplayed;
					};
					wp.customize.control( slave, setupControl );
				} );
			} );
		} );
	},

	/**
	 * Should we show the control?
	 *
	 * @since 3.0.17
	 * @param {string|object} control - The control-id or the control object.
	 * @returns {bool} - Whether the control should be shown or not.
	 */
	showKirkiControl: function( control ) {
		var self     = this,
			show     = true,
			isOption = (
				control.params && // Check if control.params exists.
				control.params.kirkiOptionType &&  // Check if option_type exists.
				'option' === control.params.kirkiOptionType &&  // We're using options.
				control.params.kirkiOptionName && // Check if option_name exists.
				! _.isEmpty( control.params.kirkiOptionName ) // Check if option_name is not empty.
			),
			i;


		if ( _.isString( control ) ) {
			control = wp.customize.control( control );
		}

		// Exit early if control not found or if "required" argument is not defined.
		if ( 'undefined' === typeof control || ( control.params && _.isEmpty( control.params.required ) ) ) {
			return true;
		}

		// Loop control requirements.
		for ( i = 0; i < control.params.required.length; i++ ) {
			if ( ! self.checkCondition( control.params.required[ i ], control, isOption, 'AND' ) ) {
				show = false;
			}
		}
		return show;
	},

	/**
	 * Check a condition.
	 *
	 * @param {Object} requirement - The requirement, inherited from showKirkiControl.
	 * @param {Object} control - The control object.
	 * @param {bool}   isOption - Whether it's an option or not.
	 * @param {string} relation - Can be one of 'AND' or 'OR'.
	 * @returns {bool} - Returns the results of the condition checks.
	 */
	checkCondition: function( requirement, control, isOption, relation ) {
		var self          = this,
			childRelation = ( 'AND' === relation ) ? 'OR' : 'AND',
			nestedItems,
			value,
			i;

		// Tweak for using active callbacks with serialized options instead of theme_mods.
		if ( isOption && requirement.setting ) {

			// Make sure we don't already have the option_name in there.
			if ( -1 === requirement.setting.indexOf( control.params.kirkiOptionName + '[' ) ) {
				requirement.setting = control.params.kirkiOptionName + '[' + requirement.setting + ']';
			}
		}

		// If an array of other requirements nested, we need to process them separately.
		if ( 'undefined' !== typeof requirement[0] && 'undefined' === typeof requirement.setting ) {
			nestedItems = [];

			// Loop sub-requirements.
			for ( i = 0; i < requirement.length; i++ ) {
				nestedItems.push( self.checkCondition( requirement[ i ], control, isOption, childRelation ) );
			}

			// OR relation. Check that true is part of the array.
			if ( 'OR' === childRelation ) {
				return ( -1 !== nestedItems.indexOf( true ) );
			}

			// AND relation. Check that false is not part of the array.
			return ( -1 === nestedItems.indexOf( false ) );
		}

		// Early exit if setting is not defined.
		if ( 'undefined' === typeof wp.customize.control( requirement.setting ) ) {
			return true;
		}

		self.listenTo[ requirement.setting ] = self.listenTo[ requirement.setting ] || [];
		if ( -1 === self.listenTo[ requirement.setting ].indexOf( control.id ) ) {
			self.listenTo[ requirement.setting ].push( control.id );
		}

		value = wp.customize( requirement.setting ).get();
		if ( wp.customize.control( requirement.setting ).setting ) {
			value = wp.customize.control( requirement.setting ).setting._value;
		}

		return self.evaluate( requirement.value, value, requirement.operator, requirement.choice );
	},

	/**
	 * Figure out if the 2 values have the relation we want.
	 *
	 * @since 3.0.17
	 * @param {mixed} value1 - The 1st value.
	 * @param {mixed} value2 - The 2nd value.
	 * @param {string} operator - The comparison to use.
	 * @param {string} choice - If we want to check an item in an object value.
	 * @returns {bool} - Returns the evaluation result.
	 */
	evaluate: function( value1, value2, operator, choice ) {
		var found = false;

		if ( choice && 'object' === typeof value2 ) {
			value2 = value2[ choice ];
		}

		if ( '===' === operator ) {
			return value1 === value2;
		}
		if ( '==' === operator || '=' === operator || 'equals' === operator || 'equal' === operator ) {
			return value1 == value2;
		}
		if ( '!==' === operator ) {
			return value1 !== value2;
		}
		if ( '!=' === operator || 'not equal' === operator ) {
			return value1 != value2;
		}
		if ( '>=' === operator || 'greater or equal' === operator || 'equal or greater' === operator ) {
			return value2 >= value1;
		}
		if ( '<=' === operator || 'smaller or equal' === operator || 'equal or smaller' === operator ) {
			return value2 <= value1;
		}
		if ( '>' === operator || 'greater' === operator ) {
			return value2 > value1;
		}
		if ( '<' === operator || 'smaller' === operator ) {
			return value2 < value1;
		}
		if ( 'contains' === operator || 'in' === operator ) {
			if ( _.isArray( value1 ) && _.isArray( value2 ) ) {
				_.each( value2, function( value ) {
					if ( value1.includes( value ) ) {
						found = true;
						return false;
					}
                } );
				return found;
			}
			if ( _.isArray( value2 ) ) {
				_.each( value2, function( value ) {
					if ( value == value1 ) { // jshint ignore:line
						found = true;
					}
				} );
				return found;
			}
			if ( _.isObject( value2 ) ) {
				if ( ! _.isUndefined( value2[ value1 ] ) ) {
					found = true;
				}
				_.each( value2, function( subValue ) {
					if ( value1 === subValue ) {
						found = true;
					}
				} );
				return found;
			}
			if ( _.isString( value2 ) ) {
				if ( _.isString( value1 ) ) {
					return ( -1 < value1.indexOf( value2 ) && -1 < value2.indexOf( value1 ) );
				}
				return -1 < value1.indexOf( value2 );
			}
		}
		if ( 'does not contain' === operator || 'not in' === operator ) {
			return ( ! this.evaluate( value1, value2, 'contains', choice ) );
		}

		return value1 == value2;
	}
};

jQuery( document ).ready( function() {
	kirkiDependencies.init();
} );
