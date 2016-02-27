/**
 * KIRKI CONTROL: TYPOGRAPHY
 */
wp.customize.controlConstructor['typography'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;

		// Get initial values
		var compiled_value = {};
		compiled_value['font-family']    = ( undefined !== control.setting._value['font-family'] ) ? control.setting._value['font-family'] : '';
		compiled_value['font-size']      = ( undefined !== control.setting._value['font-size'] ) ? control.setting._value['font-size'] : '';
		compiled_value['variant']        = ( undefined !== control.setting._value['variant'] ) ? control.setting._value['variant'] : '';
		compiled_value['line-height']    = ( undefined !== control.setting._value['line-height'] ) ? control.setting._value['line-height'] : '';
		compiled_value['letter-spacing'] = ( undefined !== control.setting._value['letter-spacing'] ) ? control.setting._value['letter-spacing'] : '';
		compiled_value['color']          = ( undefined !== control.setting._value['color'] ) ? control.setting._value['color'] : '';

		/**
		 * Event handler for font-families.
		 */
		var eventHandlerFontFamily = function(newval) {
			return function() {
				// add the value to the array and set the setting's value
				compiled_value['font-family'] = newval;
				control.setting.set( compiled_value );
				// find the selected variant
				for ( var i = 0, len = kirkiAllFonts.length; i < len; i++ ) {
					if ( compiled_value['font-family'] === kirkiAllFonts[ i ]['family'] ) {
						var variants = kirkiAllFonts[ i ]['variants'];
						// Determine the initial value we have to use
						if ( undefined !== kirkiAllFonts[ i ]['variants'][ compiled_value['variant'] ] ) {
							var initial_variant = compiled_value['variant'];
						} else {
							for ( var w = 0, len = variants.length; w < len; w++ ) {
								if ( '400' == variants[ w ]['id'] ) {
									var has_regular = true
								} else if ( undefined === first_available_fw ) {
									var first_available_fw = variants[ w ]['id'];
								}
							}
							// select regular if it exists, otherwise fallback to the first available value
							var initial_variant = ( undefined !== has_regular ) ? '400' : first_available_fw;
						}
						// refresh available variants
						if ( undefined !== variants ) {
							jQuery( '#kirki-typography-variant-' + control.id ).selectize()[0].selectize.destroy();
							var variants_selectize;
							fvariants_selectize = jQuery( '#kirki-typography-variant-' + control.id ).selectize({
								maxItems: 1,
								valueField: 'id',
								labelField: 'label',
								searchField: ['id', 'label'],
								options: variants,
								items: [ initial_variant ],
								create: false,
								onChange: eventHandlerFontVariant( jQuery( '#kirki-typography-variant-' + control.id ).val() )
							}).data( 'selectize' );
						}
					}
				}
				// refresh the preview
				wp.customize.previewer.refresh();
				console.log('lalalalalalalala-font-family');
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
				console.log('lalalalalalalala-font-variant');
			};
		};

		/**
		 * font-family
		 */
		if ( control.container.has( '.font-family' ).size() ) {
			jQuery( '#kirki-typography-font-family-' + control.id ).selectize({
				options:     kirkiAllFonts,
				items:       [ control.setting._value['font-family'] ],
				persist:     false,
				maxItems:    1,
				valueField:  'family',
				labelField:  'label',
				searchField: ['family', 'label', 'subsets'],
				create:      false,
				onChange: eventHandlerFontFamily( jQuery( '#kirki-typography-font-family-' + control.id ).val() ),
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
			// populate this field initially with the variants available for this family.
			for ( var i = 0, len = kirkiAllFonts.length; i < len; i++ ) {
				if ( compiled_value['font-family'] === kirkiAllFonts[ i ]['family'] ) {
					var variants = kirkiAllFonts[ i ]['variants'];
					// Determine the initial value we have to use
					if ( undefined !== kirkiAllFonts[ i ]['variants'][ compiled_value['variant'] ] ) {
						var initial_variant = compiled_value['variants'];
					} else {
						for ( var w = 0, len = variants.length; w < len; w++ ) {
							if ( '400' == variants[ w ]['id'] ) {
								var has_regular = true
							} else if ( undefined === first_available_fw ) {
								var first_available_fw = variants[ w ]['id'];
							}
						}
						// select regular if it exists, otherwise fallback to the first available value
						var initial_variant = ( undefined !== has_regular ) ? '400' : first_available_fw;
					}
					// refresh available variants
					if ( undefined !== variants ) {
						jQuery( '#kirki-typography-variant-' + control.id ).selectize()[0].selectize.destroy();
						var variants_selectize;
						variants_selectize = jQuery( '#kirki-typography-variant-' + control.id ).selectize({
							maxItems: 1,
							valueField: 'id',
							labelField: 'label',
							searchField: ['id', 'label'],
							options: variants,
							items: [ initial_variant ],
							onChange: eventHandlerFontVariant( jQuery( '#kirki-typography-variant-' + control.id ).val() ),
							create: false
						}).data( 'selectize' );
					}
				}
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
