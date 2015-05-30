jQuery(document).ready(function($) {
	"use strict";
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
