/**
 * KIRKI CONTROL: MULTICHECK
 */
wp.customize.controlConstructor['multicheck'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {
		var control = this;

		// Save the value
		control.container.on( 'change', 'input', function() {
			var compiled_value = [],
			    i = 0;

			// build the value as an object using the sub-values from individual checkboxes.
			jQuery.each( control.params.choices, function( key, value ) {
				if ( control.container.find( 'input[value="' + key + '"]' ).is( ':checked' ) ) {
					compiled_value[ i ] = key;
					i++;
				}
			});

			// Update the value in the customizer
			control.setting.set( compiled_value );

		});

	}

});
