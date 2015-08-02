jQuery( document ).ready( function() {
	jQuery( '.customize-control-dimension input[type="text"]' ).on( 'change', function() {
		numeric_value = jQuery( this ).parents( '.customize-control' ).find( 'input[type="text"]' ).map(
			function() {
				return this.value;
			}
		).get();
		units_value = jQuery( this ).parents( '.customize-control' ).find( 'select' ).map(
			function() {
				return this.value;
			}
		).get();
		jQuery( this ).parents( '.customize-control' ).find( 'input[type="hidden"]' ).val( numeric_value[0] + units_value[0] ).trigger( 'change' );
	} );
} );
