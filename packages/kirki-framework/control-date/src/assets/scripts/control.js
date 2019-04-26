wp.customize.controlConstructor['kirki-date'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function( control ) {
		var selector;
		control  = control || this;
		selector = control.selector + ' input.datepicker';

		// Init the datepicker
		jQuery( selector ).datepicker( {
			dateFormat: 'yy-mm-dd'
		} );

		// Save the changes
		this.container.on( 'change keyup paste', 'input.datepicker', function() {
			control.setting.set( jQuery( this ).val() );
		} );
	}
} );
