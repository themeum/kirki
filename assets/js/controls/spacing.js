/**
 * KIRKI CONTROL: SPACING
 */
wp.customize.controlConstructor['spacing'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		var compiled_value = {};

		jQuery.each( ['top', 'bottom', 'left', 'right'], function( index, dimension ) {

			// get initial values and pre-populate the object
			if ( control.container.has( '.' + dimension ).size() ) {
				compiled_value[ dimension ] = control.setting._value[ dimension ];
				// Validate the value and show a warning if it's invalid
				if ( false === kirkiValidateCSSValue( control.setting._value[ dimension ] ) ) {
					jQuery( control.selector + ' .' + dimension + '.input-wrapper' ).addClass( 'invalid' );
				} else {
					jQuery( control.selector + ' .' + dimension + '.input-wrapper' ).removeClass( 'invalid' );
				}
			}

			if ( control.container.has( '.' + dimension ).size() ) {
				control.container.on( 'change keyup paste', '.' + dimension + ' input', function() {
					subValue = jQuery( this ).val();
					// Validate the value and show a warning if it's invalid
					if ( false === kirkiValidateCSSValue( subValue ) ) {
						jQuery( control.selector + ' .' + dimension + '.input-wrapper' ).addClass( 'invalid' );
					} else {
						jQuery( control.selector + ' .' + dimension + '.input-wrapper' ).removeClass( 'invalid' );
						// only proceed if value is valid
						compiled_value[ dimension ] = subValue;
						control.setting.set( compiled_value );
						wp.customize.previewer.refresh();
					}
				});
			}
		});
	}
});
