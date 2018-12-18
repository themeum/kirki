/* global kirkiSetSettingValue */
var current_section = null;
var last_session_cookie = '_kirki_last_section';

/* global jQuery, kirki_reset_section, ajaxurl, wp */
function generate_buttons()
{
	var $container = $('#customize-header-actions');
	
	var $reset_section_btn = $( '<input>' )
		.attr( 'type', 'submit' )
		.addClass( 'button-secondary button' )
		.attr( 'name', 'kirki-reset-section' )
		.attr( 'id', 'kirki-reset-section' )
		.attr( 'value', kirki_reset_section.reset_section )
		.attr( 'disabled', 'disabled' )
		.css({
			'float': 'right',
			'margin-right': '10px',
			'margin-top': '9px'
		});

	$reset_section_btn.on( 'click', function ( event ) {
		event.preventDefault();
		
		if ( !confirm( kirki_reset_section.confirm_section ) )
			return;
		
		var data = {
			wp_customize: 'on',
			action: 'kirki_reset_section',
			section: current_section,
			nonce: kirki_reset_section.nonce.reset
		};
	
		$reset_section_btn.attr('disabled', 'disabled');
		
		wp.customize.state( 'saving' ).set( true );
		
		$.post( ajaxurl, data, function ( result ) {
			if ( result.success )
			{
				createCookie( last_session_cookie, current_section, 1 );
				wp.customize.state( 'saved' ).set( true );
				location.reload();
			}
			else
			{
				wp.customize.state( 'saving' ).set( false );
				$reset_section_btn.removeAttr( 'disabled' );
				alert( result.data || kirki_reset_section.something_went_wrong );
			}
		});
	});
	
	$container.append( $reset_section_btn );
}

jQuery( document ).ready( function() {
	
	generate_buttons();
	
	var $reset_section_btn = $( '#kirki-reset-section' );
	
	var enable_button = function() {
		$reset_section_btn.removeAttr( 'disabled' );
	};
	
	var disable_button = function() {
		current_section = null;
		back_btn = null;
		$reset_section_btn.attr( 'disabled', 'disabled' );
	};
	
	wp.customize.panel.each( function ( panel ) {
		
		panel.expanded.bind( function() {
			disable_button();
		});
	});
	
	wp.customize.section.each( function ( section ) {
		
		section.expanded.bind( function() {
			current_section = section.id;
			enable_button();
			$( '.customize-section-back' ).on( 'click', function(){
				disable_button();
			});
		});
	} );
	
	current_section = readCookie( last_session_cookie );
	
	if ( current_section )
	{
		deleteCookie ( last_session_cookie );
		setTimeout( function() {
			wp.customize.section( current_section ).expanded.set ( true );
			enable_button();
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