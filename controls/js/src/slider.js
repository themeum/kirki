wp.customize.controlConstructor['kirki-slider'] = wp.customize.kirkiDynamicControl.extend({

	initKirkiControl: function() {
		var control      = this,
		    changeAction = ( 'postMessage' === control.setting.transport ) ? 'mousemove change' : 'change',
			rangeInput   = control.container.find( 'input[type="range"]' ),
			textInput    = control.container.find( 'input[type="text"]' ),
		    value        = control.setting._value;

		// Set the initial value in the text input.
		textInput.attr( 'value', value );

		// The range input changed.
		rangeInput.on( changeAction, function() {

			// Update value in text input.
			textInput.attr( 'value', rangeInput.val() );

			// Save value.
			control.setting.set( rangeInput.val() );
		});

		// The text input changed.
		textInput.on( 'input paste change', function() {

			// Update value in text input.
			rangeInput.attr( 'value', textInput.val() );

			// Save value.
			control.setting.set( textInput.val() );
		});
	}
});
