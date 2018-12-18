jQuery( document ).ready( function( e )
{
	jQuery( '.background-wrapper' ).each( function( e )
	{
		var container = jQuery(this),
			input = jQuery( 'input[kirki-metabox-link]', container ),
			color = jQuery( '.background-color input', container ),
			background_image_outer = jQuery( '.background-image', container ),
			background_image_input = jQuery( 'input.image-url', background_image_outer ),
			background_image_remove_btn = jQuery( '.background-image-upload-remove-button', background_image_outer ),
			background_image_select = jQuery( '.background-image-upload-button', background_image_outer ),
			background_image_preview = jQuery( '.thumbnail-image img', background_image_outer ),
			background_image_placeholder = jQuery( '.placeholder', background_image_outer ),
			repeat = jQuery( '.background-repeat select', container ),
			position = jQuery( '.background-position select', container ),
			size = jQuery( '.background-size input[type="radio"]', container ),
			attachment = jQuery( '.background-attachment input[type="radio"]', container ),
			color_tid = 0,
			frame = null;

			color.wpColorPicker({
				change: function()
				{
					clearTimeout(color_tid);
					color_tid = setTimeout( function( e )
					{
						save();
					}, 100 );
				}
			});

			repeat.on ( 'change', function()
			{
				save();
			});

			position.on( 'change', function()
			{
				save();
			});

			attachment.on( 'change', function()
			{
				save();
			});

			size.on( 'change', function()
			{
				save();
			});

			background_image_select.click( function()
			{
				if ( frame ) {
					frame.open();
					return;
				}
				var library = {
					type: ['image']
				};
				frame = wp.media({
					title: kirkiL10n.selectImage,
					button: {
					  text: kirkiL10n.useThisMedia
					},
					library,
					multiple: false
				});
				frame.on( 'select', function() {
					var attachment = frame.state().get('selection').first().toJSON();
					background_image_preview.attr ( 'src', attachment.url );
					background_image_input.val ( attachment.url );
					background_image_placeholder.hide();
				});
				frame.open();
			});

			background_image_remove_btn.click( function()
			{
				background_image_preview.attr( 'src', '' );
				background_image_input.val( '' );
				background_image_placeholder.show();
			});

			function save()
			{
				var obj = {
					'background-image': background_image_input.val(),
					'background-color': color.val(),
					'background-repeat': repeat.val(),
					'background-position': position.val(),
					'background-size': size.val(),
					'background-attachment': attachment.val()
				};
				input.attr( 'value', JSON.stringify( obj ) );
			}
	});
});