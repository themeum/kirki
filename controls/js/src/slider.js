wp.customize.controlConstructor['kirki-slider'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function() {
		var compiled = {
			desktop: {
				value: 0
			},
			tablet: {
				value: 0
			},
			mobile: {
				value: 0
			}
		};
		var control      = this,
			changeAction = ( 'postMessage' === control.setting.transport ) ? 'mousemove change' : 'change',
			rangeInput   = control.container.find( 'input[type="range"]' ),
			textInput    = control.container.find( 'input[type="text"]' ),
			value        = control.setting._value,
			active_device = 0;
			kirki.util.helpers.media_query( control, {
				device_change: function( device )
				{
					active_device = device;
					if ( active_device == 0)
					{
						textInput.val( compiled.desktop || '' );
						rangeInput.val( compiled.desktop || '' );
					}
					else if ( active_device == 1 )
					{
						textInput.val( compiled.tablet || '' );
						rangeInput.val( compiled.tablet || '' );
					}
					else
					{
						textInput.val( compiled.mobile || '' );
						rangeInput.val( compiled.mobile || '' );
					}
				}
			});
		if ( value )
		{
			if ( this.isset( value.desktop ) )
				compiled.desktop = value.desktop;
			if ( this.isset( value.tablet ) )
				compiled.tablet = value.tablet;
			if ( this.isset ( value.mobile ) )
				compiled.mobile = value.mobile;
			compiled.unit = value.unit;
		}
		// Set the initial value in the text input.
		textInput.attr( 'value', value );

		// If the range input value changes copy the value to the text input.
		rangeInput.on( 'mousemove change', function() {
			var val = rangeInput.val();
			textInput.attr( 'value', val );
			if ( active_device == 0 )
				compiled.destop = val;
			else if ( active_device == 1 )
				compiled.tablet == val;
			else
				compiled.mobile = val;
			//control.setting.set( val );
		} );

		// Save the value when the range input value changes.
		// This is separate from the above because of the postMessage differences.
		// If the control refreshes the preview pane,
		// we don't want a refresh for every change
		// but 1 final refresh when the value is changed.
		rangeInput.on( changeAction, function() {
			var val = rangeInput.val();
			if ( active_device == 0 )
				compiled.destop = val;
			else if ( active_device == 1 )
				compiled.tablet == val;
			else
				compiled.mobile = val;
			//control.setting.set( compiled );
		} );

		// If the text input value changes,
		// copy the value to the range input
		// and then save.
		textInput.on( 'input paste change', function() {
			var val = textInput.val();
			rangeInput.attr( 'value', val );
			if ( active_device == 0 )
			compiled.destop = val;
			else if ( active_device == 1 )
				compiled.tablet == val;
			else
				compiled.mobile = val;
			//control.setting.set( compiled );
		} );

		// If the reset button is clicked,
		// set slider and text input values to default
		// and then save.
		control.container.find( '.slider-reset' ).on( 'click', function() {
			textInput.attr( 'value', control.params.default );
			rangeInput.attr( 'value', control.params.default );
			if ( active_device == 0 )
				compiled.destop = control.params.default;
			else if ( active_device == 1 )
				compiled.tablet == control.params.default;
			else
				compiled.mobile = control.params.default;
			//control.setting.set( compiled );
		} );
	},
	
	isset: function( val )
	{
		return val == 0 || val;
	}
} );
