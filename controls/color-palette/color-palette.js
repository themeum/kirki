wp.customize.controlConstructor['kirki-color-palette'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		'use strict';

		var control = this,
		    section = control.section.get();

		// Add to the queue.
		kirkiControlLoader( control );
	},

	initKirkiControl: function() {

		'use strict';

		var control = this;

		// Save the value
		this.container.on( 'click', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});

	}

});
