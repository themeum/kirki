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

		// The trigger markup.
		const trigger =
			'<span class="tooltip-trigger"><span class="dashicons dashicons-editor-help"></span></span>';

		// Build the tooltip content.
		const content =
			'<span class="tooltip-content">' + tooltip.content + '</span>';

		// Add the trigger & content.
		jQuery(
			'<span class="kirki-tooltip-wrapper">' +
				trigger +
				content +
				'</span>'
		).appendTo( jQuery( target ) );
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
