jQuery(document).ready(function() {
	return;
	var google_loaded = false;
	var std_loaded = false;
	jQuery(document).on('google-fonts-loaded', function() {
		google_loaded = true;
		if (std_loaded && google_loaded)
			initializeTypography();
		//console.log(kirki.util.webfonts.google.getFonts());
	});

	jQuery(document).on('std-fonts-loaded', function() {
		std_loaded = true;
		if (std_loaded && google_loaded)
			initializeTypography();
		//console.log(kirki.util.webfonts.standard.fonts);
	});
	kirki.util.webfonts.standard.initialize();
	kirki.util.webfonts.google.initialize();

	function initializeTypography() {
		jQuery('.customize-control-kirki-typography').each(function(e) {
			var container = jQuery(this);
			var tp = new typeography(container);
		});
	}

	var typeography = function(container) {
		var self = this;
		var value = {};
		this.container = container;
		this.wrapper = jQuery('.wrapper', container);
		this.input = jQuery( 'input[kirki-metabox-link]', container );
		this.params = JSON.parse(this.wrapper.attr('kirki-args'));
		this.init = function() {
			var initialGoogleFonts = kirki.util.webfonts.google.getFonts(),
				googleFonts = {},
				googleFontsSort = 'alpha',
				googleFontsNumber = 0,
				standardFonts = {};

			// Get google fonts.
			if (!_.isEmpty(self.params.choices.fonts.google)) {
				if ('alpha' === self.params.choices.fonts.google[0] || 'popularity' === self.params.choices.fonts.google[0] || 'trending' === self.params.choices.fonts.google[0]) {
					googleFontsSort = self.params.choices.fonts.google[0];
					if (!isNaN(self.params.choices.fonts.google[1])) {
						googleFontsNumber = parseInt(self.params.choices.fonts.google[1], 10);
					}
					googleFonts = kirki.util.webfonts.google.getFonts(googleFontsSort, '', googleFontsNumber);

				} else {
					_.each(self.params.choices.fonts.google, function(fontName) {
						if ('undefined' !== typeof initialGoogleFonts[fontName] && !_.isEmpty(initialGoogleFonts[fontName])) {
							googleFonts[fontName] = initialGoogleFonts[fontName];
						}
					});
				}
			} else {
				googleFonts = kirki.util.webfonts.google.getFonts(googleFontsSort, '', googleFontsNumber);
			}

			// Get standard fonts.
			if (!_.isEmpty(self.params.choices.fonts.standard)) {
				_.each(self.params.choices.fonts.standard, function(fontName) {
					if ('undefined' !== typeof kirki.util.webfonts.standard.fonts[fontName] && !_.isEmpty(kirki.util.webfonts.standard.fonts[fontName])) {
						standardFonts[fontName] = {};
						if ('undefined' !== kirki.util.webfonts.standard.fonts[fontName].stack && !_.isEmpty(kirki.util.webfonts.standard.fonts[fontName].stack)) {
							standardFonts[fontName].family = kirki.util.webfonts.standard.fonts[fontName].stack;
						} else {
							standardFonts[fontName].family = googleFonts[fontName];
						}
						if ('undefined' !== kirki.util.webfonts.standard.fonts[fontName].label && !_.isEmpty(kirki.util.webfonts.standard.fonts[fontName].label)) {
							standardFonts[fontName].label = kirki.util.webfonts.standard.fonts[fontName].label;
						} else if (!_.isEmpty(standardFonts[fontName])) {
							standardFonts[fontName].label = standardFonts[fontName];
						}
					} else {
						standardFonts[fontName] = {
							family: fontName,
							label: fontName
						};
					}
				});
			} else {
				_.each(kirki.util.webfonts.standard.fonts, function(font, id) {
					standardFonts[id] = {
						family: font.stack,
						label: font.label
					};
				});
			}
			return {
				google: googleFonts,
				standard: standardFonts
			};
		};
		this.getFonts = function() {
			var initialGoogleFonts = kirki.util.webfonts.google.getFonts(),
				googleFonts = {},
				googleFontsSort = 'alpha',
				googleFontsNumber = 0,
				standardFonts = {};

			// Get google fonts.
			if (!_.isEmpty(self.params.choices.fonts.google)) {
				if ('alpha' === self.params.choices.fonts.google[0] || 'popularity' === self.params.choices.fonts.google[0] || 'trending' === self.params.choices.fonts.google[0]) {
					googleFontsSort = self.params.choices.fonts.google[0];
					if (!isNaN(self.params.choices.fonts.google[1])) {
						googleFontsNumber = parseInt(self.params.choices.fonts.google[1], 10);
					}
					googleFonts = kirki.util.webfonts.google.getFonts(googleFontsSort, '', googleFontsNumber);

				} else {
					_.each(self.params.choices.fonts.google, function(fontName) {
						if ('undefined' !== typeof initialGoogleFonts[fontName] && !_.isEmpty(initialGoogleFonts[fontName])) {
							googleFonts[fontName] = initialGoogleFonts[fontName];
						}
					});
				}
			} else {
				googleFonts = kirki.util.webfonts.google.getFonts(googleFontsSort, '', googleFontsNumber);
			}

			// Get standard fonts.
			if (!_.isEmpty(self.params.choices.fonts.standard)) {
				_.each(self.params.choices.fonts.standard, function(fontName) {
					if ('undefined' !== typeof kirki.util.webfonts.standard.fonts[fontName] && !_.isEmpty(kirki.util.webfonts.standard.fonts[fontName])) {
						standardFonts[fontName] = {};
						if ('undefined' !== kirki.util.webfonts.standard.fonts[fontName].stack && !_.isEmpty(kirki.util.webfonts.standard.fonts[fontName].stack)) {
							standardFonts[fontName].family = kirki.util.webfonts.standard.fonts[fontName].stack;
						} else {
							standardFonts[fontName].family = googleFonts[fontName];
						}
						if ('undefined' !== kirki.util.webfonts.standard.fonts[fontName].label && !_.isEmpty(kirki.util.webfonts.standard.fonts[fontName].label)) {
							standardFonts[fontName].label = kirki.util.webfonts.standard.fonts[fontName].label;
						} else if (!_.isEmpty(standardFonts[fontName])) {
							standardFonts[fontName].label = standardFonts[fontName];
						}
					} else {
						standardFonts[fontName] = {
							family: fontName,
							label: fontName
						};
					}
				});
			} else {
				_.each(kirki.util.webfonts.standard.fonts, function(font, id) {
					standardFonts[id] = {
						family: font.stack,
						label: font.label
					};
				});
			}
			return {
				google: googleFonts,
				standard: standardFonts
			};
		};
		this.renderFontSelector = function() {
			var selector = jQuery('.font-family select', self.container),
				data = [],
				standardFonts = [],
				googleFonts = [],
				//value           = control.setting._value,
				fonts = self.getFonts(),
				fontSelect,
				controlFontFamilies;

			// Format standard fonts as an array.
			if (!_.isUndefined(fonts.standard)) {
				_.each(fonts.standard, function(font) {
					standardFonts.push({
						id: font.family.replace(/&quot;/g, '&#39'),
						text: font.label
					});
				});
			}

			// Format google fonts as an array.
			if (!_.isUndefined(fonts.google)) {
				_.each(fonts.google, function(font) {
					googleFonts.push({
						id: font.family,
						text: font.family
					});
				});
			}

			// Do we have custom fonts?
			controlFontFamilies = {};
			if (!_.isUndefined(self.params) && !_.isUndefined(self.params.choices) && !_.isUndefined(self.params.choices.fonts) && !_.isUndefined(self.params.choices.fonts.families)) {
				controlFontFamilies = self.params.choices.fonts.families;
			}

			// Combine forces and build the final data.
			data = jQuery.extend({}, controlFontFamilies, {
				default: {
					text: kirkiL10n.defaultCSSValues,
					children: [{
							id: '',
							text: kirkiL10n.defaultBrowserFamily
						},
						{
							id: 'initial',
							text: 'initial'
						},
						{
							id: 'inherit',
							text: 'inherit'
						}
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
			});

			// if ( kirkiL10n.isScriptDebug ) {
			// 	console.info( 'Kirki Debug: Font families for control "' + control.id + '":' );
			// 	console.info( data );
			// }

			data = _.values(data);

			// Instantiate selectWoo with the data.
			fontSelect = jQuery(selector).selectWoo({
				data: data
			});

			// Set the initial value.
			//if ( value['font-family'] || '' === value['font-family'] ) {
				//fontSelect.val( value['font-family'].replace( /'/g, '"' ) ).trigger( 'change' );
			//}

			// When the value changes
			fontSelect.on('change', function() {
				// Set the value.
				//control.saveValue( 'font-family', jQuery( this ).val() );

				// Re-init the font-backup selector.
				//control.renderBackupFontSelector();

				// Re-init variants selector.
				//control.renderVariantSelector();
			});
		};
		this.renderBackupFontSelector = function()
		{
			var selector      = jQuery( '.font-backup select', self.container ),
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
		};
		this.initColorPicker = function() {
			var selector = jQuery('.color .color-picker', self.container);
			selector.wpColorPicker();
		};
		this.save = function()
		{

		};

		this.init();
		this.renderFontSelector();
		this.initColorPicker();
	};
});