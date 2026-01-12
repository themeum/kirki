import "./control.scss";

/* global tinyMCE */
wp.customize.controlConstructor[ 'kirki-editor' ] = wp.customize.kirkiDynamicControl.extend( {
	initKirkiControl: function( control ) {
		var element, editor, id, defaultParams, container;
		control = control || this;
		container = control.container[0] || control.container;
		element = container.querySelector( 'textarea' );
		id      = 'kirki-editor-' + control.id.replace( '[', '' ).replace( ']', '' );

		defaultParams = {
			tinymce: {
				wpautop: true
			},
			quicktags: true,
			mediaButtons: true
		};

		// Overwrite the default parameters if choices is defined.
		if ( wp.editor && wp.editor.initialize ) {
			wp.editor.initialize( id, Object.assign( {}, defaultParams, control.params.choices ) );
		}

		editor = tinyMCE.get( id );

		if ( editor && element ) {
			editor.onChange.add( function( ed ) {
				var content;

				ed.save();
				content = editor.getContent();
				element.value = content;
				element.dispatchEvent( new Event( 'change', { bubbles: true } ) );
				wp.customize.instance( control.id ).set( content );
			} );
		}
	}
} );
