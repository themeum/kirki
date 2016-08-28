function kirkiNotifications( settingName, type, configID ) {

	wp.customize( settingName, function( setting ) {
		setting.bind( function( value ) {
			var code = 'long_title',
			    subs = {};

			// Dimension fields.
			if ( 'kirki-dimension' === type ) {

				if ( false === kirkiValidateCSSValue( value ) ) {
					setting.notifications.add( code, new wp.customize.Notification(
						code,
						{
							type: 'warning',
							message: window.kirki.l10n[ configID ]['invalid-value']
						}
					) );
				} else {
					setting.notifications.remove( code );
				}

			} else if ( 'kirki-spacing' === type ) {

				if ( 'undefined' !== typeof value.top ) {
					if ( false === kirkiValidateCSSValue( value.top ) ) {
						subs.top = window.kirki.l10n[ configID ].top;
					} else {
						delete subs.top;
					}
				}

				if ( 'undefined' !== typeof value.bottom ) {
					if ( false === kirkiValidateCSSValue( value.bottom ) ) {
						subs.bottom = window.kirki.l10n[ configID ].bottom;
					} else {
						delete subs.bottom;
					}
				}

				if ( 'undefined' !== typeof value.left ) {
					if ( false === kirkiValidateCSSValue( value.left ) ) {
						subs.left = window.kirki.l10n[ configID ].left;
					} else {
						delete subs.left;
					}
				}

				if ( 'undefined' !== typeof value.right ) {
					if ( false === kirkiValidateCSSValue( value.right ) ) {
						subs.right = window.kirki.l10n[ configID ].right;
					} else {
						delete subs.right;
					}
				}

				if ( ! _.isEmpty( subs ) ) {

					setting.notifications.add( code, new wp.customize.Notification(
						code,
						{
							type: 'warning',
							message: window.kirki.l10n[ configID ]['invalid-value']
						}
					) );
				} else {
					setting.notifications.remove( code );
				}

			}

	    } );

	} );

}
