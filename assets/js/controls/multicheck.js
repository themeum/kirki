/**
 * KIRKI CONTROL: MULTICHECK
 */
wp.customize.controlConstructor['multicheck'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;

		// Modified values
		control.container.on( 'change', 'input', function() {
			var compiled_value = [];
			var i = 0;
			jQuery.each( control.params.choices, function( key, value ) {
				if ( jQuery( 'input[value="' + key + '"' ).is( ':checked' ) ) {
					compiled_value[i] = key;
					i++;
				}
			});
			control.setting.set( compiled_value );
			wp.customize.previewer.refresh();
		});
	}
});
