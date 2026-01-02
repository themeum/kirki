import "./control.scss";

wp.customize.controlConstructor['kirki-date'] = wp.customize.kirkiDynamicControl.extend({

	handleWidth: (input) => {
		var styleTag = document.querySelector('#kirki-style-datepicker');
		styleTag.innerHTML = '.kirki-datepicker-popup {width: ' + input.clientWidth.toString() + 'px;}';
	},

	initKirkiControl: function (control) {
		var selector;

		control = control || this;
		selector = control.selector + ' input.datepicker';

		var styleTag = document.querySelector('#kirki-style-datepicker');

		if (!styleTag) {
			styleTag = document.createElement('style');
			styleTag.id = 'kirki-style-datepicker';
			document.head.appendChild(styleTag);
		}

		// Init the datepicker.
		jQuery(selector).datepicker({
			dateFormat: 'yy-mm-dd',
			duration: 200,
			beforeShow: function (input, inst) {
				inst.dpDiv[0].classList.add('kirki-datepicker-popup');
				control.handleWidth(input);
			}
		});

		// Save the changes
		this.container.on('change keyup paste', 'input.datepicker', function () {
			control.setting.set(jQuery(this).val());
		});
	}
});
