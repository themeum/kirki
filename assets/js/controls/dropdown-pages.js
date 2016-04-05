/**
 * KIRKI CONTROL: DROPDOWN-PAGES
 */
wp.customize.controlConstructor['dropdown-pages'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		var control = this,
		    element = this.container.find( 'select' );

		jQuery( element ).selectize();
		this.container.on( 'change', 'select', function() {
			control.setting.set( jQuery( this ).val() );
		});

	}

});
