wp.customize.controlConstructor['kirki-border'] = wp.customize.kirkiDynamicControl.extend( {
	initKirkiControl: function() {
		var control = this,
			container = control.container,
			style_select = jQuery( '.border-style select', container),
			inputs = jQuery( '.kirki-control-dimension input', container),
			link_inputs_btn = jQuery( '.kirki-input-link', container),
			color_picker = jQuery( '.color input', container ),
			has_units = !_.isUndefined( control.params.choices.units ),
			value = control.setting._value;
		
		control.has_units = has_units;
		
		if ( !has_units )
			inputs.attr( 'type', 'text' );
		
		if ( !value && control.params.default )
		{
			value = control.params.default;
			if ( _.isUndefined( value['unit'] ) )
				value['unit'] = jQuery( '.kirki-unit-choice input[type="radio"]:first', container ).val()
		}
		if ( value )
		{
			style_select.val( value['style'] || 'none' );
			control.fill_inputs( value );
		}
		else
			style_select.val( 'none' );
		
		color_picker.attr( 'data-default-color', value['color'] )
			.data( 'default-color', value['color'] )
			.val( value['color'] )
			.wpColorPicker( {
				change: function(e, ui) {
					setTimeout(function(){
						control.save();
					}, 100);
				},
				clear: function (event) {
					setTimeout( function() {
						control.save();
					}, 100 );
				}
			});
		
		if ( has_units )
		{
			kirki.util.helpers.initUnitSelect( control, {
				selected_unit: value['unit'],
				unit_changed: function( new_unit ) {
					control.save();
				}
			});
		}
		
		style_select.change( function( e ) {
			e.preventDefault();
			control.toggle_visibility( style_select );
			control.save();
		});
	
		inputs.on( 'keyup change click', function() {
			var input = jQuery( this );
			var cur_val = input.val();
			var last_val = input.attr( 'last-val' );
			if ( cur_val != last_val )
			{
				input.attr( 'last-val', cur_val );
				if ( link_inputs_btn.hasClass( 'linked' ) )
				{
					inputs.attr( 'last-val', cur_val );
					inputs.val( cur_val );
				}
				control.save();
			}
		});
	
		link_inputs_btn.click( function( e )
		{
			e.preventDefault();
			link_inputs_btn.toggleClass( 'unlinked linked' );
		});
		
		this.toggle_visibility( style_select );
		
		if ( control.params.choices.sync_values )
			link_inputs_btn.click();
	},
	
	toggle_visibility: function( style_select )
	{
		var val = style_select.val(),
			containers = jQuery( '.size,.color', this.container );
		if ( val !== 'none' )
			containers.show();
		else
			containers.hide();
	},
	
	fill_inputs: function( value )
	{
		var control = this;
		_.each( ['top', 'right', 'bottom', 'left'], function( side )
		{
			if ( _.isUndefined( control.params.default[side] ))
				return false;
			var input = jQuery( '[side="' + side + '"]', control.container ),
				border_val = value[side];
			if ( value['unit'] && value['unit'] !== '' )
				border_val = kirki.util.parseNumber( border_val );
			input.val( border_val );
		});
	},
	
	save: function()
	{
		var new_val = {};
		var control = this,
			container = this.container,
			input = jQuery( '.border-hidden-value', container ),
			border_style = jQuery( '.border-style select', container).val(),
			selected_unit = jQuery( '.kirki-unit-choice input[type="radio"]:checked', container ),
			color = jQuery( '.color input', container).val();
		new_val['style'] = border_style;
		new_val['unit']  = selected_unit.val();
		new_val['color'] = color;
		_.each( ['top', 'right', 'bottom', 'left'], function ( side )
		{
			var val = 0;
			if ( !_.isUndefined( control.params.default[side] ) )
			{
				val = jQuery( 'input[side="' + side + '"]', container).val();
				if ( !val )
					val = 0;
			}
			if ( value != 0 && new_val['unit'] !== '' )
				val += new_val['unit'];
			new_val[side] = val;
		});
		input.attr( 'value', JSON.stringify ( new_val ) ).trigger( 'change' );
		control.setting.set( new_val );
	}
} );