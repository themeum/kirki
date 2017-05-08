jQuery( document ).ready( function() {
	var fuse = new Fuse( kirkiFieldsSearch.fields, {
			shouldSort: true,
			threshold: 0.2,
			location: 0,
			distance: 100,
			maxPatternLength: 32,
			minMatchCharLength: 3,
			keys: [
				'label',
				'description'
			]
		}),
	    searchInput;

	// Search
	searchInput = jQuery( '#customize-control-kirki_search input' );
	jQuery( '#customize-control-kirki_search input' ).on( 'change keyup paste', function() {
		var searchVal     = jQuery( this ).val(),
		    results       = {},
		    searchWrapper = jQuery( '#customize-control-kirki_search' ).find( '.kirki-search-results' );

		if ( 1 > searchWrapper.length ) {
			jQuery( '#customize-control-kirki_search' ).append( '<div class="kirki-search-results"></div>' );
		}
		// Clear previous results.
		jQuery( '.kirki-search-results' ).empty();

		if ( 2 < searchVal.length ) {
			results = fuse.search( searchVal );
		}

		// Add search results.
		_.each( results, function( result ) {
			jQuery( '#customize-control-kirki_search .kirki-search-results' ).append( '<div class="kirki-search-result" data-setting="' + result.id + '">' + result.label + '</div>' );
		});

		// Actions to run when clicking on a search result.
		jQuery( '.kirki-search-result' ).on( 'click', function() {

			// Focus on the clicked setting.
			wp.customize.control( jQuery( this ).data( 'setting' ) ).focus();

		});
	});

	wp.customize.section.each( function( section ) {

		// Get the pane element.
		var pane      = jQuery( '#sub-accordion-section-' + section.id ),
		    sectionLi = jQuery( '#accordion-section-' + section.id );

		// Check if the section is expanded.
		if ( sectionLi.hasClass( 'control-section-kirki-search-module-section' ) ) {

			// Move element.
			pane.appendTo( sectionLi );

		}

	} );

} );
