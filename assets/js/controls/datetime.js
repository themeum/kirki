/**
 * KIRKI CONTROL: DATETIME
 */
wp.customize.controlConstructor['kirki-datetime'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		var selector = control.selector + ' input.datepicker';
		jQuery( selector ).datepicker({
			inline: true
		});

		this.container.on( 'change keyup paste', 'input.datepicker', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
