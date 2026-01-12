import './control.scss';

/* global kirkiTooltips */
function kirkiTooltipAdd( control ) {
	// Safety check: ensure kirkiTooltips exists
	if ( typeof kirkiTooltips === 'undefined' ) {
		return;
	}

	// Convert object to array if needed (wp_localize_script creates objects from associative arrays)
	const tooltipsArray = Array.isArray( kirkiTooltips ) ? kirkiTooltips : Object.values( kirkiTooltips || {} );

	tooltipsArray.forEach( function ( tooltip ) {
		if ( ! tooltip || ! tooltip.id || tooltip.id !== control.id ) {
			return;
		}

		// Get the target element first
		const target = document.querySelector(
			'#customize-control-' + tooltip.id + ' .customize-control-title'
		);
		
		// Check if tooltip already exists
		if ( target && target.querySelector( '.tooltip-content' ) ) {
			return;
		}

		if ( ! target ) {
			return;
		}

		target.classList.add( 'kirki-tooltip-wrapper' );

		// Build the tooltip trigger.
		const trigger = document.createElement( 'span' );
		trigger.className = 'tooltip-trigger';
		const triggerIcon = document.createElement( 'span' );
		triggerIcon.className = 'dashicons dashicons-editor-help';
		trigger.appendChild( triggerIcon );

		// Build the tooltip content.
		const content = document.createElement( 'span' );
		content.className = 'tooltip-content';
		content.innerHTML = tooltip.content || '';

		// Append the trigger & content next to the control's title.
		target.appendChild( trigger );
		target.appendChild( content );
	} );
}

function initTooltips() {
	// Safety check: ensure kirkiTooltips exists
	if ( typeof kirkiTooltips === 'undefined' ) {
		return;
	}

	// Convert object to array if needed (wp_localize_script creates objects from associative arrays)
	const tooltipsArray = Array.isArray( kirkiTooltips ) ? kirkiTooltips : Object.values( kirkiTooltips || {} );
	
	if ( tooltipsArray.length === 0 ) {
		return;
	}

	let sectionNames = [];

	wp.customize.control.each( function ( control ) {
		if ( ! control || ! control.id ) {
			return;
		}

		const sectionId = control.section();
		if ( sectionId && ! sectionNames.includes( sectionId ) ) {
			sectionNames.push( sectionId );
		}

		wp.customize.section( sectionId, function ( section ) {
			if ( ! section ) {
				return;
			}

			if (
				section.expanded() ||
				( wp.customize.settings && wp.customize.settings.autofocus && wp.customize.settings.autofocus.control === control.id )
			) {
				kirkiTooltipAdd( control );
			} else {
				section.expanded.bind( function ( expanded ) {
					if ( expanded ) {
						kirkiTooltipAdd( control );
					}
				} );
			}
		} );
	} );

	// Also listen for dynamically added controls
	wp.customize.control.bind( 'add', function( addedControl ) {
		if ( addedControl && addedControl.id ) {
			wp.customize.section( addedControl.section(), function ( section ) {
				if ( section && section.expanded() ) {
					kirkiTooltipAdd( addedControl );
				} else if ( section ) {
					section.expanded.bind( function ( expanded ) {
						if ( expanded ) {
							kirkiTooltipAdd( addedControl );
						}
					} );
				}
			} );
		}
	} );

	// Create and append style element
	let tooltipStyleEl = document.querySelector( '.kirki-tooltip-inline-styles' );
	if ( ! tooltipStyleEl ) {
		tooltipStyleEl = document.createElement( 'style' );
		tooltipStyleEl.className = 'kirki-tooltip-inline-styles';
		document.head.appendChild( tooltipStyleEl );
	}

	const sidebarOverlay = document.querySelector( '.wp-full-overlay-sidebar-content' );

	sectionNames.forEach( function ( sectionName ) {
		wp.customize.section( sectionName, function ( section ) {
			section.expanded.bind( function ( expanded ) {
				if ( expanded ) {
					if (
						sidebarOverlay &&
						section.contentContainer[0] &&
						section.contentContainer[0].scrollHeight >
						sidebarOverlay.offsetHeight
					) {
						tooltipStyleEl.textContent =
							'.kirki-tooltip-wrapper span.tooltip-content {min-width: 258px;}';
					} else {
						tooltipStyleEl.textContent = '';
					}
				}
			} );
		} );
	} );
}

// Wait for WordPress customizer to be ready
if ( typeof wp !== 'undefined' && wp.customize ) {
	wp.customize.bind( 'ready', function() {
		initTooltips();
	} );
} else {
	// Fallback: wait for DOM and wp.customize to be available
	function waitForCustomizer() {
		if ( typeof wp !== 'undefined' && wp.customize && wp.customize.control ) {
			wp.customize.bind( 'ready', function() {
				initTooltips();
			} );
		} else {
			setTimeout( waitForCustomizer, 50 );
		}
	}
	
	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', waitForCustomizer );
	} else {
		waitForCustomizer();
	}
}
