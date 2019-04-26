/* global tinyMCE */
wp.customize.controlConstructor['kirki-editor'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function( control ) {
		var element, editor, id;
		control = control || this;
		element = control.container.find( 'textarea' );
		id      = 'kirki-editor-' + control.id.replace( '[', '' ).replace( ']', '' );
			
		wp.editor.initialize( id, {
			tinymce: {
				wpautop: true
			},
			quicktags: true,
			mediaButtons: true
		} );

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
