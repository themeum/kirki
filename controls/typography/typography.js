wp.customize.controlConstructor['kirki-typography'] = wp.customize.Control.extend({

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
		    waitTime = 10,
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

		var control               = this,
		    textTransformSelector = control.selector + ' .text-transform select',
		    value                 = control.getValue(),
		    picker;

		control.renderFontSelector();
		control.renderBackupFontSelector();
		control.renderVariantSelector();
		control.renderSubsetSelector();

		// Font-size.
		this.container.on( 'change keyup paste', '.font-size input', function() {
			control.saveValue( 'font-size', jQuery( this ).val() );
		});

		// Line-height.
		this.container.on( 'change keyup paste', '.line-height input', function() {
			control.saveValue( 'line-height', jQuery( this ).val() );
		});

		// Margin-top.
		this.container.on( 'change keyup paste', '.margin-top input', function() {
			control.saveValue( 'margin-top', jQuery( this ).val() );
		});

		// Margin-bottom.
		this.container.on( 'change keyup paste', '.margin-bottom input', function() {
			control.saveValue( 'margin-bottom', jQuery( this ).val() );
		});

		// Letter-spacing.
		value['letter-spacing'] = ( jQuery.isNumeric( value['letter-spacing'] ) ) ? value['letter-spacing'] + 'px' : value['letter-spacing'];
		this.container.on( 'change keyup paste', '.letter-spacing input', function() {
			value['letter-spacing'] = ( jQuery.isNumeric( jQuery( this ).val() ) ) ? jQuery( this ).val() + 'px' : jQuery( this ).val();
			control.saveValue( 'letter-spacing', value['letter-spacing'] );
		});

		// Word-spacing.
		this.container.on( 'change keyup paste', '.word-spacing input', function() {
			control.saveValue( 'word-spacing', jQuery( this ).val() );
		});

		this.container.on( 'change', '.text-align input', function() {
			control.saveValue( 'text-align', jQuery( this ).val() );
		});

		// Text-transform
		jQuery( textTransformSelector ).select2().on( 'change', function() {
			control.saveValue( 'text-transform', jQuery( this ).val() );
		});

		picker = this.container.find( '.kirki-color-control' );

		// Change color
		picker.wpColorPicker({
			change: function() {
				setTimeout( function() {
					control.saveValue( 'color', picker.val() );
				}, 100 );
			}
		});
	},

	/**
	 * Adds the font-families to the font-family dropdown
	 * and instantiates select2.
	 */
	renderFontSelector: function() {

		var control         = this,
		    selector        = control.selector + ' .font-family select',
		    data            = [],
		    standardFonts   = [],
		    googleFonts     = [],
			value           = control.getValue(),
			variantSelector = control.selector + ' .variant select',
		    subsetSelector  = control.selector + ' .subsets select',
			fonts           = control.getFonts(),
		    fontSelect;

		// Format standard fonts as an array.
		if ( ! _.isUndefined( fonts.standard ) ) {
			_.each( fonts.standard, function( font ) {
				standardFonts.push({
					id: font.family.replace( /&quot;/g, '&#39' ),
					text: font.label
				});
			});
		}

		// Format google fonts as an array.
		if ( ! _.isUndefined( fonts.standard ) ) {
			_.each( fonts.google, function( font ) {
				googleFonts.push({
					id: font.family,
					text: font.label
				});
			});
		}

		// Combine forces and build the final data.
		data = [
			{ text: 'Standard Fonts', children: standardFonts },
			{ text: 'Google Fonts',   children: googleFonts }
		];

		// Instantiate select2 with the data.
		fontSelect = jQuery( selector ).select2({
			data: data
		});

		// Set the initial value.
		if ( value['font-family'] ) {
			fontSelect.val( value['font-family'].replace( /'/g, '"' ) ).trigger( 'change' );
		}

		// When the value changes
		fontSelect.on( 'change', function() {

			// Set the value.
			control.saveValue( 'font-family', jQuery( this ).val() );

			// Re-init the font-backup selector.
			control.renderBackupFontSelector();

			// Re-init variants selector.
			control.renderVariantSelector();

			// Re-init subsets selector.
			control.renderSubsetSelector();
		});
	},

	/**
	 * Adds the font-families to the font-family dropdown
	 * and instantiates select2.
	 */
	renderBackupFontSelector: function() {

		var control       = this,
		    selector      = control.selector + ' .font-backup select',
		    standardFonts = [],
		    value         = control.getValue(),
		    fontFamily    = value['font-family'],
		    variants      = control.getVariants( fontFamily ),
		    fonts         = control.getFonts(),
		    fontSelect;

		if ( _.isUndefined( value['font-backup'] ) || null === value['font-backup'] ) {
			value['font-backup'] = '';
		}

		// Hide if we're not on a google-font.
		if ( false !== variants ) {
			jQuery( control.selector + ' .font-backup' ).show();
		} else {
			jQuery( control.selector + ' .font-backup' ).hide();
		}

		// Format standard fonts as an array.
		if ( ! _.isUndefined( fonts.standard ) ) {
			_.each( fonts.standard, function( font ) {
				standardFonts.push({
					id: font.family.replace( /&quot;/g, '&#39' ),
					text: font.label
				});
			});
		}

		// Instantiate select2 with the data.
		fontSelect = jQuery( selector ).select2({
			data: standardFonts
		});

		// Set the initial value.
		fontSelect.val( value['font-backup'].replace( /'/g, '"' ) ).trigger( 'change' );

		// When the value changes
		fontSelect.on( 'change', function() {

			// Set the value.
			control.saveValue( 'font-backup', jQuery( this ).val() );
		});
	},

	/**
	 * Renders the variants selector using select2
	 * Displays font-variants for the currently selected font-family.
	 */
	renderVariantSelector: function() {

		var control    = this,
		    value      = control.getValue(),
			fontFamily = value['font-family'],
			variants   = control.getVariants( fontFamily ),
		    selector   = control.selector + ' .variant select',
		    data       = [],
		    isValid    = false,
		    variantSelector,
		    fontWeight,
		    fontStyle;

		if ( false !== variants ) {
			jQuery( control.selector + ' .variant' ).show();
			_.each( variants, function( variant ) {
				if ( value.variant === variant.id ) {
					isValid = true;
				}
				data.push({
					id: variant.id,
					text: variant.label
				});
			});
			if ( ! isValid ) {
				value.variant = 'regular';
			}

			if ( jQuery( selector ).hasClass( 'select2-hidden-accessible' ) ) {
				jQuery( selector ).select2( 'destroy' );
				jQuery( selector ).empty();
			}

			// Instantiate select2 with the data.
			variantSelector = jQuery( selector ).select2({
				data: data
			});
			variantSelector.val( value.variant ).trigger( 'change' );
			variantSelector.on( 'change', function() {
				control.saveValue( 'variant', jQuery( this ).val() );

				fontWeight = ( ! _.isString( value.variant ) ) ? '400' : value.variant.match( /\d/g );
				fontWeight = ( ! _.isObject( fontWeight ) ) ? '400' : fontWeight.join( '' );
				fontStyle  = ( -1 !== value.variant.indexOf( 'italic' ) ) ? 'italic' : 'normal';

				control.saveValue( 'font-weight', fontWeight );
				control.saveValue( 'font-style', fontStyle );
			});
		} else {
			jQuery( control.selector + ' .variant' ).hide();
		}
	},

	/**
	 * Renders the subsets selector using select2
	 * Displays font-subsets for the currently selected font-family.
	 */
	renderSubsetSelector: function() {

		var control    = this,
		    value      = control.getValue(),
			fontFamily = value['font-family'],
			subsets    = control.getSubsets( fontFamily ),
		    selector   = control.selector + ' .subsets select',
		    data       = [],
		    validValue = value.subsets,
		    subsetSelector;

		if ( false !== subsets ) {
			jQuery( control.selector + ' .subsets' ).show();
			_.each( subsets, function( subset ) {

				if ( _.isObject( validValue ) ) {
					if ( -1 === validValue.indexOf( subset.id ) ) {
						validValue = _.reject( validValue, function( subValue ) {
							return subValue === subset.id;
						});
					}
				}

				data.push({
					id: subset.id,
					text: subset.label
				});
			});

		} else {
			jQuery( control.selector + ' .subsets' ).hide();
		}

		if ( jQuery( selector ).hasClass( 'select2-hidden-accessible' ) ) {
			jQuery( selector ).select2( 'destroy' );
			jQuery( selector ).empty();
		}

		// Instantiate select2 with the data.
		subsetSelector = jQuery( selector ).select2({
			data: data
		});
		subsetSelector.val( validValue ).trigger( 'change' );
		subsetSelector.on( 'change', function() {
			control.saveValue( 'subsets', jQuery( this ).val() );
		});
	},

	/**
	 * Get fonts.
	 */
	getFonts: function() {
		var control = this;

		if ( ! _.isUndefined( window[ 'kirkiFonts' + control.id ] ) ) {
			return window[ 'kirkiFonts' + control.id ];
		}
		if ( ! _.isUndefined( kirkiAllFonts ) ) {
			return kirkiAllFonts;
		}
		return {
			google: [],
			standard: []
		};
	},

	/**
	 * Get variants for a font-family.
	 */
	getVariants: function( fontFamily ) {
		var control = this,
		    fonts   = control.getFonts();

		var variants = false;
		_.each( fonts.standard, function( font ) {
			if ( fontFamily && font.family === fontFamily.replace( /'/g, '"' ) ) {
				variants = font.variants;
				return font.variants;
			}
		});

		_.each( fonts.google, function( font ) {
			if ( font.family === fontFamily ) {
				variants = font.variants;
				return font.variants;
			}
		});
		return variants;
	},

	/**
	 * Get subsets for a font-family.
	 */
	getSubsets: function( fontFamily ) {

		var control = this,
		    subsets = false,
		    fonts   = control.getFonts();

		_.each( fonts.google, function( font ) {
			if ( font.family === fontFamily ) {
				subsets = font.subsets;
			}
		});
		return subsets;
	},

	/**
	 * Gets the value.
	 */
	getValue: function() {

		'use strict';

		var control   = this,
		    input     = control.container.find( '.typography-hidden-value' ),
		    valueJSON = jQuery( input ).val();

		return JSON.parse( valueJSON );
	},

	/**
	 * Saves the value.
	 */
	saveValue: function( property, value ) {

		'use strict';

		var control   = this,
		    input     = control.container.find( '.typography-hidden-value' ),
		    valueJSON = jQuery( input ).val(),
		    valueObj  = JSON.parse( valueJSON );

		valueObj[ property ] = value;
		jQuery( input ).attr( 'value', JSON.stringify( valueObj ) ).trigger( 'change' );
		control.setting.set( valueObj );

	}
});
