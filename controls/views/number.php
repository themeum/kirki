<?php
/**
 * Customizer controls underscore.js template.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license     https://opensource.org/licenses/MIT
 * @since       3.0.27
 */

?>
<#
data = _.defaults( data, {
	label: '',
	description: '',
	inputAttrs: '',
	value: '',
	'data-id': ''
} );
#>

<div class="kirki-input-container" data-id="{{ data['data-id'] }}">
	<label>
		<# if ( data.label ) { #>
			<span class="customize-control-title">{{{ data.label }}}</span>
		<# } #>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		<div class="customize-control-content">
			<input {{{ data.inputAttrs }}} type="text" value="{{ data.value }}" data-id="{{ data['data-id'] }}"/>
			<div class="quantity button minus">-</div>
			<div class="quantity button plus">+</div>
		</div>
	</label>
</div>
