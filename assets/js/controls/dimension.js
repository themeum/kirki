wp.customize.controlConstructor['kirki-dimension'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		'use strict';

		var control = this,
		    value;

		// Validate the value and show a warning if it's invalid
		if ( false === kirkiValidateCSSValue( control.setting._value ) ) {
			jQuery( control.selector + ' .input-wrapper' ).addClass( 'invalid' );
		} else {
			jQuery( control.selector + ' .input-wrapper' ).removeClass( 'invalid' );
		}

		// Save the value
		this.container.on( 'change keyup paste', 'input', function() {

			value = jQuery( this ).val();

			// Validate the value and show a warning if it's invalid.
			// We did this once when initializing the field, but we need to re-evaluate
			// every time the value changes.
			if ( false === kirkiValidateCSSValue( value ) ) {

				jQuery( control.selector + ' .input-wrapper' ).addClass( 'invalid' );

			} else {

				jQuery( control.selector + ' .input-wrapper' ).removeClass( 'invalid' );

				// Set the value to the customizer.
				// We're only saving VALID values.
				control.setting.set( value );

			}

		});

	}

});
