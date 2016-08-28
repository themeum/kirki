function kirkiNotifications( settingName, type, configID ) {

	wp.customize( settingName, function( setting ) {
		setting.bind( function( value ) {
			var code = 'long_title';

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

			}

	    } );

	} );

}
