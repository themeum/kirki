/* global numberKirkiL10n */
wp.customize.controlConstructor['kirki-number'] = wp.customize.kirkiDynamicControl.extend({

	initKirkiControl: function() {

		var control = this,
		    value   = control.setting._value,
		    html    = '',
		    input,
		    up,
		    down;

		// Make sure we use default values if none are define for some arguments.
		control.params.choices = _.defaults( control.params.choices, {
			min: 0,
			max: 100,
			step: 1
		} );

		// Make sure we have a valid value.
		if ( isNaN( value ) || '' === value ) {
			value = ( 0 > control.params.choices.min && 0 < control.params.choices.max ) ? 0 : control.params.choices.min;
		}
		value = parseFloat( value );

		// If step is 'any', set to 0.001.
		control.params.choices.step = ( 'any' === control.params.choices.step ) ? 0.001 : control.params.choices.step;

		// Make sure choices are properly formtted as numbers.
		control.params.choices.min  = parseFloat( control.params.choices.min );
		control.params.choices.max  = parseFloat( control.params.choices.max );
		control.params.choices.step = parseFloat( control.params.choices.step );

		// Build the HTML for the control.
		html += '<label>';
		if ( control.params.label ) {
			html += '<span class="customize-control-title">' + control.params.label + '</span>';
		}
		if ( control.params.description ) {
			html += '<span class="description customize-control-description">' + control.params.description + '</span>';
		}
		html += '<div class="customize-control-content">';
		html += '<input ' + control.params.inputAttrs + ' type="text" ' + control.params.link + ' value="' + value + '" />';
		html += '<div class="quantity button minus">-</div>';
		html += '<div class="quantity button plus">+</div>';
		html += '</div>';
		html += '</label>';

		control.container.html( html );

		input = control.container.find( 'input' );
		up    = control.container.find( '.plus' );
		down  = control.container.find( '.minus' );

		up.click( function() {
			var oldVal = parseFloat( input.val() ),
			    newVal;

			newVal = ( oldVal >= control.params.choices.max ) ? oldVal : oldVal + control.params.choices.step;

			input.val( newVal );
			input.trigger( 'change' );
		} );

		down.click( function() {
			var oldVal = parseFloat( input.val() ),
			    newVal;

			newVal = ( oldVal <= control.params.choices.min ) ? oldVal : oldVal - control.params.choices.step;

			input.val( newVal );
			input.trigger( 'change' );
		} );

		this.container.on( 'change keyup paste click', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
