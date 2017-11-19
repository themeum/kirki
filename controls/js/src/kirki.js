var kirki = {

	/**
	 * An object containing definitions for controls.
	 *
	 * @since 3.0.16
	 */
	control: {

		/**
		 * The color control.
		 *
		 * @since 3.0.16
		 */
		'kirki-color': {

			/**
			 * Init the control.
			 *
			 * @since 3.0.16
			 * @param {object} [control] The customizer control object.
			 * @returns {void}
			 */
			init: function( control ) {
				var self = this;

				// Render the template.
				self.template( control );

				// Init the control.
				kirki.input.color.init( control );

			},

			/**
			 * Render the template.
			 *
			 * @since 3.0.16
			 * @param {object} [control] The customizer control object.
			 * @returns {void}
			 */
			template: function( control ) {
				control.container.html( kirki.input.color.getTemplate( {
					label: control.params.label,
					description: control.params.description,
					'data-id': control.id,
					mode: control.params.mode,
					inputAttrs: control.params.inputAttrs,
					'data-palette': control.params.palette,
					'data-default-color': control.params['default'],
					'data-alpha': control.params.choices.alpha,
					value: kirki.setting.get( control.id )
				} ) );
			}
		},

		/**
		 * The generic control.
		 *
		 * @since 3.0.16
		 */
		'kirki-generic': {

			/**
			 * Init the control.
			 *
			 * @since 3.0.17
			 * @param {object} [control] The customizer control object.
			 * @returns {void}
			 */
			init: function( control ) {
				var self = this;

				// Render the template.
				self.template( control );

				// Init the control.
				if ( ! _.isUndefined( control.params ) && ! _.isUndefined( control.params.choices ) && ! _.isUndefined( control.params.choices.element ) && 'textarea' === control.params.choices.element ) {
					kirki.input.textarea.init( control );
					return;
				}
				kirki.input.genericInput.init( control );
			},

			/**
			 * Render the template.
			 *
			 * @since 3.0.17
			 * @param {object} [control] The customizer control object.
			 * @returns {void}
			 */
			template: function( control ) {
				var args = {
						label: control.params.label,
						description: control.params.description,
						'data-id': control.id,
						inputAttrs: control.params.inputAttrs,
						choices: control.params.choices,
						value: kirki.setting.get( control.id )
				    };

				if ( ! _.isUndefined( control.params ) && ! _.isUndefined( control.params.choices ) && ! _.isUndefined( control.params.choices.element ) && 'textarea' === control.params.choices.element ) {
					control.container.html( kirki.input.textarea.getTemplate( args ) );
					return;
				}
				control.container.html( kirki.input.genericInput.getTemplate( args ) );
			}
		}
	},

	/**
	 * An object containing definitions for input fields.
	 *
	 * @since 3.0.16
	 */
	input: {

		/**
		 * Color input fields.
		 *
		 * @since 3.0.16
		 */
		color: {

			/**
			 * Get the HTML for color inputs.
			 *
			 * @since 3.0.16
			 * @param {object} [data] The arguments.
			 * @returns {string}
			 */
			getTemplate: function( data ) {

				var html = '';

				data = _.defaults( data, {
					label: '',
					description: '',
					mode: 'full',
					inputAttrs: '',
					'data-palette': data['data-palette'] ? data['data-palette'] : true,
					'data-default-color': data['data-default-color'] ? data['data-default-color'] : '',
					'data-alpha': data['data-alpha'] ? data['data-alpha'] : false,
					value: '',
					'data-id': ''
				} );

				html += '<label>';
				if ( data.label ) {
					html += '<span class="customize-control-title">' + data.label + '</span>';
				}
				if ( data.description ) {
					html += '<span class="description customize-control-description">' + data.description + '</span>';
				}
				html += '</label>';
				html += '<input type="text" data-type="' + data.mode + '" ' + data.inputAttrs + ' data-palette="' +  data['data-palette'] + '" data-default-color="' +  data['data-default-color'] + '" data-alpha="' + data['data-alpha'] + '" value="' + data.value + '" class="kirki-color-control" data-id="' + data['data-id'] + '"/>';

				return '<div class="kirki-input-container" data-id="' + data.id + '">' + html + '</div>';
			},

			/**
			 * Init the control.
			 *
			 * @since 3.0.16
			 * @param {object} [control] The control object.
			 * @returns {void}
			 */
			init: function( control ) {
				var picker = jQuery( '.kirki-color-control[data-id="' + control.id + '"]' ),
				    clear;

				control.choices = control.choices || {};
				if ( _.isEmpty( control.choices ) && control.params.choices ) {
					control.choices = control.params.choices;
				}

				// If we have defined any extra choices, make sure they are passed-on to Iris.
				if ( ! _.isEmpty( control.choices ) ) {
					picker.wpColorPicker( control.choices );
				}

				// Tweaks to make the "clear" buttons work.
				setTimeout( function() {
					clear = jQuery( '.kirki-input-container[data-id="' + control.id + '"] .wp-picker-clear' );
					if ( clear.length ) {
						clear.click( function() {
							control.setting.set( '' );
						});
					}
				}, 200 );

				// Saves our settings to the WP API
				picker.wpColorPicker({
					change: function() {

						// Small hack: the picker needs a small delay
						setTimeout( function() {
							kirki.setting.set( control.id, picker.val() );
						}, 20 );
					}
				});
			}
		},

		/**
		 * Generic input fields.
		 *
		 * @since 3.0.17
		 */
		genericInput: {

			/**
			 * Get the HTML.
			 *
			 * @since 3.0.17
			 * @param {object} [data] The arguments.
			 * @returns {string}
			 */
			getTemplate: function( data ) {
				var html    = '',
				    element = ( data.choices.element ) ? data.choices.element : 'input';

				data = _.defaults( data, {
					label: '',
					description: '',
					inputAttrs: '',
					value: '',
					'data-id': '',
					choices: {}
				} );

				html += '<label>';
				if ( data.label ) {
					html += '<span class="customize-control-title">' + data.label + '</span>';
				}
				if ( data.description ) {
					html += '<span class="description customize-control-description">' + data.description + '</span>';
				}
				html += '<div class="customize-control-content">';
				html += '<' + element + ' data-id="' + data['data-id'] + '" ' + data.inputAttrs + ' value="' + data.value + '" ' + data.link;
				_.each( data.choices, function( val, key ) {
					html += ' ' + key + '="' + val + '"';
				});
				if ( data.choices.content ) {
					html += '>' + data.choices.content + '</' + element + '>';
				} else {
					html += '/>';
				}
				html += '</div>';
				html += '</label>';

				return '<div class="kirki-input-container" data-id="' + data.id + '">' + html + '</div>';
			},

			/**
			 * Init the control.
			 *
			 * @since 3.0.17
			 * @param {object} [control] The control object.
			 * @returns {void}
			 */
			init: function( control ) {
				var input = jQuery( 'input[data-id="' + control.id + '"]' );

				// Save the value
				input.on( 'change keyup paste click', function() {
					kirki.setting.set( control.id, jQuery( this ).val() );
				});
			}
		},

		/**
		 * Generic input fields.
		 *
		 * @since 3.0.17
		 */
		textarea: {

			/**
			 * Get the HTML for textarea inputs.
			 *
			 * @since 3.0.17
			 * @param {object} [data] The arguments.
			 * @returns {string}
			 */
			getTemplate: function( data ) {
				var html    = '';

				data = _.defaults( data, {
					label: '',
					description: '',
					inputAttrs: '',
					value: '',
					'data-id': '',
					choices: {}
				} );

				html += '<label>';
				if ( data.label ) {
					html += '<span class="customize-control-title">' + data.label + '</span>';
				}
				if ( data.description ) {
					html += '<span class="description customize-control-description">' + data.description + '</span>';
				}
				html += '<div class="customize-control-content">';
				html += '<textarea data-id="' + data['data-id'] + '"' + data.inputAttrs + ' ' + data.link + 'value="' + data.value + '"';
				_.each( data.choices, function( val, key ) {
					html += ' ' + key + '="' + val + '"';
				});
				html += '>' + data.value + '</textarea>';
				html += '</div>';
				html += '</label>';

				return '<div class="kirki-input-container" data-id="' + data.id + '">' + html + '</div>';
			},

			/**
			 * Init the control.
			 *
			 * @since 3.0.17
			 * @param {object} [control] The control object.
			 * @returns {void}
			 */
			init: function( control ) {
				var textarea = jQuery( 'textarea[data-id="' + control.id + '"]' );

				// Save the value
				textarea.on( 'change keyup paste click', function() {
					kirki.setting.set( control.id, jQuery( this ).val() );
				});
			}
		},

		select: {

			/**
			 * Get the HTML for select inputs.
			 *
			 * @since 3.0.17
			 * @param {object} [data] The arguments.
			 * @returns {string}
			 */
			getTemplate: function( data ) {
				var html,
				    selected;

				data = _.defaults( data, {
					label: '',
					description: '',
					inputAttrs: '',
					'data-id': '',
					choices: {},
					multiple: 1,
					value: ( 1 < data.multiple ) ? [] : ''
				} );

				if ( ! data.choices ) {
					return;
				}
				if ( 1 < data.multiple && data.value && _.isString( data.value ) ) {
					data.value = [ data.value ];
				}

				html += '<label>';
				if ( data.label ) {
					html += '<span class="customize-control-title">' + data.label + '</span>';
				}
				if ( data.description ) {
					html += '<span class="description customize-control-description">' + data.description + '</span>';
				}
				html += '<select data-id="' + data['data-id'] + '" ' + data.inputAttrs + ' ' + data.link;
			 	if ( 1 < data.multiple ) {
					html += ' data-multiple="' + data.multiple + '" multiple="multiple"';
				}
				html += '>';
				_.each( data.choices, function( optionLabel, optionKey ) {
					selected = ( data.value === optionKey );
					if ( 1 < data.multiple && data.value ) {
						selected = _.contains( data.value, optionKey );
					}
					if ( _.isObject( optionLabel ) ) {
						html += '<optgroup label="' + optionLabel[0] + '">';
						_.each( optionLabel[1], function( optgroupOptionLabel, optgroupOptionKey ) {
							selected = ( data.value === optgroupOptionKey );
							if ( 1 < data.multiple && data.value ) {
								selected = _.contains( data.value, optgroupOptionKey );
							}
							html += '<option value="' + optgroupOptionKey + '"';
							if ( selected ) {
								html += ' selected';
							}
							html += '>' + optgroupOptionLabel + '</option>';
						} );
						html += '</optgroup>';
					} else {
						html += '<option value="' + optionKey + '"';
						if ( selected ) {
							html += ' selected';
						}
						html += '>' + optionLabel + '</option>';
					}
				} );
				html += '</select></label>';

				return '<div class="kirki-input-container" data-id="' + data.id + '">' + html + '</div>';
			},

			/**
			 * Init the control.
			 *
			 * @since 3.0.17
			 * @param {object} [control] The control object.
			 * @returns {void}
			 */
			init: function( control ) {
				var element  = jQuery( 'select[data-id="' + control.id + '"' ),
				    multiple = parseInt( element.data( 'multiple' ), 10 ),
				    selectValue,
				    selectWooOptions = {
						escapeMarkup: function( markup ) {
							return markup;
						}
				    };

				if ( 1 < multiple ) {
					selectWooOptions.maximumSelectionLength = multiple;
				}
				jQuery( element ).selectWoo( selectWooOptions ).on( 'change', function() {
					selectValue = jQuery( this ).val();
					kirki.setting.set( control.id, selectValue );
				});
			}
		}
	},

	/**
	 * An object containing definitions for settings.
	 *
	 * @since 3.0.16
	 */
	setting: {

		/**
		 * Gets the value of a setting.
		 *
		 * This is a helper function that allows us to get the value of
		 * control[key1][key2] for example, when the setting used in the
		 * customizer API is "control".
		 *
		 * @since 3.0.16
		 * @param {string} [setting] The setting for which we're getting the value.
		 * @returns {mixed} Depends on the value.
		 */
		get: function( setting ) {
			var parts        = setting.split( '[' ),
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
		 * @since 3.0.16
		 * @param {object|string} [element] The DOM element whose value has changed,
		 *                                  or an ID.
		 * @param {mixed}         [value]   Depends on the control-type.
		 * @param {string}        [key]     If we only want to save an item in an object
		 *                                  we can define the key here.
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
			setting = element;
			if ( _.isObject( element ) ) {
				if ( jQuery( element ).attr( 'data-id' ) ) {
					setting = element.attr( 'data-id' );
				} else {
					setting = element.parents( '[data-id]' ).attr( 'data-id' );
				}
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
	}
};
