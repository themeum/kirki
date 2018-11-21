wp.customize.controlConstructor['kirki-border'] = wp.customize.kirkiDynamicControl.extend( {
	initKirkiControl: function() {
		var control = this,
			container = control.container,
			style_select = jQuery( '.border-style select', container),
			inputs = jQuery( '.kirki-control-dimension input', container),
			link_dims = jQuery( '.kirki-input-link', container),
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
				value['unit'] = jQuery( '.kirki-units-choices input[type="radio"]:first', container ).val()
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
			kirki.util.helpers.unit_select( control, {
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
				if ( link_dims.hasClass( 'linked' ) )
				{
					inputs.attr( 'last-val', cur_val );
					inputs.val( cur_val );
				}
				control.save();
			}
		});

		link_dims.click( function( e )
		{
			e.preventDefault();
			link_dims.toggleClass( 'unlinked' );
			link_dims.toggleClass( 'linked' );
		});
		
		this.toggle_visibility( style_select );
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
		_.each( ['top', 'right', 'bottom', 'left'], function( position )
		{
			var input = jQuery( '[data-border-position="' + position + '"]', control.container ),
				border_val = value[position];
			if ( value['unit'] !== 'all' )
				border_val = kirki.util.parseNumber( border_val );
			input.val( border_val );
		});
	},
	
	save: function()
	{
		var new_val = {};
		var control = this,
			defaults = control.params.default,
			container = this.container,
			input = jQuery( '.border-hidden-value', container ),
			border_style = jQuery( '.border-style select', container).val(),
			selected_unit = jQuery( '.kirki-units-choices input[type="radio"]:checked', container ),
			color = jQuery( '.color input', container).val();
		new_val['style'] = border_style;
		new_val['unit'] = control.has_units ? selected_unit.val() : 'all';
		new_val['color'] = color;
		_.each( ['top', 'right', 'bottom', 'left'], function ( position )
		{
			if ( !_.isUndefined( defaults[position] ) && defaults[position] == false )
			{
				new_val[position] = 0;
				return false;
			}
			var val = jQuery( 'input[data-border-position="' + position + '"]', container).val();
			if ( val === '' )
				val = 0;
			if ( new_val['unit'] !== 'all' )
				val += new_val['unit'];
			new_val[position] = val;
		});
		console.log ( new_val );
		input.attr( 'value', JSON.stringify ( new_val ) ).trigger( 'change' );
		control.setting.set( new_val );
	}
} );