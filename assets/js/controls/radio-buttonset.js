/**
 * KIRKI CONTROL: RADIO-BUTTONSET
 */
wp.customize.controlConstructor['radio-buttonset'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		this.container.on( 'click', 'input', function() {
			control.setting.set( jQuery( this ).val() );
			if ( undefined !== control.params.js_vars && 0 < control.params.js_vars.length ) {
				KirkiPostMessage( control.params.js_vars, jQuery( this ).val() );
			}
		});
	}
});
