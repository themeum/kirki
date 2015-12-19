/**
 * KIRKI CONTROL: CODE
 */
wp.customize.controlConstructor['code'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		var element = control.container.find( '#kirki-codemirror-editor-' + control.id );
		var editor  = CodeMirror.fromTextArea( element[0] );

		if ( control.params.choices.language == 'html' ) {
			var language = { name: "htmlmixed" };
		} else {
			language = control.params.choices.language;
		}

		editor.setOption( "value", control.setting._value );
		editor.setOption( "mode", language );
		editor.setOption( "lineNumbers", true );
		editor.setOption( "theme", control.params.choices.theme );
		editor.setOption( "height", control.params.choices.height + 'px' );

		editor.on('change', function() {
			control.setting.set( editor.getValue() );
		});

		element.parents('.accordion-section').on('click', function(){
		    editor.refresh();
		});
	}
});
