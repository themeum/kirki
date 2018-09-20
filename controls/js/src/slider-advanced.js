wp.customize.controlConstructor['kirki-slider-advanced'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function() {
		var control           = this,
			changeAction      = ( 'postMessage' === control.setting.transport ) ? 'mousemove change' : 'change',
			rangeInput        = control.container.find( 'input[type="range"]' ),
			textInput         = control.container.find( 'input[type="text"]' ),
			units             = control.container.find( '.kirki-units-choices input[type="radio"]' ),
			has_units         = units.length > 0,
			use_media_queries = this.params.choices.use_media_queries;
		
		this.active_device = null;
		this.current_unit = null;
		this.rangeInput = rangeInput;
		this.textInput = textInput;
		this.save_tid = 0;
		this.initCompiledValue();
		
		//If there are units for this slider.
		if ( has_units )
		{
			//Load the unit
			if ( use_media_queries )
				units.filter( '[value="' + control.compiled.desktop.unit + '"]' ).prop( 'checked', true );
			else
				units.filter( '[value="' + control.compiled.unit + '"]' ).prop( 'checked', true );
			//No filter was selected from the loading value, so select the first one.
			if ( units.filter ( ':checked' ).length == 0)
			{
				units.first().prop( 'checked', true );
			}
			//Load the initial unit.
			this.change_unit();
			
			//Register the event.
			units.on( 'change', function() {
				control.change_unit();
			});
		}
		else
		{
			console.log(this);
			//if ( this.params
		}
		
		//Setup initial value
		rangeInput.val( use_media_queries ? control.compiled.desktop.value : control.compiled.value );
		textInput.val( use_media_queries ? control.compiled.desktop.value : control.compiled.value );
		
		//If media queries are used, we need to detect device changes.
		if ( use_media_queries )
		{
			this.active_device = 0;
			kirki.util.helpers.media_query( control, this.compiled.use_media_queries, {
				device_change: function( device, enabled )
				{
					control.active_device = device;
					control.compiled.use_media_queries = enabled;
					var selected_unit = null;
					
					units.filter( ':checked' ).prop( 'checked', false );
					
					if ( has_units )
					{
						if ( control.active_device == 0 )
						{
							units.filter( '[value="' + control.compiled.desktop.unit + '"]' ).prop( 'checked', true );
						}
						else if ( control.active_device == 1 )
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
						selected_unit = units.filter ( ':checked' ).val();
					}
					if ( !enabled )
					{
						rangeInput.val( control.compiled.value || 0 );
						textInput.val( control.compiled.value || 0 );
					}
					else if ( control.active_device == 0 )
					{
						rangeInput.val( control.compiled.desktop.value || 0 );
						textInput.val( control.compiled.desktop.value || 0 );
					}
					else if ( control.active_device == 1 )
					{
						rangeInput.val( control.compiled.tablet.value || 0 );
						textInput.val( control.compiled.tablet.value || 0 );
					}
					else
					{
						rangeInput.val( control.compiled.mobile.value || 0 );
						textInput.val( control.compiled.mobile.value || 0 );
					}
					
					control.save( control.active_device, rangeInput.val(), selected_unit );
				}
			});
		}
		
		rangeInput.on( changeAction, function() {
			var val = rangeInput.val();
			var unit = control.current_unit;
			textInput.val( val );
			control.save( control.active_device, val, unit );
		} );
		//input paste change
		
		textInput.on( 'paste change', function() {
			var val = textInput.val(),
				unit = control.current_unit;
				min = rangeInput.attr( 'min' ),
				max = rangeInput.attr( 'max' );
			if ( val > max )
				val = max;
			else if ( val < min )
				val = min;
			rangeInput.attr( 'value', val );
			control.save( control.active_device, val, unit );
		} );
	},
	
	initCompiledValue: function()
	{
		var loadedValue = this.setting._value;
		this.compiled = {
			use_media_queries: loadedValue.use_media_queries || false
		};
		if ( this.params.choices.use_media_queries )
		{
			var desktop_value = 0,
				desktop_unit = '',
				tablet_value = 0,
				tablet_unit = '',
				mobile_value = 0,
				mobile_unit = '';
			if ( this.params.default )
			{
				if ( this.params.default.desktop )
				{
					desktop_value = this.params.default.desktop.value || 0;
					desktop_unit = this.params.default.desktop.unit || '';
				}
				if ( this.params.default.tablet )
				{
					tablet_value = this.params.default.tablet.value || 0;
					tablet_unit = this.params.default.tablet.unit || '';
				}
				if ( this.params.default.mobile )
				{
					mobile_value = this.params.default.mobile.value || 0;
					mobile_unit = this.params.default.mobile.unit || '';
				}
			}
			this.compiled.desktop = loadedValue.desktop || { value: desktop_value, unit: desktop_unit };
			this.compiled.tablet = loadedValue.tablet || { value: tablet_value, unit: tablet_unit };
			this.compiled.mobile = loadedValue.mobile || { value: mobile_value, unit: mobile_unit };
		}
		else
		{
			var default_val = 0,
				default_unit = '';
			if ( this.params.default )
			{
				default_val = this.params.default.value || 0;
				default_unit = this.params.default.unit || '';
			}
			this.compiled.value = loadedValue.value || default_val;
			this.compiled.unit = loadedValue.unit || default_unit;
		}
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
			active_device = this.active_device,
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
			cur_val = max;
			rangeInput.val( max );
			textInput.val( max );
		}
		else if ( cur_val < min )
		{
			cur_val = max;
			rangeInput.val( min );
			textInput.val( min );
		}
		suffix.html( current_unit.val() );
		var unit = current_unit.val();
		this.current_unit = unit;
		this.save( active_device, cur_val, unit );
	},
	
	isset: function( val )
	{
		return val != null && ( val == 0 || val );
	}
} );