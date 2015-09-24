/**
 * KIRKI CONTROL: RADIO-BUTTONSET
 */
wp.customize.controlConstructor['radio-buttonset'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		this.container.on( 'click', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
