wp.customize.controlConstructor['kirki-dimension'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		'use strict';

		var control = this,
		    value;

		// Notifications.
		control.kirkiNotifications( control.id, 'kirki-dimension', control.params.kirkiConfig );

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

				setting.notifications.remove( code );
				if ( 'undefined' !== typeof value.top ) {
					if ( false === control.kirkiValidateCSSValue( value.top ) ) {
						subs.top = window.kirki.l10n[ control.params.kirkiConfig ].top;
					} else {
						delete subs.top;
					}
				}

				if ( 'undefined' !== typeof value.bottom ) {
					if ( false === control.kirkiValidateCSSValue( value.bottom ) ) {
						subs.bottom = window.kirki.l10n[ control.params.kirkiConfig ].bottom;
					} else {
						delete subs.bottom;
					}
				}

				if ( 'undefined' !== typeof value.left ) {
					if ( false === control.kirkiValidateCSSValue( value.left ) ) {
						subs.left = window.kirki.l10n[ control.params.kirkiConfig ].left;
					} else {
						delete subs.left;
					}
				}

				if ( 'undefined' !== typeof value.right ) {
					if ( false === control.kirkiValidateCSSValue( value.right ) ) {
						subs.right = window.kirki.l10n[ control.params.kirkiConfig ].right;
					} else {
						delete subs.right;
					}
				}

				if ( ! _.isEmpty( subs ) ) {
					message = window.kirki.l10n[ control.params.kirkiConfig ]['invalid-value'] + ' (' + _.values( subs ).toString() + ') ';
					setting.notifications.add( code, new wp.customize.Notification(
						code,
						{
							type: 'warning',
							message: message
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

		// 0 is always a valid value
		if ( '0' === value ) {
			return true;
		}

		// If we're using calc() just return true.
		if ( 0 <= value.indexOf( 'calc(' ) && 0 <= value.indexOf( ')' ) ) {
			return true;
		}

		// Get the numeric value.
		numericValue = parseFloat( value );

		// Get the unit
		unit = value.replace( numericValue, '' );

		// Check the validity of the numeric value.
		if ( isNaN( numericValue ) ) {
			return false;
		}

		// Check the validity of the units.
		if ( -1 === jQuery.inArray( unit, validUnits ) ) {
			return false;
		}

		return true;

	}

});
