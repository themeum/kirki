/**
 * KIRKI CONTROL: TEXTAREA
 */
wp.customize.controlConstructor['kirki-textarea'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		this.container.on( 'change keyup paste', '.textarea', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
