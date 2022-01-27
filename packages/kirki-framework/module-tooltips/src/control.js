import './control.scss';

/* global kirkiTooltips */
function kirkiTooltipAdd( control ) {
	_.each( kirkiTooltips, function ( tooltip ) {
		if ( tooltip.id !== control.id ) {
			return;
		}

		if ( control.container.find( '.tooltip-content' ).length ) return;

		const target = document.querySelector(
			'#customize-control-' + tooltip.id + ' .customize-control-title'
		);

		if ( ! target ) return;
		target.classList.add( 'kirki-tooltip-wrapper' );

		// Build the tooltip trigger.
		const trigger =
			'<span class="tooltip-trigger"><span class="dashicons dashicons-editor-help"></span></span>';

		// Build the tooltip content.
		const content =
			'<span class="tooltip-content">' + tooltip.content + '</span>';

		const $target = jQuery( target );

		// Append the trigger & content next to the control's title.
		jQuery( trigger ).appendTo( $target );
		jQuery( content ).appendTo( $target );
	} );
}

jQuery( document ).ready( function () {
	wp.customize.control.each( function ( control ) {
		wp.customize.section( control.section(), function ( section ) {
			if (
				section.expanded() ||
				wp.customize.settings.autofocus.control === control.id
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
} );
