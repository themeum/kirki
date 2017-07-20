( function( api, $ ) {
	'use strict';

	/**
	 * A dynamic image control.
	 *
	 * @class
	 * @augments wp.customize.Control
	 * @augments wp.customize.Class
	 */
	api.kirkiImageControl = api.Control.extend({

		initialize: function( id, options ) {
			var control = this,
			    args    = options || {};

			args.params = args.params || {};
			if ( ! args.params.type ) {
				args.params.type = 'kirki-image';
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

			var control       = this,
			    value         = control.getValue(),
			    saveAs        = ( ! _.isUndefined( control.params.choices ) && ! _.isUndefined( control.params.choices.save_as ) ) ? control.params.choices.save_as : 'url',
			    preview       = control.container.find( '.placeholder, .thumbnail' ),
			    previewImage  = ( 'array' === saveAs ) ? value.url : value,
			    removeButton  = control.container.find( '.image-upload-remove-button' ),
			    defaultButton = control.container.find( '.image-default-button' );

			// If value is not empty, hide the "default" button.
			if ( ( 'url' === saveAs && '' !== value ) || ( 'array' === saveAs && ! _.isUndefined( value.url ) && '' !== value.url ) ) {
				control.container.find( 'image-default-button' ).hide();
			}

			// If value is empty, hide the "remove" button.
			if ( ( 'url' === saveAs && '' === value ) || ( 'array' === saveAs && ( _.isUndefined( value.url ) || '' === value.url ) ) ) {
				removeButton.hide();
			}

			// If value is default, hide the default button.
			if ( value === control.params['default'] ) {
				control.container.find( 'image-default-button' ).hide();
			}

			if ( '' !== previewImage ) {
				preview.removeClass().addClass( 'thumbnail thumbnail-image' ).html( '<img src="' + previewImage + '" alt="" />' );
			}

			control.container.on( 'click', '.image-upload-button', function( e ) {
				var image = wp.media({ multiple: false }).open().on( 'select', function() {

						// This will return the selected image from the Media Uploader, the result is an object.
						var uploadedImage = image.state().get( 'selection' ).first(),
						    previewImage  = uploadedImage.toJSON().sizes.full.url;

						if ( ! _.isUndefined( uploadedImage.toJSON().sizes.medium ) ) {
							previewImage = uploadedImage.toJSON().sizes.medium.url;
						} else if ( ! _.isUndefined( uploadedImage.toJSON().sizes.thumbnail ) ) {
							previewImage = uploadedImage.toJSON().sizes.thumbnail.url;
						}

						if ( 'array' === saveAs ) {
							control.saveValue( 'id', uploadedImage.toJSON().id );
							control.saveValue( 'url', uploadedImage.toJSON().sizes.full.url );
							control.saveValue( 'width', uploadedImage.toJSON().width );
							control.saveValue( 'height', uploadedImage.toJSON().height );
						} else if ( 'id' === saveAs ) {
							control.saveValue( 'id', uploadedImage.toJSON().id );
						} else {
							control.saveValue( 'url', uploadedImage.toJSON().sizes.full.url );
						}

						if ( preview.length ) {
							preview.removeClass().addClass( 'thumbnail thumbnail-image' ).html( '<img src="' + previewImage + '" alt="" />' );
						}
						if ( removeButton.length ) {
							removeButton.show();
							defaultButton.hide();
						}
				    });

				e.preventDefault();
			});

			control.container.on( 'click', '.image-upload-remove-button', function( e ) {

				var preview,
				    removeButton,
				    defaultButton;

				e.preventDefault();

				control.saveValue( 'id', '' );
				control.saveValue( 'url', '' );
				control.saveValue( 'width', '' );
				control.saveValue( 'height', '' );

				preview       = control.container.find( '.placeholder, .thumbnail' );
				removeButton  = control.container.find( '.image-upload-remove-button' );
				defaultButton = control.container.find( '.image-default-button' );

				if ( preview.length ) {
					preview.removeClass().addClass( 'placeholder' ).html( 'No file selected' );
				}
				if ( removeButton.length ) {
					removeButton.hide();
					if ( jQuery( defaultButton ).hasClass( 'button' ) ) {
						defaultButton.show();
					}
				}
			});

			control.container.on( 'click', '.image-default-button', function( e ) {

				var preview,
					removeButton,
					defaultButton;

				e.preventDefault();

				control.saveValue( 'url', control.params['default'] );

				preview       = control.container.find( '.placeholder, .thumbnail' );
				removeButton  = control.container.find( '.image-upload-remove-button' );
				defaultButton = control.container.find( '.image-default-button' );

				if ( preview.length ) {
					preview.removeClass().addClass( 'thumbnail thumbnail-image' ).html( '<img src="' + control.params['default'] + '" alt="" />' );
				}
				if ( removeButton.length ) {
					removeButton.show();
					defaultButton.hide();
				}
			});
		},

		/**
		 * Gets the value.
		 */
		getValue: function() {

			var control = this,
			    input   = control.container.find( '.image-hidden-value' ),
			    value   = jQuery( input ).val(),
			    saveAs  = ( ! _.isUndefined( control.params.choices ) && ! _.isUndefined( control.params.choices.save_as ) ) ? control.params.choices.save_as : 'url';

			if ( 'array' === saveAs ) {
				return JSON.parse( value );
			}
			return value;
		},

		/**
		 * Saves the value.
		 */
		saveValue: function( property, value ) {

			var control   = this,
			    input     = jQuery( '#customize-control-' + control.id.replace( '[', '-' ).replace( ']', '' ) + ' .image-hidden-value' ),
			    valueJSON = jQuery( input ).val(),
			    saveAs    = ( ! _.isUndefined( control.params.choices ) && ! _.isUndefined( control.params.choices.save_as ) ) ? control.params.choices.save_as : 'url',
			    valueObj  = 'array' === saveAs ? JSON.parse( valueJSON ) : {};

			if ( 'array' === saveAs ) {
				valueObj[ property ] = value;
				control.setting.set( valueObj );
				jQuery( input ).attr( 'value', JSON.stringify( valueObj ) ).trigger( 'change' );
			} else {
				control.setting.set( value );
				jQuery( input ).attr( 'value', value ).trigger( 'change' );
			}
		}
	});

	api.controlConstructor['kirki-image'] = api.kirkiImageControl;

})( wp.customize, jQuery );
