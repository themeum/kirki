/* global CodeMirror */
wp.customize.controlConstructor['kirki-code'] = wp.customize.kirkiDynamicControl.extend({

	initKirkiControl: function() {

		var control  = this,
		    element  = control.container.find( '.kirki-codemirror-editor' ),
		    language = ( 'html' === control.params.choices.language ) ? { name: 'htmlmixed' } : control.params.choices.language;

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
			setting: control.id
		} ) );
	}
});
