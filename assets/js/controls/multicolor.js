/**
 * KIRKI CONTROL: MULTICOLOR
 */
wp.customize.controlConstructor['multicolor'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;

		var colors_total = control.params.choices['colors'];

		// The current value set in Control Class (set in Kirki_Customize_Repeater_Control::to_json() function)
		var settingValue = this.params.value;

		// The hidden field that keeps the data saved (though we never update it)
		this.settingField = this.container.find('[data-customize-setting-link]').first();

		var i = 0;
		while ( i < colors_total ) {
			function multicolorChangeHandler( control, value, num ) {
				var picker = control.container.find( '.multicolor-index-' + num );
				picker.wpColorPicker({
					change: function( event, ui ) {
						setTimeout( function() {
							settingValue[ num ] = picker.val();
							control.setting.set( settingValue );
							control.container.find( '.multicolor-index-' + num ).trigger('change');
						}, 100 );
					},
				});
			}
			multicolorChangeHandler( this, settingValue, i );
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
