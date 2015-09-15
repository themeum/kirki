jQuery( document ).ready( function($) {
	$( 'textarea[data-editor]' ).each( function () {
		var textarea = $( this );
		var mode     = textarea.data( 'editor' );
		var editDiv  = $( '<div>', {
			position: 'absolute',
			width: textarea.width(),
			height: textarea.height(),
			'class': textarea.attr( 'class' )
		}).insertBefore( textarea );
		textarea.css( 'display', 'none' );
		var editor = ace.edit( editDiv[0] );
		editor.renderer.setShowGutter( false );
		editor.renderer.setPadding(10);
		editor.getSession().setValue( textarea.val() );
		editor.getSession().setMode( "ace/mode/" + mode );
		editor.setTheme( "ace/theme/" + textarea.data( 'theme' ) );

		editor.getSession().on( 'change', function(){
			textarea.val( editor.getSession().getValue() ).trigger( 'change' );
		});
	});
});

wp.customize.controlConstructor['code'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		this.container.on( 'change', 'textarea', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
