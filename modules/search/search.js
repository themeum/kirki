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

	// Add the searchfield.
	jQuery( '#customize-header-actions' ).append( kirkiFieldsSearch.button );
	jQuery( '#customize-header-actions' ).append( kirkiFieldsSearch.form );

	// Show/Hide the searchform when we click on the search icon.
	jQuery( '.kirki-customize-controls-search' ).on( 'click', function() {
		jQuery( '.kirki-search-form-wrapper' ).toggleClass( 'hidden' );
	});

	// Search
	searchInput = jQuery( '#kirki-search' );
	jQuery( '#kirki-search' ).on( 'change keyup paste', function() {
		var searchVal = jQuery( this ).val(),
		    results   = {};

		// Clear previous results.
		jQuery( '.kirki-search-results' ).empty();

		// Show search results.
		jQuery( '.kirki-search-results' ).show();

		if ( 2 < searchVal.length ) {
			results = fuse.search( searchVal );
		}

		// Add search results.
		_.each( results, function( result ) {
			jQuery( '.kirki-search-results' ).append( '<div class="kirki-search-result" data-setting="' + result.id + '">' + result.label + '</div>' );
		});

		// Actions to run when clicking on a search result.
		jQuery( '.kirki-search-result' ).on( 'click', function() {

			// Focus on the clicked setting.
			wp.customize.control( jQuery( this ).data( 'setting' ) ).focus();

			// Hide the search results.
			jQuery( '.kirki-search-results' ).addClass( 'hidden' );

		});
	});
});
