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

		// Notifications.
		control.kirkiNotifications();

	},

	/**
	 * Handles notifications.
	 */
	kirkiNotifications: function() {

		var control = this;

		wp.customize( control.id, function( setting ) {
			setting.bind( function( value ) {
				var code    = 'long_title',
					subs    = {},
					min     = false,
					max     = false,
					step    = false,
					invalid = false,
					message;

				// Make sure value is a number.
				value = Number( value );

				if ( 'undefined' !== typeof control.params.choices.min ) {
					min = Number( control.params.choices.min );
				}
				if ( 'undefined' !== typeof control.params.choices.max ) {
					max = Number( control.params.choices.max );
				}
				if ( 'undefined' !== typeof control.params.choices.step ) {
					step = Number( control.params.choices.step );
				}

				if ( false !== min && value < min ) {
					invalid = 'min-error';
				} else if ( false !== max && value > max ) {
					invalid = 'max-error';
				} else if ( false !== step && false !== min ) {
					if ( ! Number.isInteger( ( value - min ) / step ) ) {
						invalid = 'step-error';
					}
				}

				if ( false !== invalid ) {
					setting.notifications.add( code, new wp.customize.Notification(
						code,
						{
							type: 'warning',
							message: numberKirkiL10n[ invalid ]
						}
					) );
				} else {
					setting.notifications.remove( code );
				}

			} );

		} );
	}

});
