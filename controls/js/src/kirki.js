/* global ajaxurl, kirkiL10n */
var kirki = {

	initialized: false,

	/**
	 * Initialize the object.
	 *
	 * @since 3.0.17
	 * @returns {void}
	 */
	initialize: function() {
		var self = this;

		// We only need to initialize once.
		if ( self.initialized ) {
			return;
		}

		self.util.webfonts.google.initialize();

		// Mark as initialized.
		self.initialized = true;
	},

	/**
	 * An object containing definitions for controls.
	 *
	 * @since 3.0.16
	 */
	control: {

		/**
		 * The radio control.
		 *
		 * @since 3.0.17
		 */
		'kirki-radio': {

			/**
			 * Init the control.
			 *
			 * @since 3.0.17
			 * @param {Object} control - The customizer control object.
			 * @returns {void}
			 */
			init: function( control ) {
				var self = this;

				// Render the template.
				self.template( control );

				// Init the control.
				kirki.input.radio.init( control );

			},

			/**
			 * Render the template.
			 *
			 * @since 3.0.17
			 * @param {Object} control - The customizer control object.
			 * @param {Object} control.params - The control parameters.
			 * @param {string} control.params.label - The control label.
			 * @param {string} control.params.description - The control description.
			 * @param {string} control.params.inputAttrs - extra input arguments.
			 * @param {string} control.params.default - The default value.
			 * @param {Object} control.params.choices - Any extra choices we may need.
			 * @param {string} control.id - The setting.
			 * @returns {void}
			 */
			template: function( control ) {
				control.container.html( kirki.input.radio.getTemplate( {
					label: control.params.label,
					description: control.params.description,
					'data-id': control.id,
					inputAttrs: control.params.inputAttrs,
					'default': control.params['default'],
					value: kirki.setting.get( control.id ),
					choices: control.params.choices
				} ) );
			}
		},

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
			 * @param {Object} control - The customizer control object.
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
			 * @param {Object}     control - The customizer control object.
			 * @param {Object}     control.params - The control parameters.
			 * @param {string}     control.params.label - The control label.
			 * @param {string}     control.params.description - The control description.
			 * @param {string}     control.params.mode - The colorpicker mode. Can be 'full' or 'hue'.
			 * @param {bool|array} control.params.palette - false if we don't want a palette,
			 *                                              true to use the default palette,
			 *                                              array of custom hex colors if we want a custom palette.
			 * @param {string}     control.params.inputAttrs - extra input arguments.
			 * @param {string}     control.params.default - The default value.
			 * @param {Object}     control.params.choices - Any extra choices we may need.
			 * @param {boolean}    control.params.choices.alpha - should we add an alpha channel?
			 * @param {string}     control.id - The setting.
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
			 * @param {Object} control - The customizer control object.
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
			 * @param {Object}  control - The customizer control object.
			 * @param {Object}  control.params - The control parameters.
			 * @param {string}  control.params.label - The control label.
			 * @param {string}  control.params.description - The control description.
			 * @param {string}  control.params.inputAttrs - extra input arguments.
			 * @param {string}  control.params.default - The default value.
			 * @param {Object}  control.params.choices - Any extra choices we may need.
			 * @param {boolean} control.params.choices.alpha - should we add an alpha channel?
			 * @param {string}  control.id - The setting.
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
		},

		'kirki-select': {

			/**
			 * Init the control.
			 *
			 * @since 3.0.17
			 * @param {Object} control - The customizer control object.
			 * @returns {void}
			 */
			init: function( control ) {
				var self = this;

				// Render the template.
				self.template( control );

				// Init the control.
				kirki.input.select.init( control );
			},

			/**
			 * Render the template.
			 *
			 * @since 3.0.17
			 * @param {Object}  control - The customizer control object.
			 * @param {Object}  control.params - The control parameters.
			 * @param {string}  control.params.label - The control label.
			 * @param {string}  control.params.description - The control description.
			 * @param {string}  control.params.inputAttrs - extra input arguments.
			 * @param {string}  control.params.default - The default value.
			 * @param {Object}  control.params.choices - The choices for the select dropdown.
			 * @param {integer} control.params.multiple - Is this a multi-select? How many options max?
			 * @param {string}  control.id - The setting.
			 * @returns {void}
			 */
			template: function( control ) {
				var args = {
						label: control.params.label,
						description: control.params.description,
						'data-id': control.id,
						inputAttrs: control.params.inputAttrs,
						choices: control.params.choices,
						value: kirki.setting.get( control.id ),
						multiple: control.params.multiple
				    };

				control.container.html( kirki.input.select.getTemplate( args ) );
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
		 * Radio input fields.
		 *
		 * @since 3.0.17
		 */
		radio: {
			/**
			 * Get the HTML for color inputs.
			 *
			 * @since 3.0.17
			 * @param {Object} data - The arguments.
			 * @param {string} data.label - The control label.
			 * @param {string} data.description - The control description.
			 * @param {string} data.inputAttrs - extra input arguments.
			 * @param {string} data.default - The default value.
			 * @param {Object} data.choices - The choices for the select dropdown.
			 * @param {string} data.id - The setting.
			 * @returns {string}
			 */
			getTemplate: function( data ) {
				var html = '';

				data = _.defaults( data, {
					choices: {},
					label: '',
					description: '',
					inputAttrs: '',
					value: '',
					'data-id': '',
					'default': ''
				} );

				if ( ! data.choices ) {
					return;
				}

				if ( data.label ) {
					html += '<span class="customize-control-title">' + data.label + '</span>';
				}
				if ( data.description ) {
					html += '<span class="description customize-control-description">' + data.description + '</span>';
				}
				_.each( data.choices, function( val, key ) {
					html += '<label>';
					html += '<input ' + data.inputAttrs + ' type="radio" data-id="' + data['data-id'] + '" value="' + key + '" name="_customize-radio-' + data.id + '" ' + data.link + ( data.value === key ? ' checked' : '' ) + '/>';
					html += ( _.isArray( val ) ) ? val[0] + '<span class="option-description">' + val[1] + '</span>' : val;
					html += '</label>';
				} );

				return '<div class="kirki-input-container" data-id="' + data.id + '">' + html + '</div>';
			},

			/**
			 * Init the control.
			 *
			 * @since 3.0.17
			 * @param {Object} control - The control object.
			 * @param {Object} control.id - The setting.
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
		 * Color input fields.
		 *
		 * @since 3.0.16
		 */
		color: {

			/**
			 * Get the HTML for color inputs.
			 *
			 * @since 3.0.16
			 * @param {Object} data - The arguments.
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
			 * @param {Object} control - The control object.
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
			 * @param {Object} data - The arguments.
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
			 * @param {Object} control - The control object.
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
			 * @param {Object} data - The arguments.
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
			 * @param {Object} control - The control object.
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
			 * @param {Object} data - The arguments.
			 * @returns {string}
			 */
			getTemplate: function( data ) {
				var html = '',
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
			 * @param {Object} control - The control object.
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
		},

		image: {

			/**
			 * Get the HTML for image inputs.
			 *
			 * @since 3.0.17
			 * @param {Object} data - The arguments.
			 * @returns {string}
			 */
			getTemplate: function( data ) {
				var html   = '',
				    saveAs = 'url',
				    url;

				data = _.defaults( data, {
					label: '',
					description: '',
					inputAttrs: '',
					'data-id': '',
					choices: {},
					value: ''
				} );

				if ( ! _.isUndefined( data.choices ) && ! _.isUndefined( data.choices.save_as ) ) {
					saveAs = data.choices.save_as;
				}
				url = data.value;
				if ( _.isObject( data.value ) && ! _.isUndefined( data.value.url ) ) {
					url = data.value.url;
				}

				html += '<label>';
				if ( data.label ) {
					html += '<span class="customize-control-title">' + data.label + '</span>';
				}
				if ( data.description ) {
					html += '<span class="description customize-control-description">' + data.description + '</span>';
				}
				html += '</label>';
				html += '<div class="image-wrapper attachment-media-view image-upload">';
				if ( data.value.url || '' !== url ) {
					html += '<div class="thumbnail thumbnail-image"><img src="' + url + '" alt="" /></div>';
				} else {
					html += '<div class="placeholder">' + kirkiL10n.noFileSelected + '</div>';
				}
				html += '<div class="actions">';
				html += '<button class="button image-upload-remove-button' + ( '' === url ? ' hidden' : '' ) + '">' + kirkiL10n.remove + '</button>';
				if ( data['default'] && '' !== data['default'] ) {
					html += '<button type="button" class="button image-default-button"';
					if ( data['default'] === data.value || ( ! _.isUndefined( data.value.url ) && data['default'] === data.value.url ) ) {
						html += ' style="display:none;"';
					}
					html += '>' + kirkiL10n['default'] + '</button>';
				}
				html += '<button type="button" class="button image-upload-button">' + kirkiL10n.selectFile + '</button>';
				html += '</div></div>';

				return '<div class="kirki-input-container" data-id="' + data.id + '">' + html + '</div>';
			},

			/**
			 * Init the control.
			 *
			 * @since 3.0.17
			 * @param {Object} control - The control object.
			 * @returns {void}
			 */
			init: function( control ) {
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
		 * @param {string} setting - The setting for which we're getting the value.
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
		 * @param {object|string} element - The DOM element whose value has changed,
		 *                                  or an ID.
		 * @param {mixed}         value - Depends on the control-type.
		 * @param {string}        key - If we only want to save an item in an object
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
	},

	/**
	 * A collection of utility methods.
	 *
	 * @since 3.0.17
	 */
	util: {

		/**
		 * A collection of utility methods for webfonts.
		 *
		 * @since 3.0.17
		 */
		webfonts: {

			/**
			 * Google-fonts related methods.
			 *
			 * @since 3.0.17
			 */
			google: {

				/**
				 * An object containing all Google fonts.
				 *
				 * to set this call this.setFonts();
				 *
				 * @since 3.0.17
				 */
				fonts: {},

				/**
				 * Init for google-fonts.
				 *
				 * @since 3.0.17
				 * @returns {void}
				 */
				initialize: function() {
					var self = this;

					self.setFonts();
				},

				/**
				 * Set fonts in this.fonts
				 *
				 * @since 3.0.17
				 * @returns {void}
				 */
				setFonts: function() {
					var self = this,
					    fonts;

					// No need to run if we already have the fonts.
					if ( ! _.isEmpty( self.fonts ) ) {
						return;
					}

					// Make an AJAX call to set the fonts object.
					jQuery.post( ajaxurl, { 'action': 'kirki_fonts_google_all_get' }, function( response ) {

						// Get fonts from the JSON array.
						fonts = JSON.parse( response );

						_.each( fonts.items, function( font ) {
							self.fonts[ font.family ] = font;
						} );
					} );
				},

				/**
				 * Gets all properties of a font-family.
				 *
				 * @since 3.0.17
				 * @param {string} family - The font-family we're interested in.
				 * @returns {Object}
				 */
				getFont: function( family ) {
					var self = this;

					return _.isUndefined( self.fonts[ family ] ) ? false : self.fonts[ family ];
				},

				/**
				 * Gets the variants for a font-family.
				 *
				 * @since 3.0.17
				 * @param {string} family - The font-family we're interested in.
				 * @returns {Object}
				 */
				getVariants: function( family ) {
					var self = this,
					    font = self.getFont( family );

					// Early exit if font was not found.
					if ( ! font ) {
						return false;
					}

					// Early exit if font doesn't have variants.
					if ( _.isUndefined( font.variants ) ) {
						return false;
					}

					// Return the variants.
					return font.variants;
				},

				/**
				 * Get the subsets for a font-family.
				 *
				 * @since 3.0.17
				 * @param {string} family - The font-family we're interested in.
				 * @returns {Object}
				 */
				getSubsets: function( family ) {
					var self = this,
					    font = self.getFont( family );

					// Early exit if font was not found.
					if ( ! font ) {
						return false;
					}

					// Early exit if font doesn't have subsets.
					if ( _.isUndefined( font.subsets ) ) {
						return false;
					}

					// Return the variants.
					return font.subsets;
				}
			}
		}
	}
};

// Initialize the kirki object.
kirki.initialize();
