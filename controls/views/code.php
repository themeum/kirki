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
	id: '',
	label: '',
	description: '',
	input_attrs: {}
});
<# var elementIdPrefix = 'el' + String( Math.random() ); #>
<div class="kirki-input-container" data-id="{{ data.id }}">
	<# if ( data.label ) { #>
		<label for="{{ elementIdPrefix }}_editor" class="customize-control-title">
			{{{ data.label }}}
		</label>
	<# } #>
	<# if ( data.description ) { #>
		<span class="description customize-control-description">{{{ data.description }}}</span>
	<# } #>
	<div class="customize-control-notifications-container"></div>
	<textarea id="{{ elementIdPrefix }}_editor"
		<# _.each( _.extend( { 'class': 'code' }, data.input_attrs ), function( value, key ) { #>
			{{{ key }}}="{{ value }}"
		<# }); #>
		></textarea>
</div>
