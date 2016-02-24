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

		// bold
		if ( control.container.has( '.font-style' ).size() ) {
			this.container.on( 'click', '.font-style input', function() {
				compiled_value['font-style'] = jQuery( this ).val();
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
		}

		// font-family
		if ( control.container.has( '.font-family' ).size() ) {
			this.container.on( 'change', '.font-family select', function() {
				compiled_value['font-family'] = jQuery( this ).val();
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
		}

		// font-size
		if ( control.container.has( '.font-size' ).size() ) {
			var font_size_numeric_value = control.container.find('.font-size input[type=number]' ).val();
			var font_size_units_value   = control.container.find('.font-size select' ).val();

			this.container.on( 'change', '.font-size input', function() {
				font_size_numeric_value = jQuery( this ).val();
				compiled_value['font-size'] = font_size_numeric_value + font_size_units_value;
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
			this.container.on( 'change', '.font-size select', function() {
				font_size_units_value = jQuery( this ).val();
				compiled_value['font-size'] = font_size_numeric_value + font_size_units_value;
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
		}

		// font-weight
		if ( control.container.has( '.font-weight' ).size() ) {
			this.container.on( 'change', '.font-weight select', function() {
				compiled_value['font-weight'] = jQuery( this ).val();
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
		}

		// line-height
		if ( control.container.has( '.line-height' ).size() ) {
			this.container.on( 'change', '.line-height input', function() {
				compiled_value['line-height'] = jQuery( this ).val();
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
		}

		// letter-spacing
		if ( control.container.has( '.letter-spacing' ).size() ) {
			var letter_spacing_numeric_value = control.container.find('.letter-spacing input[type=number]' ).val();
			var letter_spacing_units_value   = control.container.find('.letter-spacing select' ).val();

			this.container.on( 'change', '.letter-spacing input', function() {
				letter_spacing_numeric_value = jQuery( this ).val();
				compiled_value['letter-spacing'] = letter_spacing_numeric_value + letter_spacing_units_value;
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
			this.container.on( 'change', '.letter-spacing select', function() {
				letter_spacing_units_value = jQuery( this ).val();
				compiled_value['letter-spacing'] = letter_spacing_numeric_value + letter_spacing_units_value;
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
		}

		// color
		if ( control.container.has( '.color' ).size() ) {
			var picker = this.container.find ( '.kirki-color-control' );
			picker.wpColorPicker ( {
				change: function() {
					setTimeout ( function() {
						compiled_value[ 'color' ] = picker.val ();
						control.setting.set ( compiled_value );
						wp.customize.previewer.refresh ();
					}, 100 );
				}
			} );
		}
	}
});
