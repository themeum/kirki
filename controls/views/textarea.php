<?php
/**
 * Customizer controls underscore.js template.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2020, David Vongries
 * @license     https://opensource.org/licenses/MIT
 * @since       3.0.17
 */

?>
<#
data = _.defaults( data, {
	label: '',
	description: '',
	inputAttrs: '',
	value: '',
	'data-id': '',
	choices: {}
} );
#>
<div class="kirki-input-container" data-id="' + data.id + '">
	<label>
		<# if ( data.label ) { #>
			<span class="customize-control-title">{{{ data.label }}}</span>
		<# } #>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		<div class="customize-control-content">
			<textarea
				data-id="{{ data['data-id'] }}"
				{{{ data.inputAttrs }}}
				<# _.each( data.choices, function( val, key ) { #>
					{{ key }}="{{ val }}"
				<# }); #>
			>{{{ data.value }}}</textarea>
		</div>
	</label>
</div>
