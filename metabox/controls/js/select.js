jQuery( document ).ready ( function ()
{
	jQuery( '.kirki-mb-select-outer' ).each ( function ( e )
	{
		var self = jQuery( this );
		var select = jQuery( 'select', self );

		select.selectWoo();
	});
});