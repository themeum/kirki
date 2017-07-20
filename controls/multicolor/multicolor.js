( function( api, $ ) {
	'use strict';

	/**
	 * A dynamic multicolor control.
	 *
	 * @class
	 * @augments wp.customize.Control
	 * @augments wp.customize.Class
	 */
	api.kirkiMulticolorControl = api.Control.extend({

		initialize: function( id, options ) {
			var control = this,
			    args    = options || {};

			args.params = args.params || {};
			if ( ! args.params.type ) {
				args.params.type = 'kirki-multicolor';
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

			var control = this,
			    colors  = control.params.choices,
			    keys    = Object.keys( colors ),
			    value   = this.params.value,
			    target  = control.container.find( '.iris-target' ),
			    i       = 0,
			    irisInput,
			    irisPicker;

			// Proxy function that handles changing the individual colors
			function kirkiMulticolorChangeHandler( control, value, subSetting ) {

				var picker = control.container.find( '.multicolor-index-' + subSetting ),
				    args   = {
						target: target[0],
						change: function() {

							// Color controls require a small delay.
							setTimeout( function() {

								// Set the value.
								control.saveValue( subSetting, picker.val() );

								// Trigger the change.
								control.container.find( '.multicolor-index-' + subSetting ).trigger( 'change' );
							}, 100 );
						}
					};

				if ( _.isObject( colors.irisArgs ) ) {
					_.each( colors.irisArgs, function( irisValue, irisKey ) {
						args[ irisKey ] = irisValue;
					});
				}

				// Did we change the value?
				picker.wpColorPicker( args );
			}

			// Colors loop
			while ( i < Object.keys( colors ).length ) {

				kirkiMulticolorChangeHandler( this, value, keys[ i ] );

				// Move colorpicker to the 'iris-target' container div
				irisInput  = control.container.find( '.wp-picker-container .wp-picker-input-wrap' ),
				irisPicker = control.container.find( '.wp-picker-container .wp-picker-holder' );
				jQuery( irisInput[0] ).detach().appendTo( target[0] );
				jQuery( irisPicker[0] ).detach().appendTo( target[0] );

				i++;

			}
		},

		/**
		 * Saves the value.
		 */
		saveValue: function( property, value ) {

			'use strict';

			var control   = this,
			    input     = control.container.find( '.multicolor-hidden-value' ),
			    valueJSON = jQuery( input ).val(),
			    valueObj  = JSON.parse( valueJSON );

			valueObj[ property ] = value;
			jQuery( input ).attr( 'value', JSON.stringify( valueObj ) ).trigger( 'change' );
			control.setting.set( valueObj );
		}
	});

	api.controlConstructor['kirki-multicolor'] = api.kirkiMulticolorControl;

})( wp.customize, jQuery );
