wp.customize.controlConstructor['toggle'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		this.container.on( 'click', 'span.switch', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
