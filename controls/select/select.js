/*jshint -W065 */
wp.customize.controlConstructor['kirki-select'] = wp.customize.Control.extend({

	ready: function() {

		'use strict';

		var control  = this,
		    element  = this.container.find( 'select' ),
		    multiple = parseInt( element.data( 'multiple' ) ),
		    selectValue,
		    select2Options = {
				escapeMarkup: function( markup ) {
					return markup;
				}
		    };

		if ( 1 < multiple ) {
			select2Options.maximumSelectionLength = multiple;
		}
		jQuery( element ).select2( select2Options ).on( 'change', function( e ) {
			selectValue = jQuery( this ).val();
			control.setting.set( selectValue );
		});
	}
});
