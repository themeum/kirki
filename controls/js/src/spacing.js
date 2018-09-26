wp.customize.controlConstructor['kirki-spacing-advanced'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function() {
		'use strict';
		var control           = this,
			changeAction      = ( 'postMessage' === control.setting.transport ) ? 'keyup change mouseup' : 'change',
			inputs            = control.container.find( '.kirki-control-dimension input' ),
			topInput          = inputs.filter( '[area="top"]' ),
			rightInput        = inputs.filter( '[area="right"]' ),
			bottomInput       = inputs.filter( '[area="bottom"]' ),
			leftInput         = inputs.filter( '[area="left"]' ),
			units_containers   = control.container.find( '.kirki-units-choices' ),
			units_radios      = control.container.find( '.kirki-units-choices input[type="radio"]' ),
			link_inputs_btn   = control.container.find( '.kirki-input-link' ),
			use_media_queries = control.params.choices.use_media_queries || false,
			all_units         = _.isUndefined( control.params.choices.all_units ) ? true : 
				control.params.choices.all_units;
		control.textFindRegex = /\D+/gm;
		control.selected_device = kirki.util.media_query_devices.global;
		control.selected_unit = '';
		control.inputs = {
			top: topInput,
			right: rightInput,
			bottom: bottomInput,
			left: leftInput,
		};
		control.all_units = all_units;
		control.initial_input = false;
		control.areas = ['top','right','bottom','left'];
		control.units = [];
		units_radios.each(function()
		{
			var radio = $( this );
			control.units.push( radio.val() );
		});
		
		if ( all_units )
		{
			units_containers.remove();
			inputs.attr( 'type', 'text' );
		}
		
		//Setup our value to manipulate.
		control.initValue();
		control.initMediaQueries();
		
		if ( !all_units ) //We need to load the initial unit if all_units = false.
		{
			control.initUnitSelect( units_radios );
			var top_value = null;
			//Load the unit
			if ( use_media_queries )
				top_value = control.value.desktop.top;
			else
				top_value = control.value.global.top;
			var unit = control.parseValue( top_value ).unit;
			units_radios.filter( '[value="' + unit + '"]' ).prop( 'checked', true );
			if ( units_radios.filter ( ':checked' ).length == 0)
			{
				var first_unit = units_radios.first();
				first_unit.prop( 'checked', true );
			}
			
			control.selected_unit = units_radios.filter( ':checked' ).val();
		}
		
		link_inputs_btn.click(function(e){
			e.preventDefault();
			e.stopImmediatePropagation();
			link_inputs_btn.toggleClass( 'unlinked linked' );
		});
		
		inputs.on( changeAction + ' change_visual', function( e )
		{
			if ( e.type === 'keyup' )
				control.initial_input = true;
			var input = $( this ),
				val = input.val();
			if ( all_units )
			{
				val += control.selected_unit;
			}
			if ( link_inputs_btn.hasClass( 'linked' ) )
			{
				inputs.filter(':not(' + input.attr( 'id' ) + ')' ).val( val );
			}
			inputs.each( function()
			{
				var input = $( this ),
					type = input.attr( 'area' ),
					device = control.getSelectedDeviceName(),
					val = input.val();
				if ( val.length == 0 )
				{
					input.val( val );
				}
				if ( !all_units )
				{
					val += control.selected_unit;
				}
				control.value[device][type] = val;
			});
			control.save();
		});
		
		inputs.on( 'blur', function()
		{
			var input = $( this );
			if ( input.val() == '' )
				input.val( '0' );
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
		var id = control.value.use_media_queries ? 'desktop' : 'global';
		var top    = control.value[id].top,
			right  = control.value[id].right,
			bottom = control.value[id].bottom,
			left   = control.value[id].left;
			if ( !control.value[id].loaded && control.params.default )
			{
				var defs = control.params.default;
				if ( control.all_units )
				{
					top = defs.top || top;
					right = defs.right || right;
					bottom = defs.bottom || bottom;
					left = defs.left || left;
				}
				else
				{
					var unit = control.units[0];
					if ( control.selected_unit )
						unit = control.selected_unit;
					top = defs[unit].top || top;
					right = defs[unit].right || right;
					bottom = defs[unit].bottom || bottom;
					left = defs[unit].left || left;
				}
			}
			if ( !control.all_units )
			{
				top = top.toString().replace( control.textFindRegex, '' );
				right = right.toString().replace( control.textFindRegex, '' );
				bottom = bottom.toString().replace( control.textFindRegex, '' );
				left = left.toString().replace( control.textFindRegex, '' );
			}
			control.inputs.top.val( top );
			control.inputs.right.val( right );
			control.inputs.bottom.val( bottom );
			control.inputs.left.val( left );
	},
	
	initMediaQueries: function()
	{
		var control = this,
			units_radios      = control.container.find( '.kirki-units-choices input[type="radio"]' );
		//If media queries are used, we need to detect device changes.
		if ( control.params.choices.use_media_queries )
		{
			kirki.util.helpers.media_query( control, control.value.use_media_queries, {
				device_change: function( device, enabled )
				{
					control.selected_device = device;
					control.value.use_media_queries = enabled;
					var top,
						right,
						bottom,
						left;
					if ( enabled )
						control.value.desktop = control.value.global;
					if ( !enabled )
					{
						control.value.global = control.value.desktop;
						top = control.value.global.top;
						right = control.value.global.right;
						bottom = control.value.global.bottom;
						left = control.value.global.left;
					}
					else if ( device == kirki.util.media_query_devices.desktop )
					{
						top = control.value.desktop.top;
						right = control.value.desktop.right;
						bottom = control.value.desktop.bottom;
						left = control.value.desktop.left;
					}
					else if ( device == kirki.util.media_query_devices.tablet )
					{
						top = control.value.tablet.top;
						right = control.value.tablet.right;
						bottom = control.value.tablet.bottom;
						left = control.value.tablet.left;
					}
					else if ( device == kirki.util.media_query_devices.mobile )
					{
						top = control.value.mobile.top;
						right = control.value.mobile.right;
						bottom = control.value.mobile.bottom;
						left = control.value.mobile.left;
					}
					
					if ( !control.params.choices.all_units )
					{
						var unit = control.parseValue( top )['unit'] ||
								control.parseValue( right )['unit'] ||
								control.parseValue( bottom )['unit'] ||
								control.parseValue( left )['unit'];
						if ( unit && unit.length > 0 )
						{
							units_radios.filter( ':checked' ).prop( 'checked', false );
							units_radios.filter( '[value="' + unit + '"]' ).prop( 'checked', true );
							if ( units_radios.filter ( ':checked' ).length == 0 )
								units_radios.first().click();
							control.selected_unit = units_radios.filter ( ':checked' ).val();
						}
						top = top.replace( control.textFindRegex, '' );
						right = right.replace( control.textFindRegex, '' );
						bottom = bottom.replace( control.textFindRegex, '' );
						left = left.replace( control.textFindRegex, '' );
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
	  
	initUnitSelect: function( units )
	{
		var control = this;
		units.on( 'change', function()
		{
			var selected = $( this );
			control.selected_unit = selected.val();
			
			var defs = control.params.default;
			if ( !control.value.loaded && !control.initial_input && control.params.default && defs[control.selected_unit] )
			{
				if ( defs[control.selected_unit].top )
					control.inputs.top.val( defs[control.selected_unit].top.toString().replace( control.textFindRegex, '' ) );
				if ( defs[control.selected_unit].right )
					control.inputs.right.val( defs[control.selected_unit].right.toString().replace( control.textFindRegex, '' ) );
				if ( defs[control.selected_unit].bottom )
					control.inputs.bottom.val( defs[control.selected_unit].bottom.toString().replace( control.textFindRegex, '' ) );
				if ( defs[control.selected_unit].left )
					control.inputs.left.val( defs[control.selected_unit].left.toString().replace( control.textFindRegex, '' ) );
			}
			
			control.inputs.top.trigger( 'change_visual' );
		});
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
		}
		else
		{
			delete compiled.desktop;
			delete compiled.tablet;
			delete compiled.mobile;
		}
		input.val( JSON.stringify( compiled ) ).trigger( 'change' );
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
		return { top: '0', right: '0', bottom: '0', left: '0', loaded: false };
	},
} );
