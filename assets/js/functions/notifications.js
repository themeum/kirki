function xtkirkiNotifications( settingName, type, configID ) {

	wp.customize( settingName, function( setting ) {
		setting.bind( function( value ) {
			var code = 'long_title',
			    subs = {},
			    message;

			// Dimension fields.
			if ( 'xtkirki-dimension' === type ) {

				message = window.xtkirki.l10n[ configID ]['invalid-value'];

				if ( false === xtkirkiValidateCSSValue( value ) ) {
					xtkirkiNotificationsWarning( setting, code, message );
				} else {
					setting.notifications.remove( code );
				}

			}

			// Spacing fields.
			if ( 'xtkirki-spacing' === type ) {

				setting.notifications.remove( code );
				if ( 'undefined' !== typeof value.top ) {
					if ( false === xtkirkiValidateCSSValue( value.top ) ) {
						subs.top = window.xtkirki.l10n[ configID ].top;
					} else {
						delete subs.top;
					}
				}

				if ( 'undefined' !== typeof value.bottom ) {
					if ( false === xtkirkiValidateCSSValue( value.bottom ) ) {
						subs.bottom = window.xtkirki.l10n[ configID ].bottom;
					} else {
						delete subs.bottom;
					}
				}

				if ( 'undefined' !== typeof value.left ) {
					if ( false === xtkirkiValidateCSSValue( value.left ) ) {
						subs.left = window.xtkirki.l10n[ configID ].left;
					} else {
						delete subs.left;
					}
				}

				if ( 'undefined' !== typeof value.right ) {
					if ( false === xtkirkiValidateCSSValue( value.right ) ) {
						subs.right = window.xtkirki.l10n[ configID ].right;
					} else {
						delete subs.right;
					}
				}

				if ( ! _.isEmpty( subs ) ) {
					message = window.xtkirki.l10n[ configID ]['invalid-value'] + ' (' + _.values( subs ).toString() + ') ';
					xtkirkiNotificationsWarning( setting, code, message );
				} else {
					setting.notifications.remove( code );
				}

			}

	    } );

	} );

}

function xtkirkiNotificationsWarning( setting, code, message ) {

	setting.notifications.add( code, new wp.customize.Notification(
		code,
		{
			type: 'warning',
			message: message
		}
	) );

}
