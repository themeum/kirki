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
			units_containers  = control.container.find( '.kirki-units-choices' ),
			units_radios      = control.container.find( '.kirki-units-choices input[type="radio"]' ),
			link_inputs_btn   = control.container.find( '.kirki-input-link' ),
			use_media_queries = control.params.use_media_queries || false,
			all_units         = _.isUndefined( control.params.choices.all_units ) ? false : 
				control.params.choices.all_units;
		control.textFindRegex = /\D+/gm;
		control.selected_device = kirki.util.media_query_devices.global;
		control.selected_unit = '';
		control.all_inputs = control.container.find( '.kirki-control-dimension input' );
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
			control.units.push ( 'all' );
			
			if ( control.units.length === 1 )
				units_radios.hide();
		}
		
		//Setup our value to manipulate.
		control.initValue();
		control.initMediaQueries();
		control.setVisible();
		
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
		control.initUnitSelect( units_radios );
		
		if ( control.selected_unit === 'all' )
		{
			inputs.attr( 'type', 'text' );
			if ( units_radios.length === 1 )
				units_radios.hide();
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
			var input = $( this ),
				val = input.val();
			if ( val == '' )
				val = '0';
			if ( link_inputs_btn.hasClass( 'linked' ) )
				inputs.filter(':not(' + input.attr( 'id' ) + '):not(.not-used)' ).val( input.val() );
			inputs.each( function()
			{
				var input = $( this ),
					type = input.attr( 'area' ),
					device = control.getSelectedDeviceName(),
					val = input.val();
				if ( val.length == 0 )
					input.val( val );
				if ( control.selected_unit !== 'all' )
					val += control.selected_unit;
				control.value[device][type] = val;
			});
			control.value[control.getSelectedDeviceName()]['unit'] = control.selected_unit;
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
	},
	
	setInitValue: function()
	{
		var control = this,
			choices = control.params.choices;
		var id = control.value.use_media_queries ? 'desktop' : 'global';
		var top    = control.value[id].top,
			right  = control.value[id].right,
			bottom = control.value[id].bottom,
			left   = control.value[id].left;
			if ( !control.value[id].loaded && ( !_.isUndefined ( control.params.default ) ) )
			{
				var defs = control.params.default;
				top = defs.top || top;
				right = defs.right || right;
				bottom = defs.bottom || bottom;
				left = defs.left || left;
			}
			if ( control.selected_unit !== 'all' )
			{
				if ( choices.top )
					top = top.toString().replace( control.textFindRegex, '' );
				if ( choices.right )
					right = right.toString().replace( control.textFindRegex, '' );
				if ( choices.bottom )
					bottom = bottom.toString().replace( control.textFindRegex, '' );
				if ( choices.left )
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
			choices = control.params.choices,
			units_radios      = control.container.find( '.kirki-units-choices input[type="radio"]' );
		//If media queries are used, we need to detect device changes.
		if ( control.params.use_media_queries )
		{
			kirki.util.helpers.media_query( control, control.value.use_media_queries, {
				device_change: function( device, enabled )
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
						top = control.value.global.top;
						right = control.value.global.right;
						bottom = control.value.global.bottom;
						left = control.value.global.left;
					}
					else
					{
						top = control.value[device_name].top;
						right = control.value[device_name].right;
						bottom = control.value[device_name].bottom;
						left = control.value[device_name].left;
					}
					if ( !control.params.choices.all_units )
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
						control.checkInputs();
						if ( choices.top && control.selected_unit !== 'all' )
							top = top.replace( control.textFindRegex, '' );
						if ( choices.right && control.selected_unit !== 'all' )
							right = right.replace( control.textFindRegex, '' );
						if ( choices.bottom && control.selected_unit !== 'all' )
							bottom = bottom.replace( control.textFindRegex, '' );
						if ( choices.left && control.selected_unit !== 'all' )
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
			if ( defs && !control.value.loaded && !control.initial_input )
			{
				if ( !_.isUndefined ( defs.top ) )
					control.inputs.top.val( defs.top );
				if ( !_.isUndefined ( defs.right ) )
					control.inputs.right.val( defs.right );
				if ( !_.isUndefined ( defs.bottom ) )
					control.inputs.bottom.val( defs.bottom );
				if (!_.isUndefined (  defs.left ) )
					control.inputs.left.val( defs.left );
			}
			control.checkInputs();
			
			control.inputs.top.trigger( 'change_visual' );
		});
		units.on ( 'change' );
	},
	
	setVisible: function()
	{
		var control = this,
			container = control.container,
			choices = control.params.choices,
			to_hide = [];
		if ( !choices.top )
			to_hide.push( 'top' );
		if ( !choices.right )
			to_hide.push( 'right' );
		if ( !choices.bottom )
			to_hide.push( 'bottom' );
		if ( !choices.left )
			to_hide.push( 'left' );
		to_hide.forEach ( function( v )
		{
			var element = container.find( 'input[area="' + v + '"]' ),
				parent = element.parent();
			parent.hide();
			element.attr( 'hidden', true )
				.attr( 'type', 'hidden' )
				.addClass( 'not-used' )
				.val( '0' );
			
		});
	},
	
	checkInputs: function()
	{
		var control = this;
		if ( control.selected_unit === 'all' )
			control.all_inputs.attr( 'type', 'text' );
		else
		{
			control.all_inputs.each( function()
			{
				var input = $( this );
				var val = input.val();
				input.val( val.replace( control.textFindRegex, '' ) );
			});
			control.all_inputs.attr ( 'type', 'number' );
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
		console.log ( compiled );
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
		return { top: '0', right: '0', bottom: '0', left: '0', unit: '', loaded: false };
	},
} );
