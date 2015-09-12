jQuery(document).ready(function($) {

	$( 'span.toggle-label' ).on( 'click', function() {
		var $checkbox = $( this ).closest( '.customize-control-toggle' ).find( 'input.toggle-checkbox' );
		if ( $checkbox.is( ':checked' ) ) {
			$checkbox.prop( 'checked', false );
		} else {
			$checkbox.prop( 'checked', true );
		}
	});

});
