/**
 * KIRKI CONTROL: PALETTE
 */
wp.customize.controlConstructor.palette = wp.customize.Control.extend({

	ready: function() {

		var control = this;

		// Change the value
		this.container.on( 'click', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});

	}

});
