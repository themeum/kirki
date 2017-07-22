( function( api ) {

	var self;

	self = {
		queriedPost: new api.Value()
	};

	// Listen for queried-post messages from the preview.
	api.bind( 'ready', function() {
		api.previewer.bind( 'queried-post', function( queriedPost ) {
			self.queriedPost.set( queriedPost || false );
		} );
	} );

	// Listen for post
	self.queriedPost.bind( function( newPost, oldPost ) {
		window.kirkiPost = false;
		if ( newPost || oldPost ) {
			window.kirkiPost = ( newPost ) ? newPost : oldPost;
		}
	} );
} )( wp.customize );
