wp.customize.controlConstructor['kirki-multicheck'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function( control ) {
		control = control || this;

		// Save the value
		control.container.on( 'change', 'input', function() {
			var value = [],
				i = 0;

			// Build the value as an object using the sub-values from individual checkboxes.
			jQuery.each( control.params.choices, function( key ) {
				if ( control.container.find( 'input[value="' + key + '"]' ).is( ':checked' ) ) {
					control.container.find( 'input[value="' + key + '"]' ).parent().addClass( 'checked' );
					value[ i ] = key;
					i++;
				} else {
					control.container.find( 'input[value="' + key + '"]' ).parent().removeClass( 'checked' );
				}
			} );

			// Update the value in the customizer.
			control.setting.set( value );
		} );
	}
} );
