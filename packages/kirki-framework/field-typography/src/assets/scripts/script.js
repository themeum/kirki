/* global kirkiTypographyControls, kirkiGoogleFonts */
function kirkiTypographyCompositeControlFontProperties( id, value ) {
	var control, isGoogle, fontWeights, hasItalics, fontWeightControl, fontStyleControl, closest;
	
	control           = wp.customize.control( id );
	value             = value || control.setting.get();
	isGoogle          = value['font-family'] && kirkiGoogleFonts.items[ value['font-family'] ];
	fontWeights       = [ 400, 700 ];
	hasItalics        = ! isGoogle;
	fontWeightControl = wp.customize.control( id + '[font-weight]' );
	fontStyleControl  = wp.customize.control( id + '[font-style]' );

	if ( isGoogle ) {
		/**
		 * Get font-weights from google-font variants.
		 */
		fontWeights = [];
		_.each( kirkiGoogleFonts.items[ value['font-family'] ].variants, function( variant ) {
			if ( -1 !== variant.indexOf( 'i' ) ) {
				hasItalics = true;
			}
			variant = 'regular' === variant || 'italic' === variant ? 400 : parseInt( variant );
			if ( -1 === fontWeights.indexOf( variant ) ) {
				fontWeights.push( parseInt( variant ) );
			}
		});

		/**
		 * If the selected font-family doesn't support the selected font-weight, switch to a supported one.
		 */
		if ( -1 ===fontWeights.indexOf( parseInt( value['font-weight'] ) ) ) {
			
			// Find the font-weight closest to our previous value.
			closest = fontWeights.reduce( function( prev, curr ) {
				return ( Math.abs( curr - parseInt( value['font-weight'] ) ) < Math.abs( prev - parseInt( value['font-weight'] ) ) ? curr : prev );
			});
			fontWeightControl.setting.set( closest.toString() );
		}

		/**
		 * If there's only 1 font-weight to choose from, we can hide the control.
		 */
		if ( 1 === fontWeights.length ) {
			fontWeightControl.deactivate;
		} else {
			fontWeightControl.activate();
		}

		/**
		 * Hide/show font-weight options depending on which are available for this font-family.
		 */
		_.each( [ 100, 200, 300, 400, 500, 600, 700, 800, 900 ], function( weight ) {
			if ( -1 !== fontWeights.indexOf( weight ) ) {
				fontWeightControl.container.find( '[for="' + id + '[font-weight]' + weight + '"]' ).show();
			} else {
				fontWeightControl.container.find( '[for="' + id + '[font-weight]' + weight + '"]' ).hide();
			}
		});

		/**
		 * If the user has selected italics but italics are not available for this font-family, switch to normal.
		 */
		if ( ! hasItalics && 'italic' === fontStyleControl.setting.get() ) {
			fontStyleControl.setting.set( 'normal' );
		}
	}

	wp.hooks.addAction(
		'kirki.dynamicControl.initKirkiControl',
		'kirki',
		function( controlInit ) {
			if ( id + '[font-weight]' === controlInit.id ) {
				_.each( [ 100, 200, 300, 400, 500, 600, 700, 800, 900 ], function( weight ) {
					if ( -1 !== fontWeights.indexOf( weight ) ) {
						fontWeightControl.container.find( '[for="' + id + '[font-weight]' + weight + '"]' ).show();
					} else {
						fontWeightControl.container.find( '[for="' + id + '[font-weight]' + weight + '"]' ).hide();
					}
				});		
			}
		}
	);
}

jQuery( document ).ready( function() {
	_.each( kirkiTypographyControls, function( id ) {
		kirkiTypographyCompositeControlFontProperties( id );
		wp.customize( id, function( value ) {
			value.bind( function( newval ) {
				kirkiTypographyCompositeControlFontProperties( id, newval );
			});
		});
	});
});
