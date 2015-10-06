/**
 * KIRKI CONTROL: CODE
 */
wp.customize.controlConstructor['code'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		var editor = ace.edit('kirki-ace-editor-'+control.id);

		editor.getSession().setUseWrapMode(true);
		editor.setTheme('ace/theme/'+control.params.choices.theme);
		editor.getSession().setMode('ace/mode/'+control.params.choices.language);
		editor.setValue(control.settings.default._value);

		editor.getSession().on('change', function() {
			control.setting.set( editor.getValue() );
		});
	}
});
