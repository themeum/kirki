var kirki = kirki || {};
kirki.input = kirki.input || {};

kirki.input.select = {
    /**
     * Init the control.
     *
     * @since 3.0.17
     * @param {Object} control - The control object.
     * @param {Object} control.id - The setting.
     * @returns {null}
     */
    init: function( control ) {
        var element  = jQuery( 'select[data-id="' + control.id + '"]' ),
            multiple = parseInt( element.data( 'multiple' ), 10 ),
            selectValue,
            selectWooOptions = {
                escapeMarkup: function( markup ) {
                    return markup;
                }
            };
            if ( control.params.placeholder ) {
                selectWooOptions.placeholder = control.params.placeholder;
                selectWooOptions.allowClear = true;
            }

        if ( 1 < multiple ) {
            selectWooOptions.maximumSelectionLength = multiple;
        }
        jQuery( element ).selectWoo( selectWooOptions ).on( 'change', function() {
            selectValue = jQuery( this ).val();
            selectValue = ( null === selectValue && 1 < multiple ) ? [] : selectValue;
            kirki.setting.set( control.id, selectValue );
        } );
    }
};


kirki.control = kirki.control || {};
kirki.control['kirki-select'] = {

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
        kirki.input.select.init( control );
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
     * @param {Object}  control.params.default - The default value.
     * @param {Object}  control.params.choices - The choices for the select dropdown.
     * @param {string}  control.id - The setting.
     * @returns {null}
     */
    template: function( control ) {
        var template = wp.template( 'kirki-input-select' );

        control.container.html( template( {
            label: control.params.label,
            description: control.params.description,
            'data-id': control.id,
            inputAttrs: control.params.inputAttrs,
            choices: control.params.choices,
            value: kirki.setting.get( control.id ),
            multiple: control.params.multiple || 1,
            placeholder: control.params.placeholder
        } ) );
    }
};

wp.customize.controlConstructor['kirki-select'] = wp.customize.kirkiDynamicControl.extend( {} );
