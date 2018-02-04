jQuery( document ).ready( function() {

	var self;

	self = {
		queriedPost: new wp.customize.Value()
	};

	// Listen for queried-post messages from the preview.
	wp.customize.bind( 'ready', function() {
		wp.customize.previewer.bind( 'queried-post', function( queriedPost ) {
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
} );
