<?php
/**
 * Customizer controls underscore.js template.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license     https://opensource.org/licenses/MIT
 * @since       3.0.17
 */

?>
<#
data = _.defaults( data, {
	label: '',
	description: '',
	mode: 'full',
	inputAttrs: '',
	'data-palette': data['data-palette'] ? data['data-palette'] : true,
	'data-default-color': data['data-default-color'] ? data['data-default-color'] : '',
	'data-alpha': data['data-alpha'] ? data['data-alpha'] : false,
	value: '',
	'data-id': ''
} );
#>

<div class="kirki-input-container" data-id="{{ data['data-id'] }}" data-has-alpha="{{ data['data-alpha'] }}">
	<label>
		<# if ( data.label ) { #>
			<span class="customize-control-title">{{{ data.label }}}</span>
		<# } #>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
	</label>
	<input
		type="text"
		data-type="{{ data.mode }}"
		{{{ data.inputAttrs }}}
		data-palette="{{ data['data-palette'] }}"
		data-default-color="{{ data['data-default-color'] }}"
		data-alpha="{{ data['data-alpha'] }}"
		value="{{ data.value }}"
		class="kirki-color-control"
		data-id="{{ data['data-id'] }}"
	/>
</div>
