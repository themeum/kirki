jQuery( document ).ready( function() {
	jQuery( '.customize-control-dimension input[type="text"]' ).on( 'change', function() {
		// Get the numeric value from the text input
		numeric_value = jQuery( this ).parents( '.customize-control' ).find( 'input[type="text"]' ).map(
			function() { return this.value; }
		).get();
		// Get the units value from the dropdown
		units_value = jQuery( this ).parents( '.customize-control' ).find( 'select' ).map(
			function() { return this.value; }
		).get();
		// Combine numeric value + units to get the final result of the input field
		jQuery( this ).parents( '.customize-control' ).find( 'input[type="hidden"]' ).val( numeric_value[0] + units_value[0] ).trigger( 'change' );
	} );
} );
