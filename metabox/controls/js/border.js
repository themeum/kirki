jQuery(document).ready( function()
{
	jQuery('.rugged-group-outer.border').each(function(e){
		var rugged_border_outer = jQuery(this);
		var value_input = jQuery('.rugged-border-value', rugged_border_outer);
		var border_select = jQuery('.rugged-border-select', rugged_border_outer);
		var inputs = jQuery('.rugged-control-dimension input', rugged_border_outer);
		var link_dims = jQuery('.rugged-link-dimensions', rugged_border_outer);
		var color_picker = jQuery('.color-picker', rugged_border_outer);
		var color_outer = jQuery('.color-outer', rugged_border_outer);
		var size_outer = jQuery('.size-outer', rugged_border_outer);
		var save_tid = 0;
		color_picker.wpColorPicker({
			change: function(e, ui){
				save_border();
			}
		});
		border_select.change(function(e){
			toggle_visible(border_select.val() != 'none');
			save_border();
		});

		inputs.on('keyup change click', function ( e ){
			var input = jQuery(this);
			var cur_val = input.val();
			var last_val = input.attr( 'last-val' );
			if ( cur_val != last_val )
			{
				input.attr( 'last-val', cur_val );
				clearTimeout (save_tid );
				if ( link_dims.hasClass( 'linked' ) )
				{
					inputs.attr( 'last-val', cur_val );
					inputs.val( cur_val );
				}

				save_border();
			}
		});

		link_dims.click(function(e){
			e.preventDefault();
			link_dims.toggleClass('unlinked');
			link_dims.toggleClass('linked');
		});
		toggle_visible(border_select.val() != 'none')

		function toggle_visible(visible = false)
		{
			if (visible){
				size_outer.show();
				color_outer.show();
			}
			else
			{
				size_outer.hide();
				color_outer.hide();
			}
		}

		function save_border(){
			clearTimeout (save_tid );
			save_tid = setTimeout( function ()
				{
					var data = {
						'border_type': border_select.val(),
						'top': jQuery('[data-border-type="top"]', rugged_border_outer).val(),
						'right': jQuery('[data-border-type="right"]', rugged_border_outer).val(),
						'bottom': jQuery('[data-border-type="bottom"]', rugged_border_outer).val(),
						'left': jQuery('[data-border-type="left"]', rugged_border_outer).val(),
						'color': color_picker.val()
					};
					if ( data.border_type != 'none' )
						value_input.val(JSON.stringify(data).replace( /'/g, '&#39' ));
					else
						value_input.val('');
					save_tid = 0;
			}, 300 );
		}
	});
});