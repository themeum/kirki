( function( api, $ ) {
	'use strict';

	/**
	 * A dynamic background control.
	 *
	 * @class
	 * @augments wp.customize.Control
	 * @augments wp.customize.Class
	 */
	api.kirkiBackgroundControl = api.Control.extend({

		initialize: function( id, options ) {
			var control = this,
			    args    = options || {};

			args.params = args.params || {};
			if ( ! args.params.type ) {
				args.params.type = 'kirki-background';
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

			var control = this,
			    value   = control.getValue(),
			    picker  = control.container.find( '.kirki-color-control' );

			// Hide unnecessary controls if the value doesn't have an image.
			if ( _.isUndefined( value['background-image'] ) || '' === value['background-image'] ) {
				control.container.find( '.background-wrapper > .background-repeat' ).hide();
				control.container.find( '.background-wrapper > .background-position' ).hide();
				control.container.find( '.background-wrapper > .background-size' ).hide();
				control.container.find( '.background-wrapper > .background-attachment' ).hide();
			}

			// Color.
			picker.wpColorPicker({
				change: function() {
					setTimeout( function() {
						control.saveValue( 'background-color', picker.val() );
					}, 100 );
				}
			});

			// Background-Repeat.
			control.container.on( 'change', '.background-repeat select', function() {
				control.saveValue( 'background-repeat', jQuery( this ).val() );
			});

			// Background-Size.
			control.container.on( 'change click', '.background-size input', function() {
				control.saveValue( 'background-size', jQuery( this ).val() );
			});

			// Background-Position.
			control.container.on( 'change', '.background-position select', function() {
				control.saveValue( 'background-position', jQuery( this ).val() );
			});

			// Background-Attachment.
			control.container.on( 'change click', '.background-attachment input', function() {
				control.saveValue( 'background-attachment', jQuery( this ).val() );
			});

			// Background-Image.
			control.container.on( 'click', '.background-image-upload-button', function( e ) {
				var image = wp.media({ multiple: false }).open().on( 'select', function() {

						// This will return the selected image from the Media Uploader, the result is an object.
						var uploadedImage = image.state().get( 'selection' ).first(),
						    previewImage   = uploadedImage.toJSON().sizes.full.url,
						    imageUrl,
						    imageID,
						    imageWidth,
						    imageHeight,
						    preview,
						    removeButton;

						if ( ! _.isUndefined( uploadedImage.toJSON().sizes.medium ) ) {
							previewImage = uploadedImage.toJSON().sizes.medium.url;
						} else if ( ! _.isUndefined( uploadedImage.toJSON().sizes.thumbnail ) ) {
							previewImage = uploadedImage.toJSON().sizes.thumbnail.url;
						}

						imageUrl    = uploadedImage.toJSON().sizes.full.url;
						imageID     = uploadedImage.toJSON().id;
						imageWidth  = uploadedImage.toJSON().width;
						imageHeight = uploadedImage.toJSON().height;

						// Show extra controls if the value has an image.
						if ( '' !== imageUrl ) {
							control.container.find( '.background-wrapper > .background-repeat, .background-wrapper > .background-position, .background-wrapper > .background-size, .background-wrapper > .background-attachment' ).show();
						}

						control.saveValue( 'background-image', imageUrl );
						preview      = control.container.find( '.placeholder, .thumbnail' );
						removeButton = control.container.find( '.background-image-upload-remove-button' );

						if ( preview.length ) {
							preview.removeClass().addClass( 'thumbnail thumbnail-image' ).html( '<img src="' + previewImage + '" alt="" />' );
						}
						if ( removeButton.length ) {
							removeButton.show();
						}
				    });

				e.preventDefault();
			});

			control.container.on( 'click', '.background-image-upload-remove-button', function( e ) {

				var preview,
				    removeButton;

				e.preventDefault();

				control.saveValue( 'background-image', '' );

				preview      = control.container.find( '.placeholder, .thumbnail' );
				removeButton = control.container.find( '.background-image-upload-remove-button' );

				// Hide unnecessary controls.
				control.container.find( '.background-wrapper > .background-repeat' ).hide();
				control.container.find( '.background-wrapper > .background-position' ).hide();
				control.container.find( '.background-wrapper > .background-size' ).hide();
				control.container.find( '.background-wrapper > .background-attachment' ).hide();

				if ( preview.length ) {
					preview.removeClass().addClass( 'placeholder' ).html( 'No file selected' );
				}
				if ( removeButton.length ) {
					removeButton.hide();
				}
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
				if ( _.isUndefined( value[ param ] ) ) {
					value[ param ] = subValue;
				}
			});
			return value;
		},

		/**
		 * Saves the value.
		 */
		saveValue: function( property, value ) {

			var control   = this,
			    input     = jQuery( '#customize-control-' + control.id.replace( '[', '-' ).replace( ']', '' ) + ' .background-hidden-value' ),
			    valueJSON = jQuery( input ).val(),
			    valueObj  = JSON.parse( valueJSON );

			valueObj[ property ] = value;
			control.setting.set( valueObj );
			jQuery( input ).attr( 'value', JSON.stringify( valueObj ) ).trigger( 'change' );

		}
	});

	api.controlConstructor['kirki-background'] = api.kirkiBackgroundControl;

})( wp.customize, jQuery );
