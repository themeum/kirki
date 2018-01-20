var kirkiDependencies = {

	listenTo: {},

	init: function() {
		var self = this;

		wp.customize.control.each( function( control ) {
			self.showKirkiControl( control );
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
			});
		});
	},

	/**
	 * Should we show the control?
	 *
	 * @since 3.0.17
	 * @param {string|object} control - The control-id or the control object.
	 * @returns {bool}
	 */
	showKirkiControl: function( control ) {
		var self = this,
		    show = true;

		if ( _.isString( control ) ) {
			control = wp.customize.control( control );
		}

		// Exit early if control not found or if "required" argument is not defined.
		if ( 'undefined' === typeof control || ( control.params && _.isEmpty( control.params.required ) ) ) {
			return true;
		}

		// Loop control requirements.
		_.each( control.params.required, function( requirement ) {
			let requirementShow;

			// Tweak for using active callbacks with serialized options instead of theme_mods.
			if (
				control.params && // Check if control.params exists.
				control.params.kirkiOptionType &&  // Check if option_type exists.
				'option' === control.params.kirkiOptionType &&  // We're using options.
				control.params.kirkiOptionName && // Check if option_name exists.
				! _.isEmpty( control.params.kirkiOptionName ) && // Check if option_name is not empty.
				-1 === requirement.setting.indexOf( control.params.kirkiOptionName + '[' ) // Make sure we don't already have the option_name in there.
			) {
				requirement.setting = control.params.kirkiOptionName + '[' + requirement.setting + ']';
			}

			// Early exit if setting is not defined.
			if ( 'undefined' === typeof wp.customize.control( requirement.setting ) ) {
				show = true;
				return;
			}

			requirementShow = self.evaluate( requirement.value, wp.customize.control( requirement.setting ).setting._value, requirement.operator );

			self.listenTo[ requirement.setting ] = self.listenTo[ requirement.setting ] || [];
			if ( -1 === self.listenTo[ requirement.setting ].indexOf( control.id ) ) {
				self.listenTo[ requirement.setting ].push( control.id );
			}

			if ( ! requirementShow ) {
				show = false;
			}
		} );
		return show;
	},

	/**
	 * Figure out if the 2 values have the relation we want.
	 *
	 * @since 3.0.17
	 * @param {mixed} value1 - The 1st value.
	 * @param {mixed} value2 - The 2nd value.
	 * @param {string} operator - The comparison to use.
	 * @returns {bool}
	 */
	evaluate: function( value1, value2, operator ) {
		var found  = false,
		    result = null;

		if ( '===' === operator ) {
			result = value1 === value2;
		} else if ( '==' === operator || '=' === operator || 'equals' === operator || 'equal' === operator ) {
			result = value1 == value2; // jshint ignore:line
		} else if ( '!==' === operator ) {
			result = value1 !== value2;
		} else if ( '!=' === operator || 'not equal' === operator ) {
			result = value1 != value2; // jshint ignore:line
		} else if ( '>=' === operator || 'greater or equal' === operator || 'equal or greater' === operator ) {
			result = value2 >= value1;
		} else if ( '<=' === operator || 'smaller or equal' === operator || 'equal or smaller' === operator ) {
			result = value2 <= value1;
		} else if ( '>' === operator || 'greater' === operator ) {
			result = value2 > value1;
		} else if ( '<' === operator || 'smaller' === operator ) {
			result = value2 < value1;
		} else if ( 'contains' === operator || 'in' === operator ) {
			if ( _.isArray( value2 ) ) {
				_.each( value2, function( value ) {
					if ( value == value1 ) { // jshint ignore:line
						found = true;
					}
				} );
				return found;
			} else if ( _.isObject( value2 ) ) {
				if ( ! _.isUndefined( value2[ value1 ] ) ) {
					found = true;
				}

				_.each( value2, function( subValue ) {
					if ( value1 === subValue ) {
						found = true;
					}
				} );
				return found;
			} else if ( _.isString( value2 ) ) {
				return value1.indexOf( value2 ) > -1;
			}
		}
		if ( null === result ) {
			return true;
		}
		return result;
	}
};

jQuery( document ).ready( function() {
	kirkiDependencies.init();
} );
