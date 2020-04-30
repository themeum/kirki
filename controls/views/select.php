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
	'data-id': '',
	choices: {},
	multiple: 1,
	value: ( 1 < data.multiple ) ? [] : '',
	placeholder: false
} );

if ( 1 < data.multiple && data.value && _.isString( data.value ) ) {
	data.value = [ data.value ];
}
#>
<div class="kirki-input-container" data-id="{{ data.id }}">
	<label>
		<# if ( data.label ) { #>
			<span class="customize-control-title">{{{ data.label }}}</span>
		<# } #>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		<select
			data-id="{{ data['data-id'] }}"
			{{{ data.inputAttrs }}}
			<# if ( 1 < data.multiple ) { #>
				data-multiple="{{ data.multiple }}" multiple="multiple"
			<# } #>
			>
			<# if ( data.placeholder ) { #>
				<option value=""<# if ( '' === data.value ) { #> selected<# } #>></option>
			<# } #>
			<# _.each( data.choices, function( optionLabel, optionKey ) { #>
				<#
				selected = ( data.value === optionKey );
				if ( 1 < data.multiple && data.value ) {
					selected = _.contains( data.value, optionKey );
				}
				if ( _.isObject( optionLabel ) ) {
					#>
					<optgroup label="{{ optionLabel[0] }}">
						<# _.each( optionLabel[1], function( optgroupOptionLabel, optgroupOptionKey ) { #>
							<#
							selected = ( data.value === optgroupOptionKey );
							if ( 1 < data.multiple && data.value ) {
								selected = _.contains( data.value, optgroupOptionKey );
							}
							#>
							<option value="{{ optgroupOptionKey }}"<# if ( selected ) { #> selected<# } #>>{{{ optgroupOptionLabel }}}</option>
						<# } ); #>
					</optgroup>
				<# } else { #>
					<option value="{{ optionKey }}"<# if ( selected ) { #> selected<# } #>>{{{ optionLabel }}}</option>
				<# } #>
			<# } ); #>
		</select>
	</label>
</div>
