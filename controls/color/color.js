wp.customize.controlConstructor['kirki-color'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		'use strict';

		var control = this,
		    section = control.section.get();

		// Force-load the control if we open the section.
		jQuery( '#accordion-section-' + section ).on( 'click', function() {
			control.initKirkiControl();
		});
		if ( jQuery( '#sub-accordion-section-' + section ).hasClass( 'open' ) ) {
			control.initKirkiControl();
		}

		// Add to the queue.
		control.kirkiLoader();
	},

	// Add control to a queue and load when the time is right.
	kirkiLoader: function( forceLoad ) {
		var control  = this,
		    waitTime = 20,
		    i;

		if ( _.isUndefined( window.kirkiControlsLoader ) ) {
			window.kirkiControlsLoader = {
				queue: [],
				done: [],
				busy: false
			};
		}

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
			setTimeout( function() {
				control.kirkiLoader();
			}, waitTime );
			return;
		}

		// Run if force-loading and not busy.
		if ( true === forceLoad || false === window.kirkiControlsLoader.busy ) {

			// Set to busy.
			window.kirkiControlsLoader.busy = true;

			// Init the control JS.
			control.initKirkiControl();

			// Mark as done and remove from queue.
			window.kirkiControlsLoader.done.push( control.id );
			i = window.kirkiControlsLoader.queue.indexOf( control.id );
			window.kirkiControlsLoader.queue.splice( i, 1 );

			// Set busy to false after waitTime has passed.
			setTimeout( function() {
				window.kirkiControlsLoader.busy = false;
			}, waitTime );
			return;
		}

		if ( control.id === window.kirkiControlsLoader.queue[0] ) {
			control.kirkiLoader( true );
		}
	},

	initKirkiControl: function() {
		var control = this,
		    section = control.section.get(),
		    picker  = this.container.find( '.kirki-color-control' ),
		    clear;

		// If we have defined any extra choices, make sure they are passed-on to Iris.
		if ( ! _.isUndefined( control.params.choices ) ) {
			picker.wpColorPicker( control.params.choices );
		}

		// Tweaks to make the "clear" buttons work.
		setTimeout( function() {
			clear = control.container.find( '.wp-picker-clear' );
			clear.click( function() {
				control.setting.set( '' );
			});
		}, 500 );

		// Saves our settings to the WP API
		picker.wpColorPicker({
			change: function() {

				// Small hack: the picker needs a small delay
				setTimeout( function() {
					control.setting.set( picker.val() );
				}, 100 );

			}
		});
	}
});
