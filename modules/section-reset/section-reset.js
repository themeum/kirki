/* global kirkiSetSettingValue */
var current_section = null;
var cookie_name = '_kirki_last_section';

function generate_buttons()
{
	/* global jQuery, kirki_reset_section, ajaxurl, wp */
	var $container = $('#customize-header-actions');
	
	var $button_container = $( '<div>' )
	.css({
		'float': 'right',
		'margin-right': '10px',
		'margin-top': '9px'
	});
	
	var $reset_all = $('<input>')
		.attr( 'type', 'submit' )
		.addClass( 'button-secondary button' )
		.attr( 'name', 'kirki-reset-all' )
		.attr( 'id', 'kirki-reset-all' )
		.attr( 'value', kirki_reset_section.reset_all )

	$reset_all.on('click', function (event) {
		event.preventDefault();
		if ( !confirm( kirki_reset_section.confirm ) )
			return;
		
		var data = {
			wp_customize: 'on',
			action: 'reset_theme_options',
			nonce: kirki_reset_section.nonce.reset
		};
		
		$reset_all.attr( 'disabled', 'disabled' );
	
		$.post( ajaxurl, data, function ( result ) {
			if ( result.success )
			{
				api.state( 'saved' ).set( true );
				location.reload();
			}
			else
			{
				$reset_all.removeAttr( 'disabled' );
				alert( kirki_reset_section.something_went_wrong );
			}
		});
	});
		
	var $reset_section = $( '<input>' )
		.attr( 'type', 'submit' )
		.addClass( 'button-secondary button' )
		.attr( 'name', 'kirki-reset-section' )
		.attr( 'id', 'kirki-reset-section' )
		.attr( 'value', kirki_reset_section.reset_section )
		.attr( 'disabled', 'disabled' )

	$reset_section.on('click', function ( event ) {
		event.preventDefault();
		if ( !confirm( kirki_reset_section.confirm_section ) )
			return;
		
		var data = {
			wp_customize: 'on',
			action: 'reset_section',
			section: current_section,
			nonce: kirki_reset_section.nonce.reset
		};
	
		$reset_section.attr('disabled', 'disabled');
	
		$.post( ajaxurl, data, function ( result ) {
			if ( result.success )
			{
				createCookie( cookie_name, current_section, 1 );
				wp.customize.state( 'saved' ).set( true );
				location.reload();
			}
			else
			{
				$reset_section.removeAttr( 'disabled' );
				alert( kirki_reset_section.something_went_wrong );
			}
		});
	});
	
	$button_container.append( $reset_section );
	//$button_container.append( $reset_all );
	$container.append( $button_container );
}

jQuery( document ).ready( function() {
	
	generate_buttons();
	
	var $reset_section = $( '#kirki-reset-section' );
	
	wp.customize.section.each( function ( panel ) {
		
		panel.expanded.bind( function() {
			current_section = null;
			$reset_section.attr( 'disabled', 'disabled' );
		});
	});
	
	wp.customize.section.each( function ( section ) {
		
		section.expanded.bind( function() {
			current_section = section.id;
			$reset_section.removeAttr( 'disabled' );
		});
	} );
	
	current_section = readCookie( cookie_name );
	console.log(current_section);
	if ( current_section )
	{
		deleteCookie ( cookie_name );
		setTimeout( function() {
			wp.customize.section( current_section ).expanded.set ( true );
		}, 1000 );
	}
} );

function createCookie( name, value, days ) {
	if ( days ) {
		var date = new Date();
		date.setTime( date.getTime() + ( days*24*60*60*1000 ) );
		var expires = '; expires='+date.toGMTString();
	}
	else var expires = '';
	document.cookie = name + '=' + value + expires + '; path=/';
}
function readCookie( name ) {
	var nameEQ = name + '=';
	var ca = document.cookie.split( ';' );
	for( var i = 0; i < ca.length;i++ ) {
		var c = ca[i];
		while ( c.charAt( 0 ) == ' ' ) c = c.substring( 1, c.length );
		if ( c.indexOf( nameEQ ) == 0 ) return c.substring( nameEQ.length, c.length );
	}
	return null;
}
function deleteCookie( name ) {
	createCookie( name, '', -1 );
}