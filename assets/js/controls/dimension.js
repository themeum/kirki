/**
 * KIRKI CONTROL: DIMENSION
 */
wp.customize.controlConstructor['dimension'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		var numeric_value = control.container.find('input[type=number]' ).val();
		var units_value   = control.container.find('select' ).val();

		jQuery( '.customize-control-dimension select' ).selectize();

		this.container.on( 'change', 'input', function() {
			numeric_value = jQuery( this ).val();
			control.setting.set( numeric_value + units_value );
		});
		this.container.on( 'change', 'select', function() {
			units_value = jQuery( this ).val();
			control.setting.set( numeric_value + units_value );
		});
	}
});
