jQuery( document ).ready ( function ( e )
{
	jQuery( '.kirki-mb-multicheck-outer').each( function ()
	{
		var container = jQuery( this );
		var input = jQuery( 'input[kirki-metabox-link]', container);
		var checkboxes = jQuery( 'input[type="checkbox"]', container );
		checkboxes.change ( function()
		{
			var cb = jQuery(this);
			var checked = cb.prop( 'checked' );
			if ( checked && cb.hasClass( 'default' ) )
			{
				checkboxes.not('.default').prop('checked', false);
			}
			else if ( checked && !cb.hasClass( 'default' ) )
			{
				checkboxes.first().prop('checked', false);
			}
			save();
		});

		function save()
		{
			var obj = [];
			checkboxes.each( function( e )
			{
				var cb = jQuery(this);
				var checked = cb.prop( 'checked' );
				var is_default = cb.hasClass('default');
				if ( checked && is_default )
				{
					obj = '';
					return false;
				}
				else if ( checked )
				{
					obj.push ( cb.val() );
				}
			});

			if ( obj.length == 0 )
				obj = '';

			if ( typeof obj !== 'string' )
				obj = JSON.stringify ( obj );
			input.val ( obj );
		}
	});
});