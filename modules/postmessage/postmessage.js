( function() {
	var api = wp.customize;

	function kirkiGetFontWeight( value ) {
		var numericVal = 400,
		    calculated;

		if ( ! _.isString( value ) ) {
			return numericVal;
		}
		calculated = value.match( /\d/g );
		if ( ! _.isObject( calculated ) ) {
			return numericVal;
		}
		return calculated.join( '' );
	}

	_.each( jsvars, function( jsVars, setting ) {

		var css      = '',
		    cssArray = {};

		api( setting, function( value ) {

			value.bind( function( newval ) {

				if ( ! _.isUndefined( jsVars ) && 0 < jsVars.length ) {

					_.each( jsVars, function( jsVar ) {

						var val = newval;

						jsVar = _.defaults( jsVar, {
							element: '',
							property: '',
							prefix: '',
							suffix: '',
							units: '',
							'function': 'css'
						});

						// Use $ (just the value) if value_pattern is undefined
						if ( _.isUndefined( jsVar.value_pattern ) ) {
							jsVar.value_pattern = '$';
						}

						_.each( jsVars, function( args, i ) {

							// Value is a string
							if ( _.isString( newval ) ) {

								// Process the value pattern
								if ( ! _.isUndefined( args.value_pattern ) ) {
									val = args.value_pattern.replace( /\$/g, args.prefix + newval + args.units + args.suffix );
								} else {
									val = args.prefix + newval + args.units + args.suffix;
								}

								// Simple tweak for background-image properties.
								if ( 'background-image' === args.property && 0 > val.indexOf( 'url(' ) ) {
									val = 'url("' + val + '")';
								}

								// Inject HTML
								if ( 'html' === args['function'] ) {

									if ( ! _.isUndefined( args.attr ) && ! _.isUndefined( args.attr ) ) {
										jQuery( args.element ).attr( args.attr, val );
									} else {
										jQuery( args.element ).html( val );
									}

								// Add CSS
								} else {

									// If we have new value, replace style contents with custom css
									cssArray[ i ] = '';
									if ( '' !== val ) {
										cssArray[ i ] = args.element + '{' + args.property + ':' + val + ';}';
									}

								}

								// Value is an object
							} else if ( _.isObject( newval ) ) {

								cssArray[ i ] = '';
								_.each( newval, function( subValueValue, subValueKey ) {

									// Helper for google-fonts if needed.
									var subsetsString = '';

									// Simple tweak for background-image properties.
									if ( 'background-image' === subValueKey && 0 > subValueValue.indexOf( 'url(' ) ) {
										subValueValue = 'url("' + subValueValue + '")';
									}

									// Dirty hack to make google-fonts work.
									if ( 'font-family' === subValueKey || 'variant' === subValueKey || 'subsets' === subValueKey ) {
										newval['font-family'] = ( _.isUndefined( newval['font-family'] ) ) ? '' : newval['font-family'];
										newval.variant        = ( _.isUndefined( newval.variant ) ) ? 400 : newval.variant;
										newval.subsets        = ( _.isUndefined( newval.subsets ) ) ? [] : newval.subsets;
										subsetsString         = ( _.isObject( newval.subsets ) ) ? ':' + newval.subsets.join( ',' ) : '';

										jQuery( 'head' ).append( '<script>if(!_.isUndefined(WebFont)){WebFont.load({google:{families:[\'' + newval['font-family'] + ':' + newval.variant + subsetsString + '\']}});}</script>' );

										cssArray[ i ] += args.element + '{font-weight:' + kirkiGetFontWeight( newval.variant ) + '}';
										cssArray[ i ] += ( -1 !== newval.variant.indexOf( 'italic' ) ) ? args.element + '{font-style:italic;}' : args.element + '{font-style:normal;}';
									}

									if ( ! _.isUndefined( args.choice ) ) {
										if ( args.choice === subValueKey ) {
											cssArray[ i ] += args.element + '{' + args.property + ':' + args.prefix + subValueValue + args.units + args.suffix + ';}';
										}
									} else {
										if ( _.contains( [ 'top', 'bottom', 'left', 'right' ], subValueKey ) ) {
											cssArray[ i ] += args.element + '{' + args.property + '-' + subValueKey + ':' + args.prefix + subValueValue + args.units + args.suffix + ';}';
										} else if ( 'subsets' !== subValueKey && 'variant' !== subValueKey ) {
											cssArray[ i ] += args.element + '{' + subValueKey + ':' + args.prefix + subValueValue + args.units + args.suffix + ';}';
										}
									}
								});
							}
						});
					});

					_.each( cssArray, function( singleCSS ) {

						css = '';

						setTimeout( function() {

							if ( '' !== singleCSS ) {
								css += singleCSS;
							}

							// Attach to <head>
							// Make sure we have a stylesheet with the defined ID.
							// If we don't then add it.
							if ( ! jQuery( '#kirki-customizer-postmessage' + setting.replace( /\[/g, '-' ).replace( /\]/g, '' ) ).size() ) {
								jQuery( 'head' ).append( '<style id="kirki-customizer-postmessage' + setting.replace( /\[/g, '-' ).replace( /\]/g, '' ) + '"></style>' );
							}
							jQuery( '#kirki-customizer-postmessage' + setting.replace( /\[/g, '-' ).replace( /\]/g, '' ) ).text( css );

						}, 100 );
					});
				}
			});
		});
	});
})( jQuery );
