/**
 * KIRKI CONTROL: NUMBER
 */
wp.customize.controlConstructor['number'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		var element = this.container.find( 'input' );

		jQuery( element ).spinner();
		if ( control.params.choices.min ) {
			jQuery( element ).spinner( 'option', 'min', control.params.choices.min );
		}
		if ( control.params.choices.max ) {
			jQuery( element ).spinner( 'option', 'max', control.params.choices.max );
		}
		if ( control.params.choices.step ) {
			if ( 'any' == control.params.choices.step ) {
				jQuery( element ).spinner( 'option', 'step', '0.001' );
			} else {
				jQuery( element ).spinner( 'option', 'step', control.params.choices.step );
			}
		}
		// On change
		this.container.on( 'change', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});
		// On click
		this.container.on( 'click', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});
		// On keyup
		this.container.on( 'keyup', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
