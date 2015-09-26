/**
 * KIRKI CONTROL: PRESET
 */
wp.customize.controlConstructor['preset'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		var element = this.container.find( 'select' );

		jQuery( element ).selectize();

		this.container.on( 'change', 'select', function() {
			var select_value = jQuery( this ).val();
			control.setting.set( select_value );
			jQuery.each( control.params.choices, function( key, value ) {
				if ( select_value == key ) {
					jQuery.each( value['settings'], function( preset_setting, preset_setting_value ) {
						setting_obj = wp.customize.instance( preset_setting );
						setting_obj.set( preset_setting_value );
					});
				}
			});
			wp.customize.previewer.refresh();
		});
	}
});
