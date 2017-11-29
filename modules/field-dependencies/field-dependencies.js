var kirki = kirki || {};
kirki.util = kirki.util || {};
kirki.util.dependencies = {

	listenTo: {},

	init: function() {
		var self = this;

		wp.customize.control.each( function( control ) {
			self.showKirkiControl( control );
		} );

		_.each( self.listenTo, function( slaves, master ) {
			_.each( slaves, function( slave ) {
				wp.customize( slave, function( setting ) {
				    var setupControl = function( control ) {
				        var setActiveState,
						    isDisplayed;

						control.active.validate = isDisplayed;

				        isDisplayed = function() {
				            return self.showKirkiControl( wp.customize.control( slave ) );
				        };
				        setActiveState = function() {
				            control.active.set( isDisplayed() );
				        };
				        setActiveState();
				        setting.bind( setActiveState );
				    };
				    wp.customize.control( master, setupControl );
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

		// Exit early if control not found.
		if ( 'undefined' === typeof control ) {
			return;
		}

		// Exit early if "required" argument is not defined.
		if ( _.isEmpty( control.params.required ) ) {
			return;
		}

		// Loop control requirements.
		_.each( control.params.required, function( requirement ) {
			var requirementShow = self.evaluate(
				control.setting.get(),
				wp.customize( requirement.setting ).get(),
				requirement.operator
			);

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
		var found = false,
			value;

		if ( '===' === operator ) {
			return value1 === value2;
		}
		if ( '==' === operator || '=' === operator || 'equals' === operator || 'equal' === operator ) {
			return value1 == value2; // jshint ignore:line
		}
		if ( '!==' === operator ) {
			return value1 !== value2;
		}
		if ( '!=' === operator || 'not equal' === operator ) {
			return value1 != value2; // jshint ignore:line
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
			if ( _.isArray( value2 ) ) {
				found = false;
				_.each( value2, function( index, value ) {
					if ( _.isNumber( value ) ) {
						value = parseInt( value, 10 );
					}
					if ( value1.indexOf( value ) > -1 ) {
						found = true;
					}
				} );
				return found;
			} else if ( _.isObject( value2 ) ) {
				found = false;
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
		return true;
	}
};

jQuery( document ).ready( function() {
	kirki.util.dependencies.init();
} );
