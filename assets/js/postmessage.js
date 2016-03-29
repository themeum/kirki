( function( $ ) {
	var api = wp.customize;

	$.each( js_vars, function( setting, jsVars ) {

		api( setting, function( value ) {

			value.bind( function( newval ) {

				if ( undefined !== jsVars && 0 < jsVars.length ) {

					$.each( jsVars, function( i, js_var ) {

						// Make sure everything is properly defined.
						if ( undefined === jsVars[ i ]['element'] ) {
							jsVars[ i ]['element'] = '';
						}
						if ( undefined === jsVars[ i ]['property'] ) {
							jsVars[ i ]['property'] = '';
						}
						if ( undefined === jsVars[ i ]['prefix'] ) {
							jsVars[ i ]['prefix'] = '';
						}
						if ( undefined === jsVars[ i ]['suffix'] ) {
							jsVars[ i ]['suffix'] = '';
						}
						if ( undefined === jsVars[ i ]['units'] ) {
							jsVars[ i ]['units'] = '';
						}
						if ( undefined === jsVars[ i ]['function'] ) {
							jsVars[ i ]['function'] = 'css';
						}
						if ( undefined === jsVars[ i ]['value_pattern'] ) {
							jsVars[ i ]['value_pattern'] = '$';
						}

						$.each( jsVars, function( i, args ) {

							// Value is a string
							if ( 'string' == typeof newval ) {
								// Process the value pattern
								var val = jsVars[ i ]['value_pattern'].replace( /\$/g, newval );
								// Inject HTML
								if ( 'html' === args.function ) {
									$( args.element ).html( args.prefix + val + args.units + args.suffix );
								// Attach to <head>
								} else {
									// make sure we have a stylesheet with the defined ID.
									if ( ! $( '#kirki-customizer-postmessage' + setting ).size() ) {
										$( 'head' ).append( '<style id="kirki-customizer-postmessage' + setting + '"></style>' );
									}
									// if we have new value, replace style contents with custom css
									if ( val !== '' ) {
										$( '#kirki-customizer-postmessage' + setting ).text( args.element + '{' + args.property + ':' + args.prefix + val + args.units + args.suffix + ';}' );
									}
									// else let's clear it out
									else {
										$( '#kirki-customizer-postmessage' + setting ).text('' );
									}

								}

							// Value is an object
							} else if ( 'object' == typeof newval ) {
								$.each( newval, function( subValueKey, subValueValue ) {
									$( args.element ).css( subValueKey, args.prefix + subValueValue + args.units + args.suffix );
								} );
							}
						});

					});

				}

			} );

		} );

	} );

} )( jQuery );
