jQuery( document ).ready( function( $ ) {
	var observer = new MutationObserver(function (mutations, me) {
		// Responsive switchers
		$( '.kirki-responsive-switchers li' ).off( 'click') .on( 'click', function( event ) {
			event.preventDefault();
			// Set up variables
			var $this 		= $( this ),
				$devices 	= $( '.kirki-responsive-switchers' ),
				$device 	= $this.attr( 'device' ),
				$control 	= $( '.customize-control.has-switchers' ),
				$body 		= $( '.wp-full-overlay' ),
				$footer_devices = $( '.wp-full-overlay-footer .devices' );
			
			// Button class
			$devices.find( 'li' ).removeClass( 'active' );
			if ( $device !== 'desktop' )
				$devices.find( 'li.' + $device ).addClass( 'active' );
			
			// Control class
			$control.find( '.control-wrapper-outer' ).removeClass( 'active' );
			$control.find( '.control-wrapper-outer.device-' + $device ).addClass( 'active' );
			$control.removeClass( 'device-desktop device-tablet device-mobile' ).addClass( 'device-' + $device );
			
			// Unit class
			$control.find( '.kirki-unit-choices-outer' ).removeClass( 'active' );
			$control.find( '.kirki-unit-choices-outer.device-' + $device ).addClass( 'active' );
			
			// Wrapper class
			$body.removeClass( 'preview-desktop preview-tablet preview-mobile' ).addClass( 'preview-' + $device );
			
			// Panel footer buttons
			$footer_devices.find( 'button' ).removeClass( 'active' ).attr( 'aria-pressed', false );
			$footer_devices.find( 'button.preview-' + $device ).addClass( 'active' ).attr( 'aria-pressed', true );
			
			// Open switchers
			if ( $this.hasClass( 'desktop' ) ) {
				$control.toggleClass( 'responsive-switchers-open' );
			}
			
		} );
			
		// If panel footer buttons clicked
		$( '.wp-full-overlay-footer .devices button' ).on( 'click', function( event ) {
			
			// Set up variables
			var $this 		= $( this ),
				$devices 	= $( '.customize-control.has-switchers .kirki-responsive-switchers' ),
				$device 	= $( event.currentTarget ).data( 'device' ),
				$control 	= $( '.customize-control.has-switchers' );
			
			// Button class
			$devices.find( 'li' ).removeClass( 'active' );
			if ( $device !== 'desktop' )
				$devices.find( 'li.' + $device ).addClass( 'active' );
			
			// Control class
			$control.find( '.control-wrapper-outer' ).removeClass( 'active' );
			$control.find( '.control-wrapper-outer.device-' + $device ).addClass( 'active' );
			$control.removeClass( 'device-desktop device-tablet device-mobile' ).addClass( 'device-' + $device );
			
			// Unit class
			$control.find( '.kirki-unit-choices-outer' ).removeClass( 'active' );
			$control.find( '.kirki-unit-choices-outer.device-' + $device ).addClass( 'active' );
			
			// Open switchers
			if ( ! $this.hasClass( 'preview-desktop' ) ) {
			} else {
				$control.removeClass( 'responsive-switchers-open' );
			}
		
		} );
	});
	observer.observe(document, {
		childList: true,
		subtree: true
	});
});