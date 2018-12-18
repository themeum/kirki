jQuery(document).ready( function(e)
{
	jQuery( '.kirki-mb-sortable-outer' ).each(function ( e )
	{
		var container = jQuery(this);
		var input = jQuery( 'input[kirki-metabox-link]', container );
		var sortable_list = jQuery( 'ul.sortable', container );

		sortable_list.sortable({
			stop: function()
			{
				save()
			}
		}).disableSelection().find( 'li' ).each( function() {
			// Enable/disable options when we click on the eye of Thundera.
			jQuery( this ).find( 'i.visibility' ).click( function() {
				jQuery( this ).toggleClass( 'dashicons-visibility-faint' ).parents( 'li:eq(0)' ).toggleClass( 'invisible' );
			} );
		} ).click( function() {
			save();
		} );

		function save()
		{
			var obj = [];
			sortable_list.find( 'li' ).each( function() {
				if ( ! jQuery( this ).is( '.invisible' ) ) {
					obj.push( jQuery( this ).data( 'value' ) );
				}
			} );
			input.val ( JSON.stringify ( obj ) );
		}
	});
});