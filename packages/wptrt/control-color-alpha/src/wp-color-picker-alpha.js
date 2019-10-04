/* global Color, wpColorPickerL10n */
/**
 * Overwrites Automattic Iris and enables an Alpha Channel in wpColorPicker.
 * Only run in input if data-alpha is defined and true.
 *
 * This is a heavily modified version of the script from https://github.com/kallookoo/wp-color-picker-alpha
 * for the purposes of a WPTRT package (control-color-alpha).
 *
 * Modifications include:
 *     Applying WordPress Coding Standards.
 *     Cleaning up deprecated code for WP < 4.9.
 *     Improved inline comments.
 *     Fixed infinite recursion error.
 *     Removed _addInputListeners method - it's inherited from Iris.
 *     Formatting.
 *     Other minor bugfixes.
 *
 * @version 2.1.3
 * @see https://github.com/kallookoo/wp-color-picker-alpha
 * @license GPLv2
 */

( function() {
	var image, _after, _wrap, _button, _before, _wrappingLabel, _wrappingLabelText;

	// Prevent double-init.
	if ( jQuery.wp.wpColorPicker.prototype._hasAlpha ) {
		return;
	}

	// Variable for some backgrounds ( grid ).
	image   = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAIAAAHnlligAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAHJJREFUeNpi+P///4EDBxiAGMgCCCAGFB5AADGCRBgYDh48CCRZIJS9vT2QBAggFBkmBiSAogxFBiCAoHogAKIKAlBUYTELAiAmEtABEECk20G6BOmuIl0CIMBQ/IEMkO0myiSSraaaBhZcbkUOs0HuBwDplz5uFJ3Z4gAAAABJRU5ErkJggg==';

	// HTML stuff for wpColorPicker copy of the original color-picker.js.
	_after = '<div class="wp-picker-holder" />';
	_wrap = '<div class="wp-picker-container" />';
	_button = '<input type="button" class="button button-small" />';

	// Declare some global variables when is deprecated or not.
	_before = '<button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text"></span></button>';
	_wrappingLabel = '<label></label>';
	_wrappingLabelText = '<span class="screen-reader-text"></span>';

	/**
	 * Overwrite Color to enable RGBA support.
	 *
	 * @return {string} - Returns the HEX or RGBA color.
	 */
	Color.fn.toString = function() {
		var hex;
		if ( 1 > this._alpha ) {
			return this.toCSS( 'rgba', this._alpha ).replace( /\s+/g, '' );
		}

		hex = parseInt( this._color, 10 ).toString( 16 );
		if ( this.error ) {
			return '';
		}

		if ( 6 > hex.length ) {
			hex = ( '00000' + hex ).substr( -6 );
		}

		return '#' + hex;
	};

	/**
	 * Overwrite wpColorPicker.
	 */
	jQuery.widget( 'wp.wpColorPicker', jQuery.wp.wpColorPicker, {
		_hasAlpha: true,

		/**
		 * Creates the color picker.
		 *
		 * Creates the color picker, sets default values, css classes and wraps it all in HTML.
		 *
		 * @return {void}
		 */
		_create: function() {
			var self = this,
				el = self.element;

			// Return early if Iris support is missing.
			if ( ! jQuery.support.iris ) {
				return;
			}

			// Override default options with options bound to the element.
			jQuery.extend( self.options, el.data() );

			// Create a color picker which only allows adjustments to the hue.
			if ( 'hue' === self.options.type ) {
				return self._createHueOnly();
			}

			// Bind the close event.
			self.close = jQuery.proxy( self.close, self );

			self.initialValue = el.val();

			// Add a CSS class to the input field.
			el.addClass( 'wp-color-picker' );

			// Check if there's already a wrapping label, e.g. in the Customizer.
			// If there's no label, add a default one to match the Customizer template.
			if ( ! el.parent( 'label' ).length ) {

				// Wrap the input field in the default label.
				el.wrap( _wrappingLabel );

				// Insert the default label text.
				self.wrappingLabelText = jQuery( _wrappingLabelText )
					.insertBefore( el )
					.text( wpColorPickerL10n.defaultLabel );
			}

			// At this point, either it's the standalone version or the Customizer one,
			// we have a wrapping label to use as hook in the DOM, let's store it.
			self.wrappingLabel = el.parent();

			// Wrap the label in the main wrapper.
			self.wrappingLabel.wrap( _wrap );

			// Store a reference to the main wrapper.
			self.wrap = self.wrappingLabel.parent();

			// Set up the toggle button and insert it before the wrapping label.
			self.toggler = jQuery( _before )
				.insertBefore( self.wrappingLabel )
				.css({ backgroundColor: self.initialValue });

			// Set the toggle button span element text.
			self.toggler.find( '.wp-color-result-text' ).text( wpColorPickerL10n.pick );

			// Set up the Iris container and insert it after the wrapping label.
			self.pickerContainer = jQuery( _after ).insertAfter( self.wrappingLabel );

			// Store a reference to the Clear/Default button.
			self.button = jQuery( _button );

			// Set up the Clear/Default button.
			if ( self.options.defaultColor ) {
				self.button.addClass( 'wp-picker-default' ).val( wpColorPickerL10n.defaultString );
				self.button.attr( 'aria-label', wpColorPickerL10n.defaultAriaLabel );
			} else {
				self.button.addClass( 'wp-picker-clear' ).val( wpColorPickerL10n.clear );
				self.button.attr( 'aria-label', wpColorPickerL10n.clearAriaLabel );
			}

			// Wrap the wrapping label in its wrapper and append the Clear/Default button.
			self.wrappingLabel
				.wrap( '<span class="wp-picker-input-wrap hidden" />' )
				.after( self.button );

			// The input wrapper now contains the label+input+Clear/Default button.
			// Store a reference to the input wrapper: we'll use this to toggle
			// the controls visibility.
			self.inputWrapper = el.closest( '.wp-picker-input-wrap' );

			el.iris({
				target: self.pickerContainer,
				hide: self.options.hide,
				width: self.options.width,
				mode: self.options.mode,
				palettes: self.options.palettes,

				/**
				 * Handles the onChange event if one has been defined in the options.
				 *
				 * Handles the onChange event if one has been defined in the options and additionally
				 * sets the background color for the toggler element.
				 *
				 * @param {Event} event    The event that's being called.
				 * @param {HTMLElement} ui The HTMLElement containing the color picker.
				 *
				 * @return {void}
				 */
				change: function( event, ui ) {
					if ( self.options.alpha ) {
						self.toggler.css({ 'background-image': 'url(' + image + ')' });
						self.toggler.css({
							'position': 'relative'
						});

						if ( 0 === self.toggler.find( 'span.color-alpha' ).length ) {
							self.toggler.append( '<span class="color-alpha"></span>' );
						}

						self.toggler.find( 'span.color-alpha' ).css({
							'min-width': '30px',
							'min-height': '24px',
							'position': 'absolute',
							'top': 0,
							'left': 0,
							'border-top-left-radius': '2px',
							'border-bottom-left-radius': '2px',
							'background': ui.color.toString()
						});
					} else {
						self.toggler.css({ backgroundColor: ui.color.toString() });
					}

					if ( jQuery.isFunction( self.options.change ) ) {
						self.options.change.call( this, event, ui );
					}
				}
			});

			el.val( self.initialValue );
			self._addListeners();

			// Force the color picker to always be closed on initial load.
			if ( ! self.options.hide ) {
				self.toggler.click();
			}
		},

		/**
		 * Binds event listeners to the color picker.
		 *
		 * @return {void}
		 */
		_addListeners: function() {
			var self = this;

			/**
			 * Prevent any clicks inside this widget from leaking to the top and closing it.
			 *
			 * @param {Event} event The event that's being called.
			 * @return {void}
			 */
			self.wrap.on( 'click.wpcolorpicker', function( event ) {
				event.stopPropagation();
			});

			// Open or close the color picker depending on the class.
			self.toggler.click( function() {
				if ( self.toggler.hasClass( 'wp-picker-open' ) ) {
					self.close();
				} else {
					self.open();
				}
			});

			/**
			 * Checks if value is empty when changing the color in the color picker.
			 *
			 * Checks if value is empty when changing the color in the color picker.
			 * If so, the background color is cleared.
			 *
			 * @param {Event} event The event that's being called.
			 * @return {void}
			 */
			self.element.on( 'change', function( event ) {

				// Empty or Error = clear.
				if ( '' === jQuery( this ).val() || self.element.hasClass( 'iris-error' ) ) {
					if ( self.options.alpha ) {
						self.toggler.find( 'span.color-alpha' ).css( 'backgroundColor', '' );
					} else {
						self.toggler.css( 'backgroundColor', '' );
					}

					// fire clear callback if we have one
					if ( jQuery.isFunction( self.options.clear ) ) {
						self.options.clear.call( this, event );
					}
				}
			});

			/**
			 * Enables the user to clear or revert the color in the color picker to the default value.
			 *
			 * @param {Event} event The event that's being called.
			 * @return {void}
			 */
			self.button.on( 'click', function( event ) {
				if ( jQuery( this ).hasClass( 'wp-picker-clear' ) ) {
					self.element.val( '' );
					if ( self.options.alpha ) {
						self.toggler.find( 'span.color-alpha' ).css( 'backgroundColor', '' );
					} else {
						self.toggler.css( 'backgroundColor', '' );
					}

					if ( jQuery.isFunction( self.options.clear ) ) {
						self.options.clear.call( this, event );
					}

					self.element.trigger( 'change' );
				} else if ( jQuery( this ).hasClass( 'wp-picker-default' ) ) {
					self.element.val( self.options.defaultColor ).change();
				}
			});
		}
	});

	/**
	 * Overwrite iris.
	 */
	jQuery.widget( 'a8c.iris', jQuery.a8c.iris, {
		_create: function() {
			var self, el, _html, aContainer, aSlider, controls, emptyWidth, stripsMargin, stripsWidth;
			this._super();

			// Global option for check is mode rbga is enabled
			this.options.alpha = this.element.data( 'alpha' ) || false;

			// Is not input disabled
			if ( ! this.element.is( ':input' ) ) {
				this.options.alpha = false;
			}

			if ( 'undefined' !== typeof this.options.alpha && this.options.alpha ) {
				self       = this;
				el         = self.element;
				_html      = '<div class="iris-strip iris-slider iris-alpha-slider"><div class="iris-slider-offset iris-slider-offset-alpha"></div></div>';
				aContainer = jQuery( _html ).appendTo( self.picker.find( '.iris-picker-inner' ) );
				aSlider    = aContainer.find( '.iris-slider-offset-alpha' );
				controls   = {
					aContainer: aContainer,
					aSlider: aSlider
				};

				if ( 'undefined' !== typeof el.data( 'custom-width' ) ) {
					self.options.customWidth = parseInt( el.data( 'custom-width' ), 10 ) || 0;
				} else {
					self.options.customWidth = 100;
				}

				// Set default width for input reset
				self.options.defaultWidth = el.width();

				// Update width for input
				if ( 1 > self._color._alpha || -1 !== self._color.toString().indexOf( 'rgb' ) ) {
					el.width( parseInt( self.options.defaultWidth + self.options.customWidth, 10 ) );
				}

				// Push new controls
				jQuery.each( controls, function( k, v ) {
					self.controls[k] = v;
				});

				// Change size strip and add margin for sliders
				self.controls.square.css({ 'margin-right': '0' });
				emptyWidth   = ( self.picker.width() - self.controls.square.width() - 20 );
				stripsMargin = ( emptyWidth / 6 );
				stripsWidth  = ( ( emptyWidth / 2 ) - stripsMargin );

				jQuery.each( [ 'aContainer', 'strip' ], function( k, v ) {
					self.controls[v].width( stripsWidth ).css({ 'margin-left': stripsMargin + 'px' });
				});

				// Add new slider
				self._initControls();

				// For updated widget
				self._change();
			}
		},

		/**
		 * Init the controls.
		 */
		_initControls: function() {
			var self, controls;
			this._super();

			if ( this.options.alpha ) {
				self     = this;
				controls = self.controls;

				controls.aSlider.slider({
					orientation: 'vertical',
					min: 0,
					max: 100,
					step: 1,
					value: parseInt( self._color._alpha * 100, 10 ),
					slide: function( event, ui ) {

						// Update alpha value
						self._color._alpha = parseFloat( ui.value / 100 );
						self._change.apply( self, arguments );
					}
				});
			}
		},

		/**
		 * On value change.
		 */
		_change: function() {
			var self = this,
				el   = self.element,
				controls, alpha, color, gradient, defaultWidth, customWidth, target, reset;

			this._super();

			if ( this.options.alpha ) {
				controls     = self.controls;
				alpha        = parseInt( self._color._alpha * 100, 10 );
				color        = self._color.toRgb();
				gradient     = [
					'rgb(' + color.r + ',' + color.g + ',' + color.b + ') 0%',
					'rgba(' + color.r + ',' + color.g + ',' + color.b + ', 0) 100%'
				];
				defaultWidth = self.options.defaultWidth;
				customWidth  = self.options.customWidth;
				target       = self.picker.closest( '.wp-picker-container' ).find( '.wp-color-result' );

				// Generate background slider alpha, only for CSS3 old browser.
				controls.aContainer.css({ 'background': 'linear-gradient(to bottom, ' + gradient.join( ', ' ) + '), url(' + image + ')' });

				if ( target.hasClass( 'wp-picker-open' ) ) {

					// Update alpha value.
					controls.aSlider.slider( 'value', alpha );

					// Disable opacity change in the default saturation slider and change width.
					if ( 1 > self._color._alpha ) {
						controls.strip.attr( 'style', controls.strip.attr( 'style' ).replace( /rgba\(([0-9]+,)(\s+)?([0-9]+,)(\s+)?([0-9]+)(,(\s+)?[0-9\.]+)\)/g, 'rgb($1$3$5)' ) );
						el.width( parseInt( defaultWidth + customWidth, 10 ) );
					} else {
						el.width( defaultWidth );
					}
				}
			}

			reset = el.data( 'reset-alpha' ) || false;

			if ( reset ) {
				self.picker.find( '.iris-palette-container' ).on( 'click.palette', '.iris-palette', function() {
					self._color._alpha = 1;
					self.active = 'external';
					self._change();
				});
			}

			// Only run after the first time.
			if ( self._inited ) {
				self._trigger(
					'change',
					{ type: self.active },
					{ color: self._color }
				);
			}
		}
	});
}( jQuery ) );
