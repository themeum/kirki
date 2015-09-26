/**
 * KIRKI CONTROL: MULTICHECK
 */
wp.customize.controlConstructor['multicheck'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		var compiled_value = {};

		// Initial values
		jQuery.each( control.params.choices, function( key, value ) {
			var element = control.container.find( 'input[value="' + key + '"]' );
			compiled_value[ key ] = jQuery( element ).is( ':checked' ) ? true : false;
		});

		// Modified values
		control.container.on( 'change', 'input', function() {
			jQuery.each( control.params.choices, function( key, value ) {
				compiled_value[ key ] = ( jQuery( 'input[value="' + key + '"' ).is( ':checked' ) ) ? true : false;
			});
			control.setting.set( compiled_value );
		});
	}
});
