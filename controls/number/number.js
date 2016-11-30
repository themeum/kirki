wp.customize.controlConstructor['kirki-number'] = wp.customize.Control.extend({

	ready: function() {

		'use strict';

		var control = this,
		    element = this.container.find( 'input' ),
		    step    = 1;

		// Set step value.
		if ( 'undefined' !== typeof control.params.choices && 'undefined' !== typeof control.params.choices.step ) {
			step = ( 'any' === control.params.choices.step ) ? '0.001' : control.params.choices.step;
		}

		// Init the spinner
		jQuery( element ).spinner({
			min: ( 'undefined' !== typeof control.params.choices && 'undefined' !== typeof control.params.choices.min ) ? control.params.choices.min : -99999,
			max: ( 'undefined' !== typeof control.params.choices && 'undefined' !== typeof control.params.choices.max ) ? control.params.choices.max : 99999,
			step: step
		});

		// On change
		this.container.on( 'change click keyup paste', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});

	}

});
