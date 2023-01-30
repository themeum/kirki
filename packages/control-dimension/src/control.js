import "./control.scss";

/* global dimensionkirkiL10n */
wp.customize.controlConstructor['kirki-dimension'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function( control ) {
		var value;
		control = control || this;

		// Notifications.
		control.kirkiNotifications();

		// Save the value
		control.container.on( 'change keyup paste', 'input', function() {
			value = jQuery( this ).val();
			control.setting.set( value );
		} );
	},

	/**
	 * Handles notifications.
	 *
	 * @returns {void}
	 */
	kirkiNotifications: function() {

		var control        = this,
			acceptUnitless = ( 'undefined' !== typeof control.params.choices && 'undefined' !== typeof control.params.choices.accept_unitless && true === control.params.choices.accept_unitless );

		wp.customize( control.id, function( setting ) {
			setting.bind( function( value ) {
				var code = 'long_title';

				if ( false === control.validateCssValue( value ) && ( ! acceptUnitless || isNaN( value ) ) ) {
					setting.notifications.add( code, new wp.customize.Notification( code, {
						type: 'warning',
						message: dimensionkirkiL10n['invalid-value']
					} ) );
				} else {
					setting.notifications.remove( code );
				}
			} );
		} );
	},

	validateCssValue: function( value ) {

		var control = this,
			validUnits = [ 'fr', 'rem', 'em', 'ex', '%', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ch', 'vh', 'vw', 'vmin', 'vmax' ],
			numericValue,
			unit,
			multiples,
			multiplesValid = true;

		// Whitelist values.
		if ( ! value || '' === value || 0 === value || '0' === value || 'auto' === value || 'inherit' === value || 'initial' === value ) {
			return true;
		}

		// Skip checking if calc().
		if ( 0 <= value.indexOf( 'calc(' ) && 0 <= value.indexOf( ')' ) ) {
			return true;
		}

		// Get the numeric value.
		numericValue = parseFloat( value );

		// Get the unit
		unit = value.replace( numericValue, '' );

		// Allow unitless.
		if ( ! unit ) {
			return true;
		}

		// Check for multiple values.
		multiples = value.split( ' ' );
		if ( 2 <= multiples.length ) {
			multiples.forEach( function( item ) {
				if ( item && ! control.validateCssValue( item ) ) {
					multiplesValid = false;
				}
			});

			return multiplesValid;
		}

		// Check the validity of the numeric value and units.
		return ( ! isNaN( numericValue ) && -1 !== validUnits.indexOf( unit ) );
	}
} );
