( function( $ ) {
	var api = wp.customize;

	$.each( jsvars, function( setting, jsVars ) {

		var css      = '',
		    cssArray = {};

		api( setting, function( value ) {

			value.bind( function( newval ) {

				if ( undefined !== jsVars && 0 < jsVars.length ) {

					$.each( jsVars, function( i, jsVar ) {

						var val = newval;

						// Make sure element is defined.
						if ( undefined === jsVars.i.element ) {
							jsVars.i.element = '';
						}

						// Make sure property is defined.
						if ( undefined === jsVars.i.property ) {
							jsVars.i.property = '';
						}

						// Use empty prefix if undefined
						if ( undefined === jsVars.i.prefix ) {
							jsVars.i.prefix = '';
						}

						// Use empty suffix if undefined
						if ( undefined === jsVars.i.suffix ) {
							jsVars.i.suffix = '';
						}

						// Use empty units if undefined
						if ( undefined === jsVars.i.units ) {
							jsVars.i.units = '';
						}

						// Use css if method is undefined
						if ( undefined === jsVars.i['function'] ) {
							jsVars.i['function'] = 'css';
						}

						// Use $ (just the value) if value_pattern is undefined
						if ( undefined === jsVars.i.value_pattern ) {
							jsVars.i.value_pattern = '$';
						}

						$.each( jsVars, function( i, args ) {

							// Value is a string
							if ( 'string' === typeof newval ) {

								// Process the value pattern
								if ( undefined !== jsVars.i.value_pattern ) {
									val = jsVars.i.value_pattern.replace( /\$/g, newval );
								}

								// Inject HTML
								if ( 'html' === args['function'] ) {
									$( args.element ).html( args.prefix + val + args.units + args.suffix );

								// Add CSS
								} else {

									// If we have new value, replace style contents with custom css
									if ( '' !== val ) {
										cssArray[ i ] = args.element + '{' + args.property + ':' + args.prefix + val + args.units + args.suffix + ';}';
									}

									// Else let's clear it out
									else {
										cssArray[ i ] = '';
									}

								}

							// Value is an object
							} else if ( 'object' === typeof newval ) {
								cssArray[ i ] = '';
								$.each( newval, function( subValueKey, subValueValue ) {
									if ( undefined !== args.choice ) {
										if ( args.choice === subValueKey ) {
											cssArray[ i ] += args.element + '{' + args.property + ':' + args.prefix + subValueValue + args.units + args.suffix + ';}';
										}
									} else {
										cssArray[ i ] += args.element + '{' + args.property + ':' + args.prefix + subValueValue + args.units + args.suffix + ';}';
									}
								});
							}
						});

					});

					$.each( cssArray, function( i, singleCSS ) {

						setTimeout( function() {

							if ( '' !== singleCSS ) {
								css += singleCSS;
							}

							// Attach to <head>
							if ( '' !== css ) {

								// Make sure we have a stylesheet with the defined ID.
								// If we don't then add it.
								if ( ! $( '#kirki-customizer-postmessage' + setting ).size() ) {
									$( 'head' ).append( '<style id="kirki-customizer-postmessage' + setting + '"></style>' );
								}
								$( '#kirki-customizer-postmessage' + setting ).text( css );
							}

						}, 300 );

					});

				}

			});

		});

	});

})( jQuery );
