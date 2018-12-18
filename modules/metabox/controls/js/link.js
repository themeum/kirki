jQuery(document).ready(function()
{
	jQuery( '.kirki-mb-link-outer' ).each( function( e )
	{
		var container = jQuery( this );
		var link_outer = jQuery( '.link-outer', container );
		var link_val = jQuery( 'input.link', link_outer );
		var link_select_btn = jQuery( 'button.select-link', link_outer );

		var options_outer = jQuery('.options-outer', container );
		var target_check = jQuery('.target input[type="checkbox"]', options_outer);
		var rel_check = jQuery('.rel input[type="checkbox"]', options_outer);

		var meta_field = jQuery('input[kirki-metabox-link]', container);
		function save()
		{
			var rel = rel_check.prop('checked') ? 'nofollow' : 'follow';
			var target = target_check.prop('checked') ? '_blank' : 'self';
			var url = link_val.val();

			var obj = {
				url: url,
				rel: rel,
				target: target
			};

			meta_field.val ( JSON.stringify ( obj ) );
		}

		link_select_btn.click(function(e)
		{
			e.preventDefault();
			alert ('Not implemented...');
		})

		link_val.change(function()
		{
			save();
		});

		target_check.change(function()
		{
			save();
		});

		rel_check.change(function()
		{
			save();
		});

	});
});