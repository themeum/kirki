/* global wp, _customizePostPreviewedQueriedObject */
jQuery( document ).ready( function() {

	var self = {
		queriedPost: ( ! _.isUndefined( _customizePostPreviewedQueriedObject ) ) ? _customizePostPreviewedQueriedObject : null
	};

	// Send the queried post object to the Customizer pane when ready.
	wp.customize.bind( 'preview-ready', function() {
		wp.customize.preview.bind( 'active', function() {
			wp.customize.preview.send( 'queried-post', self.queriedPost );
		} );
	} );
} );
