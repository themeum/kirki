/**
 * KIRKI CONTROL: TYPOGRAPHY
 */
wp.customize.controlConstructor['typography'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
console.log(kirkiAllFonts);
		// Get initial values
		var compiled_value = {};
		compiled_value['font-family']    = ( undefined !== control.setting._value['font-family'] ) ? control.setting._value['font-family'] : '';
		compiled_value['font-size']      = ( undefined !== control.setting._value['font-size'] ) ? control.setting._value['font-size'] : '';
		compiled_value['variant']        = ( undefined !== control.setting._value['variant'] ) ? control.setting._value['variant'] : '';
		compiled_value['line-height']    = ( undefined !== control.setting._value['line-height'] ) ? control.setting._value['line-height'] : '';
		compiled_value['letter-spacing'] = ( undefined !== control.setting._value['letter-spacing'] ) ? control.setting._value['letter-spacing'] : '';
		compiled_value['color']          = ( undefined !== control.setting._value['color'] ) ? control.setting._value['color'] : '';

		// Given a font-family name, this will look for fallbacks
		// in case the existing value is invalid.
		var familyInitialVariant = function(fontFamily) {
			var existingValue = compiled_value['variant'];
			for ( var i = 0, len = kirkiAllFonts.length; i < len; i++ ) {
				if ( fontFamily === kirkiAllFonts[ i ]['family'] ) {
					var variants = kirkiAllFonts[ i ]['variants'];
					// If the selected variant exists in this font, then use it
					if ( undefined !== kirkiAllFonts[ i ]['variants'][ existingValue ] ) {
						var result = existingValue;
					} else {
						for ( var v = 0, len = variants.length; v < len; v++ ) {
							if ( '400' == variants[ v ]['id'] ) {
								var has_regular = true
							} else if ( undefined === first_available_variant ) {
								var first_available_variant = variants[ v ]['id'];
							}
						}
						// select regular if it exists, otherwise fallback to the first available value
						var result = ( undefined !== has_regular ) ? '400' : first_available_variant;
					}
				}
			}
			return ( undefined !== result ) ? result : 'regular';
		}

		// Given a font-family returns all available variants.
		var familyVariants = function(fontFamily) {
			for ( var i = 0, len = kirkiAllFonts.length; i < len; i++ ) {
				if ( fontFamily === kirkiAllFonts[ i ]['family'] ) {
					return kirkiAllFonts[ i ]['variants'];
				}
			}
		}

		/**
		 * Event handler for font-families.
		 */
		var eventHandlerFontFamily = function(newval) {
			return function() {
				console.log(newval);
				console.log(familyVariants( newval ));
				// add the value to the array and set the setting's value
				compiled_value['font-family'] = newval;
				control.setting.set( compiled_value );

				var selector = '#kirki-typography-variant-' + control.id;

				// Get the selected font-variant.
				// This adds fallbacks in case the new font-family
				// does not have the previously selected variant.
				var initial_variant = familyInitialVariant( newval );
				// refresh available variants selectize
				jQuery( selector ).selectize()[0].selectize.destroy();
				var variants_selectize;
				variants_selectize = jQuery( selector ).selectize({
					maxItems:    1,
					valueField:  'id',
					labelField:  'label',
					searchField: ['id', 'label'],
					options:     familyVariants( newval ),
					items:       [ initial_variant ],
					create:      false,
					onChange:    eventHandlerFontVariant( jQuery( selector ).val() ),
					render: {
						item: function(item, escape) { return '<div>' + escape( item.label ) + '</div>'; },
						option: function(item, escape) { return '<div>' + escape( item.label ) + '</div>'; }
					},
				}).data( 'selectize' );

				// refresh the preview
				wp.customize.previewer.refresh();
			};
		};

		/**
		 * Event handler for variants.
		 */
		var eventHandlerFontVariant = function(newval) {
			return function() {
				// add the value to the array and set the setting's value
				compiled_value['variant'] = jQuery( this ).val();
				control.setting.set( compiled_value );
				// refresh the preview
				wp.customize.previewer.refresh();
			};
		};

		/**
		 * font-family
		 */
		if ( control.container.has( '.font-family' ).size() ) {
			var selector = '#kirki-typography-font-family-' + control.id;
			jQuery( selector ).selectize({
				options:     kirkiAllFonts,
				items:       [ control.setting._value['font-family'] ],
				persist:     false,
				maxItems:    1,
				valueField:  'family',
				labelField:  'label',
				searchField: ['family', 'label', 'subsets'],
				create:      false,
				onChange: eventHandlerFontFamily( jQuery( selector ).val() ),
				render: {
					item: function(item, escape) { return '<div>' + escape( item.family ) + '</div>'; },
					option: function(item, escape) { return '<div>' + escape( item.family ) + '</div>'; }
				},
			});

		}

		/**
		 * font-size
		 */
		if ( control.container.has( '.font-size' ).size() ) {
			this.container.on( 'change', '.font-size input', function() {
				// add the value to the array and set the setting's value
				compiled_value['font-size'] = jQuery( this ).val();
				control.setting.set( compiled_value );
				// refresh the preview
				wp.customize.previewer.refresh();
			});
		}

		/**
		 * font-variant
		 */
		if ( control.container.has( '.font-variant' ).size() ) {

			// Get the selected font-variant.
			// This adds fallbacks in case the new font-family
			// does not have the previously selected variant.
			var initial_variant = familyInitialVariant( newval );
			var variants        = familyVariants( newval )
			if ( undefined !== variants ) {
				var selector = '#kirki-typography-variant-' + control.id;
				jQuery( selector ).selectize()[0].selectize.destroy();
				var variants_selectize;
				variants_selectize = jQuery( selector ).selectize({
					maxItems:    1,
					valueField:  'id',
					labelField:  'label',
					searchField: ['id', 'label'],
					options:     variants,
					items:       [ initial_variant ],
					onChange:    eventHandlerFontVariant( jQuery( selector ).val() ),
					create:      false,
					render: {
						item: function(item, escape) { return '<div>' + escape( item.label ) + '</div>'; },
						option: function(item, escape) { return '<div>' + escape( item.label ) + '</div>'; }
					},
				}).data( 'selectize' );
			}
		}

		/**
		 * line-height
		 */
		if ( control.container.has( '.line-height' ).size() ) {
			this.container.on( 'change', '.line-height input', function() {
				// add the value to the array and set the setting's value
				compiled_value['line-height'] = jQuery( this ).val();
				control.setting.set( compiled_value );
				// refresh the preview
				wp.customize.previewer.refresh();
			});
		}

		/**
		 * letter-spacing
		 */
		if ( control.container.has( '.letter-spacing' ).size() ) {
			this.container.on( 'change', '.letter-spacing input', function() {
				// add the value to the array and set the setting's value
				compiled_value['letter-spacing'] = jQuery( this ).val();
				control.setting.set( compiled_value );
				// refresh the preview
				wp.customize.previewer.refresh();
			});
		}

		/**
		 * color
		 */
		if ( control.container.has( '.color' ).size() ) {
			var picker = this.container.find ( '.kirki-color-control' );
			picker.wpColorPicker ( {
				change: function() {
					setTimeout ( function() {
						// add the value to the array and set the setting's value
						compiled_value[ 'color' ] = picker.val ();
						control.setting.set ( compiled_value );
						// refresh the preview
						wp.customize.previewer.refresh ();
					}, 100 );
				}
			} );
		}
	}
});
