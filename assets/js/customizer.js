jQuery.noConflict();
/** Fire up jQuery - let's dance! */
jQuery(document).ready(function($){
	$("a.tooltip").tooltip();
});

jQuery(document).ready(function($) {
	"use strict";
	// initialize
	$('.kirki-sortable > ul ~ input').each(function() {
		var value = $(this).val();
		try {
			value = unserialize( value );
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
		.on( "sortstop", function( event, ui ) {
			kirkiUpdateSortable(ui.item.parent());
		})
		.find('li').each(function() {
			$(this).find('i.visibility').click(function() {
				$(this).toggleClass('dashicons-visibility-faint').parents('li:eq(0)').toggleClass('invisible');
			});
		})
		.click(function() {
			kirkiUpdateSortable( $(this).parents('ul:eq(0)') );
		})
	});


	// Switch Click
	$('.Switch').click(function() {
		// Check If Enabled (Has 'On' Class)
		if ($(this).hasClass('On')){
			// Try To Find Checkbox Within Parent Div, And Check It
			$(this).parent().find('input:checkbox').attr('checked', true);
			// Change Button Style - Remove On Class, Add Off Class
			$(this).removeClass('On').addClass('Off');
		} else { // If Button Is Disabled (Has 'Off' Class)
			// Try To Find Checkbox Within Parent Div, And Uncheck It
			$(this).parent().find('input:checkbox').attr('checked', false);
			// Change Button Style - Remove Off Class, Add On Class
			$(this).removeClass('Off').addClass('On');
		}
	});

	// Loops Through Each Toggle Switch On Page
	$('.Switch').each(function() {
		// Search of a checkbox within the parent
		if ($(this).parent().find('input:checkbox').length){
			// This just hides all Toggle Switch Checkboxs
			// Uncomment line below to hide all checkbox's after Toggle Switch is Found
			$(this).parent().find('input:checkbox').hide();
			// Look at the checkbox's checkked state
			if ($(this).parent().find('input:checkbox').is(':checked')){
				// Checkbox is not checked, Remove the 'On' Class and Add the 'Off' Class
				$(this).removeClass('On').addClass('Off');
			} else {
				// Checkbox Is Checked Remove 'Off' Class, and Add the 'On' Class
				$(this).removeClass('Off').addClass('On');
			}
		}
	});

});
function kirkiUpdateSortable(ul) {
	"use strict";
	var $ = jQuery;
	var values = [];
	ul.find('li').each(function() {
		if ( ! $(this).is('.invisible') ) {
			values.push( $(this).attr('data-value') );
		}
	});
	ul.siblings('input').eq(0).val( serialize( values ) ).trigger('change');
}
