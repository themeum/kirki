/**
 * KIRKI CONTROL: SLIDER
 */
jQuery(document).ready(function($) {

	// Update the text value
	$( 'input[type=range]' ).on( 'mousedown', function() {

		value = $( this ).attr( 'value' );
		$( this ).mousemove(function() {
			value = $( this ).attr( 'value' );
			$( this ).closest( 'label' ).find( '.kirki_range_value .value' ).text( value );
		});

	});

	// Handle the reset button
	$( '.kirki-slider-reset' ).click( function () {

		var $this_input   = $( this ).closest( 'label' ).find( 'input' ),
			input_default = $this_input.data( 'reset_value' );

		$this_input.val( input_default );
		$this_input.change();
		$( this ).closest( 'label' ).find( '.kirki_range_value .value' ).text( input_default );

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
