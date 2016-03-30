/**
 * KIRKI CONTROL: MULTICOLOR
 */
wp.customize.controlConstructor['multicolor'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this,
		    colors  = control.params.choices,
		    keys    = Object.keys( colors ),
		    value   = this.params.value;

		// The hidden field that keeps the data saved (though we never update it)
		this.settingField = this.container.find( '[data-customize-setting-link]' ).first();

		var i = 0;
		while ( i < Object.keys( colors ).length ) {
			function multicolorChangeHandler( control, value, sub_setting ) {
				var picker = control.container.find( '.multicolor-index-' + sub_setting );
				picker.wpColorPicker({
					change: function( event, ui ) {
						setTimeout( function() {
							value[ sub_setting ] = picker.val();
							control.setting.set( value );
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
