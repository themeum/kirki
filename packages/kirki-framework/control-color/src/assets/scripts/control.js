/* global iro, iroTransparencyPlugin, wp */
var kirki = kirki || {};

wp.customize.controlConstructor['kirki-color'] = wp.customize.kirkiDynamicControl.extend( {
	initKirkiControl: function( control ) {
		var colorPicker,
			isHue,
			colorpickerOptions;

		control            = control || this;
		isHue              = control.params.mode && 'hue' === control.params.mode;
		colorpickerOptions = {
			width: control.container.width(),
			color: isHue ? { h: parseInt( control.params.value ), s: 100, l: 50 } : control.params.value,
			layout: [
				{
					component: iro.ui.Slider,
					options: {
						sliderType: 'hue'
					}
				}
			]
		};

		if ( ! isHue ) {
			colorpickerOptions.layout.push( { // Saturation slider.
				component: iro.ui.Slider,
				options: {
					sliderType: 'saturation'
				}
			} );
			colorpickerOptions.layout.push( { // Regular value slider.
				component: iro.ui.Slider,
				options: {}
			} );
		}

		// Check if we want transparency.
		if ( 'true' === control.params.choices.alpha || true === control.params.choices.alpha ) {
			iro.use( iroTransparencyPlugin );
			colorpickerOptions.transparency = true;
		}

		// Add color to the previewer next to the input.
		jQuery( control.container.find( '.toggle-colorpicker .placeholder' ) ).css( 'background-color', control.params.value );

		// Init the colorpicker.
		colorPicker = new iro.ColorPicker( '.colorpicker-' + control.id.replace( '[', '--' ).replace( ']', '' ), colorpickerOptions );

		// Update on colorpicker change.
		colorPicker.on( 'color:change', function( color ) {
			var value = ( 'undefined' !== typeof color.alpha && 1 > parseFloat( color.alpha ) ) ? color.rgbaString : color.hexString;
			if ( isHue ) {
				value = color.hsl.h;
			}

			// Update the value.
			control.container.find( '.kirki-color-control' ).attr( 'value', value ).trigger( 'change' );
			control.setting.set( value );
			if ( ! control.params.mode || 'hue' !== control.params.mode ) {
				jQuery( control.container.find( '.toggle-colorpicker .placeholder' ) ).css( 'background-color', value );
			}
		} );

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
			colorPicker.updateColor( new iro.Color( jQuery( this ).data( 'color' ) ) );
			colorPicker.color.set( jQuery( this ).data( 'color' ) );
		} );

		// Handle clicking on the reset button.
		control.container.find( '.reset' ).on( 'click', function( e ) {
			e.preventDefault();
			control.container.find( '.kirki-color-control' ).attr( 'value', '' ).trigger( 'change' );
			if ( ! control.params.default ) {
				setTimeout( function() {
					colorPicker.updateColor( new iro.Color( 'rgba(0,0,0,0)' ) );
					colorPicker.color.set( 'rgba(0,0,0,0)' );
					control.container.find( '.kirki-color-control' ).attr( 'value', value ).trigger( 'change' );
					control.setting.set( value );
					if ( ! control.params.mode || 'hue' !== control.params.mode ) {
						jQuery( control.container.find( '.toggle-colorpicker .placeholder' ) ).css( 'background-color', value );
					}
					jQuery( control.container.find( '.toggle-colorpicker .placeholder' ) ).css( 'background-color', '' );
				}, 50 );
			} else {
				colorPicker.updateColor( new iro.Color( control.params.default ) );
				colorPicker.color.set( control.params.default );
			}
		} );

		// Toggle classes when we want to expand the pickers.
		control.container.find( '.toggle-colorpicker' ).on( 'click', function( e ) {
			e.preventDefault();
			control.container.find( '.kirki-color-input-wrapper' ).toggleClass( 'collapsed' );
		} );

		// If we click on the text input expand the colorpicker.
		control.container.find( '.kirki-color-control' ).on( 'click', function() {
			control.container.find( '.kirki-color-input-wrapper' ).removeClass( 'collapsed' );
		} );

		// Handle resizing the window.
		window.addEventListener( 'resize', function() {
			colorPicker.resize( control.container.width() );
		});
	}
} );
