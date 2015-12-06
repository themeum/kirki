/**
 * KIRKI CONTROL: TEXT
 */
wp.customize.controlConstructor['kirki-text'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		this.container.on( 'change keyup paste', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
