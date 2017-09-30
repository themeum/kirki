/* global wp, _ */
var kirki = kirki || {
	input: {
		/**
		 * Get the template for an input field.
		 */
		getTemplate: function( args ) {
			var self = this,
			    html = '';

			args = _.defaults( args, {
				type: 'text',
				inputAttrs: '',
				element: 'input',
				value: '',
				choice: {},
				id: '',
				label: '',
				description: ''
			});

			args.type = args.type || 'text';
			args.inputAttrs = args.inputAttrs || '';

			switch ( args.type ) {
				case 'textarea':
					return '<textarea ' + args.inputAttrs + '>' + args.value + '</textarea>';

				case 'select':
					args.multiple = args.multiple || 1;
					args.multiple = parseInt( args.multiple, 10 );
					html += '<select data-id="' + args.id + '" ' + args.inputAttrs + ( 1 < args.multiple ? ' data-multiple="' + args.multiple + '" multiple="multiple"' : '' ) + '>';
						_.each( args.choices, function( optionLabel, optionKey ) {

							// Is this option selected?
							var selected = ( args.value === optionKey );
							if ( 1 < args.multiple && args.value ) {
								selected = _.contains( args.value, optionKey );
							}

							// If instead of a label (string) we have an object,
							// then treat this as an optgroup element.
							if ( _.isObject( optionLabel ) ) {
								html += '<optgroup label="' + optionLabel[0] + '">';
								_.each( optionLabel[1], function( optgroupOptionLabel, optgroupOptionKey ) {

									// Is this option selected? (re-loop because of optgroup).
									selected = ( args.value === optgroupOptionKey );
									if ( 1 < args.multiple && args.value ) {
										selected = _.contains( args.value, optgroupOptionKey );
									}

									// Add option in optgroup.
									html += '<option value="' + optgroupOptionKey + '"' + ( selected ? ' selected' : '' ) + '>' + optgroupOptionLabel + '</option>';
								} );
								html += '</optgroup>';
							} else {

								// Add hte option.
								html += '<option value="' + optionKey + '"' + ( selected ? ' selected' : '' ) + '>' + optionLabel + '</option>';
							}
						} );
					html += '</select>';
					break;

				case 'radio':
					_.each( args.choices, function( value, key ) {
						html += '<label>';
							html += '<input ' + args.inputAttrs + ' type="radio" value="' + key + '" name="' + args.id + '" ' + ( args.value === key ? ' checked' : '' ) + '/>';
							html += ( _.isArray( value ) ) ? args.value[0] + '<span class="option-description">' + args.value[1] + '</span>' : value;
						html += '</label>';
					} );
					return html;

				case 'color':
					return self.getTemplate( _.defaults( args, {
						type: 'text',
						inputAttrs: '',
						'data-palette': args.palette || '',
						'data-default-color': args['default'] || '',
						'data-alpha': args.arpha || true,
						value: '',
						'class': 'kirki-color-control'
					} ) );

				case 'checkbox':
					return '<input data-setting="' + args.id + '" type="checkbox" ' + args.inputAttrs + 'value="' + args.value + '" ' + ( true === args.value ? ' checked' : '' ) + '/>';

				default:
					html += '<' + args.element + ' data-setting="' + args.id + '" value="' + args.value + '" ' + args.inputAttrs + ' ';
					_.each( args.choices, function( value, key ) {
						html += key += '"' + value + '"';
					} );
					html += ( ! _.isUndefined( args.choices.content ) && args.choices.content ) ? '>' + args.choices.content + '</' + args.element + '>' : '/>';
					return html;
			}
		},

		init: function( args ) {
			var element;

			switch ( args.type ) {
				case 'select':
					element = 'select[data-id=' + args.id + ']';

					// Init select2 for this element.
					jQuery( element ).select2( {
						escapeMarkup: function( markup ) {
							return markup;
						},
						maximumSelectionLength: args.multiple
					} ).on( 'change', function() {
						kirki.setting.set( this, jQuery( this ).val() );
					} );
					break;

				case 'color':

					element = '.kirki-color-control[data-setting=' + args.id + ']';

					// If we have defined any extra choices, make sure they are passed-on to Iris.
					if ( ! _.isUndefined( args.choices ) ) {
						jQuery( element ).wpColorPicker( args.choices );
					}

					// Tweaks to make the "clear" buttons work.
					setTimeout( function() {
						var clear = jQuery( element ).closest( '.wp-picker-clear' );
						clear.click( function() {
							kirki.setting.set( jQuery( element ), '' );
						});
					}, 200 );

					// Saves our settings to the WP API
					jQuery( element ).wpColorPicker({
						change: function() {

							// Small hack: the picker needs a small delay
							setTimeout( function() {
								kirki.setting.set( jQuery( element ), jQuery( element ).val() );
							}, 20 );
						}
					});
					break;

				default:
			}
		}
	},

	control: {

		/**
		 * An object containing template-specific functions.
		 *
		 * @since 3.1.0
		 */
		template: {

			/**
			 * Gets the HTML for control headers.
			 *
			 * @since 3.1.0
			 * @param {object} [control] The control object.
			 * @return {string}
			 */
			header: function( control ) {
				var html = '';

				html += '<span class="customize-control-title">' + control.params.label + '</span>';
				if ( control.params.description && '' !== control.params.description ) {
					html += '<span class="description customize-control-description">' + control.params.description + '</span>';
				}
				return html;
			}
		},

		setValue: function() {}

	},
	setting: {
		/**
		 * Gets the value of a setting.
		 *
		 * This is a helper function that allows us to get the value of
		 * control[key1][key2] for example, when the setting used in the
		 * customizer API is "control".
		 *
		 * @since 3.1.0
		 * @param {string} [setting] The setting for which we're getting the value.
		 * @returns {(string|array|object|bool)} Depends on the value.
		 */
		get: function( setting ) {
			var parts = setting.split( '[' ),
				foundSetting = '',
				foundInStep  = 0,
				currentVal   = '';

			_.each( parts, function( part, i ) {
				part = part.replace( ']', '' );

				if ( 0 === i ) {
					foundSetting = part;
				} else {
					foundSetting += '[' + part + ']';
				}

				if ( ! _.isUndefined( wp.customize.instance( foundSetting ) ) ) {
					currentVal  = wp.customize.instance( foundSetting ).get();
					foundInStep = i;
				}

				if ( foundInStep < i ) {
					if ( _.isObject( currentVal ) && ! _.isUndefined( currentVal[ part ] ) ) {
						currentVal = currentVal[ part ];
					}
				}
			});

			return currentVal;
		},

		/**
		 * Sets the value of a setting.
		 *
		 * This function is a bit complicated because there any many scenarios to consider.
		 * Example: We want to save the value for my_setting[something][3][something-else].
		 * The control's setting is my_setting[something].
		 * So we need to find that first, then figure out the remaining parts,
		 * merge the values recursively to avoid destroying my_setting[something][2]
		 * and also take into account any defined "key" arguments which take this even deeper.
		 *
		 * @since 3.1.0
		 * @param {object}                     [element] The DOM element whose value has changed.
		 *                                               Format: {element:value, context:id|element}.
		 *                                               We'll use this to find the setting.
		 * @param {(string|array|bool|object)} [value]   Depends on the control-type.
		 * @param {string}                     [key]     If we only want to save an item in an object
		 *                                               we can define the key here.
		 * @returns {void}
		 */
		set: function( element, value, key ) {
			var setting,
			    parts,
			    currentNode   = '',
			    foundNode     = '',
			    subSettingObj = {},
			    currentVal,
			    subSetting,
			    subSettingParts;

			// Get the setting from the element.
			if ( jQuery( element ).attr( 'data-setting' ) ) {
				setting = jQuery( element ).attr( 'data-setting' );
			} else {
				setting = jQuery( element ).parents( '.kirki-control-wrapper' ).attr( 'data-setting' );
			}
			parts = setting.split( '[' ),

			// Find the setting we're using in the control using the customizer API.
			_.each( parts, function( part, i ) {
				part = part.replace( ']', '' );

				// The current part of the setting.
				currentNode = ( 0 === i ) ? part : '[' + part + ']';

				// When we find the node, get the value from it.
				// In case of an object we'll need to merge with current values.
				if ( ! _.isUndefined( wp.customize.instance( currentNode ) ) ) {
					foundNode  = currentNode;
					currentVal = wp.customize.instance( foundNode ).get();
				}
			} );

			// Get the remaining part of the setting that was unused.
			subSetting = setting.replace( foundNode, '' );

			// If subSetting is not empty, then we're dealing with an object
			// and we need to dig deeper and recursively merge the values.
			if ( '' !== subSetting ) {
				if ( ! _.isObject( currentVal ) ) {
					currentVal = {};
				}
				if ( '[' === subSetting.charAt( 0 ) ) {
					subSetting = subSetting.replace( '[', '' );
				}
				subSettingParts = subSetting.split( '[' );
				_.each( subSettingParts, function( subSettingPart, i ) {
					subSettingParts[ i ] = subSettingPart.replace( ']', '' );
				} );

				// If using a key, we need to go 1 level deeper.
				if ( key ) {
					subSettingParts.push( key );
				}

				// Converting to a JSON string and then parsing that to an object
				// may seem a bit hacky and crude but it's efficient and works.
				subSettingObj = '{"' + subSettingParts.join( '":{"' ) + '":"' + value + '"' + '}'.repeat( subSettingParts.length );
				subSettingObj = JSON.parse( subSettingObj );

				// Recursively merge with current value.
				jQuery.extend( true, currentVal, subSettingObj );
				value = currentVal;

			} else {
				if ( key ) {
					currentVal = ( ! _.isObject( currentVal ) ) ? {} : currentVal;
					currentVal[ key ] = value;
					value = currentVal;
				}
			}

			wp.customize.control( foundNode ).setting.set( value );
		}
	},

	value: {
		set: {

			/**
			 * Sets the value in wp-customize settings.
			 *
			 * @param {object} [control] The control.
			 * @param {mixed}  [value]   The value.
			 * @param {string} [key]     A key if we only want to change part of an object value.
			 * @returns {void}
			 */
			defaultControl: function( control, value, key ) {
				var valObj;

				// Calculate the value if we've got a key defined.
				if ( ! _.isUndefined( key ) ) {
					if ( ! _.isUndefined( control.setting ) && ! _.isUndefined( control.setting._value ) ) {
						valObj = control.setting._value;
					} else if ( ! _.isUndefined( control.params ) && ! _.isUndefined( control.params.value ) ) {
						valObj = control.params.value;
					} else if ( ! _.isUndefined( control.value ) ) {
						valObj = control.value;
					}
					valObj[ key ] = value;
					value = valObj;
				}

				// Reset the value.
				if ( _.isUndefined( key ) ) {
					control.setting.set( '' );
				} else {
					control.setting.set( {} );
				}

				// Set the value.
				control.setting.set( value );
			}
		}
	},

	/**
	 * A collection of utility functions.
	 *
	 * @since 3.1.0
	 */
	util: {

		/**
		 * Returns the wrapper element of the control.
		 *
		 * @since 3.1.0
		 * @param {object} [control] The control arguments.
		 * @returns {array}
		 */
		controlContainer: function( control ) {
			return jQuery( '#kirki-control-wrapper-' + control.id );
		},

		/**
		 * Gets the control-type, with or without the 'kirki-' prefix.
		 *
		 * @since 3.1.0
		 * @param {string}      [controlType] The control-type.
		 * @param {bool|string} [prefix]      If false, return without prefix.
		 *                                    If true, return with 'kirki-' as prefix.
		 *                                    If string, add custom prefix.
		 * @returns {string}
		 */
		getControlType: function( controlType, prefix ) {

			controlType = controlType.replace( 'kirki-', '' );
			if ( _.isUndefined( prefix ) || false === prefix ) {
				return controlType;
			}
			if ( true === prefix ) {
				return 'kirki-' + controlType;
			}
			return prefix + controlType;
		},

		/**
		 * Validates dimension css values.
		 *
		 * @param {string} [value] The value we want to validate.
		 * @returns {bool}
		 */
		kirkiValidateCSSValue: function( value ) {

			var validUnits = ['rem', 'em', 'ex', '%', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ch', 'vh', 'vw', 'vmin', 'vmax'],
				numericValue,
				unit;

			// 0 is always a valid value, and we can't check calc() values effectively.
			if ( '0' === value || ( 0 <= value.indexOf( 'calc(' ) && 0 <= value.indexOf( ')' ) ) ) {
				return true;
			}

			// Get the numeric value.
			numericValue = parseFloat( value );

			// Get the unit
			unit = value.replace( numericValue, '' );

			// Check the validity of the numeric value and units.
			if ( isNaN( numericValue ) || 0 > _.indexOf( validUnits, unit ) ) {
				return false;
			}
			return true;
		}
	}
};
