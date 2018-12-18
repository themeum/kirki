jQuery( document ).ready ( function()
{
	jQuery( '.kirki-multicolor-outer' ).each ( function ( e )
	{
		var container = jQuery( this );
		var input = jQuery( 'input[kirki-metabox-link]', container );
		var pickers = jQuery( 'input.color-picker', container );
		var params = JSON.parse ( container.attr ( 'kirki-args' ) );
		var color_picker_args = {
			change: function(event, ui)
			{
				save();
			}
		};
		pickers.wpColorPicker(color_picker_args);

		function save()
		{
			var obj = {
			};
			pickers.each ( function ( e )
			{
				var picker = jQuery( this );
				var id = picker.attr ( 'color-id' );
				var color = picker.val();
				obj[id] = color;
			});

			input.val ( JSON.stringify ( obj ) );
		}
	});
});