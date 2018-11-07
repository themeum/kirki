wp.customize.controlConstructor['toggle-tabs'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function() {

		var control = this,
			container = control.container,
			tab_container = container.find( '.kirki-toggle-tabs-outer' ),
			id = control.id,
			choices = control.params.choices;
			
		control.tab_container = tab_container;
		
		tab_container.find( '.tabs li:first' ).addClass( 'active' );
		tab_container.find( '.tab-content:first' ).addClass( 'active' );
		
		for ( var label in choices )
		{
			var label_id = label.replace( ' ', '_' ),
				tab = $( 'li[href="#' + id + '_' + label_id + '"]' ),
				tab_content = $( '#' + id + '_' + label_id );
			control.registerTabEvents ( tab, tab_content );
		}
		
		//TODO FIXME: Think of an event-based way to handle this.
		setInterval( function()
		{
			for ( var label in choices )
			{
				var label_id = label.replace( ' ', '_' ),
					control_ids = choices[label],
					tab_content = $( '#' + id + '_' + label_id );
				
				for ( var control_idx in control_ids )
				{
					var control_id = control_ids[control_idx];
					var wp_control = $( '#customize-control-' + control_id );
					if ( wp_control.parent().hasClass( 'tab-content' ) )
						continue;
					wp_control.detach().appendTo( tab_content );
				}
			}
		}, 500 );
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
