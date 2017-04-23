wp.customize.controlConstructor['kirki-typography'] = wp.customize.Control.extend({

	ready: function() {

		'use strict';

		var control               = this,
		    fontFamilySelector    = control.selector + ' .font-family select',
		    variantSelector       = control.selector + ' .variant select',
		    subsetSelector        = control.selector + ' .subsets select',
		    textTransformSelector = control.selector + ' .text-transform select',
		    value                 = control.getValue(),
		    picker;

		control.renderFontSelector();
		control.renderVariantSelector();
		control.renderSubsetSelector();

		// Font-size.
		this.container.on( 'change keyup paste', '.font-size input', function() {
			value['font-size'] = jQuery( this ).val();
			control.saveValue( value );
		});

		// Line-height.
		this.container.on( 'change keyup paste', '.line-height input', function() {
			value['line-height'] = jQuery( this ).val();
			control.saveValue( value );
		});

		// Letter-spacing.
		this.container.on( 'change keyup paste', '.letter-spacing input', function() {
			value['letter-spacing'] = jQuery( this ).val();
			control.saveValue( value );
		});

		// Word-spacing.
		this.container.on( 'change keyup paste', '.word-spacing input', function() {
			value['word-spacing'] = jQuery( this ).val();
			control.saveValue( value );
		});

		this.container.on( 'change', '.text-align input', function() {
			value['text-align'] = jQuery( this ).val();
			control.saveValue( value );
		});

		// Text-transform
		jQuery( textTransformSelector ).select2().on( 'change', function() {
			value['text-transform'] = jQuery( this ).val();
			control.saveValue( value );
		});

		picker = this.container.find( '.kirki-color-control' );

		// Change color
		picker.wpColorPicker({
			change: function() {
				setTimeout( function() {
					value.color = picker.val();
					control.saveValue( value );
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
		    selectValue,
		    fontSelect;

		// Format standard fonts as an array.
		if ( 'undefined' !== typeof kirkiAllFonts.standard ) {
			_.each( kirkiAllFonts.standard, function( font ) {
				standardFonts.push({
					id: font.family,
					text: font.label
				});
			});
		}

		// Format google fonts as an array.
		if ( 'undefined' !== typeof kirkiAllFonts.standard ) {
			_.each( kirkiAllFonts.google, function( font ) {
				googleFonts.push({
					id: font.family,
					text: font.label
				});
			});
		}

		// Combine forces and build the final data.
		data = [
			{
				text: 'Standard Fonts',
				children: standardFonts
			},
			{
				text: 'Google Fonts',
				children: googleFonts
			}
		];

		// Instantiate select2 with the data.
		fontSelect = jQuery( selector ).select2({
			data: data
		})

		// Set the initial value.
		.val( value['font-family'] )

		// When the value changes
		.on( 'change', function( e ) {

			// Set the value.
			value['font-family'] = jQuery( this ).val();
			control.saveValue( value );

			// Re-init variants selector.
			jQuery( variantSelector ).select2( 'destroy' );
			control.renderVariantSelector();

			// Re-init subsets selector.
			jQuery( subsetSelector ).select2( 'destroy' );
			control.renderSubsetSelector();
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
		    variantSelector;

		if ( false !== variants ) {
			jQuery( control.selector + ' .variant' ).show();
			_.each( variants, function( variant ) {
				data.push({
					id: variant.id,
					text: variant.label
				});
			});

		} else {
			jQuery( control.selector + ' .variant' ).hide();
		}

		// Instantiate select2 with the data.
		variantSelector = jQuery( selector ).select2({
			data: data
		}).val( value.variant ).on( 'change', function( e ) {
			value.variant = jQuery( this ).val();
			control.saveValue( value );
		});
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
		    subsetSelector;

		if ( false !== subsets ) {
			jQuery( control.selector + ' .subsets' ).show();
			_.each( subsets, function( subset ) {
				data.push({
					id: subset.id,
					text: subset.label
				});
			});

		} else {
			jQuery( control.selector + ' .subsets' ).hide();
		}

		// Instantiate select2 with the data.
		subsetSelector = jQuery( selector ).select2({
			data: data
		}).val( value.subsets ).on( 'change', function( e ) {
			value.subsets = jQuery( this ).val();
			control.saveValue( value );
		});
	},

	/**
	 * Get variants for a font-family.
	 */
	getVariants: function( fontFamily ) {

		var variants = false;

		_.each( kirkiAllFonts.google, function( font ) {
			if ( font.family === fontFamily ) {
				variants = font.variants;
			}
		});
		return variants;
	},

	/**
	 * Get subsets for a font-family.
	 */
	getSubsets: function( fontFamily ) {

		var subsets = false;

		_.each( kirkiAllFonts.google, function( font ) {
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

		var control = this,
		    value   = {};

		// Make sure everything we're going to need exists.
		_.each( control.params['default'], function( defaultParamValue, param ) {
			if ( false !== defaultParamValue ) {
				value[ param ] = defaultParamValue;
				if ( 'undefined' !== typeof control.setting._value[ param ] ) {
					value[ param ] = control.setting._value[ param ];
				}
			}
		});
		_.each( control.setting._value, function( subValue, param ) {
			if ( 'undefined' === typeof value[ param ] ) {
				value[ param ] = subValue;
			}
		});
		return value;
	},

	/**
	 * Saves the value.
	 */
	saveValue: function( value ) {

		'use strict';

		var control  = this,
		    newValue = {};

		_.each( value, function( newSubValue, i ) {
			newValue[ i ] = newSubValue;
		});

		control.setting.set( newValue );
	}
});
