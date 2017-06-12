wp.customize.controlConstructor['kirki-preset'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		'use strict';

		var control = this,
		    section = control.section.get();

		// Add to the queue.
		control.kirkiLoader();
	},

	// Add control to a queue and load when the time is right.
	kirkiLoader: function( forceLoad ) {
		var control  = this,
		    waitTime = 30,
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
		    selectValue;

		// Trigger a change
		this.container.on( 'change', 'select', function() {

			// Get the control's value
			selectValue = jQuery( this ).val();

			// Update the value using the customizer API and trigger the "save" button
			control.setting.set( selectValue );

			// We have to get the choices of this control
			// and then start parsing them to see what we have to do for each of the choices.
			jQuery.each( control.params.choices, function( key, value ) {

				// If the current value of the control is the key of the choice,
				// then we can continue processing, Otherwise there's no reason to do anything.
				if ( selectValue === key ) {

					// Each choice has an array of settings defined in it.
					// We'll have to loop through them all and apply the changes needed to them.
					jQuery.each( value.settings, function( presetSetting, presetSettingValue ) {
						kirkiSetSettingValue.set( presetSetting, presetSettingValue );
					});

				}

			});

			wp.customize.previewer.refresh();

		});

	}
});
