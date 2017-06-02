wp.customize.controlConstructor['kirki-image-array'] = wp.customize.Control.extend({

	ready: function() {

		var control = this,
		    value   = control.getValue();

		control.container.on( 'click', '.image-array-image-upload-button', function( e ) {
			var image = wp.media({ multiple: false }).open().on( 'select', function() {

					// This will return the selected image from the Media Uploader, the result is an object.
					var uploadedImage = image.state().get( 'selection' ).first(),
					    previewImage   = uploadedImage.toJSON().sizes.full.url,
					    preview,
					    removeButton;

					if ( ! _.isUndefined( uploadedImage.toJSON().sizes.medium ) ) {
						previewImage = uploadedImage.toJSON().sizes.medium.url;
					} else if ( ! _.isUndefined( uploadedImage.toJSON().sizes.thumbnail ) ) {
						previewImage = uploadedImage.toJSON().sizes.thumbnail.url;
					}

					control.saveValue( 'id', uploadedImage.toJSON().id );
					control.saveValue( 'url', uploadedImage.toJSON().sizes.full.url );
					control.saveValue( 'width', uploadedImage.toJSON().width );
					control.saveValue( 'height', uploadedImage.toJSON().height );

					preview      = control.container.find( '.placeholder, .thumbnail' );
					removeButton = control.container.find( '.image-array-image-upload-remove-button' );

					if ( preview.length ) {
						preview.removeClass().addClass( 'thumbnail thumbnail-image' ).html( '<img src="' + previewImage + '" alt="" />' );
					}
					if ( removeButton.length ) {
						removeButton.show();
					}
			    });

			e.preventDefault();
		});

		control.container.on( 'click', '.image-array-image-upload-remove-button', function( e ) {

			var preview,
			    removeButton;

			e.preventDefault();

			control.saveValue( 'id', '' );
			control.saveValue( 'url', '' );
			control.saveValue( 'width', '' );
			control.saveValue( 'height', '' );

			preview      = control.container.find( '.placeholder, .thumbnail' );
			removeButton = control.container.find( '.image-array-image-upload-remove-button' );

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

		var control   = this,
		    input     = control.container.find( '.image-array-hidden-value' ),
		    valueJSON = jQuery( input ).val();

		return JSON.parse( valueJSON );
	},

	/**
	 * Saves the value.
	 */
	saveValue: function( property, value ) {

		'use strict';

		var control   = this,
		    input     = jQuery( '#customize-control-' + control.id.replace( '[', '-' ).replace( ']', '' ) + ' .image-array-hidden-value' ),
		    valueJSON = jQuery( input ).val(),
		    valueObj  = JSON.parse( valueJSON );

		valueObj[ property ] = value;
		control.setting.set( valueObj );
		jQuery( input ).attr( 'value', JSON.stringify( valueObj ) ).trigger( 'change' );

	}

});
