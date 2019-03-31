var kirki = kirki || {};
kirki.input = kirki.input || {};
kirki.input.radio = {
    /**
     * Init the control.
     *
     * @since 3.0.17
     * @param {Object} control - The control object.
     * @param {Object} control.id - The setting.
     * @returns {null}
     */
    init: function( control ) {
        var input = jQuery( 'input[data-id="' + control.id + '"]' );

        // Save the value
        input.on( 'change keyup paste click', function() {
            kirki.setting.set( control.id, jQuery( this ).val() );
        } );
    }
};

kirki.control = kirki.control || {};
kirki.control['kirki-radio'] = {

    /**
     * Init the control.
     *
     * @since 3.0.17
     * @param {Object} control - The customizer control object.
     * @returns {null}
     */
    init: function( control ) {
        var self = this;

        // Render the template.
        self.template( control );

        // Init the control.
        kirki.input.radio.init( control );

    },

    /**
     * Render the template.
     *
     * @since 3.0.17
     * @param {Object} control - The customizer control object.
     * @param {Object} control.params - The control parameters.
     * @param {string} control.params.label - The control label.
     * @param {string} control.params.description - The control description.
     * @param {string} control.params.inputAttrs - extra input arguments.
     * @param {string} control.params.default - The default value.
     * @param {Object} control.params.choices - Any extra choices we may need.
     * @param {string} control.id - The setting.
     * @returns {null}
     */
    template: function( control ) {
        var template = wp.template( 'kirki-input-radio' );
        control.container.html( template( {
            label: control.params.label,
            description: control.params.description,
            'data-id': control.id,
            inputAttrs: control.params.inputAttrs,
            'default': control.params.default,
            value: kirki.setting.get( control.id ),
            choices: control.params.choices
        } ) );
    }
};

wp.customize.controlConstructor['kirki-radio'] = wp.customize.kirkiDynamicControl.extend( {} );
wp.customize.controlConstructor['kirki-radio-buttonset'] = wp.customize.kirkiDynamicControl.extend( {} );
wp.customize.controlConstructor['kirki-radio-image'] = wp.customize.kirkiDynamicControl.extend( {} );
