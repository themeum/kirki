/**
 * KIRKI CONTROL: SLIDER
 */
jQuery( document ).ready(function() {

	// Update the text value
	jQuery( 'input[type=range]' ).on( 'mousedown', function() {

		var value = jQuery( this ).attr( 'value' );

		jQuery( this ).mousemove(function() {
			value = jQuery( this ).attr( 'value' );
			jQuery( this ).closest( 'label' ).find( '.kirki_range_value .value' ).text( value );
		});

	});

	// Handle the reset button
	jQuery( '.kirki-slider-reset' ).click( function() {

		var thisInput    = jQuery( this ).closest( 'label' ).find( 'input' ),
			inputDefault = thisInput.data( 'reset_value' );

		thisInput.val( inputDefault );
		thisInput.change();
		jQuery( this ).closest( 'label' ).find( '.kirki_range_value .value' ).text( inputDefault );

	});

});

wp.customize.controlConstructor.slider = wp.customize.Control.extend({

	ready: function() {

		var control = this;
		this.container.on( 'change', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}

});
