/**
 * KIRKI CONTROL: COLOR-ALPHA
 */
wp.customize.controlConstructor['color-alpha'] = wp.customize.Control.extend( {
	ready: function() {
		var control   = this;
		var picker    = this.container.find( '.kirki-color-control' );
		var new_color = picker.val();

		picker.wpColorPicker({
			change: function( event, ui ) {
				setTimeout( function(){
					control.setting.set( picker.val() );
				}, 100 );
			},
		});
	}
});
