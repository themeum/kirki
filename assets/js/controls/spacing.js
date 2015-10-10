/**
 * KIRKI CONTROL: SPACING
 */
wp.customize.controlConstructor['spacing'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		var compiled_value = {};

		// get initial values and pre-populate the object
		if ( control.container.has( '.top' ).size() ) {
			compiled_value['top'] = control.setting._value['top'];
		}
		if ( control.container.has( '.bottom' ).size() ) {
			compiled_value['bottom'] = control.setting._value['bottom'];
		}
		if ( control.container.has( '.left' ).size() ) {
			compiled_value['left']  = control.setting._value['left'];
		}
		if ( control.container.has( '.right' ).size() ) {
			compiled_value['right']    = control.setting._value['right'];
		}

		// use selectize
		jQuery( '.customize-control-spacing select' ).selectize();

		// top
		if ( control.container.has( '.top' ).size() ) {
			var top_numeric_value = control.container.find('.top input[type=number]' ).val();
			var top_units_value   = control.container.find('.top select' ).val();

			this.container.on( 'change', '.top input', function() {
				top_numeric_value = jQuery( this ).val();
				compiled_value['top'] = top_numeric_value + top_units_value;
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
			this.container.on( 'change', '.top select', function() {
				top_units_value = jQuery( this ).val();
				compiled_value['top'] = top_numeric_value + top_units_value;
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
		}

		// bottom
		if ( control.container.has( '.bottom' ).size() ) {
			var bottom_numeric_value = control.container.find('.bottom input[type=number]' ).val();
			var bottom_units_value   = control.container.find('.bottom select' ).val();

			this.container.on( 'change', '.bottom input', function() {
				bottom_numeric_value = jQuery( this ).val();
				compiled_value['bottom'] = bottom_numeric_value + bottom_units_value;
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
			this.container.on( 'change', '.bottom select', function() {
				bottom_units_value = jQuery( this ).val();
				compiled_value['bottom'] = bottom_numeric_value + bottom_units_value;
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
		}

		// left
		if ( control.container.has( '.left' ).size() ) {
			var left_numeric_value = control.container.find('.left input[type=number]' ).val();
			var left_units_value   = control.container.find('.left select' ).val();

			this.container.on( 'change', '.left input', function() {
				left_numeric_value = jQuery( this ).val();
				compiled_value['left'] = left_numeric_value + left_units_value;
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
			this.container.on( 'change', '.left select', function() {
				left_units_value = jQuery( this ).val();
				compiled_value['left'] = left_numeric_value + left_units_value;
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
		}

		// right
		if ( control.container.has( '.right' ).size() ) {
			var right_numeric_value = control.container.find('.right input[type=number]' ).val();
			var right_units_value   = control.container.find('.right select' ).val();

			this.container.on( 'change', '.right input', function() {
				right_numeric_value = jQuery( this ).val();
				compiled_value['right'] = right_numeric_value + right_units_value;
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
			this.container.on( 'change', '.right select', function() {
				right_units_value = jQuery( this ).val();
				compiled_value['right'] = right_numeric_value + right_units_value;
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
		}
	}
});
