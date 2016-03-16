/**
 * KIRKI CONTROL: DIMENSION
 */
wp.customize.controlConstructor['dimension'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;

		// Validate the value and show a warning if it's invalid
		if ( false === kirkiValidateCSSValue( control.setting._value ) ) {
			jQuery( control.selector + ' .input-wrapper' ).addClass( 'invalid' );
		} else {
			jQuery( control.selector + ' .input-wrapper' ).removeClass( 'invalid' );
		}

		this.container.on( 'change keyup paste', 'input', function() {
			var value = jQuery( this ).val();
			// Validate the value and show a warning if it's invalid
			if ( false === kirkiValidateCSSValue( value ) ) {
				jQuery( control.selector + ' .input-wrapper' ).addClass( 'invalid' );
			} else {
				jQuery( control.selector + ' .input-wrapper' ).removeClass( 'invalid' );
				// Set the value to the customizer
				control.setting.set( value );
			}
		});
	}
});
