jQuery( document ).ready( function() {
	wp.customize.control.each( function( control ) {
		wp.customize.Control.extend({
			ready: function() {
				console.log( this );
			}
		})
	});
});
