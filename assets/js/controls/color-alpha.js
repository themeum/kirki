/**
 * KIRKI CONTROL: COLOR-ALPHA
 */
wp.customize.controlConstructor['color-alpha'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this,
			picker = this.container.find('.kirki-color-control');
			console.log(picker);

		this.setting.bind( function ( value ) {
			console.log( picker.val( value ) );
			picker.wpColorPicker( 'color', value );
		});
	}
});
