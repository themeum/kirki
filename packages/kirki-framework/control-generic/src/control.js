wp.customize.controlConstructor['kirki-generic'] = wp.customize.kirkiDynamicControl.extend( {
	initKirkiControl: function( control ) {
        control = control || this;
        control.container.find( 'input, textarea' ).on( 'change keyup paste click', function() {
            control.setting.set( jQuery( this ).val() );
        } );
	}
} );
