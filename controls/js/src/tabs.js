wp.customize.controlConstructor['kirki-tabs'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function() {

		var control = this,
			container = control.container,
			tab_container = container.find( '.kirki-tabs-outer' ),
			id = control.id,
			choices = control.params.choices;
			
		control.tab_container = tab_container;
		for ( var label in choices )
		{
			var label_id = label.replace( ' ', '_' ),
				control_ids = choices[label],
				tab = $( 'li[href="#' + id + '_' + label_id + '"]' ),
				tab_content = $( '#' + id + '_' + label_id );
			
			for ( var control_idx in control_ids )
			{
				var control_id = control_ids[control_idx];
				var wp_control = $( '#customize-control-' + control_id );
				wp_control.detach().appendTo( tab_content );
			}
			
			control.registerTabEvents ( tab, tab_content );
		}
		
		tab_container.find( '.tabs li:first' ).addClass( 'active' );
		tab_container.find( '.tab-content:first' ).addClass( 'active' );
	},
	
	registerTabEvents: function( tab, tab_content )
	{
		var control = this,
			tab_container = control.tab_container;
		
		tab.click( function( e )
		{
			e.preventDefault();
			tab_container.find( '.active' ).removeClass( 'active' );
			tab.addClass( 'active' );
			tab_content.addClass( 'active' );
		});
	}
} );
