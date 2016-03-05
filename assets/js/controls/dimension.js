/**
 * KIRKI CONTROL: DIMENSION
 */
wp.customize.controlConstructor['dimension'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;

		if ( false === kirkiValidateCSSValue( control.setting._value ) ) {
			jQuery( control.selector + ' .input-wrapper' ).addClass( 'invalid' );
		} else {
			jQuery( control.selector + ' .input-wrapper' ).removeClass( 'invalid' );
		}

		this.container.on( 'change keyup paste', 'input', function() {
			var value = jQuery( this ).val();
			// Set the value to the customizer
			control.setting.set( value );

			if ( false === kirkiValidateCSSValue( value ) ) {
				jQuery( control.selector + ' .input-wrapper' ).addClass( 'invalid' );
			} else {
				jQuery( control.selector + ' .input-wrapper' ).removeClass( 'invalid' );
			}
		});
	}
});
