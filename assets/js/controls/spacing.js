/**
 * KIRKI CONTROL: SPACING
 */
wp.customize.controlConstructor.spacing = wp.customize.Control.extend({

	ready: function() {

		var control = this,
		    compiledValue = {};

		jQuery.each( ['top', 'bottom', 'left', 'right'], function( index, dimension ) {

			// Get initial values and pre-populate the object.
			if ( control.container.has( '.' + dimension ).size() ) {

				compiledValue[ dimension ] = control.setting._value[ dimension ];

				// Validate the value and show a warning if it's invalid.
				jQuery( control.selector + ' .' + dimension + '.input-wrapper' ).removeClass( 'invalid' );
				if ( false === kirkiValidateCSSValue( control.setting._value[ dimension ] ) ) {
					jQuery( control.selector + ' .' + dimension + '.input-wrapper' ).addClass( 'invalid' );
				}

			}

			if ( control.container.has( '.' + dimension ).size() ) {

				control.container.on( 'change keyup paste', '.' + dimension + ' input', function() {

					var subValue = jQuery( this ).val();

					// Validate the value and show a warning if it's invalid.
					if ( false === kirkiValidateCSSValue( subValue ) ) {

						jQuery( control.selector + ' .' + dimension + '.input-wrapper' ).addClass( 'invalid' );

					} else {

						jQuery( control.selector + ' .' + dimension + '.input-wrapper' ).removeClass( 'invalid' );

						// Only proceed if value is valid.
						compiledValue[ dimension ] = subValue;
						control.setting.set( compiledValue );
						wp.customize.previewer.refresh();

					}

				});

			}

		});

	}

});
