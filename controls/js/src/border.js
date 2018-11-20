wp.customize.controlConstructor['kirki-border'] = wp.customize.kirkiDynamicControl.extend( {
	initKirkiControl: function() {
		var control = this,
			container = control.container,
			style_select = jQuery( '.border-type select', container),
			inputs = jQuery( '.kirki-control-dimension input', container),
			link_dims = jQuery( '.kirki-input-link', container),
			color_picker = jQuery( '.color input', container );
			value = control.setting._value;
		
		if ( !value && control.params.default )
			value = control.params.default;
		if ( value )
		{
			if ( value['unit'] === 'all' )
				inputs.attr( 'type', 'text' );
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
		
		kirki.util.helpers.unit_select( control, {
			selected_unit: value['unit'],
			unit_changed: function( new_unit ) {
				control.swap_inputs( new_unit === 'all' );
				control.save();
			}
		});
		
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
	
	swap_inputs: function( use_all_units )
	{
		var control = this;
		if ( use_all_units == false )
		{
			_.each( ['top', 'right', 'bottom', 'left'], function( position )
			{
				var input = jQuery( '[data-border-position="' + position + '"]', control.container ),
					cleaned_val = kirki.util.parseNumber( input.val() );
				input.attr( 'type', 'number' );
				input.val( cleaned_val );
			});
		}
		else
			jQuery( '.kirki-control-dimension input', control.container ).attr( 'type', 'text' );
	},
	
	save: function()
	{
		var new_val = {};
		var control = this,
			container = this.container,
			input = jQuery( '.border-hidden-value', container ),
			border_style = jQuery( '.border-type select', container).val(),
			color = jQuery( '.color input', container).val();
		new_val['style'] = border_style;
		new_val['unit'] = jQuery( '.kirki-units-choices input[type="radio"]:checked', container ).val();
		new_val['color'] = color;
		_.each( ['top', 'right', 'bottom', 'left'], function ( position )
		{
			var val = jQuery( 'input[data-border-position="' + position + '"]', container).val();
			if ( val === '' )
				val = 0;
			if ( new_val['unit'] !== 'all' )
				val += new_val['unit'];
			new_val[position] = val;
		});
		input.attr( 'value', JSON.stringify ( new_val ) ).trigger( 'change' );
		control.setting.set( new_val );
	}
} );