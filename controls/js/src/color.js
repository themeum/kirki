/* global kirki */
wp.customize.controlConstructor['kirki-color'] = wp.customize.kirkiDynamicControl.extend({

	initKirkiControl: function() {
		var control = this,
			data    = {
				label: control.params.label,
				description: control.params.description,
				mode: control.params.mode,
				inputAttrs: control.params.inputAttrs,
				'data-palette': control.params.palette,
				'data-default-color': control.params['default'],
				'data-alpha': control.params.choices.alpha,
				value: control.setting._value,
				link: control.params.link
		    },
		    html = kirki.input.color.template( data ),
		    picker,
		    clear;

		// Add the HTML for the control.
		control.container.html( html );

		// Init the control.
		kirki.input.color.init( control );

	}
});
