wp.customize.controlConstructor['kirki-dimension'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		'use strict';

		var control = this,
		    value;

		// Notifications.
		control.kirkiNotifications();

		// Save the value
		this.container.on( 'change keyup paste', 'input', function() {

			value = jQuery( this ).val();
			control.setting.set( value );

		});

	},

	/**
	 * Handles notifications.
	 */
	kirkiNotifications: function() {

		var control = this;

		wp.customize( control.id, function( setting ) {
			setting.bind( function( value ) {
				var code = 'long_title',
					subs = {},
					message;

				if ( false === control.kirkiValidateCSSValue( value ) ) {
					setting.notifications.add( code, new wp.customize.Notification(
						code,
						{
							type: 'warning',
							message: dimensionkirkiL10n['invalid-value']
						}
					) );
				} else {
					setting.notifications.remove( code );
				}

			} );

		} );
	},
	kirkiValidateCSSValue: function( value ) {

		var validUnits = ['rem', 'em', 'ex', '%', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ch', 'vh', 'vw', 'vmin', 'vmax'],
		    numericValue,
		    unit;

		// 0 is always a valid value, and we can't check calc() values effectively.
		if ( '0' === value || ( 0 <= value.indexOf( 'calc(' ) && 0 <= value.indexOf( ')' ) ) ) {
			return true;
		}

		// Get the numeric value.
		numericValue = parseFloat( value );

		// Get the unit
		unit = value.replace( numericValue, '' );

		// Check the validity of the numeric value and units.
		if ( isNaN( numericValue ) || -1 === jQuery.inArray( unit, validUnits ) ) {
			return false;
		}

		return true;

	}

});
