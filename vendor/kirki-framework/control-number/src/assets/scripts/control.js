var kirki = kirki || {};
kirki.input = kirki.input || {};

kirki.input.number = {
    /**
     * Init the control.
     *
     * @since 3.0.17
     * @param {Object} control - The control object.
     * @param {Object} control.id - The setting.
     * @returns {null}
     */
    init: function( control ) {

        var element = jQuery( 'input[data-id="' + control.id + '"]' ),
            value   = control.setting._value,
            up,
            down;

        // Make sure we use default values if none are define for some arguments.
        control.params.choices = _.defaults( control.params.choices, {
            min: 0,
            max: 100,
            step: 1
        } );

        // Make sure we have a valid value.
        if ( isNaN( value ) || '' === value ) {
            value = ( 0 > control.params.choices.min && 0 < control.params.choices.max ) ? 0 : control.params.choices.min;
        }
        value = parseFloat( value );

        // If step is 'any', set to 0.001.
        control.params.choices.step = ( 'any' === control.params.choices.step ) ? 0.001 : control.params.choices.step;

        // Make sure choices are properly formtted as numbers.
        control.params.choices.min  = parseFloat( control.params.choices.min );
        control.params.choices.max  = parseFloat( control.params.choices.max );
        control.params.choices.step = parseFloat( control.params.choices.step );

        up   = jQuery( '.kirki-input-container[data-id="' + control.id + '"] .plus' );
        down = jQuery( '.kirki-input-container[data-id="' + control.id + '"] .minus' );

        up.click( function() {
            var oldVal = parseFloat( element.val() ),
                newVal;

            newVal = ( oldVal >= control.params.choices.max ) ? oldVal : oldVal + control.params.choices.step;

            element.val( newVal );
            element.trigger( 'change' );
        } );

        down.click( function() {
            var oldVal = parseFloat( element.val() ),
                newVal;

            newVal = ( oldVal <= control.params.choices.min ) ? oldVal : oldVal - control.params.choices.step;

            element.val( newVal );
            element.trigger( 'change' );
        } );

        element.on( 'change keyup paste click', function() {
            var val = jQuery( this ).val();
            if ( isNaN( val ) ) {
                val = parseFloat( val, 10 );
                val = ( isNaN( val ) ) ? 0 : val;
                jQuery( this ).attr( 'value', val );
            }
            kirki.setting.set( control.id, val );
        } );
    }
};