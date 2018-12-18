jQuery( document ).ready ( function()
{
	jQuery( '.kirki-color-picker-outer' ).each ( function ( e )
	{
		var container = jQuery( this );
		var input = jQuery( '.color-picker', container );
		var params = JSON.parse ( container.attr ( 'kirki-args' ) );
		var args = {};
		input.wpColorPicker(args);
	});
});