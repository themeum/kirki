jQuery.noConflict();
/** Fire up jQuery - let's dance! */
jQuery(document).ready(function($) {
	$("a.tooltip").tooltip();
});

jQuery(document).ready(function($) {
	"use strict";
	// initialize
	$('.kirki-sortable > ul ~ input').each(function() {
		var value = $(this).val();
		try {
			value = unserialize(value);
		} catch (err) {
			return;
		}
		var ul = $(this).siblings('ul:eq(0)');
		ul.find('li').addClass('invisible').find('i.visibility').toggleClass('dashicons-visibility-faint');
		$.each(value, function(i, val) {
			ul.find('li[data-value=' + val + ']').removeClass('invisible').find('i.visibility').toggleClass('dashicons-visibility-faint');
		});
	});
	$('.kirki-sortable > ul').each(function() {
		$(this).sortable()
			.disableSelection()
			.on("sortstop", function(event, ui) {
				kirkiUpdateSortable(ui.item.parent());
			})
			.find('li').each(function() {
				$(this).find('i.visibility').click(function() {
					$(this).toggleClass('dashicons-visibility-faint').parents('li:eq(0)').toggleClass('invisible');
				});
			})
			.click(function() {
				kirkiUpdateSortable($(this).parents('ul:eq(0)'));
			})
	});


	// Switch Click
	$('.Switch').click(function() {
		if ($(this).hasClass('On')) {
			$(this).parent().find('input:checkbox').attr('checked', true);
			$(this).removeClass('On').addClass('Off');
		} else {
			$(this).parent().find('input:checkbox').attr('checked', false);
			$(this).removeClass('Off').addClass('On');
		}
	});

});

function kirkiUpdateSortable(ul) {
	"use strict";
	var $ = jQuery;
	var values = [];
	ul.find('li').each(function() {
		if (!$(this).is('.invisible')) {
			values.push($(this).attr('data-value'));
		}
	});
	ul.siblings('input').eq(0).val(serialize(values)).trigger('change');
}


(function($) {
	wp.customizerCtrlEditor = {

		init: function() {

			$(window).load(function() {

				$('textarea.wp-editor-area').each(function() {
					var tArea = $(this),
						id = tArea.attr('id'),
						input = $('input[data-customize-setting-link="' + id + '"]'),
						editor = tinyMCE.get(id),
						setChange,
						content;

					if (editor) {
						editor.onChange.add(function(ed, e) {
							ed.save();
							content = editor.getContent();
							clearTimeout(setChange);
							setChange = setTimeout(function() {
								input.val(content).trigger('change');
							}, 500);
						});
					}

					if (editor) {
						editor.onChange.add(function(ed, e) {
							ed.save();
							content = editor.getContent();
							clearTimeout(setChange);
							setChange = setTimeout(function() {
								input.val(content).trigger('change');
							}, 500);
						});
					}

					tArea.css({
						visibility: 'visible'
					}).on('keyup', function() {
						content = tArea.val();
						clearTimeout(setChange);
						setChange = setTimeout(function() {
							input.val(content).trigger('change');
						}, 500);
					});
				});
			});
		}

	};

	wp.customizerCtrlEditor.init();

})(jQuery);

jQuery(document).ready(function($) {

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
				$(this).find('.ui-slider-handle').text(v);
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

});
