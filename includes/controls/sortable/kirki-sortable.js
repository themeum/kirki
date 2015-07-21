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
