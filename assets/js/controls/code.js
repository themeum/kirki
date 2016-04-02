/**
 * KIRKI CONTROL: CODE
 */
wp.customize.controlConstructor.code = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		var control = this,
		    element = control.container.find( '#kirki-codemirror-editor-' + control.id ),
		    editor  = CodeMirror.fromTextArea( element[0] ),
		    language = control.params.choices.language;

		// HTML mode requires a small hack because CodeMirror uses 'htmlmixed'.
		if ( control.params.choices.language == 'html' ) {
			language = { name: 'htmlmixed' };
		}

		// Set the initial value for CodeMirror
		editor.setOption( 'value', control.setting._value );
		// Set the language
		editor.setOption( 'mode', language );
		// Enable line-numbers
		editor.setOption( 'lineNumbers', true );
		// Set the theme
		editor.setOption( 'theme', control.params.choices.theme );
		// Set the height
		editor.setOption( 'height', control.params.choices.height + 'px' );

		// On change make sure we infor the Customizer API
		editor.on( 'change', function() {
			control.setting.set( editor.getValue() );
		});

		// Hack to refresh the editor when we open a section
		element.parents( '.accordion-section' ).on( 'click', function(){
		    editor.refresh();
		});

	}

});
