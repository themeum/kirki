wp.customize.controlConstructor['kirki-image'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		'use strict';

		var control = this,
		    section = control.section.get();

		jQuery( '#accordion-section-' + section ).on( 'click', function() {
			control.initKirkiControl();
		});

		if ( jQuery( '#sub-accordion-section-' + section ).hasClass( 'open' ) ) {
			control.initKirkiControl();
		}
	},

	initKirkiControl: function() {

		var control = this,
		    value   = control.getValue(),
		    saveAs  = ( ! _.isUndefined( control.params.choices ) && ! _.isUndefined( control.params.choices.save_as ) ) ? control.params.choices.save_as : 'url',
		    preview = control.container.find( '.placeholder, .thumbnail' ),
		    previewImage = ( 'array' === saveAs ) ? value.url : value;

		if ( '' !== previewImage ) {
			preview.removeClass().addClass( 'thumbnail thumbnail-image' ).html( '<img src="' + previewImage + '" alt="" />' );
		}

		control.container.on( 'click', '.image-upload-button', function( e ) {
			var image = wp.media({ multiple: false }).open().on( 'select', function() {

					// This will return the selected image from the Media Uploader, the result is an object.
					var uploadedImage = image.state().get( 'selection' ).first(),
					    previewImage   = uploadedImage.toJSON().sizes.full.url,
					    removeButton;

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

					removeButton = control.container.find( '.image-upload-remove-button' );

					if ( preview.length ) {
						preview.removeClass().addClass( 'thumbnail thumbnail-image' ).html( '<img src="' + previewImage + '" alt="" />' );
					}
					if ( removeButton.length ) {
						removeButton.show();
					}
			    });

			e.preventDefault();
		});

		control.container.on( 'click', '.image-upload-remove-button', function( e ) {

			var preview,
			    removeButton;

			e.preventDefault();

			control.saveValue( 'id', '' );
			control.saveValue( 'url', '' );
			control.saveValue( 'width', '' );
			control.saveValue( 'height', '' );

			preview      = control.container.find( '.placeholder, .thumbnail' );
			removeButton = control.container.find( '.image-upload-remove-button' );

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

		'use strict';

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

		'use strict';

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
