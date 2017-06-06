wp.customize.controlConstructor['kirki-radio'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		'use strict';

		var control = this,
		    section = control.section.get();

		jQuery( '#accordion-section-' + section ).on( 'click', function() {
			control.initKirkiControl();
		});

		if ( jQuery( '#sub-accordion-section-' + section ).hasClass( 'open' ) ) {
			control.initKirkiControl();
		}
	},

	initKirkiControl: function() {

		'use strict';

		var control = this;

		// Change the value
		this.container.on( 'change', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});

	}

});
