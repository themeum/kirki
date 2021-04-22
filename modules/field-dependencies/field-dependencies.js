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
			} );
		} );
	},

	/**
	 * Should we show the control?
	 *
	 * @since 3.0.17
	 * @param {string|object} control - The control-id or the control object.
	 * @returns {bool}
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

		// control.params.required
		// console.log(control);

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
	 */
	checkCondition: function( requirement, control, isOption, relation ) {
		var self          = this,
			childRelation = ( 'AND' === relation ) ? 'OR' : 'AND',
			nestedItems,
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

		return self.evaluate(
			requirement.value,
			wp.customize.control( requirement.setting ).setting._value,
			requirement.operator
		);
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
		var found = false;

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
		return value1 == value2;
	}
};



/**
 * Enable [active_callback] for repeater's controls
 * 
 * @since 3.1.7
 */
var KirkiRepeaterDependencies = {

	repeatersControls: {},

	repeatersActiveCallbackFields: {},
	listenTo: {},

	init: function() {
		var self = this;

		/* 1. Collect All Repeaters */
		wp.customize.control.each( function( control ) {
			
			if( control.params && control.params.type && control.params.type === 'repeater' ) {

				self.repeatersControls[ control.id ] = self.repeatersControls[ control.id ] || [];

				self.repeatersControls[ control.id ] = {
					'user_entries': JSON.parse( decodeURI( control.setting.get() ) ) /* @see function [getValue] in [wp.customize.controlConstructor.repeater] located in [controls/js/script.js] */
				};

			}

		} );

		/* 2. Collect Active Callbacks Arrays for each Available Repeater */
		_.each( self.repeatersControls, function( repDetails, repID ) {
				
			var repControl = wp.customize.control( repID ),
				repUserEntries = (! _.isUndefined( repDetails ) && !_.isUndefined( repDetails['user_entries'] ) && ! _.isEmpty( repDetails['user_entries'] ) ) ? repDetails['user_entries'] : null;

			if( ! _.isUndefined( repControl ) && ! _.isNull( repUserEntries ) ) {

				_.each(repUserEntries, function(rowValue, rowIndex) {

					_.each(rowValue, function(eleValue, eleID) {
						
						if( !_.isUndefined( repControl.params.fields[ eleID ] ) ) {

							var eleDetails = repControl.params.fields[ eleID ];

							self.showRepeaterControl( repControl.id, eleDetails, rowValue );

						}

					});

				});


				self.repeatersActiveCallbackFields[ repControl.id ] = self.repeatersActiveCallbackFields[ repControl.id ] || [];
				self.repeatersActiveCallbackFields[ repControl.id ] = self.listenTo;
				/* Destroy it */
				self.listenTo = {};

			}

		} );


		/* 3. Iterate inside every user entry and Apply [showRepeaterControl] on each slave element */
		_.each( self.repeatersActiveCallbackFields, function( required_fields, repID ) {
			
			objRepeaterControl 		= wp.customize.control( repID );
			
			if( ! _.isUndefined( objRepeaterControl ) ) {
			
				var repUserEntries 	= JSON.parse( decodeURI( objRepeaterControl.setting.get() ) ), /* @see function [getValue] in [wp.customize.controlConstructor.repeater] located in [controls/js/script.js] */
					repFields 	= objRepeaterControl.params.fields;
				
				_.each(repUserEntries, function(rowValue, rowIndex) {

					_.each( required_fields, function( slaves, master ) {
						
						_.each( slaves, function( slave ) {
	
								var objSlave = repFields[ slave ],
									setActiveState,
									isDisplayed;
	
								isDisplayed = function() {
									return self.showRepeaterControl( repID, objSlave, rowValue );
								};
	
								setActiveState = function() {
									if( isDisplayed() ) {
										jQuery(objRepeaterControl.selector).find( '[data-row="' + rowIndex + '"] .repeater-field-' + slave ).removeClass('inactive').addClass('active').slideDown('fast');
									}
									else {
										jQuery(objRepeaterControl.selector).find( '[data-row="' + rowIndex + '"] .repeater-field-' + slave ).removeClass('active').addClass('inactive').slideUp('fast');
									}
								};
	
								setActiveState();
		
	
						} );
	
					});
	
				});

			}

		} );

	},


	/**
	 * Should we show the control?
	 *
	 * @since 3.1.7
	 * 
	 * @param {string} 			repeaterID - The repeater ID
	 * @param {string|object}	control - The control-id or the control object.
	 * @param {object}			rowEntries - The user entry for a repeater block
	 * @returns {bool}
	 */
	showRepeaterControl: function( repeaterID, control, rowEntries ) {
		
		var self     = this,
			show     = true,

			isOption = (
				! _.isUndefined( control ) &&	/* Fix: Multiple Repeaters with no active_callback */
				! _.isUndefined( control.id ) &&	/* Fix: Multiple Repeaters with no active_callback */
				control.id && // Check if id exists.
				control.type &&  // Check if tpe exists.
				! _.isEmpty( control.type ) // Check if control's type is not empty.
			),
			i;

		// Exit early if control not found or if "required" argument is not defined.
		if ( 'undefined' === typeof control || 'undefined' === typeof control.active_callback || ( control.active_callback && _.isEmpty( control.active_callback ) ) ) {
			return true;
		}

		// console.log(rowEntries);

		// Loop control requirements.
		for ( i = 0; i < control.active_callback.length; i++ ) {
			if ( ! self.checkCondition( repeaterID, control.active_callback[ i ], control, rowEntries, isOption, 'AND' ) ) {
				show = false;
			}
		}
		return show;
	},

	/**
	 * Check a condition.
	 *
	 * @param {string} repeaterID - The repeater ID
	 * @param {Object} requirement - The requirement, inherited from showRepeaterControl - Represents the Active Callack Array.
	 * @param {Object} control 	- The repeater's control object.
	 * @param {object} rowEntries - The user entry for a repeater block
	 * @param {bool}   isOption - Whether it's an option or not.
	 * @param {string} relation - Can be one of 'AND' or 'OR'.
	 */
	checkCondition: function( repeaterID, requirement, control, rowEntries, isOption, relation ) {
		var self          = this,
			childRelation = ( 'AND' === relation ) ? 'OR' : 'AND',
			nestedItems,
			requirementSettingValue,
			i;



		// If an array of other requirements nested, we need to process them separately.
		if ( 'undefined' !== typeof requirement[0] && 'undefined' === typeof requirement.setting ) {

			nestedItems = [];

			// Loop sub-requirements.
			for ( i = 0; i < requirement.length; i++ ) {
				nestedItems.push( self.checkCondition( repeaterID, requirement[ i ], control, rowEntries, isOption, childRelation ) );
			}


			// OR relation. Check that true is part of the array.
			if ( 'OR' === childRelation ) {
				return ( -1 !== nestedItems.indexOf( true ) );
			}

			// AND relation. Check that false is not part of the array.
			return ( -1 === nestedItems.indexOf( false ) );
		}


		// Early exit if setting is not defined.
		if ( ! requirement.setting in rowEntries ) {
			return true;
		}

		/* Requirement Setting User Value */
		requirementSettingValue = rowEntries[ requirement.setting ];
	
		// console.log( requirementSettingValue );

		/**
		 * Output: listenTo
		 * 
		 * Master_#1	=> array(
		 * 		0: Slave #1,
		 * 		1: Slave #2
		 * )
		 * 
		 */
		self.listenTo[ requirement.setting ] = self.listenTo[ requirement.setting ] || [];

		if ( -1 === self.listenTo[ requirement.setting ].indexOf( control.id ) ) {
			
			self.listenTo[ requirement.setting ].push( control.id );
	   
	   }

		return self.evaluate(
			requirement.value,
			requirementSettingValue,
			requirement.operator
		);

	},

	/**
	 * Figure out if the 2 values have the relation we want.
	 *
	 * @since 3.1.7
	 * @param {mixed} value1 - The 1st value.
	 * @param {mixed} value2 - The 2nd value.
	 * @param {string} operator - The comparison to use.
	 * @returns {bool}
	 */
	evaluate: function( value1, value2, operator ) {
		var found = false;

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
		return value1 == value2;
	}

};



jQuery( document ).ready( function() {
	
	kirkiDependencies.init();
		
	KirkiRepeaterDependencies.init();
	
} );
