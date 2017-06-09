wp.customize.controlConstructor['kirki-number'] = wp.customize.Control.extend({

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
		    waitTime = 100,
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

		'use strict';

		var control = this,
		    element = this.container.find( 'input' ),
		    step    = 1;

		// Set step value.
		if ( ! _.isUndefined( control.params.choices ) && ! _.isUndefined( control.params.choices.step ) ) {
			step = ( 'any' === control.params.choices.step ) ? '0.001' : control.params.choices.step;
		}

		// Init the spinner
		jQuery( element ).spinner({
			min: ( ! _.isUndefined( control.params.choices ) && ! _.isUndefined( control.params.choices.min ) ) ? control.params.choices.min : -99999,
			max: ( ! _.isUndefined( control.params.choices ) && ! _.isUndefined( control.params.choices.max ) ) ? control.params.choices.max : 99999,
			step: step
		});

		// On change
		this.container.on( 'change click keyup paste', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});

		// Notifications.
		control.kirkiNotifications();

	},

	/**
	 * Handles notifications.
	 */
	kirkiNotifications: function() {

		var control = this;

		wp.customize( control.id, function( setting ) {
			setting.bind( function( value ) {
				var code    = 'long_title',
					min     = ( ! _.isUndefined( control.params.choices.min ) ) ? Number( control.params.choices.min ) : false,
					max     = ( ! _.isUndefined( control.params.choices.max ) ) ? Number( control.params.choices.max ) : false,
					step    = ( ! _.isUndefined( control.params.choices.step ) ) ? Number( control.params.choices.step ) : false,
					invalid = false;

				// Make sure value is a number.
				value = Number( value );

				if ( false !== min && value < min ) {
					invalid = 'min-error';
				} else if ( false !== max && value > max ) {
					invalid = 'max-error';
				} else if ( false !== step && false !== min && ! Number.isInteger( ( value - min ) / step ) ) {
					invalid = 'step-error';
				}

				if ( false !== invalid ) {
					setting.notifications.add( code, new wp.customize.Notification( code, {
						type: 'warning',
						message: numberKirkiL10n[ invalid ]
					} ) );
				} else {
					setting.notifications.remove( code );
				}
			});
		});
	}
});
