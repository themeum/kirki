/* global iro, iroTransparencyPlugin, wp */
var kirki = kirki || {};

wp.customize.controlConstructor['kirki-color'] = wp.customize.kirkiDynamicControl.extend( {
	initKirkiControl: function( control ) {
		var colorPicker,
			isHue;

		control = control || this;
		isHue   = control.params.mode && 'hue' === control.params.mode;

		colorPicker = this.initColorPicker();

		// Update color when a value is manually entered.
		control.container.find( '.kirki-color-control' ).on( 'change paste keyup', function() {
			var value   = jQuery( this ).val();
			if ( isHue ) {
				colorPicker.updateColor( new iro.Color( { h: parseInt( value ), s: 100, l: 50 } ) );
				colorPicker.color.set( 'hsl(' + parseInt( value ) + ',100%,50%)' );
			} else if ( /^(\#[\da-f]{3}|\#[\da-f]{6}|\#[\da-f]{8}|rgba\(((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*,\s*){2}((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*)(,\s*(0\.\d+|1))\)|hsla\(\s*((\d{1,2}|[1-2]\d{2}|3([0-5]\d|60)))\s*,\s*((\d{1,2}|100)\s*%)\s*,\s*((\d{1,2}|100)\s*%)(,\s*(0\.\d+|1))\)|rgb\(((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*,\s*){2}((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*)|hsl\(\s*((\d{1,2}|[1-2]\d{2}|3([0-5]\d|60)))\s*,\s*((\d{1,2}|100)\s*%)\s*,\s*((\d{1,2}|100)\s*%)\))$/.test( value ) ) {
				colorPicker.updateColor( new iro.Color( value ) );
				colorPicker.color.set( value );
			}
		} );

		// Handle clicks on palette colors.
		control.container.find( '.palette-color' ).on( 'click', function( e ) {
			e.preventDefault();

			// Don't change value if we just clicked on the colorpicker icon.
			if ( jQuery( this ).hasClass( 'color-preview' ) ) {
				return;
			}

			// Set the value.
			colorPicker.updateColor( new iro.Color( jQuery( this ).data( 'color' ) ) );
			colorPicker.color.set( jQuery( this ).data( 'color' ) );
		} );

		// Handle clicks on the custom-color toggler element.
		control.container.find( '.palette-color.placeholder, summary.description' ).on( 'click', function() {
			if ( ! control.container.find( 'details' ).is( '[open]' ) ) {
				control.container.find( 'details' ).attr( 'open', true );
			} else {
				control.container.find( 'details' ).removeAttr( 'open' );
			}
		} );

		// Handle resizing the window.
		window.addEventListener( 'resize', function() {
			colorPicker.resize( control.container.width() );
		} );
	},

	/**
	 * Re-calculate which color element is ActiveXObject, and toggle it.
	 *
	 * @since 0.1
	 * @param {string} value - The color we want to check.
	 * @return void
	 */
	reCalcActive: function( value, control ) {
		var items     = control.container.find( '.palette-color' ),
			inPalette = false;

		control.container.find( 'button.palette-color' ).attr( 'aria-pressed', 'false' );

		_.each( items, function( item ) {
			var color = '';
			if ( jQuery( item ).attr( 'data-color' ) ) {
				color = jQuery( item ).attr( 'data-color' );
				if ( color === value ) {
					jQuery( item ).attr( 'aria-pressed', true );
					inPalette = true;
				}
			}
		} );

		if ( ! inPalette ) {
			control.container.find( 'button.palette-color.color-preview' ).attr( 'aria-pressed', 'true' );
		}
	},

	/**
	 * Init colorpicker.
	 *
	 * @since 0.1
	 * @param {Object} control - The control object.
	 * @return {void}
	 */
	initColorPicker: function( control ) {
		var colorPicker, isHue;
		control = control || this;
		isHue   = control.params.mode && 'hue' === control.params.mode;

		// Check if we want transparency.
		if ( 'true' === control.params.choices.alpha || true === control.params.choices.alpha ) {
			iro.use( iroTransparencyPlugin );
		}

		// Init the colorpicker.
		colorPicker = new iro.ColorPicker( '.colorpicker-' + control.id.replace( '[', '--' ).replace( ']', '' ), this.getColorpickerOptions( control ) );

		/**
		 * Handle colorpicker changes.
		 */
		colorPicker.on( 'color:change', function( color ) {
			var value = ( 'undefined' !== typeof color.alpha && 1 > parseFloat( color.alpha ) ) ? color.rgbaString : color.hexString;
			if ( isHue ) {
				value = color.hsl.h;
			}

			// Update the value.
			control.container.find( '.kirki-color-control' ).attr( 'value', value ).trigger( 'change' );
			control.setting.set( value );
			if ( ! control.params.mode || 'hue' !== control.params.mode ) {
				jQuery( control.container.find( '.placeholder.color-preview .button-inner' ) ).css( 'color', value );
			}

			control.reCalcActive( color.hexString, control );
		} );

		return colorPicker;
	},

	/**
	 * Get the parameters for our colorpicker.
	 *
	 * @since 0.1
	 * @param {Object} control - The control object.
	 * @returns {Object}
	 */
	getColorpickerOptions: function( control ) {
		var isHue,
			colorpickerOptions;

		control            = control || this;
		isHue              = control.params.mode && 'hue' === control.params.mode;

		// If we only want hue, return a simple slider.
		if ( isHue ) {
			return {
				width: control.container.width(),
				color: { h: parseInt( control.params.value ), s: 100, l: 50 },
				layout: [
					{
						component: iro.ui.Slider,
						options: {
							sliderType: 'hue'
						}
					}
				]
			};
		}

		colorpickerOptions = {
			width: control.container.width(),
			color: control.params.value,
			wheelLightness: false
		};

		// Check if we want transparency.
		if ( 'true' === control.params.choices.alpha || true === control.params.choices.alpha ) {
			colorpickerOptions.transparency = true;
		}
		return colorpickerOptions;
	}
} );
