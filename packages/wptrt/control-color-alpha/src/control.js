/* global Color */
/**
 * A colorpicker control.
 *
 * @since 1.0.0
 * @augments wp.customize.ColorControl
 */
wp.customize.controlConstructor['color-alpha'] = wp.customize.ColorControl.extend({

	ready: function() {
		var control = this,
			updating = false,
			picker = this.getColorPicker(),
			saveObject = this.params.choices.save_as === 'array';

		if ( 'hue' === this.params.mode ) {
			picker.val( control.setting() ).wpColorPicker({
				change: function( event, ui ) {
					updating = true;
					control.setting( ui.color.h() );
					updating = false;
				}
			});
		} else {
			picker.val( saveObject ? control.setting._value.css : control.setting() ).wpColorPicker({
				change: function() {
					updating = true;
					control.setting.set( control.getColorValue() );
					updating = false;
				},
				clear: function() {
					updating = true;
					control.setting.set( '' );
					updating = false;
				}
			});
		}

		control.setting.bind( function ( value ) {
			// Bail if the update came from the control itself.
			if ( updating ) {
				return;
			}

			if ( 'array' === control.params.choices.save_as ) {
				picker.val( value.css );
				picker.wpColorPicker( 'color', value.css );
			} else {
				picker.val( value );
				picker.wpColorPicker( 'color', value );
			}
		} );

		// Collapse color picker when hitting Esc instead of collapsing the current section.
		control.container.on( 'keydown', function( event ) {
			var pickerContainer;
			if ( 27 !== event.which ) { // Esc.
				return;
			}
			pickerContainer = control.container.find( '.wp-picker-container' );
			if ( pickerContainer.hasClass( 'wp-picker-active' ) ) {
				picker.wpColorPicker( 'close' );
				control.container.find( '.wp-color-result' ).focus();
				event.stopPropagation(); // Prevent section from being collapsed.
			}
		} );
	},

	getColorValue: function() {
		const picker = this.getColorPicker();
		var stringVal = picker.wpColorPicker( 'color' ),
			color, white, black, value = {};

		if ( 'array' === this.params.choices.save_as ) {
			color = Color( stringVal );
			white = Color( '#ffffff' );
			black = Color( '#000000' );

			// Get the basics for this color.
			value = {
				r: color.r(),
				g: color.g(),
				b: color.b(),
				h: color.h(),
				s: color.s(),
				l: color.l(),
				a: color.a(),
				v: color.toHsl().v,
				hex: color.clone().a( 1 ).toCSS(),
				css: color.toCSS()
			};

			// A11y properties.
			value.a11y = {
				luminance: color.toLuminosity(),
				distanceFromWhite: color.getDistanceLuminosityFrom( white ),
				distanceFromBlack: color.getDistanceLuminosityFrom( black ),
				maxContrastColor: color.clone().a( 1 ).getMaxContrastColor().toCSS(),
				readableContrastingColorFromWhite: [
					color.clone().a( 1 ).getReadableContrastingColor( white, 7 ).toCSS(),
					color.clone().a( 1 ).getReadableContrastingColor( white, 4.5 ).toCSS()
				],
				readableContrastingColorFromBlack: [
					color.clone().a( 1 ).getReadableContrastingColor( black, 7 ).toCSS(),
					color.clone().a( 1 ).getReadableContrastingColor( black, 4.5 ).toCSS()
				]
			};
			value.a11y.isDark = value.a11y.distanceFromWhite > value.a11y.distanceFromBlack;

			return value;
		}

		return stringVal;
	},

	getColorPicker: function() {
		if ( 'hue' === this.params.mode ) {
			return this.container.find( '.color-picker-hue' );
		}
		return this.container.find( '.color-picker-hex' );
	},

	/**
	 * Embed the control in the document.
	 *
	 * Overrides the embed() method to embed the control
	 * when the section is expanded instead of on load.
	 *
	 * @since 1.0.0
	 * @return {void}
	 */
	embed: function() {
		const control = this;
		const sectionId = control.section();
		if ( ! sectionId ) {
			return;
		}
		wp.customize.section( sectionId, function( section ) {
			section.expanded.bind( function( expanded ) {
				if ( expanded ) {
					control.actuallyEmbed();
				}
			} );
		} );
	},

	/**
	 * Deferred embedding of control.
	 *
	 * This function is called in Section.onChangeExpanded() so the control
	 * will only get embedded when the Section is first expanded.
	 *
	 * @since 1.0.0
	 */
	actuallyEmbed: function () {
		const control = this;
		if ( 'resolved' === control.deferred.embedded.state() ) {
			return;
		}
		control.renderContent();
		control.deferred.embedded.resolve(); // Triggers control.ready().
	},
} );
