wp.customize.controlConstructor['kirki-editor'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		var control       = this,
		    element       = control.container.find( 'textarea' ),
		    toggler       = control.container.find( '.toggle-editor' ),
		    editorWrapper = jQuery( '#kirki-editor-editor-pane' ),
		    setChange,
		    content;

		jQuery( window ).load( function() {

			var editor  = tinyMCE.get( 'kirki-editor' );

			// Add the button text
			toggler.html( window.kirki.l10n['open-editor'] );

			toggler.on( 'click', function() {

				// Toggle the editor.
				control.toggleEditor();

				// Change button.
				control.changeButton();

				// Add the content to the editor.
				control.setEditorContent( editor );

			});

			// Update the option from the editor contents on change.
			if ( editor ) {

				editor.onChange.add( function( ed, e ) {

					ed.save();
					content = editor.getContent();
					clearTimeout( setChange );
					setChange = setTimeout( function() {
						element.val( content ).trigger( 'change' );
						wp.customize.instance( control.getEditorWrapperSetting() ).set( content );
					}, 500 );

				});

			}
		});

	},

	/**
	 * Modify the button text and classes.
	 */
	changeButton: function() {

		var control       = this,
			editorWrapper = jQuery( '#kirki-editor-editor-pane' );

		// Reset all editor buttons.
		// Necessary if we have multiple editor fields.
		jQuery( '.customize-control-kirki-editor .toggle-editor' ).html( window.kirki.l10n['switch-editor'] );

		// Change the button text & color.
		if ( false !== control.getEditorWrapperSetting() ) {
			jQuery( '.customize-control-kirki-editor .toggle-editor' ).html( window.kirki.l10n['switch-editor'] );
			jQuery( '#customize-control-' + control.getEditorWrapperSetting() + ' .toggle-editor' ).html( window.kirki.l10n['close-editor'] );
		} else {
			jQuery( '.customize-control-kirki-editor .toggle-editor' ).html( window.kirki.l10n['open-editor'] );
		}

	},

	/**
	 * Toggle the editor.
	 */
	toggleEditor: function() {

		var control = this,
		    editorWrapper = jQuery( '#kirki-editor-editor-pane' );

		if ( ! control.getEditorWrapperSetting() || control.id !== control.getEditorWrapperSetting() ) {
			editorWrapper.removeClass();
			editorWrapper.addClass( control.id );
		} else {
			editorWrapper.removeClass();
			editorWrapper.addClass( 'hidden' );
		}

	},

	/**
	 * Set the content.
	 */
	setEditorContent: function( editor ) {

		var control = this,
		    editorWrapper = jQuery( '#kirki-editor-editor-pane' );

		editor.setContent( control.setting._value );

	},

	/**
	 * Gets the setting from the editor wrapper class.
	 */
	getEditorWrapperSetting: function() {

		if ( jQuery( '#kirki-editor-editor-pane' ).hasClass( 'hidden' ) ) {
			return false;
		}

		if ( jQuery( '#kirki-editor-editor-pane' ).attr( 'class' ) ) {
			return jQuery( '#kirki-editor-editor-pane' ).attr( 'class' );
		} else {
			return false;
		}

	}

});
