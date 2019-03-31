/* global kirkiSetSettingValue */
jQuery( document ).ready( function() {

	// Loop Controls.
	wp.customize.control.each( function( control ) {

		// Check if we have a preset defined.
		if ( control.params && control.params.preset && ! _.isEmpty( control.params.preset ) ) {
			wp.customize( control.id, function( value ) {

				// Listen to value changes.
				value.bind( function( to ) {

					// Loop preset definitions.
					_.each( control.params.preset, function( preset, valueToListen ) {

						// Check if the value set want is the same as the one we're looking for.
						if ( valueToListen === to ) {

							// Loop settings defined inside the preset.
							_.each( preset.settings, function( controlValue, controlID ) {

								// Set the value.
								kirkiSetSettingValue.set( controlID, controlValue );
							} );
						}
					} );
				} );
			} );
		}
	} );
} );
