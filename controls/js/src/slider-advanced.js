wp.customize.controlConstructor['kirki-slider-advanced'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function() {
		var control       = this,
			changeAction  = ( 'postMessage' === control.setting.transport ) ? 'mousemove change' : 'change',
			rangeInput    = control.container.find( 'input[type="range"]' ),
			textInput     = control.container.find( 'input[type="text"]' ),
			units         = control.container.find( '.kirki-units-choices input[type="radio"]' ),
			media_queries = this.params.choices.media_queries,
			active_device = null;
		
		this.save_tid = 0;
		this.initCompiledValue();
		
		//Load the unit
		if ( media_queries )
			units.filter( '[value="' + control.compiled.desktop.unit + '"]' ).prop( 'checked', true );
		else
			units.filter( '[value="' + control.unit + '"]' ).prop( 'checked', true );
		
		//No filter was selected from the loading value, so select the first one.
		if ( units.filter ( ':checked' ).length == 0)
		{
			units.first().prop( 'checked', true );
			control.save( active_device, null, unit );
		}
		
		this.change_unit();
		
		rangeInput.val( media_queries ? control.compiled.desktop.value : control.compiled.value );
		textInput.val( media_queries ? control.compiled.desktop.value : control.compiled.value );
		
		if ( media_queries )
		{
			active_device = 0;
			kirki.util.helpers.media_query( control, true, {
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
					if ( units.filter ( ':checked' ).length == 0 )
						units.first().click();	
					control.change_unit();
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
					
					control.save( active_device, rangeInput.val(), units.filter ( ':checked' ).val() );
				}
			});
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
			var unit = $( this ).val();
			control.change_unit();
		});
	},
	
	initCompiledValue: function()
	{
		var loadedValue = this.setting._value;
		// if ( this.setting.id == 'test_slider' );
		// 	console.log(this.setting._value);
		this.compiled = {
			media_queries: false
		};
		if ( this.params.choices.media_queries )
		{
			this.compiled.media_queries = loadedValue.media_queries;
			this.compiled.desktop = loadedValue.desktop || { value: 0, unit: '' };
			this.compiled.tablet = loadedValue.tablet || { value: 0, unit: '' };
			this.compiled.mobile = loadedValue.mobile || { value: 0, unit: '' };
		}
		else
		{
			this.compiled.value = loadedValue.value || 0;
			this.compiled.unit = loadedValue.unit || '';
		}
		// if ( this.setting.id == 'test_slider' );
		// 	console.log(this.compiled);
	},
	
	save: function( device, value, unit )
	{
		var self = this;
		clearTimeout( this.save_tid );
		this.save_tid = setTimeout( function()
		{
			var input = self.container.find( '.slider-hidden-value' );
			if ( device == null )
			{
				if ( self.isset( value ) )
					self.compiled.value = parseFloat( value );
				if ( self.isset( unit ) )
					self.compiled.unit = unit;
			}
			else if ( device == 0 )
			{
				if ( self.isset( value ) )
					self.compiled.desktop.value = parseFloat( value );
				if ( self.isset( unit ) )
					self.compiled.desktop.unit = unit;
			}
			else if ( device == 1 )
			{
				if ( self.isset( value ) )
					self.compiled.tablet.value = parseFloat( value );
				if ( self.isset( unit ) )
					self.compiled.tablet.unit = unit;
			}
			else
			{
				if ( self.isset( value ) )
					self.compiled.mobile.value = parseFloat( value );
				if ( self.isset( unit ) )
					self.compiled.mobile.unit = unit;
			}
			input.val( JSON.stringify( self.compiled ) ).trigger( 'change' );
			self.setting.set( self.compiled );
		}, 100 );
	},
	
	change_unit: function()
	{
		var units = this.container.find( '.kirki-units-choices input[type="radio"]' ),
			textInput = this.container.find( 'input[type="text"]' ),
			rangeInput = this.container.find( 'input[type="range"]' ),
			suffix = this.container.find( 'span.suffix' ),
			current_unit = units.filter( ':checked' ),
			min  = current_unit.attr( 'min' ),
			max  = current_unit.attr( 'max' ),
			step = current_unit.attr( 'step' );
		var cur_val = rangeInput.val();
		rangeInput.attr( 'min', min );
		rangeInput.attr( 'max', max );
		rangeInput.attr( 'step', step );
		if ( cur_val > max )
		{
			rangeInput.val( max );
			textInput.val( max );
		}
		else if ( cur_val < min )
		{
			rangeInput.val( min );
			textInput.val( min );
		}
		rangeInput.trigger( 'change' );
		suffix.html( current_unit.val() );
	},
	
	isset: function( val )
	{
		return val != null && ( val == 0 || val );
	}
} );
