jQuery.noConflict();

/** Fire up jQuery - let's dance!
 */
jQuery(document).ready(function($){

	$('a.tooltip').tooltipsy({
	    offset: [10, 0],
	    css: {
	        'padding': '6px 15px',
	        'max-width': '200px',
	        'color': '#f7f7f7',
	        'background-color': '#222222',
	        'border': '1px solid #333333',
	        '-moz-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
	        '-webkit-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
	        'box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
	        'text-shadow': 'none',
	        'border-radius' : '3px'
	    }
	});

});


