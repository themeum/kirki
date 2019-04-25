/* global kirkiTypographyControls, kirkiGoogleFonts */

var kirkiTypographyCompositeControlFontProperties = function( id, value ) {
	var control, isGoogle, fontWeights, hasItalics, fontWeightControl, fontStyleControl;
	
	control           = wp.customize.control( id );
	value             = value || control.setting.get();
	isGoogle          = value['font-family'] && kirkiGoogleFonts.items[ value['font-family'] ];
	fontWeights       = [ 400, 700 ];
	hasItalics        = ! isGoogle;
	fontWeightControl = wp.customize.control( id + '[font-weight]' );
	fontStyleControl  = wp.customize.control( id + '[font-style]' );

	if ( isGoogle ) {
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

		_.each( [ 100, 200, 300, 400, 500, 600, 700, 800, 900 ], function( weight ) {
			if ( -1 !== fontWeights.indexOf( weight ) ) {
				fontWeightControl.container.find( '[for="' + id + '[font-weight]' + weight + '"]' ).show();
			} else {
				fontWeightControl.container.find( '[for="' + id + '[font-weight]' + weight + '"]' ).hide();
			}
		});
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
			} else if ( id + '[font-style]' === controlInit.id ) {
				if ( hasItalics ) {
					fontStyleControl.activate();
				} else {
					fontStyleControl.deactivate();
				}
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
			} );
		} );
		
	});
});
