/**
 * KIRKI CONTROL: KIRKI-SELECT
 */
function kirkiArrayToObject( arr ) {
	var rv = {};
	if ( null !== arr ) {
		for ( var i = 0; i < arr.length; ++i ) {
			if ( arr[i] !== undefined ) rv[i] = arr[i];
		}
	}
	return rv;
}

wp.customize.controlConstructor['kirki-select'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;

		var element  = this.container.find( 'select' );
		var multiple = parseInt( element.data( 'multiple' ) );

		if ( multiple > 1 ) {
			jQuery( element ).selectize({
				maxItems: multiple,
				plugins: ['remove_button', 'drag_drop']
			});
		} else {
			jQuery( element ).selectize();
		}

		this.container.on( 'change', 'select', function() {
			if ( multiple > 1 ) {
				var select_value = kirkiArrayToObject( jQuery( this ).val() );
			} else {
				var select_value = jQuery( this ).val();
			}
			control.setting.set( select_value );
		});
	}
});
