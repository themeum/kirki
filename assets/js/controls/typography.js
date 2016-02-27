/**
 * KIRKI CONTROL: TYPOGRAPHY
 */
wp.customize.controlConstructor['typography'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		var compiled_value = {};

		// get initial values and pre-populate the object
		if ( control.container.has( '.font-style' ).size() ) {
			compiled_value['font-style']     = control.setting._value['font-style'];
		}
		if ( control.container.has( '.font-family' ).size() ) {

			jQuery('#kirki-typography-font-family-' + control.id ).selectize({
				options:     kirkiAllFonts,
				items:       [ control.setting._value['font-family'] ],
				persist:     false,
				maxItems:    1,
				valueField:  'family',
				labelField:  'label',
				searchField: ['family', 'label', 'subsets'],
				create:      false,
				render: {
					item: function(item, escape) {
						return '<div>' + escape( item.family ) + '</div>';
					},
					option: function(item, escape) {
						return '<div>' + escape( item.family ) + '</div>';
					}
				},
			});

			compiled_value['font-family']    = control.setting._value['font-family'];
		}
		if ( control.container.has( '.font-size' ).size() ) {
			compiled_value['font-size']      = control.setting._value['font-size'];
		}
		if ( control.container.has( '.font-weight' ).size() ) {
			compiled_value['font-weight']    = control.setting._value['font-weight'];
		}
		if ( control.container.has( '.line-height' ).size() ) {
			compiled_value['line-height']    = control.setting._value['line-height'];
		}
		if ( control.container.has( '.letter-spacing' ).size() ) {
			compiled_value['letter-spacing'] = control.setting._value['letter-spacing'];
		}
		if ( control.container.has( '.color' ).size() ) {
			compiled_value['color'] = control.setting._value['color'];
		}

		// use selectize
		jQuery( '.customize-control-typography select' ).selectize();

		// font-style
		if ( control.container.has( '.font-style' ).size() ) {
			this.container.on( 'click', '.font-style input', function() {
				// add the value to the array and set the setting's value
				compiled_value['font-style'] = jQuery( this ).val();
				control.setting.set( compiled_value );
				// refresh the preview
				wp.customize.previewer.refresh();
			});
		}

		// font-family
		if ( control.container.has( '.font-family' ).size() ) {
			this.container.on( 'change', '.font-family select', function() {
				// add the value to the array and set the setting's value
				compiled_value['font-family'] = jQuery( this ).val();
				control.setting.set( compiled_value );
				// find the font-weights of this family
				for ( var i = 0, len = kirkiAllFonts.length; i < len; i++ ) {
					if ( compiled_value['font-family'] === kirkiAllFonts[ i ]['family'] ) {
						var font_weights = kirkiAllFonts[ i ]['font-weights'];
						// Determine the initial value we have to use
						if ( undefined !== kirkiAllFonts[ i ]['font-weights'][ compiled_value['font-weight'] ] ) {
							var initial_fw = compiled_value['font-weight'];
						} else {
							for ( var w = 0, len = font_weights.length; w < len; w++ ) {
								if ( '400' == font_weights[ w ]['id'] ) {
									var has_regular = true
								} else if ( undefined === first_available_fw ) {
									var first_available_fw = font_weights[ w ]['id'];
								}
							}
							// select regular if it exists, otherwise fallback to the first available value
							var initial_fw = ( undefined !== has_regular ) ? '400' : first_available_fw;
						}
						// refresh available font-weights
						if ( undefined !== font_weights ) {
							jQuery( '#kirki-typography-font-weight-' + control.id ).selectize()[0].selectize.destroy();
							var font_weights_refresh;
							font_weights_refresh = jQuery( '#kirki-typography-font-weight-' + control.id ).selectize({
								maxItems: 1,
								valueField: 'id',
								labelField: 'label',
								searchField: ['id', 'label'],
								options: font_weights,
								items: [ initial_fw ],
								create: false
							}).data( 'selectize' );
						}
					}
				}

				// refresh the preview
				wp.customize.previewer.refresh();
			});
		}

		// font-size
		if ( control.container.has( '.font-size' ).size() ) {
			var font_size_numeric_value = control.container.find('.font-size input[type=number]' ).val();
			var font_size_units_value   = control.container.find('.font-size select' ).val();

			this.container.on( 'change', '.font-size input', function() {
				font_size_numeric_value = jQuery( this ).val();
				// add the value to the array and set the setting's value
				compiled_value['font-size'] = font_size_numeric_value + font_size_units_value;
				control.setting.set( compiled_value );
				// refresh the preview
				wp.customize.previewer.refresh();
			});
			this.container.on( 'change', '.font-size select', function() {
				font_size_units_value = jQuery( this ).val();
				// add the value to the array and set the setting's value
				compiled_value['font-size'] = font_size_numeric_value + font_size_units_value;
				control.setting.set( compiled_value );
				// refresh the preview
				wp.customize.previewer.refresh();
			});
		}

		// font-weight
		if ( control.container.has( '.font-weight' ).size() ) {
			// populate this field initially with the font-weights available for this family.
			for ( var i = 0, len = kirkiAllFonts.length; i < len; i++ ) {
				if ( compiled_value['font-family'] === kirkiAllFonts[ i ]['family'] ) {
					var font_weights = kirkiAllFonts[ i ]['font-weights'];
					// Determine the initial value we have to use
					if ( undefined !== kirkiAllFonts[ i ]['font-weights'][ compiled_value['font-weight'] ] ) {
						var initial_fw = compiled_value['font-weight'];
					} else {
						for ( var w = 0, len = font_weights.length; w < len; w++ ) {
							if ( '400' == font_weights[ w ]['id'] ) {
								var has_regular = true
							} else if ( undefined === first_available_fw ) {
								var first_available_fw = font_weights[ w ]['id'];
							}
						}
						// select regular if it exists, otherwise fallback to the first available value
						var initial_fw = ( undefined !== has_regular ) ? '400' : first_available_fw;
					}
					// refresh available font-weights
					if ( undefined !== font_weights ) {
						jQuery( '#kirki-typography-font-weight-' + control.id ).selectize()[0].selectize.destroy();
						var font_weights_initial;
						font_weights_initial = jQuery( '#kirki-typography-font-weight-' + control.id ).selectize({
							maxItems: 1,
							valueField: 'id',
							labelField: 'label',
							searchField: ['id', 'label'],
							options: font_weights,
							items: [ initial_fw ],
							create: false
						}).data( 'selectize' );
					}
				}
			}
			this.container.on( 'change', '.font-weight select', function() {
				// add the value to the array and set the setting's value
				compiled_value['font-weight'] = jQuery( this ).val();
				control.setting.set( compiled_value );
				// refresh the preview
				wp.customize.previewer.refresh();
			});
		}

		// line-height
		if ( control.container.has( '.line-height' ).size() ) {
			this.container.on( 'change', '.line-height input', function() {
				// add the value to the array and set the setting's value
				compiled_value['line-height'] = jQuery( this ).val();
				control.setting.set( compiled_value );
				// refresh the preview
				wp.customize.previewer.refresh();
			});
		}

		// letter-spacing
		if ( control.container.has( '.letter-spacing' ).size() ) {
			var letter_spacing_numeric_value = control.container.find('.letter-spacing input[type=number]' ).val();
			var letter_spacing_units_value   = control.container.find('.letter-spacing select' ).val();

			this.container.on( 'change', '.letter-spacing input', function() {
				letter_spacing_numeric_value = jQuery( this ).val();
				// add the value to the array and set the setting's value
				compiled_value['letter-spacing'] = letter_spacing_numeric_value + letter_spacing_units_value;
				control.setting.set( compiled_value );
				// refresh the preview
				wp.customize.previewer.refresh();
			});
			this.container.on( 'change', '.letter-spacing select', function() {
				letter_spacing_units_value = jQuery( this ).val();
				// add the value to the array and set the setting's value
				compiled_value['letter-spacing'] = letter_spacing_numeric_value + letter_spacing_units_value;
				control.setting.set( compiled_value );
				// refresh the preview
				wp.customize.previewer.refresh();
			});
		}

		// color
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
