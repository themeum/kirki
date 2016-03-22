( function( $ ) {
	var $style = $( '#twentyfifteen-color-scheme-css' ),
		api = wp.customize;

	$.each( js_vars, function( setting, jsVars ) {

		api( setting, function( value ) {

			value.bind( function( newval ) {

				if ( undefined !== jsVars && 0 < jsVars.length ) {

					$.each( jsVars, function( i, js_var ) {

						// Make sure everything is properly defined.
						if ( undefined === jsVars[ i ]["element"] ) {
							jsVars[ i ]["element"] = "";
						}
						if ( undefined === jsVars[ i ]["property"] ) {
							jsVars[ i ]["property"] = "";
						}
						if ( undefined === jsVars[ i ]["prefix"] ) {
							jsVars[ i ]["prefix"] = "";
						}
						if ( undefined === jsVars[ i ]["suffix"] ) {
							jsVars[ i ]["suffix"] = "";
						}
						if ( undefined === jsVars[ i ]["units"] ) {
							jsVars[ i ]["units"] = "";
						}
						if ( undefined === jsVars[ i ]["function"] ) {
							jsVars[ i ]["function"] = "css";
						}

						$.each( jsVars, function( i, args ) {
							if ( "html" === args.functionName ) {

								$( args.element ).html( args.prefix + newval + args.units + args.suffix );

							} else if ( "style" === args.functionName ) {

								if ( ! $( "#kirki-style-" + args.id ).size() ) {
									$( "head" ).append( '<style id="#kirki-style-' + args.id + '"></style>' );
								}

								if ( newval !== "" ) {
									$( "#kirki-style-" + args.id ).text( args.element + "{" + args.property + ":" + args.prefix + args.newval + args.units + args.suffix + ";}" );
								} else {
									$( "#kirki-style-" + args.id ).text( "" );
								}

							} else {

								$( args.element ).css( args.property, args.prefix + newval + args.units + args.suffix );

							}

						});

					});

				}

			} );

		} );

	} );

} )( jQuery );
