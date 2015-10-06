/**
 * KIRKI CONTROL: MULTICHECK
 */
wp.customize.controlConstructor['multicheck'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;

		// Modified values
		control.container.on( 'change', 'input', function() {
			var compiled_value = {};
			jQuery.each( control.params.choices, function( key, value ) {
				if ( jQuery( 'input[value="' + key + '"' ).is( ':checked' ) ) {
					compiled_value[ key ] = true;
				}
			});
			control.setting.set( compiled_value );
			wp.customize.previewer.refresh();
			console.log( compiled_value );
		});
	}
});
