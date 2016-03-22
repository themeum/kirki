( function( $ ) {
	var $style = $( '#twentyfifteen-color-scheme-css' ),
		api = wp.customize;

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

						$.each( jsVars, function( i, args ) {

							// Value is a string
							if ( 'string' == typeof newval ) {
								// Inject HTML
								if ( 'html' === args.function ) {
									$( args.element ).html( args.prefix + newval + args.units + args.suffix );
								// Attach to <head>
								} else if ( 'style' === args.function ) {
									if ( newval !== '' ) {
										$( 'head' ).append( '<style>' + args.element + '{' + args.property + ':' + args.prefix + newval + args.units + args.suffix + ';}</style>' );
									}
								// CSS
								} else if ( 'css' === args.function ) {
									$( args.element ).css( args.property, args.prefix + newval + args.units + args.suffix );
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
