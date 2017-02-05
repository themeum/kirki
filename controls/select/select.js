/*jshint -W065 */
wp.customize.controlConstructor['kirki-select'] = wp.customize.Control.extend({

	ready: function() {

		'use strict';

		var control  = this,
		    element  = this.container.find( 'select' ),
		    multiple = parseInt( element.data( 'multiple' ) ),
		    selectValue;

		jQuery( element ).select2().on( 'change', function( e ) {
			selectValue = jQuery( this ).val();
			control.setting.set( selectValue );
		});
		// if ( 1 < multiple ) {
		// 	jQuery( element ).parent().find( 'ul.select2-selection__rendered' ).sortable({
		// 		containment: 'parent',
		// 		update: function() {
		// 			selectValue = jQuery( this ).val();
		// 			control.setting.set( selectValue );
		// 	    }
		// 	});
		// }
	}
});
