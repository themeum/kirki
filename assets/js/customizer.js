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

	// Range Input
	var s = document.createElement('style'),
		r = document.querySelector('[type=range]');
	document.body.appendChild(s);

	s.textContent += '.js input[type=range] /deep/ #thumb:before{content:"' + r.value + '"}' // Set the tooltip value based on the sliders current value.

	r.addEventListener('input', function() {
		$( this ).css("background-size", this.value + '%' ); // This changes the background size based on slider value, but is wonky.
		s.textContent += '.js input[type=range] /deep/ #thumb:before{content:"' + this.value + '"}' // This updates tooltip value.
	}, false);

	// Switch Click
	$('.Switch').click(function() {
		if ($(this).hasClass('On')){
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
		if ( ! $(this).is('.invisible') ) {
			values.push( $(this).attr('data-value') );
		}
	});
	ul.siblings('input').eq(0).val( serialize( values ) ).trigger('change');
}

( function( $ ) {
	wp.customizerCtrlEditor = {

		init: function() {

			$(window).load(function(){

				$('textarea.wp-editor-area').each(function(){
					var tArea = $(this),
						id = tArea.attr('id'),
						input = $('input[data-customize-setting-link="'+ id +'"]'),
						editor = tinyMCE.get(id),
						setChange,
						content;

					if(editor){
						editor.onChange.add(function (ed, e) {
							ed.save();
							content = editor.getContent();
							clearTimeout(setChange);
							setChange = setTimeout(function(){
								input.val(content).trigger('change');
							},500);
						});
					}

					if(editor){
						editor.onChange.add(function (ed, e) {
							ed.save();
							content = editor.getContent();
							clearTimeout(setChange);
							setChange = setTimeout(function(){
								input.val(content).trigger('change');
							},500);
						});
					}

					tArea.css({
						visibility: 'visible'
					}).on('keyup', function(){
						content = tArea.val();
						clearTimeout(setChange);
						setChange = setTimeout(function(){
							input.val(content).trigger('change');
						},500);
					});
				});
			});
		}

	};

	wp.customizerCtrlEditor.init();

} )( jQuery );
