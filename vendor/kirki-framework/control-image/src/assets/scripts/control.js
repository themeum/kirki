/* global kirkiL10n */
var kirki = kirki || {};
kirki.input = kirki.input || {};

kirki.input.image = {

    /**
     * Init the control.
     *
     * @since 3.0.34
     * @param {Object} control - The control object.
     * @returns {null}
     */
    init: function( control ) {
        var value         = kirki.setting.get( control.id ),
            saveAs        = ( ! _.isUndefined( control.params.choices ) && ! _.isUndefined( control.params.choices.save_as ) ) ? control.params.choices.save_as : 'url',
            preview       = control.container.find( '.placeholder, .thumbnail' ),
            previewImage  = ( 'array' === saveAs ) ? value.url : value,
            removeButton  = control.container.find( '.image-upload-remove-button' ),
            defaultButton = control.container.find( '.image-default-button' );

        // Make sure value is properly formatted.
        value = ( 'array' === saveAs && _.isString( value ) ) ? { url: value } : value;

        // Tweaks for save_as = id.
        if ( ( 'id' === saveAs || 'ID' === saveAs ) && '' !== value ) {
            wp.media.attachment( value ).fetch().then( function() {
                setTimeout( function() {
                    var url = wp.media.attachment( value ).get( 'url' );
                    preview.removeClass().addClass( 'thumbnail thumbnail-image' ).html( '<img src="' + url + '" alt="" />' );
                }, 700 );
            } );
        }

        // If value is not empty, hide the "default" button.
        if ( ( 'url' === saveAs && '' !== value ) || ( 'array' === saveAs && ! _.isUndefined( value.url ) && '' !== value.url ) ) {
            control.container.find( 'image-default-button' ).hide();
        }

        // If value is empty, hide the "remove" button.
        if ( ( 'url' === saveAs && '' === value ) || ( 'array' === saveAs && ( _.isUndefined( value.url ) || '' === value.url ) ) ) {
            removeButton.hide();
        }

        // If value is default, hide the default button.
        if ( value === control.params.default ) {
            control.container.find( 'image-default-button' ).hide();
        }

        if ( '' !== previewImage ) {
            preview.removeClass().addClass( 'thumbnail thumbnail-image' ).html( '<img src="' + previewImage + '" alt="" />' );
        }

        control.container.on( 'click', '.image-upload-button', function( e ) {
            var image = wp.media( { multiple: false } ).open().on( 'select', function() {

                // This will return the selected image from the Media Uploader, the result is an object.
                var uploadedImage = image.state().get( 'selection' ).first(),
                    jsonImg       = uploadedImage.toJSON(),
                    previewImage  = jsonImg.url;

                if ( ! _.isUndefined( jsonImg.sizes ) ) {
                    previewImage = jsonImg.sizes.full.url;
                    if ( ! _.isUndefined( jsonImg.sizes.medium ) ) {
                        previewImage = jsonImg.sizes.medium.url;
                    } else if ( ! _.isUndefined( jsonImg.sizes.thumbnail ) ) {
                        previewImage = jsonImg.sizes.thumbnail.url;
                    }
                }

                if ( 'array' === saveAs ) {
                    kirki.setting.set( control.id, {
                        id: jsonImg.id,
                        url: jsonImg.sizes.full.url,
                        width: jsonImg.width,
                        height: jsonImg.height
                    } );
                } else if ( 'id' === saveAs ) {
                    kirki.setting.set( control.id, jsonImg.id );
                } else {
                    kirki.setting.set( control.id, ( ( ! _.isUndefined( jsonImg.sizes ) ) ? jsonImg.sizes.full.url : jsonImg.url ) );
                }

                if ( preview.length ) {
                    preview.removeClass().addClass( 'thumbnail thumbnail-image' ).html( '<img src="' + previewImage + '" alt="" />' );
                }
                if ( removeButton.length ) {
                    removeButton.show();
                    defaultButton.hide();
                }
            } );

            e.preventDefault();
        } );

        control.container.on( 'click', '.image-upload-remove-button', function( e ) {

            var preview,
                removeButton,
                defaultButton;

            e.preventDefault();

            kirki.setting.set( control.id, '' );

            preview       = control.container.find( '.placeholder, .thumbnail' );
            removeButton  = control.container.find( '.image-upload-remove-button' );
            defaultButton = control.container.find( '.image-default-button' );

            if ( preview.length ) {
                preview.removeClass().addClass( 'placeholder' ).html( kirkiL10n.noFileSelected );
            }
            if ( removeButton.length ) {
                removeButton.hide();
                if ( jQuery( defaultButton ).hasClass( 'button' ) ) {
                    defaultButton.show();
                }
            }
        } );

        control.container.on( 'click', '.image-default-button', function( e ) {

            var preview,
                removeButton,
                defaultButton;

            e.preventDefault();

            kirki.setting.set( control.id, control.params.default );

            preview       = control.container.find( '.placeholder, .thumbnail' );
            removeButton  = control.container.find( '.image-upload-remove-button' );
            defaultButton = control.container.find( '.image-default-button' );

            if ( preview.length ) {
                preview.removeClass().addClass( 'thumbnail thumbnail-image' ).html( '<img src="' + control.params.default + '" alt="" />' );
            }
            if ( removeButton.length ) {
                removeButton.show();
                defaultButton.hide();
            }
        } );
    }
};

kirki.control = kirki.control || {};
kirki.control['kirki-image'] = {

    /**
     * Init the control.
     *
     * @since 3.0.34
     * @param {Object} control - The customizer control object.
     * @returns {null}
     */
    init: function( control ) {
        var self = this;

        // Render the template.
        self.template( control );

        // Init the control.
        kirki.input.image.init( control );
    },

    /**
     * Render the template.
     *
     * @since 3.0.34
     * @param {Object}  control - The customizer control object.
     * @param {Object}  control.params - The control parameters.
     * @param {string}  control.params.label - The control label.
     * @param {string}  control.params.description - The control description.
     * @param {string}  control.params.inputAttrs - extra input arguments.
     * @param {string}  control.params.default - The default value.
     * @param {Object}  control.params.choices - Any extra choices we may need.
     * @param {string}  control.id - The setting.
     * @returns {null}
     */
    template: function( control ) {
        var template = wp.template( 'kirki-input-image' );

        control.container.html(
            template( args = {
                label: control.params.label,
                description: control.params.description,
                'data-id': control.id,
                inputAttrs: control.params.inputAttrs,
                choices: control.params.choices,
                value: kirki.setting.get( control.id )
            } )
        );
    }
};

wp.customize.controlConstructor['kirki-image'] = wp.customize.kirkiDynamicControl.extend( {} );
