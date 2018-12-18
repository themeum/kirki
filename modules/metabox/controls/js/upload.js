jQuery( document ).ready ( function()
{
	jQuery( '.kirki-metabox.customize-control-kirki-upload' ).each ( function ( e )
	{
		var self = jQuery( this );
		var input = jQuery( 'input[kirki-metabox-link]', self );
		var thumbnail = jQuery( '.thumbnail img', self );
		var link_preview = jQuery( '.media-link-preview', self );
		var select_btn = jQuery( '.image-upload-button', self );
		var remove_btn = jQuery( '.image-remove-button', self );
		var default_btn = jQuery( '.image-default-button', self );
		var params = JSON.parse(self.attr('kirki-args'));
		var frame;
		// ADD IMAGE LINK
		select_btn.on( 'click', function ( event ) {
			event.preventDefault();
			// If the media frame already exists, reopen it.
			if ( frame ) {
			  frame.open();
			  return;
			}
			var library = {
				type: []
			};

			if ( params.type == 'image' )
				library.type.push('image');

			// Create a new media frame
			frame = wp.media({
			  title: kirkiL10n.selectFile,
			  button: {
				text: kirkiL10n.useThisMedia
			  },
			  library,
			  multiple: false  // Set to true to allow multiple files to be selected
			});
			// When an image is selected in the media frame...
			frame.on( 'select', function() {
			  // Get media attachment details from the frame state
			  var attachment = frame.state().get('selection').first().toJSON();
			  if ( params.type == 'image' )
			  {
				// Send the attachment URL to our custom image input field.
				thumbnail.attr ( 'src', attachment.url );

				var obj = {
				};

				if ( params.choices )
				{
					if ( params.choices.save_as )
					{
						switch ( params.choices.save_as )
						{
							case 'array':
								obj.id = attachment.id;
								obj.url = attachment.url;
								obj.width = attachment.width;
								obj.height = attachment.height;
								break;
							case 'id':
								obj = attachment.id;
								break;
							default:
								obj = attachment.url;
								break;
						}
					}
					else
					{
						obj = attachment.url;
					}
				}
				else
				{
					obj = attachment.url;
				}

				if ( typeof obj == 'object' )
					obj = JSON.stringify ( obj );

				// Send the JSOn string to our hidden input
				input.val ( obj );
			  }
			  else
			  {
				link_preview.val ( attachment.url );
				//Normal media just saves the URL.
				input.val ( attachment.url );
			  }
			});
			// Finally, open the modal on click
			frame.open();
		});
		default_btn.on ( 'click', function ( e ) {
			e.preventDefault();
			input.val ( '' );
			thumbnail.attr ( 'src', input.attr ( 'default-value' ) );
			link_preview.val ( '' );
		});
	} );
});