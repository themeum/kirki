/* global dimensionskirkiL10n */
wp.customize.controlConstructor['kirki-dimensions'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function() {

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
		} );
	},

	/**
	 * Saves the value.
	 */
	saveValue: function( value ) {

		var control  = this,
			newValue = {};

		_.each( value, function( newSubValue, i ) {
			newValue[ i ] = newSubValue;
		} );

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

				_.each( value, function( val, direction ) {
					if ( false === kirki.util.validate.cssValue( val ) ) {
						subs[ direction ] = val;
					} else {
						delete subs[ direction ];
					}
				} );

				if ( ! _.isEmpty( subs ) ) {
					message = dimensionskirkiL10n['invalid-value'] + ' (' + _.values( subs ).toString() + ') ';
					setting.notifications.add( code, new wp.customize.Notification( code, {
						type: 'warning',
						message: message
					} ) );
					return;
				}
				setting.notifications.remove( code );
			} );
		} );
	}
} );
