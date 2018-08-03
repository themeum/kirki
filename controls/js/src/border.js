wp.customize.controlConstructor['kirki-border'] = wp.customize.kirkiDynamicControl.extend( {
	initKirkiControl: function() {
		var control = this,
			input = $( '.border-hidden-value', container ),
			container = control.container,
			style = $( '.border-type select', container),
			inputs = $( '.kirki-control-dimension input', container),
			link_dims = $( '.kirki-link-dimensions', container),
			size = $( '.size', container ),
			color = $( '.color', container ),
			color_picker = $( 'input', color ),
			top = $( '[data-border-type="top"]', container ),
			right = $( '[data-border-type="right"]', container ),
			bottom = $( '[data-border-type="bottom"]', container ),
			left = $( '[data-border-type="left"]', container ),
			value = control.setting._value;
			console.log ( value );
		if ( value )
		{
			style.val ( value.style );
			top.val ( value.top );
			right.val ( value.right );
			bottom.val ( value.bottom );
			left.val ( value.left );
			color_picker.val ( value.color );
			if ( value.style )
			{
				size.show();
				color.show();
			}
			else
			{
				size.hide();
				color.hide();
			}
		}
		else
		{
			size.hide();
			color.hide();
		}
		
		color_picker.wpColorPicker(
		{
			change: function(e, ui)
			{
				save();
			}
		});
		
		style.change(function(e){
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
		
		function toggle_visible()
		{
			var val = style.val();
			if ( val != '' )
			{
				size.show();
				color.show();
			}
			else
			{
				size.hide();
				color.hide();
			}
		}
		
		function save()
		{
			var new_val = {
				'style': style.val(),
				'top': top.val(),
				'right': right.val(),
				'bottom': bottom.val(),
				'left': left.val(),
				'color': color_picker.val()
			};
			console.log ( new_val );
			jQuery( input ).attr( 'value', JSON.stringify( new_val ).replace( /'/g, '&#39' ) ).trigger( 'change' );
			control.setting.set( new_val );
		}
	}
} );
