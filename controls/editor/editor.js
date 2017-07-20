( function( api, $ ) {
	'use strict';

	/**
	 * A dynamic editor control.
	 *
	 * @class
	 * @augments wp.customize.Control
	 * @augments wp.customize.Class
	 */
	api.kirkiEditorControl = api.Control.extend({

		initialize: function( id, options ) {
			var control = this,
			    args    = options || {};

			args.params = args.params || {};
			if ( ! args.params.type ) {
				args.params.type = 'kirki-editor';
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

			var control      = this,
				element      = control.container.find( 'textarea' ),
				toggler      = control.container.find( '.toggle-editor' ),
				wpEditorArea = jQuery( '#kirki_editor_pane textarea.wp-editor-area' ),
				setChange,
				content;

			jQuery( window ).load( function() {

				var editor  = tinyMCE.get( 'kirki-editor' );

				// Add the button text
				toggler.html( editorKirkiL10n['open-editor'] );

				toggler.on( 'click', function() {

					// Toggle the editor.
					control.toggleEditor();

					// Change button.
					control.changeButton();

					// Add the content to the editor.
					control.setEditorContent( editor );

					// Modify the preview-area height.
					control.previewHeight();

				});

				// Update the option from the editor contents on change.
				if ( editor ) {

					editor.onChange.add( function( ed ) {

						ed.save();
						content = editor.getContent();
						clearTimeout( setChange );
						setChange = setTimeout( function() {
							element.val( content ).trigger( 'change' );
							wp.customize.instance( control.getEditorWrapperSetting() ).set( content );
						}, 500 );
					});
				}

				// Handle text mode.
				wpEditorArea.on( 'change keyup paste', function() {
					wp.customize.instance( control.getEditorWrapperSetting() ).set( jQuery( this ).val() );
				});
			});
		},

		/**
		 * Modify the button text and classes.
		 */
		changeButton: function() {

			var control = this;

			// Reset all editor buttons.
			// Necessary if we have multiple editor fields.
			jQuery( '.customize-control-kirki-editor .toggle-editor' ).html( editorKirkiL10n['switch-editor'] );

			// Change the button text & color.
			if ( false !== control.getEditorWrapperSetting() ) {
				jQuery( '.customize-control-kirki-editor .toggle-editor' ).html( editorKirkiL10n['switch-editor'] );
				jQuery( '#customize-control-' + control.getEditorWrapperSetting() + ' .toggle-editor' ).html( editorKirkiL10n['close-editor'] );
			} else {
				jQuery( '.customize-control-kirki-editor .toggle-editor' ).html( editorKirkiL10n['open-editor'] );
			}
		},

		/**
		 * Toggle the editor.
		 */
		toggleEditor: function() {

			var control = this,
				editorWrapper = jQuery( '#kirki_editor_pane' );

			if ( ! control.getEditorWrapperSetting() || control.id !== control.getEditorWrapperSetting() ) {
				editorWrapper.removeClass();
				editorWrapper.addClass( control.id );
			} else {
				editorWrapper.removeClass();
				editorWrapper.addClass( 'hide' );
			}
		},

		/**
		 * Set the content.
		 */
		setEditorContent: function( editor ) {

			var control = this;

			editor.setContent( control.setting._value );
		},

		/**
		 * Gets the setting from the editor wrapper class.
		 */
		getEditorWrapperSetting: function() {

			if ( jQuery( '#kirki_editor_pane' ).hasClass( 'hide' ) ) {
				return false;
			}

			if ( jQuery( '#kirki_editor_pane' ).attr( 'class' ) ) {
				return jQuery( '#kirki_editor_pane' ).attr( 'class' );
			} else {
				return false;
			}
		},

		/**
		 * Modifies the height of the preview area.
		 */
		previewHeight: function() {
			if ( jQuery( '#kirki_editor_pane' ).hasClass( 'hide' ) ) {
				if ( jQuery( '#customize-preview' ).hasClass( 'is-kirki-editor-open' ) ) {
					jQuery( '#customize-preview' ).removeClass( 'is-kirki-editor-open' );
				}
			} else {
				if ( ! jQuery( '#customize-preview' ).hasClass( 'is-kirki-editor-open' ) ) {
					jQuery( '#customize-preview' ).addClass( 'is-kirki-editor-open' );
				}
			}
		}
	});

	api.controlConstructor['kirki-editor'] = api.kirkiEditorControl;

})( wp.customize, jQuery );
