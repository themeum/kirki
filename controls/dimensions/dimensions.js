wp.customize.controlConstructor['kirki-dimensions'] = wp.customize.Control.extend({

	ready: function() {

		'use strict';

		var control     = this,
		    subControls = control.params.choices.controls,
		    value       = {},
		    subsArray   = [],
		    i;

		_.each( subControls, function( v, i ) {
			if ( true === v ) {
				subsArray.push( i );
			}
		} );

		for ( i = 0; i < subsArray.length; i++ ) {

			value[ subsArray[ i ] ] = control.setting._value[ subsArray[ i ] ];

			control.updateDimensionsValue( subsArray[ i ], value );

		}

	},

	/**
	 * Updates the value.
	 */
	updateDimensionsValue: function( context, value ) {

		var control = this;

		control.container.on( 'change keyup paste', '.' + context + ' input', function() {
			value[ context ] = jQuery( this ).val();

			// Notifications.
			control.kirkiNotifications();

			// Save the value
			control.saveValue( value );
		});

	},

	/**
	 * Saves the value.
	 */
	saveValue: function( value ) {

		'use strict';

		var control  = this,
		    newValue = {};

		_.each( value, function( newSubValue, i ) {
			newValue[ i ] = newSubValue;
		});

		control.setting.set( newValue );
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
						subs.top = dimensionskirkiL10n.top;
					} else {
						delete subs.top;
					}
				}

				if ( 'undefined' !== typeof value.bottom ) {
					if ( false === control.kirkiValidateCSSValue( value.bottom ) ) {
						subs.bottom = dimensionskirkiL10n.bottom;
					} else {
						delete subs.bottom;
					}
				}

				if ( 'undefined' !== typeof value.left ) {
					if ( false === control.kirkiValidateCSSValue( value.left ) ) {
						subs.left = dimensionskirkiL10n.left;
					} else {
						delete subs.left;
					}
				}

				if ( 'undefined' !== typeof value.right ) {
					if ( false === control.kirkiValidateCSSValue( value.right ) ) {
						subs.right = dimensionskirkiL10n.right;
					} else {
						delete subs.right;
					}
				}

				if ( ! _.isEmpty( subs ) ) {
					message = dimensionskirkiL10n['invalid-value'] + ' (' + _.values( subs ).toString() + ') ';
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
