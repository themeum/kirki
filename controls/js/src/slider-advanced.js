wp.customize.controlConstructor['kirki-slider-advanced'] = wp.customize.kirkiDynamicControl.extend( {
	initKirkiControl: function() {
		'use strict';
		
		if ( this.params.use_media_queries )
		{
			this.container.addClass( 'has-switchers' );
		}
		
		this.normalizeDefault();
		this.initSlider();
	},
	
	normalizeDefault: function() {
		var val_unit_arr = function( value, unit )
		{
			return {
				value: value,
				unit: unit
			};
		};
		
		var value           = this.setting._value,
			is_value_object = typeof value === 'object',
			has_units       = !_.isUndefined( this.params.choices.units ),
			default_unit    = '';
			if ( has_units )
			{
				if ( _.isUndefined( this.params.choices.min ) &&
					_.isUndefined( this.params.choices.max ) &&
					_.isUndefined( this.params.choices.step ) )
					default_unit = Object.keys( this.params.choices.units )[0];
				else
					default_unit = this.params.choices.units[0];
			}
		
		if ( this.params.use_media_queries )
		{
			if ( has_units && !is_value_object )
			{
				new_value = {};
				new_value[kirki.util.media_query_devices.desktop] = val_unit_arr( value, default_unit );
				new_value[kirki.util.media_query_devices.tablet]  = val_unit_arr( value, default_unit );
				new_value[kirki.util.media_query_devices.mobile]  = val_unit_arr( value, default_unit );
				value = new_value;
			}
			else
			{
				if ( !is_value_object )
				{
					new_value = {};
					new_value[kirki.util.media_query_devices.desktop] = value;
					new_value[kirki.util.media_query_devices.tablet]  = value;
					new_value[kirki.util.media_query_devices.mobile]  = value;
					value = new_value;
				}
			}
		}
		else
		{
			if ( has_units && !is_value_object )
			{
				value = val_unit_arr( value, default_unit );
			}
		}
		
		this.setting._value = value;
	},
	
	initSlider: function()
	{
		var control           = this,
			has_units         = !_.isUndefined( control.params.choices.units );
			changeAction      = ( 'postMessage' === control.setting.transport ) ? 'mousemove change' : 'change',
			value             = control.setting._value;
			
		var wrappers = kirki.util.helpers.setupMediaQueries( control );
		
		_.each( wrappers.devices, function( device_wrappers )
		{
			var device_wrapper = $( device_wrappers[0] );
			var rangeInput   = device_wrapper.find( 'input[type="range"]' ),
				textInput    = device_wrapper.find( 'input[type="text"]' ),
				suffix       = device_wrapper.find( '.suffix' );
				device       = device_wrapper.attr( 'device' ) || 'desktop',
				device_val   = control.params.default,
				range        = control.params.choices,
				device_unit  = null;
			
			if ( !_.isUndefined( value[device] ) )
			{
				device_val = has_units ? value[device]['value'] : value[device];
				if ( has_units )
					device_unit = value[device]['unit'];
			}
			else if ( has_units || typeof value === 'object' )
			{
				device_val  = value['value'];
				device_unit = value['unit'];
			}
			else if ( !Number.isNaN( value ) )
			{
				device_val = value;
			}
			else
			{
				if ( has_units )
				{
					device_val  = control.params.default['value'];
					device_unit = control.params.default['unit'];
				}
				else
				{
					device_val = control.params.default;
				}
			}
			
			// Set the initial value/ranges/events.
			if ( has_units )
			{
				var unit_wrapper = wrappers.units[device];
				range = control.params.choices['units'][device_unit];
				if ( _.isUndefined( range ) )
					range = control.params.choices;
				kirki.util.helpers.selectUnit( unit_wrapper, device_unit );
				
				unit_wrapper.find ( '.kirki-unit-choice input[type="radio"]').on ( 'change', function( e )
				{
					var $this = $( this ),
						unit  = $this.val(),
						range = control.params.choices['units'][unit];
					if ( _.isUndefined( range ) )
						range = control.params.choices;
					rangeInput.attr( 'min', range.min )
						.attr( 'max', range.max )
						.attr( 'step', range.step );
					textInput.attr( 'value', rangeInput.val() );
					control.save();
				});
			}
			
			rangeInput.attr( 'min', range.min )
				.attr( 'max', range.max )
				.attr( 'step', range.step );
			
			rangeInput.attr( 'value', device_val );
			textInput.attr( 'value', device_val );
			
			rangeInput.on( 'mousemove change', function() {
				textInput.attr( 'value', rangeInput.val() );
			} );
			
			rangeInput.on( changeAction, function() {
				control.save();
			} );
			
			textInput.on( 'input paste change', function() {
				rangeInput.attr( 'value', textInput.val() );
				control.save();
			} );
			
			device_wrapper.find( '.slider-reset' ).on( 'click', function() {
				if ( has_units )
				{
					kirki.util.helpers.selectUnit( unit_wrapper );
				}
				var val = control.params.default;
				if ( !_.isUndefined( control.params.default['value'] ) )
					val = control.params.default['value'];
				textInput.attr( 'value', val );
				rangeInput.attr( 'value', val );
				control.save();
			} );
		});
	},
	
	save: function() {
		var control    = this,
			container  = control.container;
			has_units  = !_.isUndefined( control.params.choices.units ),
			save_value = null;
		
		if ( control.params.use_media_queries )
		{
			save_value = {};
			_.each( kirki.util.media_query_devices, function( device )
			{
				var device_val  = container.find( '.control-wrapper-outer.device-' + device + ' input[type="range"]' ).val(),
					device_unit = container.find( '.kirki-unit-choices-outer.device-' + device + ' input[type="radio"]:checked' ).val();
				
				if ( has_units )
				{
					save_value[device] = {
						value: device_val,
						unit: device_unit
					};
				}
				else
				{
					save_value[device] = device_val;
				}
			});
		}
		else
		{
			var device_val  = container.find( '.control-wrapper-outer input[type="range"]' ).val(),
				device_unit = container.find( '.kirki-unit-choices-outer input[type="radio"]:checked' ).val();
			if ( has_units )
			{
				save_value = {
					value: device_val,
					unit: device_unit
				};
			}
			else
			{
				save_value = device_val;
			}
			
		}
		control.setting.set( save_value );
	}
} );