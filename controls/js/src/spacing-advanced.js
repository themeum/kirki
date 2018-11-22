wp.customize.controlConstructor['kirki-spacing-advanced'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function() {
		'use strict';
		var control           = this,
			container         = control.container,
			changeAction      = ( 'postMessage' === control.setting.transport ) ? 'keyup change mouseup' : 'change',
			inputs            = control.container.find( '.kirki-control-dimension input' ),
			topInput          = inputs.filter( '[data-side="top"]' ),
			rightInput        = inputs.filter( '[data-side="right"]' ),
			bottomInput       = inputs.filter( '[data-side="bottom"]' ),
			leftInput         = inputs.filter( '[data-side="left"]' ),
			units_radios      = control.container.find( '.kirki-units-choices input[type="radio"]' ),
			link_inputs_btn   = control.container.find( '.kirki-input-link' ),
			has_units         = !_.isUndefined( control.params.choices.units );
		control.selected_device = kirki.util.media_query_devices.global;
		control.selected_unit = has_units ? units_radios.first().val() : 'all';
		control.all_inputs = control.container.find( '.kirki-control-dimension input' );
		control.inputs = {
			top: topInput,
			right: rightInput,
			bottom: bottomInput,
			left: leftInput,
		};
		control.has_units = has_units;
		control.initial_input = false;
		
		if ( !has_units )
			inputs.attr( 'type', 'text' );
		
		//Setup our value to manipulate.
		control.initValue();
		control.initMediaQueries();
		
		if ( has_units )
		{
			kirki.util.helpers.unit_select( control, {
				selected_unit: control.selected_device,
				unit_changed: function( new_unit ) {
					control.selected_unit = new_unit;
					inputs.trigger( 'change_visual' );
				}
			});
		}
		
		control.setInitValue();
		
		link_inputs_btn.click(function(e){
			e.preventDefault();
			e.stopImmediatePropagation();
			link_inputs_btn.toggleClass( 'unlinked linked' );
		});
		
		inputs.on( changeAction + ' change_visual', function( e )
		{
			if ( e.type === 'keyup' )
				control.initial_input = true;
			var input = $( this );
			if ( link_inputs_btn.hasClass( 'linked' ) )
				inputs.filter(':not(' + input.attr( 'id' ) + '):not(.not-used)' ).val( input.val() );
			
			_.each( ['top', 'right', 'bottom', 'left'], function( side )
			{
				var input = jQuery( 'input[data-side="' + side + '"]', container),
					val = input.val(),
					device = control.getSelectedDeviceName();
				if ( _.isUndefined( control.params.default[side] ) )
				{
					control.value[device][side] = 0;
					return false;
				}
				if ( val == '' )
					val = 0;
				if ( control.selected_unit !== 'all' )
					val += control.selected_unit;
				control.value[device][side] = val;
			});
			control.value[control.getSelectedDeviceName()]['unit'] = control.selected_unit;
			control.save();
		});
		
		control.inputs.top.trigger( 'change_visual' );
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
				if ( loadedValue[name] )
				{
					control.value[name] = loadedValue[name];
					control.value[name]['loaded'] = true;
				}
			});
			if ( loadedValue['desktop'] )
				control.value['global'] = loadedValue['desktop'];
		}
		else
		{
			if ( loadedValue['global'] )
			{
				control.value['global'] = loadedValue['global'];
				control.value['global']['loaded'] = true;
			}
		}
	},
	
	setInitValue: function()
	{
		var control = this,
			defs = control.params.default;
			choices = control.params.choices;
		var id = control.value.use_media_queries ? 'desktop' : 'global';
		var top    = control.value[id].top,
			right  = control.value[id].right,
			bottom = control.value[id].bottom,
			left   = control.value[id].left;
			if ( !control.value[id].loaded && ( !_.isUndefined ( control.params.default ) ) )
			{
				top = defs.top || top;
				right = defs.right || right;
				bottom = defs.bottom || bottom;
				left = defs.left || left;
			}
			if ( control.selected_unit != 'all' )
			{
				if ( !_.isUndefined( defs.top ) )
					top = kirki.util.parseNumber( top );
				if ( !_.isUndefined( defs.right ) )
					right = kirki.util.parseNumber( right );
				if ( !_.isUndefined( defs.bottom ) )
					bottom = kirki.util.parseNumber( bottom );
				if ( !_.isUndefined( defs.left ) )
					left = kirki.util.parseNumber( left );
			}
			control.inputs.top.val( top );
			control.inputs.right.val( right );
			control.inputs.bottom.val( bottom );
			control.inputs.left.val( left );
	},
	
	initMediaQueries: function()
	{
		var control      = this,
			defs         = control.params.default,
			units_radios = control.container.find( '.kirki-units-choices input[type="radio"]' );
		//If media queries are used, we need to detect device changes.
		if ( control.params.choices.use_media_queries )
		{
			kirki.util.helpers.media_query( control, control.value.use_media_queries, {
				device_change: function( enabled, device )
				{
					control.selected_device = device;
					control.value.use_media_queries = enabled;
					var device_name = control.getSelectedDeviceName();
					var top = 0,
						right = 0,
						bottom = 0,
						left = 0;
					if ( enabled )
						control.value.desktop = control.value.global;
					if ( !enabled )
					{
						control.value.global = control.value.desktop;
						device_name = 'global';
					}
					top = control.value[device_name].top;
					right = control.value[device_name].right;
					bottom = control.value[device_name].bottom;
					left = control.value[device_name].left;
					if ( !_.isUndefined( control.params.choices.units ) )
					{
						var unit = control.value[device_name].unit;
						if ( unit && unit.length > 0 )
						{
							units_radios.filter( ':checked' ).prop( 'checked', false );
							units_radios.filter( '[value="' + unit + '"]' ).prop( 'checked', true );
							if ( units_radios.filter ( ':checked' ).length == 0 )
								units_radios.first().click();
							control.selected_unit = units_radios.filter ( ':checked' ).val();
						}
						  
						if ( !_.isUndefined( defs.top ) )
							top = kirki.util.parseNumber( top );
						if ( !_.isUndefined( defs.right ) )
							right = kirki.util.parseNumber( right );
						if ( !_.isUndefined( defs.bottom ) )
							bottom = kirki.util.parseNumber( bottom );
						if ( !_.isUndefined( defs.left ) )
							left = kirki.util.parseNumber( left );
					}
					
					control.inputs.top.val( top );
					control.inputs.right.val( right );
					control.inputs.bottom.val( bottom );
					control.inputs.left.val( left );
					
					control.save();
				}
			});
		}
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
	
	save: function()
	{
		var control = this,
			input  = control.container.find( '.spacing-hidden-value' ),
			compiled = jQuery.extend( {}, control.value );
		delete compiled.loaded;
		if ( compiled.use_media_queries )
		{
			delete compiled.global;
			
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
		}
		console.log( compiled );
		input.attr( 'value', JSON.stringify( compiled ) ).trigger( 'change' );
		control.setting.set( compiled );
	},
	
	defaultValue: function()
	{
		return { top: '', right: '', bottom: '', left: '', unit: '', loaded: false };
	},
} );