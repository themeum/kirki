/**
 * KIRKI CONTROL: COLOR PALETTE
 */
wp.customize.controlConstructor['color-palette'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		this.container.on( 'click', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
