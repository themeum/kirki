/**
 * KIRKI CONTROL: NUMBER
 */
wp.customize.controlConstructor.number = wp.customize.Control.extend({

	ready: function() {
		var control = this,
		    element = this.container.find( 'input' );

		// Init the spinner
		jQuery( element ).spinner();

		// set minimum value
		if ( control.params.choices.min ) {
			jQuery( element ).spinner( 'option', 'min', control.params.choices.min );
		}

		// Set maximum value
		if ( control.params.choices.max ) {
			jQuery( element ).spinner( 'option', 'max', control.params.choices.max );
		}

		// Set steps
		if ( control.params.choices.step ) {
			if ( 'any' == control.params.choices.step ) {
				jQuery( element ).spinner( 'option', 'step', '0.001' );
			} else {
				jQuery( element ).spinner( 'option', 'step', control.params.choices.step );
			}
		}

		// On change
		this.container.on( 'change click keyup paste', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});

	}

});
