/**
 * KIRKI CONTROL: EDITOR
 */
wp.customize.controlConstructor.editor = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		var control = this;

		jQuery( window ).load( function() {

			var element    = control.container.find( 'textarea.wp-editor-area' ),
				textareaID = element.attr( 'id' ),
				editor     = tinyMCE.get( textareaID ),
				setChange,
				content;

			if ( editor ) {
				editor.onChange.add( function( ed, e ) {
					ed.save();
					content = editor.getContent();
					clearTimeout( setChange );
					setChange = setTimeout( function() {
						element.val( content ).trigger( 'change' );
					}, 500 );
				});
			}

			element.css({ visibility: 'visible' }).on( 'keyup', function() {
				content = element.val();
				clearTimeout( setChange );
				setChange = setTimeout( function() {
					content.trigger( 'change' );
				}, 500 );
			});

		});

	}

});
