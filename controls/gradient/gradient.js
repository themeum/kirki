( function( api, $ ) {
	'use strict';

	/**
	 * A dynamic gradient control.
	 *
	 * @class
	 * @augments wp.customize.Control
	 * @augments wp.customize.Class
	 */
	api.kirkiGradientControl = api.Control.extend({

		initialize: function( id, options ) {
			var control = this,
			    args    = options || {};

			args.params = args.params || {};
			if ( ! args.params.type ) {
				args.params.type = 'kirki-gradient';
			}
			if ( ! args.params.content ) {
				args.params.content = jQuery( '<li></li>' );
				args.params.content.attr( 'id', 'customize-control-' + id.replace( /]/g, '' ).replace( /\[/g, '-' ) );
				args.params.content.attr( 'class', 'customize-control customize-control-' + args.params.type );
			}

			control.propertyElements = [];
			api.Control.prototype.initialize.call( control, id, args );
		},

		/**
		 * Add bidirectional data binding links between inputs and the setting(s).
		 *
		 * This is copied from wp.customize.Control.prototype.initialize(). It
		 * should be changed in Core to be applied once the control is embedded.
		 *
		 * @private
		 * @returns {void}
		 */
		_setUpSettingRootLinks: function() {
			var control = this,
			    nodes   = control.container.find( '[data-customize-setting-link]' );

			nodes.each( function() {
				var node = jQuery( this ),
				    name;

				api( node.data( 'customizeSettingLink' ), function( setting ) {
					var element = new api.Element( node );
					control.elements.push( element );
					element.sync( setting );
					element.set( setting() );
				});
			});
		},

		/**
		 * Add bidirectional data binding links between inputs and the setting properties.
		 *
		 * @private
		 * @returns {void}
		 */
		_setUpSettingPropertyLinks: function() {
			var control = this,
			    nodes;

			if ( ! control.setting ) {
				return;
			}

			nodes = control.container.find( '[data-customize-setting-property-link]' );

			nodes.each( function() {
				var node = jQuery( this ),
				    name,
				    element,
				    propertyName = node.data( 'customizeSettingPropertyLink' );

				element = new api.Element( node );
				control.propertyElements.push( element );
				element.set( control.setting()[ propertyName ] );

				element.bind( function( newPropertyValue ) {
					var newSetting = control.setting();
					if ( newPropertyValue === newSetting[ propertyName ] ) {
						return;
					}
					newSetting = _.clone( newSetting );
					newSetting[ propertyName ] = newPropertyValue;
					control.setting.set( newSetting );
				} );
				control.setting.bind( function( newValue ) {
					if ( newValue[ propertyName ] !== element.get() ) {
						element.set( newValue[ propertyName ] );
					}
				} );
			});
		},

		/**
		 * @inheritdoc
		 */
		ready: function() {
			var control = this;

			control._setUpSettingRootLinks();
			control._setUpSettingPropertyLinks();

			api.Control.prototype.ready.call( control );

			control.deferred.embedded.done( function() {
				control.initKirkiControl();
			});
		},

		/**
		 * Embed the control in the document.
		 *
		 * Override the embed() method to do nothing,
		 * so that the control isn't embedded on load,
		 * unless the containing section is already expanded.
		 *
		 * @returns {void}
		 */
		embed: function() {
			var control   = this,
			    sectionId = control.section();

			if ( ! sectionId ) {
				return;
			}

			api.section( sectionId, function( section ) {
				if ( section.expanded() || api.settings.autofocus.control === control.id ) {
					control.actuallyEmbed();
				} else {
					section.expanded.bind( function( expanded ) {
						if ( expanded ) {
							control.actuallyEmbed();
						}
					} );
				}
			} );
		},

		/**
		 * Deferred embedding of control when actually
		 *
		 * This function is called in Section.onChangeExpanded() so the control
		 * will only get embedded when the Section is first expanded.
		 *
		 * @returns {void}
		 */
		actuallyEmbed: function() {
			var control = this;
			if ( 'resolved' === control.deferred.embedded.state() ) {
				return;
			}
			control.renderContent();
			control.deferred.embedded.resolve(); // This triggers control.ready().
		},

		/**
		 * This is not working with autofocus.
		 *
		 * @param {object} [args] Args.
		 * @returns {void}
		 */
		focus: function( args ) {
			var control = this;
			control.actuallyEmbed();
			api.Control.prototype.focus.call( control, args );
		},

		initKirkiControl: function() {

			'use strict';

			var control      = this,
			    value        = control.getValue(),
			    pickerStart  = control.container.find( '.kirki-gradient-control-start' ),
			    pickerEnd    = control.container.find( '.kirki-gradient-control-end' ),
			    angleElement = jQuery( '.angle.gradient-' + control.id ),
			    throttledAngleChange,
			    throttledPositionStartChange,
			    throttledPositionEndChange,
			    startPositionElement = jQuery( '.position.gradient-' + control.id + '-start' ),
			    endPositionElement   = jQuery( '.position.gradient-' + control.id + '-end' );

			// If we have defined any extra choices, make sure they are passed-on to Iris.
			if ( ! _.isUndefined( control.params.choices.iris ) ) {
				pickerStart.wpColorPicker( control.params.choices.iris );
				pickerEnd.wpColorPicker( control.params.choices.iris );
			}

			control.updatePreview( value );

			_.each( { 'start': pickerStart, 'end': pickerEnd }, function( obj, index ) {

				// Saves our settings to the WP API
				obj.wpColorPicker({
					change: function() {
						setTimeout( function() {

							// Add the value to the object.
							value[ index ].color = obj.val();

							// Update the preview.
							control.updatePreview( value );

							// Set the value.
							control.setValue( value );

						}, 100 );
					}
				});
			});

			jQuery( control.container.find( '.global .angle' ) ).show();
			if ( ! _.isUndefined( value.mode && 'radial' === value.mode ) ) {
				jQuery( control.container.find( '.global .angle' ) ).hide();
			}

			// Mode (linear/radial).
			jQuery( control.container.find( '.mode .switch-input' ) ).on( 'click input', function() {
				value.mode = jQuery( this ).val();
				control.updatePreview( value );
				control.setValue( value );
				jQuery( control.container.find( '.global .angle' ) ).show();
				if ( 'radial' === value.mode ) {
					jQuery( control.container.find( '.global .angle' ) ).hide();
				}
			});

			// Angle (-90° -to 90°).
			throttledAngleChange = _.throttle( function() {
				value.angle = angleElement.val();

				// Update the preview.
				control.updatePreview( value );

				// Set the value.
				control.setValue( value );
			}, 20 );
			angleElement.on( 'input change oninput', function() {
				throttledAngleChange();
			});

			// Start Position( 0% - 100%);
			throttledPositionStartChange = _.throttle( function() {
				value.start.position = startPositionElement.val();

				// Update the preview.
				control.updatePreview( value );

				// Set the value.
				control.setValue( value );
			}, 20 );
			startPositionElement.on( 'input change oninput', function() {
				throttledPositionStartChange();
			});

			// End Position( 0% - 100%);
			throttledPositionEndChange = _.throttle( function() {
				value.end.position = endPositionElement.val();

				// Update the preview.
				control.updatePreview( value );

				// Set the value.
				control.setValue( value );
			}, 20 );
			endPositionElement.on( 'input change oninput', function() {
				throttledPositionEndChange();
			});
		},

		/**
		 * Gets the value.
		 */
		getValue: function() {

			var control = this,
				value   = {};

			// Make sure everything we're going to need exists.
			_.each( control.params['default'], function( defaultParamValue, param ) {
				if ( false !== defaultParamValue ) {
					value[ param ] = defaultParamValue;
					if ( ! _.isUndefined( control.setting._value[ param ] ) ) {
						value[ param ] = control.setting._value[ param ];
					}
				}
			});
			_.each( control.setting._value, function( subValue, param ) {
				if ( ! _.isUndefined( value[ param ] ) ) {
					value[ param ] = subValue;
				}
			});
			return value;
		},

		/**
		 * Updates the preview area.
		 */
		updatePreview: function( value ) {
			var control     = this,
			    previewArea = control.container.find( '.gradient-preview' );

			if ( ! _.isUndefined( value.mode ) && 'radial' === value.mode ) {
				jQuery( previewArea ).css(
					'background',
					'radial-gradient(ellipse at center, ' + value.start.color + ' ' + value.start.position + '%,' + value.end.color + ' ' + value.end.position + '%)'
				);
			} else {
				jQuery( previewArea ).css(
					'background',
					'linear-gradient(' + value.angle + 'deg, ' + value.start.color + ' ' + value.start.position + '%,' + value.end.color + ' ' + value.end.position + '%)'
				);
			}
		},

		/**
		 * Saves the value.
		 */
		setValue: function( value ) {

			var control = this;

			wp.customize( control.id, function( obj ) {

				// Reset the setting value, so that the change is triggered
				obj.set( '' );

				// Set the right value
				obj.set( value );

			});
		}
	});

	api.controlConstructor['kirki-gradient'] = api.kirkiGradientControl;

})( wp.customize, jQuery );
