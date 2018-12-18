jQuery( document ).ready( function( e )
{
	jQuery( '.kirki-metabox.customize-control-kirki-slider' ).each ( function ( e )
		{
				var container = $ ( this ),
				control = container.find ( 'input[data-link]' ),
				rangeInput   = container.find( 'input[type="range"]' ),
				textInput    = container.find( 'input[type="text"]' ),
				value        = rangeInput.val();
			var params = JSON.parse ( container.attr ( 'kirki-args' ) );
			// Set the initial value in the text input.
			textInput.attr( 'value', value );

			// If the range input value changes copy the value to the text input.
			rangeInput.on( 'mousemove change', function() {
				textInput.attr( 'value', rangeInput.val() );
			} );

			// If the text input value changes,
			// copy the value to the range input
			// and then save.
			textInput.on( 'input paste change', function() {
				rangeInput.attr( 'value', textInput.val() );
			} );

			// If the reset button is clicked,
			// set slider and text input values to default
			// and hen save.
			container.find( '.slider-reset' ).on( 'click', function() {
				textInput.attr( 'value', params.default );
				rangeInput.attr( 'value', params.default );
			} );
		});
});