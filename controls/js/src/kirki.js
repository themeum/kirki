var kirki = {

	initialized: false,

	/**
	 * Initialize the object.
	 *
	 * @since 3.0.17
	 * @returns {null}
	 */
	initialize: function() {
		var self = this;

		// We only need to initialize once.
		if ( self.initialized ) {
			return;
		}

		if (
			'undefined' !== typeof self.util &&
			'undefined' !== typeof self.util.webfonts &&
			'undefined' !== typeof self.util.webfonts.google &&
			'function' === typeof self.util.webfonts.google.initialize
		) {
			self.util.webfonts.google.initialize();
		} else {
			setTimeout( function() {
				self.initialize();
			}, 150 );
			return;
		}

		// Mark as initialized.
		self.initialized = true;
	}
};

// Initialize the kirki object.
kirki.initialize();
