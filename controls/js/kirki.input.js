var kirki = kirki || {};
kirki.input = {

	textarea: {

		/**
		 * Get the template for a <textarea> element.
		 *
		 * @since 3.1.0
		 * @param {object} [args] The arguments for the input element.
		 * @returns {string}      The HTML for the input element.
		 */
		template: function( args ) {
			args = _.defaults( args, {
				id: '',
				value: '',
				inputAttrs: ''
			} );
			return '<textarea data-id="' + args.id + '"' + args.inputAttrs + '>' + args.value + '</textarea>';
		}
	},

	select: {

		/**
		 * Get the template for a <select> element.
		 *
		 * @since 3.1.0
		 * @param {object} [args] The arguments for the input element.
		 * @returns {string}      The HTML for the input element.
		 */
		template: function( args ) {
			var html = '';

			args = _.defaults( args, {
				multiple: 1,
				inputAttrs: '',
				choices: {}
			} );
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
			return html;
		},

		/**
		 * Init for select2 input fields.
		 *
		 * @since 3.1.0
		 * @param {object} [args] The arguments for the input element.
		 * @returns {void}
		 */
		init: function( args ) {
			var id      = args.id || '',
				element = 'select[data-id=' + id + ']';

			args.multiple = args.multiple || 1;
			args.multiple = parseInt( args.multiple, 10 );

			// Init select2 for this element.
			jQuery( element ).select2( {
				escapeMarkup: function( markup ) {
					return markup;
				},
				maximumSelectionLength: args.multiple
			} ).on( 'change', function() {
				kirki.setting.set( this, jQuery( this ).val() );
			} );
		}
	},

	radio: {

		/**
		 * Get the template for a <radio> element.
		 *
		 * @since 3.1.0
		 * @param {object} [args] The arguments for the input element.
		 * @returns {string}      The HTML for the input element.
		 */
		template: function( args ) {
			var html = '';

			args = _.defaults( args, {
				id: '',
				choices: {},
				inputAttrs: '',
				value: ''
			} );

			_.each( args.choices, function( value, key ) {
				html += '<label>';
					html += '<input data-id="' + args.id + '" ' + args.inputAttrs + ' type="radio" value="' + key + '" name="' + args.id + '" ' + ( args.value === key ? ' checked' : '' ) + '/>';
					html += ( _.isArray( value ) ) ? args.value[0] + '<span class="option-description">' + args.value[1] + '</span>' : value;
				html += '</label>';
			} );
			return html;

		},

		/**
		 * Init for radio input.
		 *
		 * @since 3.1.0
		 * @param {object} [args] The arguments.
		 * @returns {void}
		 */
		init: function( args ) {
			jQuery( 'input[data-id=' + args.id + ']' ).on( 'change click', function( event ) {
				var value = jQuery( 'input[data-id=' + args.id + ']:checked' ).val();
				kirki.setting.set( event.target, value );
			} );
		}
	},

	color: {

		/**
		 * Get the template for a <color> element.
		 *
		 * @since 3.1.0
		 * @param {object} [args] The arguments for the input element.
		 * @returns {string}      The HTML for the input element.
		 */
		template: function( args ) {
			args = _.defaults( args, {
				inputAttrs: '',
				'data-palette': args.palette || '',
				'data-default-color': args['default'] || '',
				'data-alpha': args.arpha || true,
				value: '',
				'class': 'kirki-color-control'
			} );
			args.type = 'text';

			return kirki.input.generic.template( args );
		},

		/**
		 * Init for color inputs.
		 *
		 * @since 3.1.0
		 * @param {object} [args] The arguments for the input element.
		 * @returns {void}
		 */
		init: function( args ) {
			var id      = args.id || '',
				element = '.kirki-color-control[data-id=' + id + ']';

			// If we have defined any extra choices, make sure they are passed-on to Iris.
			if ( ! _.isUndefined( args.choices ) ) {
				jQuery( element ).wpColorPicker( args.choices );
			}

			// Tweaks to make the "clear" buttons work.
			// TODO
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
		}
	},

	checkbox: {

		/**
		 * Get the template for a <checkbox> element.
		 *
		 * @since 3.1.0
		 * @param {object} [args] The arguments for the input element.
		 * @returns {string}      The HTML for the input element.
		 */
		template: function( args ) {
			args = _.defaults( args, {
				id: '',
				inputAttrs: '',
				value: ''
			} );
			return '<input data-id="' + args.id + '" type="checkbox" ' + args.inputAttrs + 'value="' + args.value + '" ' + ( true === args.value ? ' checked' : '' ) + '/>';
		}
	},

	generic: {

		/**
		 * Get the template for a generic input element.
		 *
		 * @since 3.1.0
		 * @param {object} [args] The arguments for the input element.
		 * @returns {string}      The HTML for the input element.
		 */
		template: function( args ) {
			var html = '';

			args = _.defaults( args, {
				element: 'input',
				id: '',
				value: '',
				inputAttrs: '',
				choices: {},
				type: 'text'
			} );

			args.choices.content = args.choices.content || '';

			// Delete blacklisted.
			delete args.content;
			delete args.description;
			delete args.instanceNumber;
			delete args.label;
			delete args.link;
			delete args.output;
			delete args.priority;
			delete args.section;
			delete args.settings;
			delete args.ajaxurl;

			html += '<' + args.element;
			_.each( args, function( val, key ) {
				if ( 'link' === key || 'inputattrs' === key || 'element' === key ) {
					return;
				}
				if ( _.isString( val ) ) {
					key = ( 'id' === key ) ? 'data-id' : key;
					html += ' ' + key + '="' + val + '"';
				}
			} );
			_.each( args.choices, function( value, key ) {
				html += ' ' + key + '="' + value + '"';
			} );
			html += ( '' !== args.choices.content ) ? '>' + args.choices.content + '</' + args.element + '>' : '/>';
			return html;
		},

		/**
		 * Init for radio input.
		 *
		 * @since 3.1.0
		 * @param {object} [args] The arguments.
		 * @returns {void}
		 */
		init: function( args ) {
			jQuery( 'input[data-id=' + args.id + ']' ).on( 'change keyup paste', function( event ) {
				var value = jQuery( 'input[data-id=' + args.id + ']' ).val();
				kirki.setting.set( jQuery( this ), jQuery );
			} );
		}
	}
};
