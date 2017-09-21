wp.customize.controlConstructor['kirki-slider'] = wp.customize.kirkiDynamicControl.extend({

	initKirkiControl: function() {
		var control = this,
		    value,
		    thisInput,
		    inputDefault,
		    changeAction;

		// Update the text value
		jQuery( 'input[type=range]' ).on( 'mousedown', function() {
			value = jQuery( this ).attr( 'value' );
			jQuery( this ).mousemove( function() {
				value = jQuery( this ).attr( 'value' );
				jQuery( this ).closest( 'label' ).find( '.kirki_range_value .value' ).text( value );
			});
		});

		// Handle the reset button
		jQuery( '.kirki-slider-reset' ).click( function() {
			thisInput    = jQuery( this ).closest( 'label' ).find( 'input' );
			inputDefault = thisInput.data( 'reset_value' );
			thisInput.val( inputDefault );
			thisInput.change();
			jQuery( this ).closest( 'label' ).find( '.kirki_range_value .value' ).text( inputDefault );
		});

		changeAction = ( 'postMessage' === control.setting.transport ) ? 'mousemove change' : 'change';

		// Save changes.
		control.container.on( changeAction, 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
