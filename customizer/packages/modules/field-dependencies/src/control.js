var kirkiDependencies = {
  dependencyControls: {},

  init: function () {
    var self = this;

    _.each(
      window.kirkiControlDependencies,
      function (requirements, dependantID) {
        var control = wp.customize.control(dependantID);

        if (control) {
          requirements = self.addSettingLink(requirements);

          wp.customize.control(dependantID).params.required = requirements;
          self.showKirkiControl(control);
        }
      }
    );

    _.each(self.dependencyControls, function (dependency, dependencySetting) {
      _.each(dependency.childrens, function (childrenSetting) {
        wp.customize(dependency.settingLink, function (setting) {
          var setupControl = function (control) {
            var setActiveState;
            var isDisplayed;

            isDisplayed = function () {
              return self.showKirkiControl(
                wp.customize.control(childrenSetting)
              );
            };

            setActiveState = function () {
              control.active.set(isDisplayed());
            };

            setActiveState();
            setting.bind(setActiveState);

            control.active.validate = isDisplayed;
          };

          wp.customize.control(childrenSetting, setupControl);
        });
      });
    });
  },

  /**
   * Get the actual customize setting link of a control.
   *
   * @since 1.0.3
   * @param {string} controlID The ID of the control.
   * @return {string} The setting link.
   */
  getSettingLink: function (controlID) {
    var control = document.querySelector(
      '[data-kirki-setting="' + controlID + '"]'
    );
    var setting = controlID;

    if (control) {
      if (controlID !== control.dataset.kirkiSettingLink) {
        setting = control.dataset.kirkiSettingLink;
      }
    }

    return setting;
  },

  addSettingLink: function (requirements) {
		const self = this;

    requirements.forEach(function (requirement, requirementIndex) {
      if (requirement.setting) {
        requirements[requirementIndex].settingLink = self.getSettingLink(
          requirement.setting
        );
      } else {
        // If `requirement` is an array, then it has nested dependencies, so let's loop it.
        if (requirement.length) {
          requirements[requirementIndex] = self.addSettingLink(
            requirements[requirementIndex]
          );
        }
      }
    });

    return requirements;
  },

  /**
   * Should we show the control?
   *
   * @since 3.0.17
   * @param {string|object} control - The control-id or the control object.
   * @returns {bool} - Whether the control should be shown or not.
   */
  showKirkiControl: function (control) {
    const self = this;
    let show = true;

    let i;

    if (_.isString(control)) {
      control = wp.customize.control(control);
    }

    // Exit early if control not found or if "required" argument is not defined.
    if (
      "undefined" === typeof control ||
      (control.params && _.isEmpty(control.params.required))
    ) {
      return true;
    }

    // Loop control requirements.
    for (i = 0; i < control.params.required.length; i++) {
      if (!self.checkCondition(control.params.required[i], control, "AND")) {
        show = false;
      }
    }

    return show;
  },

  /**
   * Check a condition.
   *
   * @param {Object} dependency - The dependency, inherited from showKirkiControl.
   * @param {Object} dependantControl - The dependant control object.
   * @param {string} relation - Can be one of 'AND' or 'OR'.
   * @returns {bool} - Returns the results of the condition checks.
   */
  checkCondition: function (dependency, dependantControl, relation) {
    let self = this;
    let childRelation = "AND" === relation ? "OR" : "AND";
    let nestedItems;
    let value;
    let i;

    // If dependency has nested dependants, we need to process them separately.
    if (
      "undefined" !== typeof dependency[0] &&
      "undefined" === typeof dependency.setting
    ) {
      nestedItems = [];

      // Loop sub-dependencies.
      for (i = 0; i < dependency.length; i++) {
        nestedItems.push(
          self.checkCondition(dependency[i], dependantControl, childRelation)
        );
      }

      // OR relation. Check that true is part of the array.
      if ("OR" === childRelation) {
        return -1 !== nestedItems.indexOf(true);
      }

      // AND relation. Check that false is not part of the array.
      return -1 === nestedItems.indexOf(false);
    } // End of nested dependants processing.

    if ("undefined" === typeof wp.customize.control(dependency.setting)) {
      // Early exit if setting is not defined.
      return true;
    }

    if (!self.dependencyControls[dependency.setting]) {
      self.dependencyControls[dependency.setting] = {
        settingLink: dependency.settingLink,
        childrens: [],
      };
    }

    if (
      !self.dependencyControls[dependency.setting].childrens.includes(
        dependantControl.id
      )
    ) {
      self.dependencyControls[dependency.setting].childrens.push(
        dependantControl.id
      );
    }

    if (!dependency.settingLink) {
      // console.log(dependency);
      // console.log(dependantControl);
      console.log(self.dependencyControls);
      console.log("--------");
    }

    value = wp.customize(dependency.settingLink).get();

    if (wp.customize.control(dependency.setting).setting) {
      value = wp.customize.control(dependency.setting).setting._value;
    }

    return self.evaluate(
      dependency.value,
      value,
      dependency.operator,
      dependency.choice
    );
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
  evaluate: function (value1, value2, operator, choice) {
    var found = false;

    if (choice && "object" === typeof value2) {
      value2 = value2[choice];
    }

    if ("===" === operator) {
      return value1 === value2;
    }

    if (
      "==" === operator ||
      "=" === operator ||
      "equals" === operator ||
      "equal" === operator
    ) {
      return value1 == value2;
    }

    if ("!==" === operator) {
      return value1 !== value2;
    }

    if ("!=" === operator || "not equal" === operator) {
      return value1 != value2;
    }

    if (
      ">=" === operator ||
      "greater or equal" === operator ||
      "equal or greater" === operator
    ) {
      return value2 >= value1;
    }

    if (
      "<=" === operator ||
      "smaller or equal" === operator ||
      "equal or smaller" === operator
    ) {
      return value2 <= value1;
    }

    if (">" === operator || "greater" === operator) {
      return value2 > value1;
    }

    if ("<" === operator || "smaller" === operator) {
      return value2 < value1;
    }

    if ("contains" === operator || "in" === operator) {
      if (_.isArray(value1) && _.isArray(value2)) {
        _.each(value2, function (value) {
          if (value1.includes(value)) {
            found = true;
            return false;
          }
        });

        return found;
      }

      if (_.isArray(value2)) {
        _.each(value2, function (value) {
          if (value == value1) {
            // jshint ignore:line
            found = true;
          }
        });
        return found;
      }

      if (_.isObject(value2)) {
        if (!_.isUndefined(value2[value1])) {
          found = true;
        }
        _.each(value2, function (subValue) {
          if (value1 === subValue) {
            found = true;
          }
        });
        return found;
      }

      if (_.isString(value2)) {
        if (_.isString(value1)) {
          return -1 < value1.indexOf(value2) && -1 < value2.indexOf(value1);
        }
        return -1 < value1.indexOf(value2);
      }
    }

    if ("does not contain" === operator || "not in" === operator) {
      return !this.evaluate(value1, value2, "contains", choice);
    }

    return value1 == value2;
  },
};


/**
 * Enable [active_callback] for repeater's controls
 * This function MUST be here to use [kirkiControlDependencies] passed from [Field_Dependencies.php]
 *
 * @author: Kirki
 * @since 4.1.1
 */
var KirkiRepeaterDependencies = {

	repeatersControls: {},

	repeatersActiveCallbackFields: {},
	listenTo: {},

	init: function() {
			var self = this;

			/* 1. Collect All Repeaters */
	_.each( window.kirkiRepeaterControlsAvailable, function (repDetails, repeaterID) {

			var control = wp.customize.control(repeaterID);

					if( control && control.params && control.params.type && control.params.type === 'repeater' ) {

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
	 * @since 4.0.22
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
	 * @since 4.0.22
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

jQuery(document).ready(function () {
  kirkiDependencies.init();
  KirkiRepeaterDependencies.init();
});
