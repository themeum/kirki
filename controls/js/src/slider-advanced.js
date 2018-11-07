wp.customize.controlConstructor['kirki-slider-advanced'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function() {
		var control           = this,
			changeAction      = ( 'postMessage' === control.setting.transport ) ? 'mousemove change' : 'change',
			rangeInput        = control.container.find( 'input[type="range"]' ),
			textInput         = control.container.find( 'input[type="text"]' ),
			units_radios      = control.container.find( '.kirki-units-choices input[type="radio"]' ),
			resetBtn          = control.container.find( '.slider-reset' ),
			has_units         = units_radios.length > 0,
			use_media_queries = control.params.use_media_queries;
		
		control.selected_device = kirki.util.media_query_devices.global;
		control.selected_unit = '';
		control.rangeInput = rangeInput;
		control.textInput = textInput;
		control.has_units = has_units;
		control.initial_input = false;
		control.initial_media_query = false;
		control.units = [];
		control.use_media_queries = use_media_queries;
		
		units_radios.each(function()
		{
			var radio = $( this );
			control.units.push( radio.val() );
		});
		
		control.initValue();
		control.initMediaQueries();
		
		//If there are units for this slider.
		if ( has_units )
		{
			control.initUnitSelect( units_radios );
			var unit = null;
			//Load the unit
			if ( use_media_queries )
				unit = control.value.desktop.unit;
			else
				unit = control.value.global.unit;
			units_radios.filter( '[value="' + unit + '"]' ).prop( 'checked', true );
			if ( units_radios.filter ( ':checked' ).length == 0)
			{
				var first_unit = units_radios.first();
				first_unit.prop( 'checked', true );
			}
			
			control.selected_unit = units_radios.filter( ':checked' ).val();
		}
		
		control.setRange();
		
		rangeInput.on( changeAction + ' change_visual', function( e ) {
			if ( e.type !== 'change_visual' )
				control.initial_input = true;
			var val = rangeInput.val();
			textInput.val( val );
			control.setValue( val );
			control.save();
		} );
		
		//input paste change
		textInput.on( 'paste change change_visual', function( e ) {
			if ( e.type !== 'change_visual' )
				control.initial_input = true;
			var val = textInput.val(),
				min = rangeInput.attr( 'min' ),
				max = rangeInput.attr( 'max' );
			if ( val > max )
				val = max;
			else if ( val < min )
				val = min;
			rangeInput.attr( 'value', val );
			control.setValue( val );
			control.save();
		} );
		
		resetBtn.click( function()
		{
			control.value[control.getSelectedDeviceName()].loaded = false;
			control.initValue();
			control.rangeInput.trigger( 'change_visual' );
		});
		
		control.rangeInput.trigger( changeAction );
	},
	initValue: function()
	{
		var control = this,
			loadedValue = control.setting._value;
		control.value = {
			use_media_queries: loadedValue.use_media_queries || false,
			global: control.defaultValue(),
			desktop: control.defaultValue(),
			tablet: control.defaultValue(),
			mobile: control.defaultValue()
		};
		
		if ( loadedValue.use_media_queries )
		{
			kirki.util.media_query_device_names.forEach( function( name )
			{
				if ( !control.value[name].loaded && loadedValue[name] )
				{
					var parsed = control.parseValue( loadedValue[name] );
					control.value[name]['value'] = parsed['value'];
					control.value[name]['unit'] = parsed['unit'];
					control.value[name]['loaded'] = true;
				}
			});
			if ( loadedValue['desktop'] )
				control.value['global'] = control.value['desktop'];
		}
		else
		{
			if ( !control.value['global'].loaded && loadedValue['global'] )
			{
				var parsed = control.parseValue( loadedValue['global'] );
				control.value['global']['value'] = parsed['value'];
				control.value['global']['unit'] = parsed['unit'];
				control.value['global']['loaded'] = true;
			}
		}
		var id = control.value.use_media_queries ? 'desktop' : 'global';
		var value = control.value[id].value;
		control.setRange();
		if ( !control.value[id].loaded && control.params.default )
		{
			if ( !_.isUndefined ( control.params.default ) )
			{
				value = parseFloat( control.params.default );
				var min = control.rangeInput.attr( 'min' ),
					max = control.rangeInput.attr( 'max' );
				if ( value > max )
					value = max;
				else if ( value < min )
					value = min;
			}
			else
				value = control.rangeInput.attr( 'max' );
		}
		if ( !value )
			value = control.rangeInput.attr( 'max' );
		if ( control.has_units )
		{
			if ( value )
				value = value.toString().replace( control.textFindRegex, '' );
		}
		control.rangeInput.val( value );
		control.textInput.val( value );
	},
	
	initMediaQueries: function()
	{
		var control = this,
			units_radios = control.container.find( '.kirki-units-choices input[type="radio"]' );
		//If media queries are used, we need to detect device changes.
		if ( control.params.use_media_queries )
		{
			kirki.util.helpers.media_query( control, control.value.use_media_queries, {
				device_change: function( device, enabled )
				{
					control.selected_device = device;
					control.value.use_media_queries = enabled;
					var value = null,
						unit = null;
					if ( enabled && !control.initial_media_query )
					{
						var choices = control.params.choices,
							range = choices.units ? choices.units[control.selected_unit] : control.params.choices;
						
						kirki.util.media_query_device_names.forEach( function( name )
						{
							if ( !control.value[name].value )
							{
								control.value[name].value = control.params.default || range['min'];
								control.value[name].unit = control.selected_unit;
							}
						});
					}
					if ( enabled )
						control.value.desktop = control.value.global;
					if ( !enabled )
					{
						control.value.global = control.value.desktop;
						value = control.value.global.value;
						unit = control.value.global.unit;
					}
					else if ( device == kirki.util.media_query_devices.desktop )
					{
						value = control.value.desktop.value;
						unit = control.value.desktop.unit;
					}
					else if ( device == kirki.util.media_query_devices.tablet )
					{
						value = control.value.tablet.value;
						unit = control.value.tablet.unit;
					}
					else if ( device == kirki.util.media_query_devices.mobile )
					{
						value = control.value.mobile.value;
						unit = control.value.mobile.unit;
					}
					
					if ( control.has_units )
					{
						if ( unit && unit.length > 0 )
						{
							units_radios.filter( ':checked' ).prop( 'checked', false );
							units_radios.filter( '[value="' + unit + '"]' ).prop( 'checked', true );
							if ( units_radios.filter ( ':checked' ).length == 0 )
								units_radios.first().click();
							control.selected_unit = units_radios.filter ( ':checked' ).val();
						}
					}
					control.setRange();
					control.setValue( value );
					control.save();
					control.initial_media_query = true;
				}
			});
		}
	},
	  
	initUnitSelect: function( units )
	{
		var control = this;
		units.on( 'change', function()
		{
			var selected = $( this );
			control.selected_unit = selected.val();
			control.setRange();
			
			var defs = control.params.default;
			if ( !control.value[control.getSelectedDeviceName()].loaded && !control.initial_input && control.params.default )
			{
				var value = '';
				if ( typeof defs === 'object' && defs[control.selected_unit] )
				{
					value = defs[control.selected_unit].replace( control.textFindRegex, '' );
				}
				else
				{
					value = control.parseValue( defs );
					
					if ( value['value'] )
						value = value['value'];
					else
						value = control.rangeInput.attr( 'max' );
				}
				control.rangeInput.val( value );
				control.textInput.val( value );
			}
			
			control.rangeInput.trigger( 'change_visual' );
		});
	},
	
	setValue: function( value )
	{
		var control = this,
			device = control.getSelectedDeviceName();
		
		control.rangeInput.val( value );
		control.textInput.val( value );
		control.value[device]['value'] = value;
		control.value[device]['unit'] = control.selected_unit;
	},
	
	getSelectedDeviceName: function()
	{
		var control = this,
			device = 'global';
		if ( control.selected_device == kirki.util.media_query_devices.desktop )
			device = 'desktop';
		else if ( control.selected_device == kirki.util.media_query_devices.tablet )
			device = 'tablet';
		else if ( control.selected_device == kirki.util.media_query_devices.mobile )
			device = 'mobile';
		return device;
	},
	
	setRange: function()
	{
		var control = this,
			choices = control.params.choices,
			unit = choices.units ? ( control.selected_unit || Object.keys( choices.units )[0] ) : '',
			rangeInput = control.rangeInput,
			textInput = control.textInput,
			suffixElement = control.container.find( '.suffix' );
		
		var range = choices.units ? choices.units[unit] : control.params.choices,
			min = range['min'],
			max = range['max'],
			step = range['step'],
			suffix = choices.units ? unit : ( range['suffix'] || '' ),
			val = rangeInput.val();
		
		rangeInput.attr( 'min', min ).attr( 'max', max ).attr( 'step', step );
		suffixElement.html( suffix );
		var range_clamp = val > max || val < min;
		if ( val > max )
			val = max;
		else if ( val < min )
			val = min;
		if ( range_clamp )
		{
			rangeInput.val( val );
			textInput.val( val );
		}
	},
	
	save: function()
	{
		var control = this,
			input  = control.container.find( '.spacing-hidden-value' ),
			compiled = jQuery.extend( {}, control.value );
		delete compiled.loaded;
		if ( compiled.use_media_queries )
		{
			compiled.desktop = compiled.desktop.value + compiled.desktop.unit;
			compiled.tablet = compiled.tablet.value + compiled.tablet.unit;
			compiled.mobile = compiled.mobile.value + compiled.mobile.unit;
			
			delete compiled.desktop.loaded;
			delete compiled.tablet.loaded;
			delete compiled.mobile.loaded;
		}
		else
		{
			delete compiled.desktop;
			delete compiled.tablet;
			delete compiled.mobile;
			delete compiled.global.loaded;
			
			compiled.global = compiled.global.value + compiled.global.unit;
		}
		delete compiled.value;
		input.attr( 'value', JSON.stringify( compiled ) ).trigger( 'change' );
		control.setting.set( compiled );
	},
	
	parseValue: function( value )
	{
		var control = this,
			parser = /(\d+)(\w+|.)/gm;
		var parsed = parser.exec( value );
		if ( !parsed || parsed.length < 2 )
		{
			if ( !Number.isNaN( value ) )
				return { value: value, unit: '' };
			else
				return { value: 0, unit: '' };
		}
		return {
			value: parsed[1] || '',
			unit: parsed[2] || ''
		};
	},
	
	defaultValue: function()
	{
		return { value: '', unit: '', loaded: false };
	},
} );