( function( api, $ ) {
	'use strict';

	/**
	 * A dynamic dimensions control.
	 *
	 * @class
	 * @augments wp.customize.Control
	 * @augments wp.customize.Class
	 */
	api.kirkiDimensionsControl = api.Control.extend({

		initialize: function( id, options ) {
			var control = this,
			    args    = options || {};

			args.params = args.params || {};
			if ( ! args.params.type ) {
				args.params.type = 'kirki-dimensions';
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

			var control     = this,
				subControls = control.params.choices.controls,
				value       = {},
				subsArray   = [],
				i;

			_.each( subControls, function( v, i ) {
				if ( true === v ) {
					subsArray.push( i );
				}
			} );

			for ( i = 0; i < subsArray.length; i++ ) {
				value[ subsArray[ i ] ] = control.setting._value[ subsArray[ i ] ];
				control.updateDimensionsValue( subsArray[ i ], value );
			}
		},

		/**
		 * Updates the value.
		 */
		updateDimensionsValue: function( context, value ) {

			var control = this;

			control.container.on( 'change keyup paste', '.' + context + ' input', function() {
				value[ context ] = jQuery( this ).val();

				// Notifications.
				control.kirkiNotifications();

				// Save the value
				control.saveValue( value );
			});
		},

		/**
		 * Saves the value.
		 */
		saveValue: function( value ) {

			'use strict';

			var control  = this,
				newValue = {};

			_.each( value, function( newSubValue, i ) {
				newValue[ i ] = newSubValue;
			});

			control.setting.set( newValue );
		},

		/**
		 * Handles notifications.
		 */
		kirkiNotifications: function() {

			var control = this;

			wp.customize( control.id, function( setting ) {
				setting.bind( function( value ) {
					var code = 'long_title',
						subs = {},
						message;

					setting.notifications.remove( code );

					_.each( ['top', 'bottom', 'left', 'right'], function( direction ) {
						if ( ! _.isUndefined( value[ direction ] ) ) {
							if ( false === control.kirkiValidateCSSValue( value[ direction ] ) ) {
								subs[ direction ] = dimensionskirkiL10n[ direction ];
							} else {
								delete subs[ direction ];
							}
						}
					});

					if ( ! _.isEmpty( subs ) ) {
						message = dimensionskirkiL10n['invalid-value'] + ' (' + _.values( subs ).toString() + ') ';
						setting.notifications.add( code, new wp.customize.Notification(
							code,
							{
								type: 'warning',
								message: message
							}
						) );
					} else {
						setting.notifications.remove( code );
					}
				} );
			} );
		},

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
			if ( isNaN( numericValue ) || -1 === jQuery.inArray( unit, validUnits ) ) {
				return false;
			}
			return true;
		}
	});

	api.controlConstructor['kirki-dimensions'] = api.kirkiDimensionsControl;

})( wp.customize, jQuery );
