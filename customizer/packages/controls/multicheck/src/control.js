import "./control.scss";

wp.customize.controlConstructor['kirki-multicheck'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function( control ) {
		control = control || this;
		const container = control.container[0] || control.container;

		// Save the value
		container.addEventListener( 'change', function( event ) {
			// Only handle input checkbox changes
			if ( event.target && event.target.tagName === 'INPUT' && event.target.type === 'checkbox' ) {
				var value = [],
					i = 0;

				// Build the value as an object using the sub-values from individual checkboxes.
				Object.keys( control.params.choices ).forEach( function( key ) {
					const input = container.querySelector( 'input[value="' + key + '"]' );
					if ( input && input.checked ) {
						const parent = input.parentElement;
						if ( parent ) {
							parent.classList.add( 'checked' );
						}
						value[ i ] = key;
						i++;
					} else if ( input ) {
						const parent = input.parentElement;
						if ( parent ) {
							parent.classList.remove( 'checked' );
						}
					}
				} );

				// Update the value in the customizer.
				control.setting.set( value );
			}
		} );
	}
} );
