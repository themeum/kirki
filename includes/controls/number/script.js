/**
 * KIRKI CONTROL: NUMBER
 */
jQuery(document).ready(function($) {
	"use strict";
	$( ".customize-control-number input[type='number']").number();
});

wp.customize.controlConstructor['number'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		this.container.on( 'change', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
