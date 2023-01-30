import "./control.scss";

/* global tinyMCE */
wp.customize.controlConstructor[ 'kirki-editor' ] = wp.customize.kirkiDynamicControl.extend( {
	initKirkiControl: function( control ) {
		var element, editor, id, defaultParams;
		control = control || this;
		element = control.container.find( 'textarea' );
		id      = 'kirki-editor-' + control.id.replace( '[', '' ).replace( ']', '' );

		defaultParams = {
			tinymce: {
				wpautop: true
			},
			quicktags: true,
			mediaButtons: true
		};

		// Overwrite the default paramaters if choices is defined.
		if ( wp.editor && wp.editor.initialize ) {
			wp.editor.initialize( id, jQuery.extend( {}, defaultParams, control.params.choices ) );
		}

		editor = tinyMCE.get( id );

		if ( editor ) {
			editor.onChange.add( function( ed ) {
				var content;

				ed.save();
				content = editor.getContent();
				element.val( content ).trigger( 'change' );
				wp.customize.instance( control.id ).set( content );
			} );
		}
	}
} );
