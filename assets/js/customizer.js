jQuery( document ).ready( function($) {
	$( 'textarea[data-editor]' ).each( function () {
		var textarea = $( this );
		var mode     = textarea.data( 'editor' );
		var editDiv  = $( '<div>', {
			position: 'absolute',
			width: textarea.width(),
			height: textarea.height(),
			'class': textarea.attr( 'class' )
		}).insertBefore( textarea );
		textarea.css( 'display', 'none' );
		var editor = ace.edit( editDiv[0] );
		editor.renderer.setShowGutter( false );
		editor.renderer.setPadding(10);
		editor.getSession().setValue( textarea.val() );
		editor.getSession().setMode( "ace/mode/" + mode );
		editor.setTheme( "ace/theme/" + textarea.data( 'theme' ) );

		editor.getSession().on( 'change', function(){
			textarea.val( editor.getSession().getValue() ).trigger( 'change' );
		});
	});
});

wp.customize.controlConstructor['code'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		this.container.on( 'change', 'textarea', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
jQuery(document).ready(function($) {

	if ( typeof Color !== "undefined" ) {

		Color.prototype.toString = function(remove_alpha) {
			if (remove_alpha == 'no-alpha') {
				return this.toCSS('rgba', '1').replace(/\s+/g, '');
			}
			if (this._alpha < 1) {
				return this.toCSS('rgba', this._alpha).replace(/\s+/g, '');
			}
			var hex = parseInt(this._color, 10).toString(16);
			if (this.error) return '';
			if (hex.length < 6) {
				for (var i = 6 - hex.length - 1; i >= 0; i--) {
					hex = '0' + hex;
				}
			}
			return '#' + hex;
		};

		$('.kirki-color-control').each(function() {
			var $control = $(this),
				value = $control.val().replace(/\s+/g, '');
			// Manage Palettes
			var palette_input = $control.attr('data-palette');
			if (palette_input == 'false' || palette_input == false) {
				var palette = false;
			} else if (palette_input == 'true' || palette_input == true) {
				var palette = true;
			} else {
				var palette = $control.attr('data-palette').split(",");
			}
			$control.wpColorPicker({ // change some things with the color picker
				clear: function(event, ui) {
					// TODO reset Alpha Slider to 100
				},
				change: function(event, ui) {
					// send ajax request to wp.customizer to enable Save & Publish button
					var _new_value = $control.val();
					var key = $control.attr('data-customize-setting-link');
					wp.customize(key, function(obj) {
						obj.set(_new_value);
					});
					// change the background color of our transparency container whenever a color is updated
					var $transparency = $control.parents('.wp-picker-container:first').find('.transparency');
					// we only want to show the color at 100% alpha
					$transparency.css('backgroundColor', ui.color.toString('no-alpha'));
				},
				palettes: palette // remove the color palettes
			});
			$('<div class="kirki-alpha-container"><div class="slider-alpha"></div><div class="transparency"></div></div>').appendTo($control.parents('.wp-picker-container'));
			var $alpha_slider = $control.parents('.wp-picker-container:first').find('.slider-alpha');
			// if in format RGBA - grab A channel value
			if (value.match(/rgba\(\d+\,\d+\,\d+\,([^\)]+)\)/)) {
				var alpha_val = parseFloat(value.match(/rgba\(\d+\,\d+\,\d+\,([^\)]+)\)/)[1]) * 100;
				var alpha_val = parseInt(alpha_val);
			} else {
				var alpha_val = 100;
			}
			$alpha_slider.slider({
				slide: function(event, ui) {
					$(this).find('.ui-slider-handle').text(ui.value); // show value on slider handle
					// send ajax request to wp.customizer to enable Save & Publish button
					var _new_value = $control.val();
					var key = $control.attr('data-customize-setting-link');
					wp.customize(key, function(obj) {
						obj.set(_new_value);
					});
				},
				create: function(event, ui) {
					var v = $(this).slider('value');
					$(this).find('.ui-slider-handle').text(v + '%');
				},
				value: alpha_val,
				range: "max",
				step: 1,
				min: 1,
				max: 100
			}); // slider
			$alpha_slider.slider().on('slidechange', function(event, ui) {
				var new_alpha_val = parseFloat(ui.value),
					iris = $control.data('a8cIris'),
					color_picker = $control.data('wpWpColorPicker');
				iris._color._alpha = new_alpha_val / 100.0;
				$control.val(iris._color.toString());
				color_picker.toggler.css({
					backgroundColor: $control.val()
				});
				// fix relationship between alpha slider and the 'side slider not updating.
				var get_val = $control.val();
				$($control).wpColorPicker('color', get_val);
			});
		}); // each
	}
});
wp.customize.controlConstructor['dimension'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		var numeric_value = control.container.find('input[type=number]' ).val();
		var units_value   = control.container.find('select' ).val();

		this.container.on( 'change', 'input', function() {
			numeric_value = jQuery( this ).val();
			control.setting.set( numeric_value + units_value );
		});
		this.container.on( 'change', 'select', function() {
			units_value = jQuery( this ).val();
			control.setting.set( numeric_value + units_value );
		});
	}
});
jQuery(document).ready(function($) {
	"use strict";
	$( ".customize-control-number input[type='number']").number();
});

