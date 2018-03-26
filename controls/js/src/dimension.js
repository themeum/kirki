/* global dimensionkirkiL10n */
wp.customize.controlConstructor['kirki-dimension'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function() {

		var control = this,
			value;

		// Notifications.
		control.kirkiNotifications();

		// Save the value
		this.container.on( 'change keyup paste', 'input', function() {

			value = jQuery( this ).val();
			control.setting.set( value );
		} );
	},

	/**
	 * Handles notifications.
	 */
	kirkiNotifications: function() {

		var control = this;

		wp.customize( control.id, function( setting ) {
			setting.bind( function( value ) {
				var code = 'long_title';

				if ( false === kirki.util.validate.cssValue( value ) ) {
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
	}
} );
