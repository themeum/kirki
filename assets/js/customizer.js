// Add control to a queue and load when the time is right.
function kirkiControlLoader( control, forceLoad ) {
	var i;

	if ( _.isUndefined( window.kirkiControlsLoader ) ) {
		window.kirkiControlsLoader = {
			queue: [],
			done: [],
			busy: false
		};
	}

	// Init the control JS.
	// WIP: THIS IS HERE UNTIL WE RESOLVE THE LOADER ISSUES.
	// AFTER THAT POINT IT CAN BE REMOVED.
	control.initKirkiControl();
	jQuery( control.container.find( '.kirki-controls-loading-spinner' ) ).hide();
	return;

	/* WIP
	// No need to proceed if this control has already been initialized.
	if ( -1 !== window.kirkiControlsLoader.done.indexOf( control.id ) ) {
		return;
	}

	// Add this control to the queue if it's not already there.
	if ( -1 === window.kirkiControlsLoader.queue.indexOf( control.id ) ) {
		window.kirkiControlsLoader.queue.push( control.id );
	}

	// If we're busy check back again later.
	if ( true === window.kirkiControlsLoader.busy ) {
		_.defer( function() {
			kirkiControlLoader( control, forceLoad );
		} );
		return;
	}

	// Run if force-loading and not busy.
	if ( true === forceLoad || false === window.kirkiControlsLoader.busy ) {

		// Set to busy.
		window.kirkiControlsLoader.busy = true;

		// Init the control JS.
		control.initKirkiControl();
		jQuery( control.container.find( '.kirki-controls-loading-spinner' ) ).hide();

		// Mark as done and remove from queue.
		window.kirkiControlsLoader.done.push( control.id );
		i = window.kirkiControlsLoader.queue.indexOf( control.id );
		window.kirkiControlsLoader.queue.splice( i, 1 );

		// Set busy to false after waitTime has passed.
		_.defer( function() {
			window.kirkiControlsLoader.busy = false;
		} );
		return;
	}

	if ( control.id === window.kirkiControlsLoader.queue[0] ) {
		kirkiControlLoader( control, true );
	}
	*/
}
