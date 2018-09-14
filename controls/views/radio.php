<?php
/**
 * Customizer controls underscore.js template.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license    https://opensource.org/licenses/MIT
 * @since       3.0.17
 */

?>
<# data = _.defaults( data, {
	choices: {},
	label: '',
	description: '',
	inputAttrs: '',
	value: '',
	'data-id': '',
	'default': ''
} );
#>

<div class="kirki-input-container" data-id="' + data.id + '">
	<# if ( data.label ) { #>
		<span class="customize-control-title">{{{ data.label }}}</span>
	<# } #>
	<# if ( data.description ) { #>
		<span class="description customize-control-description">{{{ data.description }}}</span>
	<# } #>
	<# _.each( data.choices, function( val, key ) { #>
		<label>
			<input
				{{{ data.inputAttrs }}}
				type="radio"
				data-id="{{ data['data-id'] }}"
				value="{{ key }}"
				name="_customize-radio-{{ data['data-id'] }}"
				<# if ( data.value === key ) { #> checked<# } #>
			/>
			<# if ( _.isArray( val ) ) { #>
				{{{ val[0] }}}<span class="option-description">{{{ val[1] }}}</span>
			<# } else { #>
				{{ val }}
			<# } #>
		</label>
	<# } ); #>
</div>
