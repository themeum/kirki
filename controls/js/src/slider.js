wp.customize.controlConstructor['kirki-slider'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function() {
		var control      = this,
			changeAction = ( 'postMessage' === control.setting.transport ) ? 'mousemove change' : 'change',
			rangeInput   = control.container.find( 'input[type="range"]' ),
			textInput    = control.container.find( 'input[type="text"]' ),
			units        = control.container.find( 'input[data-setting="unit"]' ),
			valueInput   = control.container.find( '.slider-hidden-value' ),
			value        = control.setting._value,
			active_device = 0;
		this.compiled = {
				media_queries: false,
				desktop: {
					value: control.params.default.value || 0,
					unit: control.params.default.unit || ''
				},
				tablet: {
					value: 0,
					unit: ''
				},
				mobile: {
					value: 0,
					unit: ''
				}
			};
		this.input = valueInput;
		if ( this.id == 'test_slider' )
		{
			console.log ( this );
			console.log( value );
		}
		if ( value && typeof value == 'object' )
		{
			compiled = value;
		}
		kirki.util.helpers.media_query( control, this.compiled.media_queries, {
			device_change: function( device, enabled )
			{
				active_device = device;
				control.compiled.media_queries = enabled;
				units.filter( ':checked' ).prop( 'checked', false );
				if ( active_device == 0 )
				{
					units.filter( '[value="' + control.compiled.desktop.unit + '"]' ).prop( 'checked', true );
				}
				else if ( active_device == 1 )
				{
					units.filter( '[value="' + control.compiled.tablet.unit + '"]' ).prop( 'checked', true );
				}
				else
				{
					units.filter( '[value="' + control.compiled.mobile.unit + '"]' ).prop( 'checked', true );
				}
				change_unit();
				if ( active_device == 0 )
				{
					rangeInput.val( control.compiled.desktop.value || 0 );
					textInput.val( control.compiled.desktop.value || 0 );
				}
				else if ( active_device == 1 )
				{
					rangeInput.val( control.compiled.tablet.value || 0 );
					textInput.val( control.compiled.tablet.value || 0 );
				}
				else
				{
					rangeInput.val( control.compiled.mobile.value || 0 );
					textInput.val( control.compiled.mobile.value || 0 );
				}
			}
		});
		
		//Set initial value.
		units.find( '[value="' + control.compiled.desktop.unit + '"]' ).prop( 'checked', true );
		
		if ( units.filter( ':checked' ).length == 0 )
		{
			units.first().prop( 'checked', true );
		}
		
		rangeInput.on( changeAction, function() {
			var val = rangeInput.val();
			textInput.val( val );
			control.save( active_device, val );
		} );
		
		textInput.on( 'input paste change', function() {
			var val = textInput.val();
			rangeInput.attr( 'value', val );
			control.save( active_device, val );
		} );
		
		units.on( 'change', function() {
			var unit = $( this );
			change_unit();
			control.save( active_device, null, unit.val() );
		});
		
		control.container.find( '.slider-reset' ).on( 'click', function() {
			rangeInput.attr( 'value', control.params.default.value || 0 );
			control.save( active_device, rangeInput.val(), control.params.default.unit );
		} );
		
		change_unit();
		
		rangeInput.val( control.compiled.desktop.value || 0 );
		textInput.val( control.compiled.desktop.value || 0 );
		
		function change_unit()
		{
			var unit = units.filter( ':checked' ),
				min  = unit.attr( 'min' ),
				max  = unit.attr( 'max' ),
				step = unit.attr( 'step' );
			rangeInput.attr( 'min', min );
			rangeInput.attr( 'max', max );
			rangeInput.attr( 'step', step );
		}
	},
	
	isset: function( val )
	{
		return val != null && ( val == 0 || val );
	},
	
	save: function( device, value, unit )
	{
		if ( device == 0 )
		{
			if ( this.isset( value ) )
				this.compiled.desktop.value = parseFloat( value );
			if ( this.isset( unit ) )
				this.compiled.desktop.unit = unit;
		}
		else if ( device == 1 )
		{
			if ( this.isset( value ) )
				this.compiled.tablet.value = parseFloat( value );
			if ( this.isset( unit ) )
				this.compiled.tablet.unit = unit;
		}
		else
		{
			if ( this.isset( value ) )
				this.compiled.mobile.value = parseFloat( value );
			if ( this.isset( unit ) )
				this.compiled.mobile.unit = unit;
		}
		this.input.val( JSON.stringify( this.compiled ) ).trigger( 'change' );
		this.setting.set( this.compiled );
	}
} );