wp.customize.controlConstructor['number'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		this.container.on( 'change', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
jQuery(document).ready(function($) {
	$( '.customize-control-palette > div' ).buttonset();
});
wp.customize.controlConstructor['radio-buttonset'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		this.container.on( 'click', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
wp.customize.controlConstructor['radio-image'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		this.container.on( 'click', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
jQuery(document).ready(function($) {
	$('.select2').select2();
});
jQuery(document).ready(function($) {
	$('.select2').select2();
});
jQuery(document).ready(function($) {

	$( 'input[type=range]' ).on( 'mousedown', function() {
		value = $( this ).attr( 'value' );
		$( this ).mousemove(function() {
			value = $( this ).attr( 'value' );
			$( this ).closest( 'label' ).find( '.kirki_range_value .value' ).text( value );
		});
	});

	$( '.kirki-slider-reset' ).click( function () {
		var $this_input   = $( this ).closest( 'label' ).find( 'input' ),
			input_name    = $this_input.data( 'customize-setting-link' ),
			input_default = $this_input.data( 'reset_value' );

		$this_input.val( input_default );
		$this_input.change();
	});

});

wp.customize.controlConstructor['slider'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		this.container.on( 'change', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
wp.customize.controlConstructor['spacing'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		var compiled_value = {};

		// get initial values and pre-populate the object
		if ( control.container.has( '.top' ).size() ) {
			compiled_value['top'] = control.setting._value['top'];
		}
		if ( control.container.has( '.bottom' ).size() ) {
			compiled_value['bottom'] = control.setting._value['bottom'];
		}
		if ( control.container.has( '.left' ).size() ) {
			compiled_value['left']  = control.setting._value['left'];
		}
		if ( control.container.has( '.right' ).size() ) {
			compiled_value['right']    = control.setting._value['right'];
		}

		// top
		if ( control.container.has( '.top' ).size() ) {
			var top_numeric_value = control.container.find('.top input[type=number]' ).val();
			var top_units_value   = control.container.find('.top select' ).val();

			this.container.on( 'change', '.top input', function() {
				top_numeric_value = jQuery( this ).val();
				compiled_value['top'] = top_numeric_value + top_units_value;
				control.setting.set( compiled_value );
			});
			this.container.on( 'change', '.top select', function() {
				top_units_value = jQuery( this ).val();
				compiled_value['top'] = top_numeric_value + top_units_value;
				control.setting.set( compiled_value );
			});
		}

		// bottom
		if ( control.container.has( '.bottom' ).size() ) {
			var bottom_numeric_value = control.container.find('.bottom input[type=number]' ).val();
			var bottom_units_value   = control.container.find('.bottom select' ).val();

			this.container.on( 'change', '.bottom input', function() {
				bottom_numeric_value = jQuery( this ).val();
				compiled_value['bottom'] = bottom_numeric_value + bottom_units_value;
				control.setting.set( compiled_value );
			});
			this.container.on( 'change', '.bottom select', function() {
				bottom_units_value = jQuery( this ).val();
				compiled_value['bottom'] = bottom_numeric_value + bottom_units_value;
				control.setting.set( compiled_value );
			});
		}

		// left
		if ( control.container.has( '.left' ).size() ) {
			var left_numeric_value = control.container.find('.left input[type=number]' ).val();
			var left_units_value   = control.container.find('.left select' ).val();

			this.container.on( 'change', '.left input', function() {
				left_numeric_value = jQuery( this ).val();
				compiled_value['left'] = left_numeric_value + left_units_value;
				control.setting.set( compiled_value );
			});
			this.container.on( 'change', '.left select', function() {
				left_units_value = jQuery( this ).val();
				compiled_value['left'] = left_numeric_value + left_units_value;
				control.setting.set( compiled_value );
			});
		}

		// right
		if ( control.container.has( '.right' ).size() ) {
			var right_numeric_value = control.container.find('.right input[type=number]' ).val();
			var right_units_value   = control.container.find('.right select' ).val();

			this.container.on( 'change', '.right input', function() {
				right_numeric_value = jQuery( this ).val();
				compiled_value['right'] = right_numeric_value + right_units_value;
				control.setting.set( compiled_value );
			});
			this.container.on( 'change', '.right select', function() {
				right_units_value = jQuery( this ).val();
				compiled_value['right'] = right_numeric_value + right_units_value;
				control.setting.set( compiled_value );
			});
		}
	}
});
wp.customize.controlConstructor['switch'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;

		// Get the initial value
		var checkbox_value = control.setting._value;

		this.container.on( 'change', 'input', function() {
			checkbox_value = ( jQuery( this ).is( ':checked' ) ) ? true : false;
			control.setting.set( checkbox_value );
		});
	}
});
wp.customize.controlConstructor['toggle'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;

		// Get the initial value
		var checkbox_value = control.setting._value;

		this.container.on( 'change', 'input', function() {
			checkbox_value = ( jQuery( this ).is( ':checked' ) ) ? true : false;
			control.setting.set( checkbox_value );
		});
	}
});
wp.customize.controlConstructor['typography'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		var compiled_value = {};

		// get initial values and pre-populate the object
		if ( control.container.has( '.bold' ).size() ) {
			compiled_value['bold']           = control.setting._value['bold'];
		}
		if ( control.container.has( '.italic' ).size() ) {
			compiled_value['italic']         = control.setting._value['italic'];
		}
		if ( control.container.has( '.underline' ).size() ) {
			compiled_value['underline']      = control.setting._value['underline'];
		}
		if ( control.container.has( '.strikethrough' ).size() ) {
			compiled_value['strikethrough']  = control.setting._value['strikethrough'];
		}
		if ( control.container.has( '.font-family' ).size() ) {
			compiled_value['font-family']    = control.setting._value['font-family'];
		}
		if ( control.container.has( '.font-size' ).size() ) {
			compiled_value['font-size']      = control.setting._value['font-size'];
		}
		if ( control.container.has( '.font-weight' ).size() ) {
			compiled_value['font-weight']    = control.setting._value['font-weight'];
		}
		if ( control.container.has( '.line-height' ).size() ) {
			compiled_value['line-height']    = control.setting._value['line-height'];
		}
		if ( control.container.has( '.letter-spacing' ).size() ) {
			compiled_value['letter-spacing'] = control.setting._value['letter-spacing'];
		}

		// bold
		if ( control.container.has( '.bold' ).size() ) {
			this.container.on( 'change', '.bold input', function() {
				if ( jQuery( this ).is( ':checked' ) ) {
					compiled_value['bold'] = true;
				} else {
					compiled_value['bold'] = false;
				}
				control.setting.set( compiled_value );
			});
		}

		// italic
		if ( control.container.has( '.italic' ).size() ) {
			this.container.on( 'change', '.italic input', function() {
				if ( jQuery( this ).is( ':checked' ) ) {
					compiled_value['italic'] = true;
				} else {
					compiled_value['italic'] = false;
				}
				control.setting.set( compiled_value );
			});
		}

		// underline
		if ( control.container.has( '.underline' ).size() ) {
			this.container.on( 'change', '.underline input', function() {
				if ( jQuery( this ).is( ':checked' ) ) {
					compiled_value['underline'] = true;
				} else {
					compiled_value['underline'] = false;
				}
				control.setting.set( compiled_value );
			});
		}

		// strikethrough
		if ( control.container.has( '.strikethrough' ).size() ) {
			this.container.on( 'change', '.strikethrough input', function() {
				if ( jQuery( this ).is( ':checked' ) ) {
					compiled_value['strikethrough'] = true;
				} else {
					compiled_value['strikethrough'] = false;
				}
				control.setting.set( compiled_value );
			});
		}

		// font-family
		if ( control.container.has( '.font-family' ).size() ) {
			this.container.on( 'change', '.font-family select', function() {
				compiled_value['font-family'] = jQuery( this ).val();
				control.setting.set( compiled_value );
			});
		}

		// font-size
		if ( control.container.has( '.font-size' ).size() ) {
			var font_size_numeric_value = control.container.find('.font-size input[type=number]' ).val();
			var font_size_units_value   = control.container.find('.font-size select' ).val();

			this.container.on( 'change', '.font-size input', function() {
				font_size_numeric_value = jQuery( this ).val();
				compiled_value['font-size'] = font_size_numeric_value + font_size_units_value;
				control.setting.set( compiled_value );
			});
			this.container.on( 'change', '.font-size select', function() {
				font_size_units_value = jQuery( this ).val();
				compiled_value['font-size'] = font_size_numeric_value + font_size_units_value;
				control.setting.set( compiled_value );
			});
		}

		// font-weight
		if ( control.container.has( '.font-weight' ).size() ) {
			this.container.on( 'change', '.font-weight select', function() {
				compiled_value['font-weight'] = jQuery( this ).val();
				control.setting.set( compiled_value );
			});
		}

		// line-height
		if ( control.container.has( '.line-height' ).size() ) {
			this.container.on( 'change', '.line-height input', function() {
				compiled_value['line-height'] = jQuery( this ).val();
				control.setting.set( compiled_value );
			});
		}

		// letter-spacing
		if ( control.container.has( '.letter-spacing' ).size() ) {
			var letter_spacing_numeric_value = control.container.find('.letter-spacing input[type=number]' ).val();
			var letter_spacing_units_value   = control.container.find('.letter-spacing select' ).val();

			this.container.on( 'change', '.letter-spacing input', function() {
				letter_spacing_numeric_value = jQuery( this ).val();
				compiled_value['letter-spacing'] = letter_spacing_numeric_value + letter_spacing_units_value;
				control.setting.set( compiled_value );
			});
			this.container.on( 'change', '.letter-spacing select', function() {
				letter_spacing_units_value = jQuery( this ).val();
				compiled_value['letter-spacing'] = letter_spacing_numeric_value + letter_spacing_units_value;
				control.setting.set( compiled_value );
			});
		}

	}
});
