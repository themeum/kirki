wp.customize.controlConstructor['kirki-select'] = wp.customize.kirkiDynamicControl.extend({

	initKirkiControl: function() {

		var control  = this,
		    element  = this.container.find( 'select' ),
		    multiple = parseInt( element.data( 'multiple' ), 10 ),
		    selectValue,
		    selectWooOptions = {
				escapeMarkup: function( markup ) {
					return markup;
				}
		    };

		if ( 1 < multiple ) {
			selectWooOptions.maximumSelectionLength = multiple;
		}
		jQuery( element ).selectWoo( selectWooOptions ).on( 'change', function() {
			selectValue = jQuery( this ).val();
			control.setting.set( selectValue );
		});
	}
});
