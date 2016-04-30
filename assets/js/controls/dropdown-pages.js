wp.customize.controlConstructor['kirki-dropdown-pages'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		'use strict';

		var control = this,
		    element = this.container.find( 'select' );

		jQuery( element ).selectize();
		this.container.on( 'change', 'select', function() {
			control.setting.set( jQuery( this ).val() );
		});

	}

});
