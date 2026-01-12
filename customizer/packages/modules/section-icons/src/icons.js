/* global kirkiIcons */
( function() {
	'use strict';

	function initSectionIcons() {
		if ( ! _.isUndefined( kirkiIcons.section ) ) {

			// Parse sections and add icons.
			_.each( kirkiIcons.section, function( icon, sectionID ) {
				var sectionTitle, subSectionTitle;

				// Add icons in list.
				sectionTitle = document.querySelector( '#accordion-section-' + sectionID + ' > h3' );
				if ( sectionTitle ) {
					sectionTitle.classList.add( 'dashicons-before', icon );
				}

				// Add icons on titles when a section is open.
				subSectionTitle = document.querySelector( '#sub-accordion-section-' + sectionID + ' .customize-section-title > h3' );
				if ( subSectionTitle ) {
					var iconSpan = document.createElement( 'span' );
					iconSpan.className = 'dashicons ' + icon;
					iconSpan.style.cssText = 'float:left;padding-right:.1em;padding-top:2px;';
					subSectionTitle.appendChild( iconSpan );
				}
			} );

		}

		if ( ! _.isUndefined( kirkiIcons.panel ) ) {

			_.each( kirkiIcons.panel, function( icon, panelID ) {
				var panelTitle, subPanelTitle;

				// Add icons in lists & headers.
				panelTitle = document.querySelector( '#accordion-panel-' + panelID + ' > h3' );
				if ( panelTitle ) {
					panelTitle.classList.add( 'dashicons-before', icon );
				}

				subPanelTitle = document.querySelector( '#sub-accordion-panel-' + panelID + ' .panel-title' );
				if ( subPanelTitle ) {
					subPanelTitle.classList.add( 'dashicons-before', icon );
				}
			} );

		}
	}

	// Wait for wp.customize to be ready before initializing icons.
	wp.customize.bind( 'ready', function() {
		initSectionIcons();
	} );
} )();
