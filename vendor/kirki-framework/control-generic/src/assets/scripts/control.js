var kirki = kirki || {};
kirki.input = kirki.input || {};

kirki.input.genericInput = {

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

kirki.input.textarea = {

    /**
     * Init the control.
     *
     * @since 3.0.17
     * @param {Object} control - The control object.
     * @param {Object} control.id - The setting.
     * @returns {null}
     */
    init: function( control ) {
        var textarea = jQuery( 'textarea[data-id="' + control.id + '"]' );

        // Save the value
        textarea.on( 'change keyup paste click', function() {
            kirki.setting.set( control.id, jQuery( this ).val() );
        } );
    }
};

kirki.control = kirki.control || {};
kirki.control['kirki-generic'] = {

    /**
     * Init the control.
     *
     * @since 3.0.17
     * @param {Object} control - The customizer control object.
     * @param {Object} control.params - Control parameters.
     * @param {Object} control.params.choices - Define the specifics for this input.
     * @param {string} control.params.choices.element - The HTML element we want to use ('input', 'div', 'span' etc).
     * @returns {null}
     */
    init: function( control ) {
        var self = this;

        // Render the template.
        self.template( control );

        // Init the control.
        if ( ! _.isUndefined( control.params ) && ! _.isUndefined( control.params.choices ) && ! _.isUndefined( control.params.choices.element ) && 'textarea' === control.params.choices.element ) {
            kirki.input.textarea.init( control );
            return;
        }
        kirki.input.genericInput.init( control );
    },

    /**
     * Render the template.
     *
     * @since 3.0.17
     * @param {Object}  control - The customizer control object.
     * @param {Object}  control.params - The control parameters.
     * @param {string}  control.params.label - The control label.
     * @param {string}  control.params.description - The control description.
     * @param {string}  control.params.inputAttrs - extra input arguments.
     * @param {string}  control.params.default - The default value.
     * @param {Object}  control.params.choices - Any extra choices we may need.
     * @param {boolean} control.params.choices.alpha - should we add an alpha channel?
     * @param {string}  control.id - The setting.
     * @returns {null}
     */
    template: function( control ) {
        var args = {
                label: control.params.label,
                description: control.params.description,
                'data-id': control.id,
                inputAttrs: control.params.inputAttrs,
                choices: control.params.choices,
                value: kirki.setting.get( control.id )
            },
            template;

        if ( ! _.isUndefined( control.params ) && ! _.isUndefined( control.params.choices ) && ! _.isUndefined( control.params.choices.element ) && 'textarea' === control.params.choices.element ) {
            template = wp.template( 'kirki-input-textarea' );
            control.container.html( template( args ) );
            return;
        }
        template = wp.template( 'kirki-input-generic' );
        control.container.html( template( args ) );
    }
};

wp.customize.controlConstructor['kirki-generic'] = wp.customize.kirkiDynamicControl.extend( {} );
