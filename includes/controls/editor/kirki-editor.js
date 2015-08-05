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
						editor.on('change', function(e) {
							editor.save();
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
