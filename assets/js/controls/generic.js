wp.customize.controlConstructor['kirki-generic'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		'use strict';

		var control = this;

		// Save the value
		this.container.on( 'change keyup paste', control.params.choices.element, function() {
			control.setting.set( jQuery( this ).val() );
		});

	}

});
