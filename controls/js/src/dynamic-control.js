/* global kirki */
/**
 * The majority of the code in this file
 * is derived from the wp-customize-posts plugin
 * and the work of @westonruter to whom I am very grateful.
 *
 * @see https://github.com/xwp/wp-customize-posts
 */

( function() {
	'use strict';

	/**
	 * A dynamic color-alpha control.
	 *
	 * @class
	 * @augments wp.customize.Control
	 * @augments wp.customize.Class
	 */
	wp.customize.kirkiDynamicControl = wp.customize.Control.extend( {

		initialize: function( id, options ) {
			var control = this,
				args    = options || {};

			args.params = args.params || {};
			if ( ! args.params.type ) {
				args.params.type = 'kirki-generic';
			}
			if ( ! args.params.content ) {
				args.params.content = jQuery( '<li></li>' );
				args.params.content.attr( 'id', 'customize-control-' + id.replace( /]/g, '' ).replace( /\[/g, '-' ) );
				args.params.content.attr( 'class', 'customize-control customize-control-' + args.params.type );
			}

			control.propertyElements = [];
			wp.customize.Control.prototype.initialize.call( control, id, args );
		},

		/**
		 * Add bidirectional data binding links between inputs and the setting(s).
		 *
		 * This is copied from wp.customize.Control.prototype.initialize(). It
		 * should be changed in Core to be applied once the control is embedded.
		 *
		 * @private
		 * @returns {null}
		 */
		_setUpSettingRootLinks: function() {
			var control = this,
				nodes   = control.container.find( '[data-customize-setting-link]' );

			nodes.each( function() {
				var node = jQuery( this );

				wp.customize( node.data( 'customizeSettingLink' ), function( setting ) {
					var element = new wp.customize.Element( node );
					control.elements.push( element );
					element.sync( setting );
					element.set( setting() );
				} );
			} );
		},

		/**
		 * Add bidirectional data binding links between inputs and the setting properties.
		 *
		 * @private
		 * @returns {null}
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
					element,
					propertyName = node.data( 'customizeSettingPropertyLink' );

				element = new wp.customize.Element( node );
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
			} );
		},

		/**
		 * @inheritdoc
		 */
		ready: function() {
			var control = this;

			control._setUpSettingRootLinks();
			control._setUpSettingPropertyLinks();

			wp.customize.Control.prototype.ready.call( control );

			control.deferred.embedded.done( function() {
				control.initKirkiControl( control );
			} );
		},

		/**
		 * Embed the control in the document.
		 *
		 * Override the embed() method to do nothing,
		 * so that the control isn't embedded on load,
		 * unless the containing section is already expanded.
		 *
		 * @returns {null}
		 */
		embed: function() {
			var control   = this,
				sectionId = control.section();

			if ( ! sectionId ) {
				return;
			}

			wp.customize.section( sectionId, function( section ) {
				if ( 'kirki-expanded' === section.params.type || section.expanded() || wp.customize.settings.autofocus.control === control.id ) {
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
		 * @returns {null}
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
		 * @returns {null}
		 */
		focus: function( args ) {
			var control = this;
			control.actuallyEmbed();
			wp.customize.Control.prototype.focus.call( control, args );
		},

		/**
		 * Additional actions that run on ready.
		 *
		 * @param {object} [args] Args.
		 * @returns {null}
		 */
		initKirkiControl: function( control ) {
			if ( 'undefined' !== typeof kirki.control[ control.params.type ] ) {
				kirki.control[ control.params.type ].init( control );
				return;
			}

			// Save the value
			this.container.on( 'change keyup paste click', 'input', function() {
				control.setting.set( jQuery( this ).val() );
			} );
		}
	} );
}() );
_.each( kirki.control, function( obj, type ) {
	wp.customize.controlConstructor[ type ] = wp.customize.kirkiDynamicControl.extend( {} );
} );
