wp.customize.controlConstructor['kirki-code'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		'use strict';

		var control     = this,
		    element     = control.container.find( '.kirki-codemirror-editor' ),
		    language    = control.params.choices.language,
		    openButton  = control.container.find( 'a.edit' ),
		    closeButton = control.container.find( 'a.close' ),
		    editor;

		// HTML mode requires a small hack because CodeMirror uses 'htmlmixed'.
		if ( 'html' === control.params.choices.language ) {
			language = { name: 'htmlmixed' };
		}

		// When the edit button is clicked, change the textarea class to expanded.
		openButton.on( 'click', function() {
			element.removeClass( 'collapsed' ).addClass( 'expanded' );
		});

		// When the close button is clicked, change the textarea class to collapsed.
		closeButton.on( 'click', function() {
			element.removeClass( 'expanded' ).addClass( 'collapsed' );
		});

		editor = CodeMirror.fromTextArea( element[0], {
			value:       control.setting._value,
			mode:        language,
			lineNumbers: true,
			theme:       control.params.choices.theme,
			height:      control.params.choices.height + 'px'
		});

		// On change make sure we infor the Customizer API
		editor.on( 'change', function() {
			control.setting.set( editor.getValue() );
		});

		// Hack to refresh the editor when we open a section
		element.parents( '.accordion-section' ).on( 'click', function() {
		    editor.refresh();
		});

	}

});
