wp.customize.controlConstructor['kirki-typography'] = wp.customize.Control.extend({

	ready: function() {

		'use strict';

		var control               = this,
		    fontFamilySelector    = control.selector + ' .font-family select',
		    variantSelector       = control.selector + ' .variant select',
		    subsetSelector        = control.selector + ' .subsets select',
		    textTransformSelector = control.selector + ' .text-transform select',
		    hasDefault            = false,
		    firstAvailable        = false,
		    activeItem,
		    value = {},
		    renderSubControl,
		    picker;

		// Make sure everything we're going to need exists.
		_.each( control.params['default'], function( defaultParamValue, param ) {
			if ( false !== defaultParamValue ) {
				value[ param ] = defaultParamValue;
				if ( undefined !== control.setting._value[ param ] ) {
					value[ param ] = control.setting._value[ param ];
				}
			}
		});
		_.each( control.setting._value, function( subValue, param ) {
			if ( undefined === value[ param ] || 'undefined' === typeof value[ param ] ) {
				value[ param ] = subValue;
			}
		});

		// Renders and refreshes selectize sub-controls.
		renderSubControl = function( fontFamily, sub, startValue ) {

			var subSelector = ( 'variant' === sub ) ? variantSelector : subsetSelector,
			    isStandard = false,
			    subList = {},
			    subValue,
			    subsetValues,
			    subsetValuesArray,
			    subSelectize;

			// Destroy the selectize instance.
			if ( undefined !== jQuery( subSelector ).selectize()[0] ) {
				jQuery( subSelector ).selectize()[0].selectize.destroy();
			}

			// Get all items in the sub-list for the active font-family.
			_.each( kirkiAllFonts, function( font, i ) {

				// Find the font-family we've selected in the global array of fonts.
				if ( fontFamily === font.family ) {

					// Check if this is a standard font or a google-font.
					if ( undefined !== font.isStandard && true === font.isStandard ) {
						isStandard = true;
					}

					if ( 'variant' === sub ) {
						subList = font.variants;
					} else if ( 'subsets' === sub ) {
						subList = font.subsets;
					}

				}

			});

			// This is a googlefont, or we're talking subsets.
			if ( false === isStandard || 'subsets' !== sub ) {

				// Determine the initial value we have to use
				if ( null === startValue  ) {

					if ( 'variant' === sub ) { // The context here is variants

						// Loop the variants.
						_.each( subList, function( variant ) {

							var defaultValue;

							if ( undefined !== variant.id ) {

								activeItem = value.variant;

							} else {

								defaultValue = 'regular';

								if ( defaultValue === variant.id ) {
									hasDefault = true;
								} else if ( false === firstAvailable ) {
									firstAvailable = variant.id;
								}

							}

						});

					} else if ( 'subsets' === sub ) { // The context here is subsets

						subsetValues = {};

						_.each( subList, function( subSet ) {
							if ( null !== value.subsets ) {
								_.each( value.subsets, function( item ) {
									if ( undefined !== subSet && item === subSet.id ) {
										subsetValues[ item ] = item;
									}
								});
							}
						});

						if ( 0 !== subsetValues.length ) {
							subsetValuesArray = jQuery.map( subsetValues, function( value, index ) {
								return [value];
							});
							activeItem = subsetValuesArray;
						}

					}

					// If we have a valid setting, use it.
					// If not, check if the default value exists.
					// If not, then use the 1st available option.
					subValue = ( undefined !== activeItem ) ? activeItem : ( false !== hasDefault ) ? 'regular' : firstAvailable;

				} else {

					subValue = startValue;

				}

				// Create
				subSelectize = jQuery( subSelector ).selectize({
					maxItems:    ( 'variant' === sub ) ? 1 : null,
					valueField:  'id',
					labelField:  'label',
					searchField: ['label'],
					options:     subList,
					items:       ( 'variant' === sub ) ? [ subValue ] : subValue,
					create:      false,
					plugins:     ( 'variant' === sub ) ? '' : ['remove_button'],
					render: {
						item: function( item, escape ) {
							return '<div>' + escape( item.label ) + '</div>';
						},
						option: function( item, escape ) {
							return '<div>' + escape( item.label ) + '</div>';
						}
					}
				}).data( 'selectize' );

			}

			if ( true === isStandard ) {

				// Hide unrelated fields on standard fonts.
				control.container.find( '.hide-on-standard-fonts' ).css( 'display', 'none' );
			} else {

				if ( 2 > subList.length ) {

					// If only 1 option is available then there's no reason to show this.
					control.container.find( '.kirki-' + sub + '-wrapper' ).css( 'display', 'none' );
				} else {
					control.container.find( '.kirki-' + sub + '-wrapper' ).css( 'display', 'block' );
				}

			}

		};

		// Render the font-family
		jQuery( fontFamilySelector ).selectize({
			options:     kirkiAllFonts,
			items:       [ control.setting._value['font-family'] ],
			persist:     false,
			maxItems:    1,
			valueField:  'family',
			labelField:  'label',
			searchField: ['family', 'label', 'subsets'],
			create:      false,
			render: {
				item: function( item, escape ) {
					return '<div>' + escape( item.label ) + '</div>';
				},
				option: function( item, escape ) {
					return '<div>' + escape( item.label ) + '</div>';
				}
			}
		});

		// Render the variants
		// Please note that when the value of font-family changes,
		// this will be destroyed and re-created.
		renderSubControl( value['font-family'], 'variant', value.variant );

		// Render the subsets
		// Please note that when the value of font-family changes,
		// this will be destroyed and re-created.
		renderSubControl( value['font-family'], 'subsets', value.subsets );

		this.container.on( 'change', '.font-family select', function() {

			// Add the value to the array and set the setting's value
			value['font-family'] = jQuery( this ).val();
			control.saveValue( value );

			// Trigger changes to variants & subsets
			renderSubControl( jQuery( this ).val(), 'variant', null );
			renderSubControl( jQuery( this ).val(), 'subsets', null );

			// Refresh the preview
			wp.customize.previewer.refresh();

		});

		this.container.on( 'change', '.variant select', function() {

			// Add the value to the array and set the setting's value
			value.variant = jQuery( this ).val();
			control.saveValue( value );

			// Refresh the preview
			wp.customize.previewer.refresh();

		});

		this.container.on( 'change', '.subsets select', function() {

			// Add the value to the array and set the setting's value.
			value.subsets = jQuery( this ).val();
			control.saveValue( value );

			// Refresh the preview
			wp.customize.previewer.refresh();

		});

		this.container.on( 'change keyup paste', '.font-size input', function() {

			// Add the value to the array and set the setting's value
			value['font-size'] = jQuery( this ).val();
			control.saveValue( value );

		});

		this.container.on( 'change keyup paste', '.line-height input', function() {

			// Add the value to the array and set the setting's value
			value['line-height'] = jQuery( this ).val();
			control.saveValue( value );

		});

		this.container.on( 'change keyup paste', '.letter-spacing input', function() {

			// Add the value to the array and set the setting's value
			value['letter-spacing'] = jQuery( this ).val();
			control.saveValue( value );

		});

		this.container.on( 'change', '.text-align input', function() {

			// Add the value to the array and set the setting's value.
			value['text-align'] = jQuery( this ).val();
			control.saveValue( value );

		});

		// Text-transform
		jQuery( textTransformSelector ).selectize();
		this.container.on( 'change', '.text-transform select', function() {

			// Add the value to the array and set the setting's value.
			value['text-transform'] = jQuery( this ).val();
			control.saveValue( value );

		});

		picker = this.container.find( '.kirki-color-control' );

		// Change color
		picker.wpColorPicker({
			change: function() {

				setTimeout( function() {

					// Add the value to the array and set the setting's value
					value.color = picker.val();
					control.saveValue( value );

				}, 100 );

			}

		});

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
