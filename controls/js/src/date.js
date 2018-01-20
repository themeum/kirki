wp.customize.controlConstructor['kirki-date'] = wp.customize.kirkiDynamicControl.extend({

	initKirkiControl: function() {

		var control = this,
		    includeTime;

		// Only add in WP 4.9+.
		if ( _.isUndefined( wp.customize.DateTimeControl ) ) {
			return;
		}

		// Do we want to include time?
		includeTime = ( control.params && control.params.chices && control.params.choices.include_time );
		includeTime = ( true === includeTime );

		// New method for the DateTime control.
		wp.customize.control.add( new wp.customize.DateTimeControl( control.id, {
			section: control.params.section,
			includeTime: includeTime,
			priority: control.params.priority,
			label: control.params.label,
			description: control.params.description,
			settings: { 'default': control.id },
			'default': control.params['default']
		} ) );
	}
});
