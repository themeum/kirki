wp.customize.controlConstructor['kirki-spacing'] = wp.customize.Control.extend({

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

			control.updateSpacingValue( subsArray[ i ], value );

		}

	},

	/**
	 * Updates the value.
	 */
	updateSpacingValue: function( context, value ) {

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
					if ( false === kirkiValidateCSSValue( value.top ) ) {
						subs.top = window.kirki.l10n[ control.params.kirkiConfig ].top;
					} else {
						delete subs.top;
					}
				}

				if ( 'undefined' !== typeof value.bottom ) {
					if ( false === kirkiValidateCSSValue( value.bottom ) ) {
						subs.bottom = window.kirki.l10n[ control.params.kirkiConfig ].bottom;
					} else {
						delete subs.bottom;
					}
				}

				if ( 'undefined' !== typeof value.left ) {
					if ( false === kirkiValidateCSSValue( value.left ) ) {
						subs.left = window.kirki.l10n[ control.params.kirkiConfig ].left;
					} else {
						delete subs.left;
					}
				}

				if ( 'undefined' !== typeof value.right ) {
					if ( false === kirkiValidateCSSValue( value.right ) ) {
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
	}

});
