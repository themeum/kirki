wp.customize.controlConstructor['kirki-sortable'] = wp.customize.Control.extend( {
	ready: function() {
		'use strict';
		var control = this,
			update_tid = 0,
			sortable = control.container.find( 'ul.sortable' );
		
		if ( control.params.mode === 'text' )
			this.initTextItems( sortable );
		else
			this.initCheckboxItems( sortable );
		// Init sortable.
		sortable = jQuery( sortable ).sortable( {
			// Update value when we stop sorting.
			update: function() {
				control.save_values();
			}
		} ).disableSelection().find( 'li' ).each( function() {
			// Enable/disable options when we click on the eye of Thundera.
			jQuery( this ).find( 'i.visibility' ).click( function() {
				jQuery( this ).toggleClass( 'dashicons-visibility-faint' ).parents( 'li:eq(0)' ).toggleClass( 'invisible' );
			} );
		} ).click( function() {
			// Update value on click.
			control.save_values();
		} );
		
		// If we're on the text mode, we need to check for input change.
		if ( control.params.mode === 'text' )
		{
			// Update value on key up, but with a delay.
			control.container.find( '.kirki-sortable-item input' ).on( 'change keyup paste', function()
			{
				clearTimeout( update_tid );
				update_tid = setTimeout( function()
				{
					control.save_values();
				}, 1000 );
			});
		}
	},
	
	save_values: function()
	{
		//Saves the values.
		var control = this,
			val = control.params.mode === 'text' ?
			control.getNewValText() : control.getNewValCheckbox();
		control.setting.set( val );
	},
	
	generateListElement: function ( label, value, visible )
	{
		var control = this;
		var li = jQuery( '<li ' + control.params.inputAttrs + '>' )
			.addClass( 'kirki-sortable-item' )
			.attr( 'data-value', value );
		
		if ( visible === false )
			li.addClass ( 'invisible' );
		
		jQuery( '<i class="dashicons dashicons-menu"></i>' ).appendTo( li );
		jQuery( '<i class="dashicons dashicons-visibility visibility"></i>' ).appendTo( li );
		jQuery( '<span>' + label + '</span>' ).appendTo( li );
		
		//If we're in text mode, we need a text input.
		if ( control.params.mode === 'text' )
			jQuery( '<input type="text">' ).val( value ).appendTo( li );
		
		return li;
	},
	
	initCheckboxItems : function( list )
	{
		var control = this,
			choices = control.params.choices,
			value = control.setting._value;
		_.each( value, function( choiceID )
		{
			control.generateListElement( choices[choiceID], choiceID, true ).appendTo( list );
		});
		_.each( choices, function( choiceLabel, choiceID )
		{
			if ( -1 === value.indexOf( choiceID ) )
				control.generateListElement( choices[choiceID], choiceID, false ).appendTo( list );
		});
	},
	
	initTextItems: function( list )
	{
		var control = this,
			choices = control.params.choices,
			value = control.setting._value;
		_.each( value, function( choiceLabel, choiceID ) {
			var visible = true;
			if ( value[choiceID] && value[choiceID].length === 0 )
				visible = false;
			var li = control.generateListElement( choices[choiceID], value[choiceID], visible );
			li.attr( 'data-id', choiceID );
			li.appendTo( list );
		});
		var keys = Object.keys( value );
		_.each( choices, function( choiceLabel, choiceID ) {
			if ( -1 === keys.indexOf( choiceID ) )
			{
				var li = control.generateListElement( choices[choiceID], '', false );
				li.attr( 'data-id', choiceID );
				li.appendTo( list );
			}
		});
	},

	/**
	 * Gets the new checkbox value.
	 *
	 * @since 3.0.35
	 * @returns {Array}
	 */
	getNewValCheckbox: function() {
		var items  = jQuery( this.container.find( 'li' ) ),
			newVal = [];
		_.each ( items, function( item ) {
			if ( ! jQuery( item ).hasClass( 'invisible' ) )
				newVal.push( jQuery( item ).data( 'value' ) );
		} );
		return newVal;
	},
	
	/**
	 * Gets the new text value.
	 *
	 * @since 3.0.35
	 * @returns {Array}
	 */
	getNewValText: function() {
		var items  = jQuery( this.container.find( 'li' ) ),
			newVal = [];
		_.each ( items, function( item ) {
			if ( ! jQuery( item ).hasClass( 'invisible' ) )
			{
				/* Instead of using an object, a JSON object array was needed so the WordPress customizer base
				would think they were different values. A named object would still think the order is the same.
				*/
				var id = jQuery( item ).attr( 'data-id' ),
					textVal = jQuery( item ).find( 'input' ).val();
				newVal.push(JSON.stringify( { id: id, val: textVal } ));
			}
		} );
		return newVal;
	}
} );