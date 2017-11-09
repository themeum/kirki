wp.customize.controlConstructor['kirki-slider'] = wp.customize.kirkiDynamicControl.extend({

	initKirkiControl: function() {
		var control      = this,
		    changeAction = ( 'postMessage' === control.setting.transport ) ? 'mousemove change' : 'change',
			rangeInput   = control.container.find( 'input[type="range"]' ),
			textInput    = control.container.find( 'input[type="text"]' ),
		    value        = control.setting._value;

		// Set the initial value in the text input.
		textInput.attr( 'value', value );

		// If the range input value changes,
		// copy the value to the text input
		// and then save.
		rangeInput.on( changeAction, function() {
			textInput.attr( 'value', rangeInput.val() );
			control.setting.set( rangeInput.val() );
		} );

		// If the text input value changes,
		// copy the value to the range input
		// and then save.
		textInput.on( 'input paste change', function() {
			rangeInput.attr( 'value', textInput.val() );
			control.setting.set( textInput.val() );
		} );

		// If the reset button is clicked,
		// set slider and text input values to default
		// and hen save.
		control.container.find( '.slider-reset' ).on( 'click', function() {
			textInput.attr( 'value', control.params['default'] );
			rangeInput.attr( 'value', control.params['default'] );
			control.setting.set( textInput.val() );
		} );
	}
});
