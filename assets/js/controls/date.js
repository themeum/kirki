/**
 * KIRKI CONTROL: DATE
 */
wp.customize.controlConstructor['kirki-date'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		var control = this,
		    selector = control.selector + ' input.datepicker';

		// Init the datepicker
		jQuery( selector ).datepicker();

		// Save the changes
		this.container.on( 'change keyup paste', 'input.datepicker', function() {
			control.setting.set( jQuery( this ).val() );
		});

	}

});
