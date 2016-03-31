/**
 * KIRKI CONTROL: COLOR PALETTE
 */
wp.customize.controlConstructor['color-palette'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		var control = this;

		// Save the value
		this.container.on( 'click', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});

	}

});
