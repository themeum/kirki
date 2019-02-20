var kirki = kirki || {};

kirki.input = kirki.input || {};
kirki.input.color = {

    /**
     * Init the control.
     *
     * @since 3.0.16
     * @param {Object} control - The control object.
     * @param {Object} control.id - The setting.
     * @param {Object} control.choices - Additional options for the colorpickers.
     * @param {Object} control.params - Control parameters.
     * @param {Object} control.params.choices - alias for control.choices.
     * @returns {null}
     */
    init: function( control ) {
        var picker = jQuery( '.kirki-color-control[data-id="' + control.id + '"]' ),
            clear;

        control.choices = control.choices || {};
        if ( _.isEmpty( control.choices ) && control.params.choices ) {
            control.choices = control.params.choices;
        }

        // If we have defined any extra choices, make sure they are passed-on to Iris.
        if ( ! _.isEmpty( control.choices ) ) {
            picker.wpColorPicker( control.choices );
        }

        // Tweaks to make the "clear" buttons work.
        setTimeout( function() {
            clear = jQuery( '.kirki-input-container[data-id="' + control.id + '"] .wp-picker-clear' );
            if ( clear.length ) {
                clear.click( function() {
                    kirki.setting.set( control.id, '' );
                } );
            }
        }, 200 );

        // Saves our settings to the WP API
        picker.wpColorPicker( {
            change: function() {

                // Small hack: the picker needs a small delay
                setTimeout( function() {
                    kirki.setting.set( control.id, picker.val() );
                }, 20 );
            }
        } );
    }
};

kirki.control = kirki.control || {};
kirki.control['kirki-color'] = {

    /**
     * Init the control.
     *
     * @since 3.0.16
     * @param {Object} control - The customizer control object.
     * @returns {null}
     */
    init: function( control ) {

        // Render the template.
        this.template( control );

        // Init the control.
        kirki.input.color.init( control );

    },

    /**
     * Render the template.
     *
     * @since 3.0.16
     * @param {Object}     control - The customizer control object.
     * @param {Object}     control.params - The control parameters.
     * @param {string}     control.params.label - The control label.
     * @param {string}     control.params.description - The control description.
     * @param {string}     control.params.mode - The colorpicker mode. Can be 'full' or 'hue'.
     * @param {bool|array} control.params.palette - false if we don't want a palette,
     *                                              true to use the default palette,
     *                                              array of custom hex colors if we want a custom palette.
     * @param {string}     control.params.inputAttrs - extra input arguments.
     * @param {string}     control.params.default - The default value.
     * @param {Object}     control.params.choices - Any extra choices we may need.
     * @param {boolean}    control.params.choices.alpha - should we add an alpha channel?
     * @param {string}     control.id - The setting.
     * @returns {null}
     */
    template: function( control ) {
        var template = wp.template( 'kirki-input-color' );
        control.container.html( template( {
            label: control.params.label,
            description: control.params.description,
            'data-id': control.id,
            mode: control.params.mode,
            inputAttrs: control.params.inputAttrs,
            'data-palette': control.params.palette,
            'data-default-color': control.params.default,
            'data-alpha': control.params.choices.alpha,
            value: kirki.setting.get( control.id )
        } ) );
    }
};

wp.customize.controlConstructor['kirki-color'] = wp.customize.kirkiDynamicControl.extend( {} );
