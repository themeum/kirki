/* global numberKirkiL10n */
wp.customize.controlConstructor['kirki-number'] = wp.customize.kirkiDynamicControl.extend({

	initKirkiControl: function() {

		var control = this,
		    element = this.container.find( 'input' ),
		    step    = 1;

		// Set step value.
		if ( ! _.isUndefined( control.params.choices ) && ! _.isUndefined( control.params.choices.step ) ) {
			step = ( 'any' === control.params.choices.step ) ? '0.001' : control.params.choices.step;
		}

		// Init the spinner
		jQuery( element ).spinner({
			min: ( ! _.isUndefined( control.params.choices ) && ! _.isUndefined( control.params.choices.min ) ) ? control.params.choices.min : -99999,
			max: ( ! _.isUndefined( control.params.choices ) && ! _.isUndefined( control.params.choices.max ) ) ? control.params.choices.max : 99999,
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
				    min     = ( ! _.isUndefined( control.params.choices.min ) ) ? Number( control.params.choices.min ) : false,
				    max     = ( ! _.isUndefined( control.params.choices.max ) ) ? Number( control.params.choices.max ) : false,
				    step    = ( ! _.isUndefined( control.params.choices.step ) ) ? Number( control.params.choices.step ) : false,
				    invalid = false;

				// Make sure value is a number.
				value = Number( value );

				if ( false !== min && value < min ) {
					invalid = 'min-error';
				} else if ( false !== max && value > max ) {
					invalid = 'max-error';
				} else if ( false !== step && false !== min && ! Number.isInteger( ( value - min ) / step ) ) {
					invalid = 'step-error';
				}

				if ( false !== invalid ) {
					setting.notifications.add( code, new wp.customize.Notification( code, {
						type: 'warning',
						message: numberKirkiL10n[ invalid ]
					} ) );
				} else {
					setting.notifications.remove( code );
				}
			});
		});
	}
});
