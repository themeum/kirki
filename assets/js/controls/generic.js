/**
 * KIRKI CONTROL: GENERIC
 */
wp.customize.controlConstructor['kirki-generic'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		this.container.on( 'change keyup paste', control.params.choices.element, function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
