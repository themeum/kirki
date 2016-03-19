/**
 * KIRKI CONTROL: TYPOGRAPHY
 */
wp.customize.controlConstructor['typography'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		var fontFamilySelector = control.selector + ' .font-family select';
		var variantSelector    = control.selector + ' .variant select';
		var subsetSelector     = control.selector + ' .subset select';
		// Get initial values
		var value = {};
		value['font-family']    = ( undefined !== control.setting._value['font-family'] ) ? control.setting._value['font-family'] : '';
		value['font-size']      = ( undefined !== control.setting._value['font-size'] ) ? control.setting._value['font-size'] : '';
		value['variant']        = ( undefined !== control.setting._value['variant'] ) ? control.setting._value['variant'] : '';
		value['subset']         = ( undefined !== control.setting._value['subset'] ) ? control.setting._value['subset'] : '';
		value['line-height']    = ( undefined !== control.setting._value['line-height'] ) ? control.setting._value['line-height'] : '';
		value['letter-spacing'] = ( undefined !== control.setting._value['letter-spacing'] ) ? control.setting._value['letter-spacing'] : '';
		value['color']          = ( undefined !== control.setting._value['color'] ) ? control.setting._value['color'] : '';

		var renderSubControl = function( fontFamily, sub, startValue ) {
			subSelector = ( 'variant' == sub ) ? variantSelector : subsetSelector;
			var is_standard = false;
			var subList = {}
			// destroy
			if ( undefined !== jQuery( subSelector ).selectize()[0] ) {
				jQuery( subSelector ).selectize()[0].selectize.destroy();
			}
			// Get all items in the sub-list for the active font-family
			for ( var i = 0, len = kirkiAllFonts.length; i < len; i++ ) {
				if ( fontFamily === kirkiAllFonts[ i ]['family'] ) {
					if ( undefined !== kirkiAllFonts[ i ]['is_standard'] && true === kirkiAllFonts[ i ]['is_standard'] ) {
						is_standard = true;
					}
					subList = kirkiAllFonts[ i ][ sub + 's' ]; // the 's' is for plural (variant/variants, subset/subsets)
				}
			}
			if ( false === is_standard || 'subset' !== sub ) {
				// Determine the initial value we have to use
				if ( null === startValue  ) {
					if ( 'variant' == sub ) { // the context here is variants
						for ( var i = 0, len = subList.length; i < len; i++ ) {
							if ( undefined !== subList[ i ]['id'] ) {
								var activeItem = value['variant'];
							} else {
								var defaultValue = 'regular';
								if ( defaultValue == subList[ i ]['id'] ) {
									var hasDefault = true;
								} else if ( undefined === firstAvailable ) {
									var firstAvailable = subList[ i ]['id'];
								}
							}
						}
					} else if ( 'subset' == sub ) { // The context here is subsets
						var subsetValues = {};
						for ( var i = 0, len = subList.length; i < len; i++ ) {
							if ( null !== value['subset'] ) {
								for ( var s = 0, len = value['subset'].length; s < len; s++ ) {
									if ( undefined !== subList[ i ] && value['subset'][ s ] == subList[ i ]['id'] ) {
										subsetValues[ value['subset'][ s ] ] = value['subset'][ s ];
									}
								}
							}
						}
						if ( 0 == subsetValues.length ) {
							activeItem = ['latin']
						} else {
							var subsetValuesArray = jQuery.map( subsetValues, function(value, index) {
								return [value];
							});
							activeItem = subsetValuesArray;
						}
					}
					// If we have a valid setting, use it.
					// If not, check if the default value exists.
					// If not, then use the 1st available option.
					subValue = ( undefined !== activeItem ) ? activeItem : ( undefined !== hasDefault ) ? 'regular' : firstAvailable;
				} else {
					subValue = startValue;
				}
				// create
				var subSelectize;
				subSelectize = jQuery( subSelector ).selectize({
					maxItems:    ( 'variant' == sub ) ? 1 : null,
					valueField:  'id',
					labelField:  'label',
					searchField: ['label'],
					options:     subList,
					items:       ( 'variant' == sub ) ? [ subValue ] : subValue,
					create:      false,
					plugins:     ( 'variant' == sub ) ? '' : ['remove_button'],
					render: {
						item: function( item, escape ) { return '<div>' + escape( item.label ) + '</div>'; },
						option: function( item, escape ) { return '<div>' + escape( item.label ) + '</div>'; }
					},
				}).data( 'selectize' );
			}


			// If only 1 option is available then there's no reason to show this.
			if ( 'variant' == sub ) {
				if ( 1 === subList.length || 0 === subList.length ) {
					control.container.find( '.kirki-variant-wrapper' ).css( 'display', 'none' );
				} else {
					control.container.find( '.kirki-variant-wrapper' ).css( 'display', 'block' );
				}
			} else if ( 'subset' == sub ) {
				if ( 0 === subList.length ) {
					control.container.find( '.kirki-subset-wrapper' ).css( 'display', 'none' );
				} else {
					control.container.find( '.kirki-subset-wrapper' ).css( 'display', 'block' );
				}
			}

			if ( true === is_standard ) {
				control.container.find( '.hide-on-standard-fonts' ).css( 'display', 'none' );
			} else {
				control.container.find( '.hide-on-standard-fonts' ).css( 'display', 'block' );
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
				item: function( item, escape ) { return '<div>' + escape( item.label ) + '</div>'; },
				option: function( item, escape ) { return '<div>' + escape( item.label ) + '</div>'; }
			},
		});

		// Render the variants
		// Please note that when the value of font-family changes,
		// this will be destroyed and re-created.
		renderSubControl( value['font-family'], 'variant', value['variant'] );

		// Render the subsets
		// Please note that when the value of font-family changes,
		// this will be destroyed and re-created.
		renderSubControl( value['font-family'], 'subset', value['subset'] );

		this.container.on( 'change', '.font-family select', function() {
			// add the value to the array and set the setting's value
			value['font-family'] = jQuery( this ).val();
			control.setting.set( value );
			// trigger changes to variants & subsets
			renderSubControl( jQuery( this ).val(), 'variant', null );
			renderSubControl( jQuery( this ).val(), 'subset', null );
			// refresh the preview
			wp.customize.previewer.refresh();
		});

		this.container.on( 'change', '.variant select', function() {
			// add the value to the array and set the setting's value
			value['variant'] = jQuery( this ).val();
			control.setting.set( value );
			// refresh the preview
			wp.customize.previewer.refresh();
		});

		this.container.on( 'change', '.subset select', function() {
			// add the value to the array and set the setting's value.
			value['subset'] = jQuery( this ).val();
			control.setting.set( value );
			// refresh the preview
			wp.customize.previewer.refresh();
		});

		this.container.on( 'change keyup paste', '.font-size input', function() {
			// add the value to the array and set the setting's value
			value['font-size'] = jQuery( this ).val();
			control.setting.set( value );
			// refresh the preview
			wp.customize.previewer.refresh();
		});

		this.container.on( 'change keyup paste', '.line-height input', function() {
			// add the value to the array and set the setting's value
			value['line-height'] = jQuery( this ).val();
			control.setting.set( value );
			// refresh the preview
			wp.customize.previewer.refresh();
		});

		this.container.on( 'change keyup paste', '.letter-spacing input', function() {
			// add the value to the array and set the setting's value
			value['letter-spacing'] = jQuery( this ).val();
			control.setting.set( value );
			// refresh the preview
			wp.customize.previewer.refresh();
		});

		var picker = this.container.find ( '.kirki-color-control' );
		picker.wpColorPicker ( {
			change: function() {
				setTimeout ( function() {
					// add the value to the array and set the setting's value
					value[ 'color' ] = picker.val ();
					control.setting.set ( value );
					// refresh the preview
					wp.customize.previewer.refresh ();
				}, 100 );
			}
		} );
	}
});
