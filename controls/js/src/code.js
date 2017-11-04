wp.customize.controlConstructor['kirki-code'] = wp.customize.kirkiDynamicControl.extend({

	initKirkiControl: function() {

		var control  = this;

		// Early exit if wp.customize.CodeEditorControl is not available.
		if ( _.isUndefined( wp.customize.CodeEditorControl ) ) {
			return;
		}

		// Hide the textarea.
		jQuery( control.container.find( 'textarea.kirki-codemirror-editor' ) ).hide();

		// Add the control.
		wp.customize.control.add( new wp.customize.CodeEditorControl( control.id, {
			section: control.params.section,
			priority: control.params.priority,
			label: control.params.label,
			editor_settings: {
				codemirror: {
					mode: control.params.choices.language
				}
			},
			settings: { 'default': control.id }
		} ) );
	}
});
