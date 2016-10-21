wp.customize.controlConstructor['xtkirki-dimension'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		'use strict';

		var control = this,
		    value;

		// Notifications.
		xtkirkiNotifications( control.id, 'xtkirki-dimension', control.params.xtkirkiConfig );

		// Save the value
		this.container.on( 'change keyup paste', 'input', function() {

			value = jQuery( this ).val();
			control.setting.set( value );

		});

	}

});
