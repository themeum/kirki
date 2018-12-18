'use strict';

jQuery( document ).ready( function ( e )
{
	var multi_tabs = jQuery( '.kirki-multi-tabs' ),
		tabs_container = jQuery( '.tabs-container', multi_tabs ),
		tab_content_outer = jQuery( '.tab-content-outer', multi_tabs ),
		tab_content = jQuery( '.tab-content', tab_content_outer),
		header = jQuery( '.header', tabs_container ),
		tabs_outer = jQuery( '.tabs-outer', tabs_container ),
		tabs = jQuery( '.tabs', tabs_outer ),
		tab_triggers = jQuery( '.tab-trigger', tabs ),
		back_outer = jQuery( '.back-outer', header ),
		back_button = jQuery( '.back-button', back_outer ),
		breadcrumbs_outer = jQuery( '.breadcrumbs-outer', header ),
		breadcrumbs_title = jQuery( '.breadcrumbs-title', breadcrumbs_outer ),
		breadcrumbs = jQuery( '.breadcrumbs', breadcrumbs_outer ),

		default_tab_content = jQuery( '.tab-content.kirki-default' );
	if ( multi_tabs.length == 0 )
		return;
	var current_panel = null;
	console.assert ( tabs_container.length > 0 );
	console.assert ( tabs.length > 0 );
	console.assert ( tab_content_outer.length > 0 );
	console.assert ( tab_content.length > 0 );
	console.assert ( header.length > 0 );
	console.assert ( back_outer.length > 0 );
	console.assert ( back_button.length > 0 );
	console.assert ( breadcrumbs_outer.length > 0 );
	console.assert ( breadcrumbs_title.length > 0 );
	console.assert ( breadcrumbs.length > 0 );

	//Loop through and hook up the tab click events.
	tabs.each ( function ( e )
	{
		var self = jQuery( this );

		var triggers = jQuery( '.tab-trigger', self );

		//Setup click events for all the triggers inside this tab group.
		triggers.click ( function ( e )
		{
			e.preventDefault();
			change_tab ( jQuery( this ) );
		});
	});

	back_button.click ( function ( e )
	{
		tab_triggers.removeClass ( 'active' );
		if ( current_panel )
		{
			if ( current_panel.parent_id )
			{
				let parent_tab = jQuery( '#' + current_panel.parent_id, tabs_outer );
				tabs.removeClass( 'active' );
				tab_content.removeClass ( 'active' );

				default_tab_content.addClass ( 'active' );
				parent_tab.addClass ( 'active' );

				current_panel = {
					id: current_panel.parent_id,
					parent_id: parent_tab.attr ( 'parent' )
				};
				var breadcrumbs_els = breadcrumbs.find ( 'li' );
				if ( breadcrumbs_els.length > 0 )
				{
					breadcrumbs_els.last().remove();
					var current = breadcrumbs_els.last();
					if ( current )
						breadcrumbs_title.html ( current.html() );
				}
			}
			else
			{
				change_tab ( null, null );
				breadcrumbs.empty();
			}
		}
	});

	function change_tab ( trigger )
	{
		tab_content.removeClass ( 'active' );
		//If a tab is passed, we'll find and show it.
		if ( trigger )
		{
			let tab_parent = trigger.parent();
			let type = tab_parent.attr ( 'type' );
			let title = trigger.attr ( 'tab-title' );
			let tab_id = tab_parent.attr ( 'id' );
			let id = trigger.attr ( 'href' ).replace ( '#', '' );
			if ( type == 'panel' )
			{
				breadcrumbs.find ( '[breadcrumb-id="' + tab_id + '"]', ).remove();
				jQuery( '<li>' )
					.html ( title )
					.attr ( 'breadcrumb-id', tab_id )
					.appendTo ( breadcrumbs );
				tabs.removeClass( 'active' );
				let tabs_to_show = jQuery( '#' + id );
				current_panel = {
					id: id,
					parent_id: tabs_to_show.attr ( 'parent' )
				};
				tabs_to_show.addClass ( 'active' );
				default_tab_content.addClass ( 'active' );
			}
			else if ( type == 'section' )
			{
				let tab_content_to_show = jQuery( '.tab-content[href="#' + id + '"]' );
				tab_content_to_show.addClass ( 'active' );
				tab_triggers.removeClass ( 'active' );
				trigger.addClass ( 'active' );
			}
			else
			{
				throw 'Invalid Type: ' + type;
			}
			back_button.removeClass ( 'hidden' );
		}
		else //If nothing is passed, we'll go to the main menu.
		{
			breadcrumbs_title.html ( '' );
			back_button.addClass ( 'hidden' );
			tabs.removeClass ( 'active' );
			jQuery( '#kirki-tab-home', tabs_outer ).addClass ( 'active' );
		}
	}

	jQuery('[href="#section_id"]').click();
});

/* Dependencies */
jQuery( document ).on( 'kirki-metabox-ready', function ( e )
{
	jQuery( '.kirki-metabox' ).each ( function()
	{
		var container = jQuery( this ),
			args = JSON.parse ( container.attr ( 'kirki-args' ) );
		if ( args.required )
		{

		}
	});

	function evaluate( value1, value2, operator ) {
		var found = false;

		if ( '===' === operator ) {
			return value1 === value2;
		}
		if ( '==' === operator || '=' === operator || 'equals' === operator || 'equal' === operator ) {
			return value1 == value2;
		}
		if ( '!==' === operator ) {
			return value1 !== value2;
		}
		if ( '!=' === operator || 'not equal' === operator ) {
			return value1 != value2;
		}
		if ( '>=' === operator || 'greater or equal' === operator || 'equal or greater' === operator ) {
			return value2 >= value1;
		}
		if ( '<=' === operator || 'smaller or equal' === operator || 'equal or smaller' === operator ) {
			return value2 <= value1;
		}
		if ( '>' === operator || 'greater' === operator ) {
			return value2 > value1;
		}
		if ( '<' === operator || 'smaller' === operator ) {
			return value2 < value1;
		}
		if ( 'contains' === operator || 'in' === operator ) {
			if ( _.isArray( value1 ) && _.isArray( value2 ) ) {
				_.each( value2, function( value ) {
					if ( value1.includes( value ) ) {
						found = true;
						return false;
					}
                } );
				return found;
			}
			if ( _.isArray( value2 ) ) {
				_.each( value2, function( value ) {
					if ( value == value1 ) { // jshint ignore:line
						found = true;
					}
				} );
				return found;
			}
			if ( _.isObject( value2 ) ) {
				if ( ! _.isUndefined( value2[ value1 ] ) ) {
					found = true;
				}
				_.each( value2, function( subValue ) {
					if ( value1 === subValue ) {
						found = true;
					}
				} );
				return found;
			}
			if ( _.isString( value2 ) ) {
				if ( _.isString( value1 ) ) {
					return ( -1 < value1.indexOf( value2 ) && -1 < value2.indexOf( value1 ) );
				}
				return -1 < value1.indexOf( value2 );
			}
		}
		return value1 == value2;
	}
});