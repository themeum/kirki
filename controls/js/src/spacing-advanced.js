wp.customize.controlConstructor['kirki-spacing-advanced'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function() {
		'use strict';
		
		if ( this.params.choices.use_media_queries )
		{
			this.container.addClass( 'has-switchers' );
		}
		
		this.initSpacing();
	},
	
	initSpacing: function() {
			var control       = this,
			has_units         = !_.isUndefined( control.params.choices.units );
			changeAction      = ( 'postMessage' === control.setting.transport ) ? 'keyup change' : 'change',
			value             = control.setting._value;
		
		var wrappers = kirki.util.helpers.setupMediaQueries( control );
		
		_.each( wrappers.devices, function( device_wrappers )
		{
			var device_wrapper    = $( device_wrappers[0] );
			var inputs            = device_wrapper.find( '.kirki-control-dimension input' ),
				device            = device_wrapper.attr( 'device' ) || 'desktop',
				device_val        = device === 'desktop' ? control.params.default : null,
				link_inputs_btn   = device_wrapper.find( '.kirki-input-link' ),
				device_unit       = null;
			
			if ( !_.isUndefined( value[device] ) )
			{
				device_val = value[device];
				if ( has_units )
					device_unit = device_val['unit'] || null;
			}
			else if ( has_units )
			{
				device_unit = value['unit'] || null;
			}
			
			if ( device_val )
			{
				inputs.each( function()
				{
					var input = $( this ),
						side = input.attr( 'side' );
					if ( !device_val[side] )
						return false;
					input.val( has_units ? parseFloat( device_val[side] ) : device_val[side] );
				});
			}
			
			// Set the events.
			if ( has_units )
			{
				var unit_wrapper = wrappers.units[device];
				kirki.util.helpers.selectUnit( unit_wrapper, device_unit );
				unit_wrapper.find ( '.kirki-unit-choice input[type="radio"]').on ( 'change', function( e )
				{
					control.save();
				});
			}
			
			inputs.on( changeAction, function()
			{
				var input = $( this );
				if ( link_inputs_btn.hasClass( 'linked' ) )
					inputs.filter(':not(' + input.attr( 'id' ) + '):not(.not-used)' ).val( input.val() );
				
				control.save();
			});
			
			link_inputs_btn.click(function(e){
				e.preventDefault();
				e.stopImmediatePropagation();
				link_inputs_btn.toggleClass( 'unlinked linked' );
			});
			
			if ( control.params.choices.sync_values )
				link_inputs_btn.click();
			
		});
	},
	
	save: function()
	{
		var control    = this,
			container  = control.container;
			has_units  = !_.isUndefined( control.params.choices.units ),
			save_value = {};
		
		if ( control.params.choices.use_media_queries )
		{
			_.each( kirki.util.media_query_devices, function( device )
			{
				var device_vals  = container.find( '.control-wrapper-outer.device-' + device + ' .kirki-control-dimension input' ),
					device_unit  = container.find( '.kirki-unit-choices-outer.device-' + device + ' input[type="radio"]:checked' ).val();
				save_value[device] = {};
				if ( has_units )
				{
					save_value[device] = {
						unit: device_unit
					};
				}
				
				device_vals.each( function()
				{
					var input = $( this ),
						val   = input.val(),
						side  = input.attr( 'side' );
					save_value[device][side] = val;
				});
			});
		}
		else
		{
			var device_vals  = container.find( '.control-wrapper-outer .kirki-control-dimension input' ),
				device_unit  = container.find( '.kirki-unit-choices-outer input[type="radio"]:checked' ).val();
			
			if ( has_units )
			{
				save_value['unit'] = device_unit;
			}
			
			device_vals.each( function()
			{
				var input = $( this ),
					val   = input.val(),
					side  = input.attr( 'side' );
				save_value[side] = val;
			});
		}
		
		//console.log(save_value);
		//return;
		control.setting.set( save_value );
	},
} );