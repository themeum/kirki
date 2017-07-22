wp.customize.controlConstructor['kirki-select'] = wp.customize.kirkiDynamicControl.extend({

	initKirkiControl: function() {

		var control  = this,
		    element  = this.container.find( 'select' ),
		    multiple = parseInt( element.data( 'multiple' ), 10 ),
		    selectValue,
		    select2Options = {
				escapeMarkup: function( markup ) {
					return markup;
				}
		    };

		if ( 1 < multiple ) {
			select2Options.maximumSelectionLength = multiple;
		}
		jQuery( element ).select2( select2Options ).on( 'change', function() {
			selectValue = jQuery( this ).val();
			control.setting.set( selectValue );
		});
	}
});
