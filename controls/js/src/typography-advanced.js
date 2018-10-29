/* global kirkiL10n, kirki */
wp.customize.controlConstructor['kirki-typography-advanced'] = wp.customize.kirkiDynamicControl.extend( {

	initKirkiControl: function() {

		'use strict';

		var control = this,
			value   = control.setting._value,
			picker;
		control.global_types = [
			'font-family',
			'font-backup',
			'font-weight',
			'font-style',
			'variant',
			'text-transform',
			'text-decoration',
			'color',
			'text-align'
		],
		control.media_query_types = [
			'font-size',
			'line-height',
			'margin-top',
			'margin-bottom',
			'letter-spacing',
			'word-spacing'
		];
		
		control.selected_device = kirki.util.media_query_devices.global;
		
		control.initValue();
		control.initMediaQueries();
		
		control.renderFontSelector();
		control.renderBackupFontSelector();
		control.renderVariantSelector();
		control.localFontsCheckbox();

		// Font-size.
		if ( control.params.default['font-size'] ) {
			this.container.on( 'change keyup paste', '.font-size input', function() {
				control.saveValue( 'font-size', jQuery( this ).val() );
			} );
		}

		// Line-height.
		if ( control.params.default['line-height'] ) {
			this.container.on( 'change keyup paste', '.line-height input', function() {
				control.saveValue( 'line-height', jQuery( this ).val() );
			} );
		}

		// Margin-top.
		if ( control.params.default['margin-top'] ) {
			this.container.on( 'change keyup paste', '.margin-top input', function() {
				control.saveValue( 'margin-top', jQuery( this ).val() );
			} );
		}

		// Margin-bottom.
		if ( control.params.default['margin-bottom'] ) {
			this.container.on( 'change keyup paste', '.margin-bottom input', function() {
				control.saveValue( 'margin-bottom', jQuery( this ).val() );
			} );
		}

		// Letter-spacing.
		if ( control.params.default['letter-spacing'] ) {
			value['letter-spacing'] = ( jQuery.isNumeric( value['letter-spacing'] ) ) ? value['letter-spacing'] + 'px' : value['letter-spacing'];
			this.container.on( 'change keyup paste', '.letter-spacing input', function() {
				value['letter-spacing'] = ( jQuery.isNumeric( jQuery( this ).val() ) ) ? jQuery( this ).val() + 'px' : jQuery( this ).val();
				control.saveValue( 'letter-spacing', value['letter-spacing'] );
			} );
		}

		// Word-spacing.
		if ( control.params.default['word-spacing'] ) {
			this.container.on( 'change keyup paste', '.word-spacing input', function() {
				control.saveValue( 'word-spacing', jQuery( this ).val() );
			} );
		}

		// Text-align.
		if ( control.params.default['text-align'] ) {
			this.container.on( 'change', '.text-align input', function() {
				control.saveValue( 'text-align', jQuery( this ).val() );
			} );
		}

		// Text-transform.
		if ( control.params.default['text-transform'] ) {
			jQuery( control.selector + ' .text-transform select' ).selectWoo().on( 'change', function() {
				control.saveValue( 'text-transform', jQuery( this ).val() );
			} );
		}

		// Text-decoration.
		if ( control.params.default['text-decoration'] ) {
			jQuery( control.selector + ' .text-decoration select' ).selectWoo().on( 'change', function() {
				control.saveValue( 'text-decoration', jQuery( this ).val() );
			} );
		}

		// Color.
		if ( ! _.isUndefined( control.params.default.color ) ) {
			picker = this.container.find( '.kirki-color-control' );
			picker.wpColorPicker( {
				change: function() {
					setTimeout( function() {
						control.saveValue( 'color', picker.val() );
					}, 100 );
				},
				clear: function (event) {
					setTimeout( function() {
						control.saveValue( 'color', '' );
					}, 100 );
				}
			} );
		}
	},

	/**
	 * Adds the font-families to the font-family dropdown
	 * and instantiates selectWoo.
	 */
	renderFontSelector: function() {

		var control         = this,
			selector        = control.selector + ' .font-family select',
			data            = [],
			standardFonts   = [],
			googleFonts     = [],
			value           = control.setting._value,
			fonts           = control.getFonts(),
			fontSelect,
			controlFontFamilies;

		// Format standard fonts as an array.
		if ( ! _.isUndefined( fonts.standard ) ) {
			_.each( fonts.standard, function( font ) {
				standardFonts.push( {
					id: font.family.replace( /&quot;/g, '&#39' ),
					text: font.label
				} );
			} );
		}

		// Format google fonts as an array.
		if ( ! _.isUndefined( fonts.google ) ) {
			_.each( fonts.google, function( font ) {
				googleFonts.push( {
					id: font.family,
					text: font.family
				} );
			} );
		}

		// Do we have custom fonts?
		controlFontFamilies = {};
		if ( ! _.isUndefined( control.params ) && ! _.isUndefined( control.params.choices ) && ! _.isUndefined( control.params.choices.fonts ) && ! _.isUndefined( control.params.choices.fonts.families ) ) {
			controlFontFamilies = control.params.choices.fonts.families;
		}

		// Combine forces and build the final data.
		data = jQuery.extend( {}, controlFontFamilies, {
			default: {
				text: kirkiL10n.defaultCSSValues,
				children: [
					{ id: '', text: kirkiL10n.defaultBrowserFamily },
					{ id: 'initial', text: 'initial' },
					{ id: 'inherit', text: 'inherit' }
				]
			},
			standard: {
				text: kirkiL10n.standardFonts,
				children: standardFonts
			},
			google: {
				text: kirkiL10n.googleFonts,
				children: googleFonts
			}
		} );

		if ( kirkiL10n.isScriptDebug ) {
			console.info( 'Kirki Debug: Font families for control "' + control.id + '":' );
			console.info( data );
		}

		data = _.values( data );

		// Instantiate selectWoo with the data.
		fontSelect = jQuery( selector ).selectWoo( {
			data: data
		} );

		// Set the initial value.
		if ( value['font-family'] || '' === value['font-family'] ) {
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
		} );
	},

	/**
	 * Adds the font-families to the font-family dropdown
	 * and instantiates selectWoo.
	 */
	renderBackupFontSelector: function() {

		var control       = this,
			selector      = control.selector + ' .font-backup select',
			standardFonts = [],
			value         = control.setting._value,
			fontFamily    = value['font-family'],
			fonts         = control.getFonts(),
			fontSelect;

		if ( _.isUndefined( value['font-backup'] ) || null === value['font-backup'] ) {
			value['font-backup'] = '';
		}

		// Hide if we're not on a google-font.
		if ( 'inherit' === fontFamily || 'initial' === fontFamily || 'google' !== kirki.util.webfonts.getFontType( fontFamily ) ) {
			jQuery( control.selector + ' .font-backup' ).hide();
			return;
		}
		jQuery( control.selector + ' .font-backup' ).show();

		// Format standard fonts as an array.
		if ( ! _.isUndefined( fonts.standard ) ) {
			_.each( fonts.standard, function( font ) {
				standardFonts.push( {
					id: font.family.replace( /&quot;/g, '&#39' ),
					text: font.label
				} );
			} );
		}

		// Instantiate selectWoo with the data.
		fontSelect = jQuery( selector ).selectWoo( {
			data: standardFonts
		} );

		// Set the initial value.
		if ( 'undefined' !== typeof value['font-backup'] ) {
			fontSelect.val( value['font-backup'].replace( /'/g, '"' ) ).trigger( 'change' );
		}

		// When the value changes
		fontSelect.on( 'change', function() {

			// Set the value.
			control.saveValue( 'font-backup', jQuery( this ).val() );
		} );
	},

	/**
	 * Renders the variants selector using selectWoo
	 * Displays font-variants for the currently selected font-family.
	 */
	renderVariantSelector: function() {
		
		var control    = this,
			value      = control.value,
			fontFamily = value['font-family'],
			selector   = control.selector + ' .variant select',
			data       = [],
			isValid    = false,
			fontType   = kirki.util.webfonts.getFontType( fontFamily ),
			variants   = [ '', 'regular', 'italic', '700', '700italic' ],
			fontWeight,
			variantSelector,
			fontStyle;

		if ( 'google' === fontType ) {
			variants = kirki.util.webfonts.google.getVariants( fontFamily );
		}

		// Check if we've got custom variants defined for this font.
		if ( ! _.isUndefined( control.params ) && ! _.isUndefined( control.params.choices ) && ! _.isUndefined( control.params.choices.fonts ) && ! _.isUndefined( control.params.choices.fonts.variants ) ) {

			// Check if we have variants for this font-family.
			if ( ! _.isUndefined( control.params.choices.fonts.variants[ fontFamily ] ) ) {
				variants = control.params.choices.fonts.variants[ fontFamily ];
			}
		}
		if ( kirkiL10n.isScriptDebug ) {
			console.info( 'Kirki Debug: Font variants for font-family "' + fontFamily + '":' );
			console.info( variants );
		}

		if ( 'inherit' === fontFamily || 'initial' === fontFamily || '' === fontFamily ) {
			value.variant = 'inherit';
			variants      = [ '' ];
			jQuery( control.selector + ' .variant' ).hide();
		}

		if ( 1 >= variants.length ) {
			jQuery( control.selector + ' .variant' ).hide();

			value.variant = variants[0];

			control.saveValue( 'variant', value.variant );

			if ( '' === value.variant || ! value.variant ) {
				fontWeight = '';
				fontStyle  = '';
			} else {
				fontWeight = ( ! _.isString( value.variant ) ) ? '400' : value.variant.match( /\d/g );
				fontWeight = ( ! _.isObject( fontWeight ) ) ? '400' : fontWeight.join( '' );
				fontStyle  = ( -1 !== value.variant.indexOf( 'italic' ) ) ? 'italic' : 'normal';
			}

			control.saveValue( 'font-weight', fontWeight );
			control.saveValue( 'font-style', fontStyle );

			return;
		}

		jQuery( control.selector + ' .font-backup' ).show();

		jQuery( control.selector + ' .variant' ).show();
		_.each( variants, function( variant ) {
			if ( value.variant === variant ) {
				isValid = true;
			}
			data.push( {
				id: variant,
				text: variant
			} );
		} );
		if ( ! isValid ) {
			value.variant = 'regular';
		}

		if ( jQuery( selector ).hasClass( 'select2-hidden-accessible' ) ) {
			jQuery( selector ).selectWoo( 'destroy' );
			jQuery( selector ).empty();
		}

		// Instantiate selectWoo with the data.
		variantSelector = jQuery( selector ).selectWoo( {
			data: data
		} );
		variantSelector.val( value.variant ).trigger( 'change' );
		variantSelector.on( 'change', function() {
			control.saveValue( 'variant', jQuery( this ).val() );
			if ( 'string' !== typeof value.variant ) {
				value.variant = variants[0];
			}

			fontWeight = ( ! _.isString( value.variant ) ) ? '400' : value.variant.match( /\d/g );
			fontWeight = ( ! _.isObject( fontWeight ) ) ? '400' : fontWeight.join( '' );
			fontStyle  = ( -1 !== value.variant.indexOf( 'italic' ) ) ? 'italic' : 'normal';

			control.saveValue( 'font-weight', fontWeight );
			control.saveValue( 'font-style', fontStyle );
		} );
	},

	/**
	 * Get fonts.
	 */
	getFonts: function() {
		var control            = this,
			initialGoogleFonts = kirki.util.webfonts.google.getFonts(),
			googleFonts        = {},
			googleFontsSort    = 'alpha',
			googleFontsNumber  = 0,
			standardFonts      = {};

		// Get google fonts.
		if ( ! _.isEmpty( control.params.choices.fonts.google ) ) {
			if ( 'alpha' === control.params.choices.fonts.google[0] || 'popularity' === control.params.choices.fonts.google[0] || 'trending' === control.params.choices.fonts.google[0] ) {
				googleFontsSort = control.params.choices.fonts.google[0];
				if ( ! isNaN( control.params.choices.fonts.google[1] ) ) {
					googleFontsNumber = parseInt( control.params.choices.fonts.google[1], 10 );
				}
				googleFonts = kirki.util.webfonts.google.getFonts( googleFontsSort, '', googleFontsNumber );

			} else {
				_.each( control.params.choices.fonts.google, function( fontName ) {
					if ( 'undefined' !== typeof initialGoogleFonts[ fontName ] && ! _.isEmpty( initialGoogleFonts[ fontName ] ) ) {
						googleFonts[ fontName ] = initialGoogleFonts[ fontName ];
					}
				} );
			}
		} else {
			googleFonts = kirki.util.webfonts.google.getFonts( googleFontsSort, '', googleFontsNumber );
		}

		// Get standard fonts.
		if ( ! _.isEmpty( control.params.choices.fonts.standard ) ) {
			_.each( control.params.choices.fonts.standard, function( fontName ) {
				if ( 'undefined' !== typeof kirki.util.webfonts.standard.fonts[ fontName ] && ! _.isEmpty( kirki.util.webfonts.standard.fonts[ fontName ] ) ) {
					standardFonts[ fontName ] = {};
					if ( 'undefined' !== kirki.util.webfonts.standard.fonts[ fontName ].stack && ! _.isEmpty( kirki.util.webfonts.standard.fonts[ fontName ].stack ) ) {
						standardFonts[ fontName ].family = kirki.util.webfonts.standard.fonts[ fontName ].stack;
					} else {
						standardFonts[ fontName ].family = googleFonts[ fontName ];
					}
					if ( 'undefined' !== kirki.util.webfonts.standard.fonts[ fontName ].label && ! _.isEmpty( kirki.util.webfonts.standard.fonts[ fontName ].label ) ) {
						standardFonts[ fontName ].label = kirki.util.webfonts.standard.fonts[ fontName ].label;
					} else if ( ! _.isEmpty( standardFonts[ fontName ] ) ) {
						standardFonts[ fontName ].label = standardFonts[ fontName ];
					}
				} else {
					standardFonts[ fontName ] = {
						family: fontName,
						label: fontName
					};
				}
			} );
		} else {
			_.each( kirki.util.webfonts.standard.fonts, function( font, id ) {
				standardFonts[ id ] = {
					family: font.stack,
					label: font.label
				};
			} );
		}
		return {
			google: googleFonts,
			standard: standardFonts
		};
	},

	localFontsCheckbox: function() {
		var control           = this,
			checkboxContainer = control.container.find( '.kirki-host-font-locally' ),
			checkbox          = control.container.find( '.kirki-host-font-locally input' ),
			checked           = jQuery( checkbox ).is( ':checked' );

		if ( control.setting._value && control.setting._value.downloadFont ) {
			jQuery( checkbox ).attr( 'checked', 'checked' );
		}

		jQuery( checkbox ).on( 'change', function() {
			checked = jQuery( checkbox ).is( ':checked' );
			control.saveValue( 'downloadFont', checked );
		} );
	},
	
	initValue: function()
	{
		var control = this,
		defs = control.params.default,
			loadedValue = control.setting._value;
		control.value = {
			use_media_queries: loadedValue.use_media_queries || false,
			loaded: !_.isUndefined( loadedValue ),
			global: control.defaultValue(),
			desktop: control.defaultValue(),
			tablet: control.defaultValue(),
			mobile: control.defaultValue(),
		};
		control.value = control.defaultGlobalValue( control.value );
		
		if ( loadedValue.use_media_queries )
		{
			kirki.util.media_query_device_names.forEach( function( name )
			{
				if ( !control.value[name].loaded && loadedValue[name] )
				{
					control.value[name] = loadedValue[name];
					control.value[name]['loaded'] = true;
				}
			});
			if ( loadedValue['desktop'] )
				control.value['global'] = control.value['desktop'];
		}
		else
		{
			if ( !control.value['global'].loaded && loadedValue['global'] )
			{
				control.value['global'] = loadedValue['global'];
				control.value['global']['loaded'] = true;
			}
		}
		
		var id = control.value.use_media_queries ? 'desktop' : 'global';
		//Set global values
		control.global_types.forEach( function( name )
		{
			if ( _.isUndefined( defs[name] ) )
				return false;
			control.value[name] = control.value.loaded ? loadedValue[name] : defs[name];
			switch ( name )
			{
				case 'font-family':
				case 'font-backup':
				case 'variant':
				case 'text-transform':
					var select = control.container.find( 'div.font-family select,div.font-backup select,div.variant select,div.text-transform select' );
					select.val( control.value[name] );
					break;
				case 'text-align':
					var radio = control.container.find( 'div.text-align input[value="' + value + '"]' );
					radio.prop( 'checked', true );
					break;
				default:
					var input = control.container.find( 'div.' + name + ' input' );
					input.val( control.value[name] );
					break;
			}
		});
		//Set media query values
		control.media_query_types.forEach( function( name )
		{
			if ( _.isUndefined( defs[name] ) )
				return false;
			control.value[id][name] = control.value[id].loaded ? loadedValue[id][name] : defs[name];
			switch ( name )
			{
				case 'font-family':
				case 'font-backup':
				case 'variant':
				case 'text-transform':
					var select = control.container.find( 'div.font-family select,div.font-backup select,div.variant select,div.text-transform select' );
					select.val( control.value[id][name] );
					break;
				case 'text-align':
					var radio = control.container.find( 'div.text-align input[value="' + value + '"]' );
					radio.prop( 'checked', true );
					break;
				default:
					var input = control.container.find( 'div.' + name + ' input' );
					input.val( control.value[id][name] );
					break;
			}
		});
		control.value['downloadFont'] = loadedValue.downloadFont || false;
	},
	
	initMediaQueries: function()
	{
		var control = this;
		//If media queries are used, we need to detect device changes.
		if ( control.params.use_media_queries )
		{
			kirki.util.helpers.media_query( control, control.value.use_media_queries, {
				device_change: function( device, enabled )
				{
					control.selected_device = device;
					control.value.use_media_queries = enabled;
					var device_name = control.getSelectedDeviceName(),
						value_to_set = null;
					if ( enabled && !control.initial_media_query )
					{
						kirki.util.media_query_device_names.forEach( function( name )
						{
							if ( !control.value[name] )
								control.value[name] = control.defaultValue();
						});
					}
					if ( enabled )
						control.value.desktop = control.value.global;
					else
						control.value.global = control.value.desktop;
					var value_to_set = control.value[device_name];
					var defs = control.params.default;
					//Set media query values
					control.media_query_types.forEach( function( name )
					{
						if ( _.isUndefined( defs[name] ) )
							return false;
						var value = value_to_set[name];
						var input = control.container.find( 'div.' + name + ' input' );
						// if ( !input.val() && enabled )
						// {
						// 	var prev_val = null;
						// 	switch ( device_name )
						// 	{
						// 		case 'mobile':
						// 			prev_val = control.value['tablet'];
						// 			break;
						// 		case 'tablet':
						// 			prev_val = control.value['desktop'];
						// 			break;
						// 	}
						// 	if ( prev_val )
						// 		value = prev_val[name];
						// }
						input.val( value );
					});
					
					control.save();
					control.initial_media_query = true;
				}
			});
		}
	},
	
	getSelectedDeviceName: function()
	{
		var control = this,
			device = 'global';
		if ( control.selected_device == kirki.util.media_query_devices.desktop )
			device = 'desktop';
		else if ( control.selected_device == kirki.util.media_query_devices.tablet )
			device = 'tablet';
		else if ( control.selected_device == kirki.util.media_query_devices.mobile )
			device = 'mobile';
		return device;
	},
	
	/**
	 * Saves the value.
	 */
	saveValue: function( property, value ) {

		var control = this,
			val     = control.value;
		if ( control.media_query_types.includes( property ) )
			val[control.getSelectedDeviceName()][ property ] = value;
		else
			val[ property ] = value;
		control.save();
	},
	
	save: function()
	{
		var control = this,
			input   = control.container.find( '.typography-hidden-value' ),
			compiled = jQuery.extend( {}, control.value );
		delete compiled.loaded;
		if ( compiled.use_media_queries )
		{
			delete compiled.global;
			delete compiled.desktop.loaded;
			delete compiled.tablet.loaded;
			delete compiled.mobile.loaded;
		}
		else
		{
			delete compiled.desktop;
			delete compiled.tablet;
			delete compiled.mobile;
		}
		input.val( JSON.stringify( compiled ) ).trigger( 'change' );
		control.setting.set( compiled );
	},
	
	defaultValue: function() {
		var control = this,
			value = { loaded: false };
		control.media_query_types.forEach( function( type )
		{
			if ( _.isUndefined( control.params.default[type] ) )
				return false;
			value[type] = '';
		});
		return value;
	},
	
	defaultGlobalValue: function( value ) {
		var control = this;
		control.global_types.forEach( function( type )
		{
			if ( _.isUndefined( control.params.default[type] ) )
				return false;
			value[type] = '';
		});
		value['font-weight'] = '';
		value['font-style'] = '';
		value['variant'] = '';
		value['downloadFont'] = false;
		value['text-align'] = 'left';
		return value;
	}
} );
