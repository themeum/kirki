/* global kirki */
wp.customize.controlConstructor['kirki-select'] = wp.customize.kirkiDynamicControl.extend( {
    initKirkiControl: function() {
        var control = this,
            element  = control.container.find( 'select' ),
            multiple = parseInt( element.data( 'multiple' ), 10 ),
            selectValue,
            selectWooOptions = {
                escapeMarkup: function( markup ) {
                    return markup;
                }
            };
            if ( control.params.placeholder ) {
                selectWooOptions.placeholder = control.params.placeholder;
                selectWooOptions.allowClear  = true;
            }

        if ( 1 < multiple ) {
            selectWooOptions.maximumSelectionLength = multiple;
        }
        jQuery( element ).selectWoo( selectWooOptions ).on( 'change', function() {
            selectValue = jQuery( this ).val();
            selectValue = ( null === selectValue && 1 < multiple ) ? [] : selectValue;
            control.setting.set( selectValue );
        } );
    }
});
