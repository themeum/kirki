wp.customize.controlConstructor['kirki-date'] = wp.customize.kirkiDynamicControl.extend({

	initKirkiControl: function() {

		var control  = this,
		    selector = control.selector + ' input.datepicker';

		// Add the control (fallback for older versions of WP).
		if ( _.isUndefined( wp.customize.DateTimeControl ) ) {

			// Init the datepicker
			jQuery( selector ).datepicker();

			// Save the changes
			this.container.on( 'change keyup paste', 'input.datepicker', function() {
				control.setting.set( jQuery( this ).val() );
			} );
			return;
		}

		// New method for the DateTime control.
		wp.customize.control.add( new wp.customize.DateTimeControl( control.id, {
			section: control.params.section,
			priority: control.params.priority,
			label: control.params.label,
			description: control.params.description,
			setting: control.id,
			'default': control.params['default']
		} ) );
	}
});
