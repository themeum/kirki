/**
 * KIRKI CONTROL: DATE
 */
wp.customize.controlConstructor['kirki-date'] = wp.customize.Control.extend( {
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
