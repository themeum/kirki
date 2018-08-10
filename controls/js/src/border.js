wp.customize.controlConstructor['kirki-border'] = wp.customize.kirkiDynamicControl.extend( {
	initKirkiControl: function() {
		var control = this,
			container = control.container,
			input = jQuery( '.border-hidden-value', container ),
			style = jQuery( '.border-type select', container),
			inputs = jQuery( '.kirki-control-dimension input', container),
			link_dims = jQuery( '.kirki-input-link', container),
			size_container = jQuery( '.size', container ),
			color_container = jQuery( '.color', container ),
			color_picker = jQuery( 'input', color_container ),
			top_input = jQuery( '[data-border-type="top"]', container ),
			right_input = jQuery( '[data-border-type="right"]', container ),
			bottom_input = jQuery( '[data-border-type="bottom"]', container ),
			left_input = jQuery( '[data-border-type="left"]', container ),
			value = control.setting._value;
		
		if ( !value && control.params.default )
		{
			value = control.params.default;
		}
		
		if ( value )
		{
			style.val ( value['border-style'] );
			top_input.val ( value['border-top'] );
			right_input.val ( value['border-right'] );
			bottom_input.val ( value['border-bottom'] );
			left_input.val ( value['border-left'] );
		}
		
		color_picker.attr( 'data-default-color', value['border-color'] )
			.data( 'default-color', value['border-color'] )
			.val( value['border-color'] )
			.wpColorPicker( {
				change: function(e, ui)
				{
					setTimeout(function()
					{
						save();
					}, 100);
				}
			});
		
		style.change( function( e ){
			e.preventDefault();
			toggle_visible();
			save();
		});

		inputs.on( 'keyup change click', function ( e ){
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
				save();
			}
		});

		link_dims.click( function( e )
		{
			e.preventDefault();
			link_dims.toggleClass( 'unlinked' );
			link_dims.toggleClass( 'linked' );
		});
		
		toggle_visible();
		
		function toggle_visible()
		{
			var val = style.val();
			if ( val != '' )
			{
				size_container.show();
				color_container.show();
			}
			else
			{
				size_container.hide();
				color_container.hide();
			}
		}
		
		function save()
		{
			var border_style = style.val(),
				top_val = parseInt( top_input.val() ) || 0,
				right_val = parseInt( right_input.val() ) || 0,
				bottom_val = parseInt( bottom_input.val() ) || 0,
				left_val = parseInt( left_input.val() ) || 0,
				color_val = color_picker.val();
			var new_val = {
				'border-style': border_style,
				'border-top': top_val,
				'border-right': right_val,
				'border-bottom': bottom_val,
				'border-left': left_val,
				'border-color': color_val
			};
			var json = JSON.stringify ( new_val );
			jQuery( input ).attr( 'value', json ).trigger( 'change' );
			control.setting.set( new_val );
		}
	}
} );