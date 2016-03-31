/**
 * KIRKI CONTROL: MULTICOLOR
 */
wp.customize.controlConstructor['multicolor'] = wp.customize.Control.extend({

	ready: function() {

		var control = this,
		    colors  = control.params.choices,
		    keys    = Object.keys( colors ),
		    value   = this.params.value,
		    i       = 0;

		// The hidden field that keeps the data saved (though we never update it)
		this.settingField = this.container.find( '[data-customize-setting-link]' ).first();

		// colors loop
		while ( i < Object.keys( colors ).length ) {

			// Proxy function that handles changing the individual colors
			function multicolorChangeHandler( control, value, sub_setting ) {

				var picker = control.container.find( '.multicolor-index-' + sub_setting );

				// did we change the value?
				picker.wpColorPicker({
					change: function( event, ui ) {
						// Color controls require a small delay
						setTimeout( function() {
							value[ sub_setting ] = picker.val();
							// Set the value
							control.setting.set( value );
							// Trigger the change
							control.container.find( '.multicolor-index-' + sub_setting ).trigger( 'change' );
						}, 100 );
					},
				});

			}

			multicolorChangeHandler( this, value, keys[ i ] );
			i++;

		}

	},

	/**
	 * Set a new value for the setting
	 *
	 * @param newValue Object
	 * @param refresh If we want to refresh the previewer or not
	 */
	setValue: function( newValue, refresh ) {
		this.setting.set( newValue );

		if ( refresh ) {
			// Trigger the change event on the hidden field so
			// previewer refresh the website on Customizer
			this.settingField.trigger( 'change' );
		}
	},

});
