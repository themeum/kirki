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
		if ( control.params.choices.min ) {
			jQuery( element ).spinner( 'option', 'max', control.params.choices.max );
		}
		if ( control.params.choices.min ) {
			var control_step = ( 'any' == control.params.choises.step ) ? '0.001' : control.params.choices.step;
			jQuery( element ).spinner( 'option', 'step', control_step );
		}
		this.container.on( 'change', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
