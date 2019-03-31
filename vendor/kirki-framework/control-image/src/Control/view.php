<?php
/**
 * Customizer controls underscore.js template.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license    https://opensource.org/licenses/MIT
 * @since       3.0.34
 */

?>
<#
data = _.defaults( data, {
	id: '',
	label: '',
	description: '',
	input_attrs: {},
	choices: {}
});

var saveAs = 'url';
if ( ! _.isUndefined( data.choices.save_as ) ) {
	saveAs = data.choices.save_as;
}

url = data.value;
if ( _.isObject( data.value ) && ! _.isUndefined( data.value.url ) ) {
	url = data.value.url;
}

data.choices.labels = _.isObject( data.choices.labels ) ? data.choices.labels : {};
data.choices.labels = _.defaults( data.choices.labels, {
	select: '<?php esc_html_e( 'Select image', 'kirki' ); ?>',
	change: '<?php esc_html_e( 'Change image', 'kirki' ); ?>',
	'default': '<?php esc_html_e( 'Default', 'kirki' ); ?>',
	remove: '<?php esc_html_e( 'Remove', 'kirki' ); ?>',
	placeholder: '<?php esc_html_e( 'No image selected', 'kirki' ); ?>',
	frame_title: '<?php esc_html_e( 'Select image', 'kirki' ); ?>',
	frame_button: '<?php esc_html_e( 'Choose image', 'kirki' ); ?>',
} );
#>

<label>
	<span class="customize-control-title">
		{{{ data.label }}}
	</span>
	<# if ( data.description ) { #>
		<span class="description customize-control-description">{{{ data.description }}}</span>
	<# } #>
</label>
<div class="image-wrapper attachment-media-view image-upload">
	<# if ( data.value['url'] || '' !== url ) { #>
		<div class="thumbnail thumbnail-image">
			<img src="{{ url }}"/>
		</div>
	<# } else { #>
		<div class="placeholder">{{ data.choices.labels.placeholder }}</div>
	<# } #>
	<div class="actions">
		<button class="button image-upload-remove-button<# if ( '' === url ) { #> hidden <# } #>">{{ data.choices.labels.remove }}</button>
		<# if ( data.default && '' !== data.default ) { #>
			<button type="button" class="button image-default-button"<# if ( data.default === data.value || ( ! _.isUndefined( data.value.url ) && data.default === data.value.url ) ) { #> style="display:none;"<# } #>>{{ data.choices.labels['default'] }}</button>
		<# } #>
		<button type="button" class="button image-upload-button">{{ data.choices.labels.select }}</button>
	</div>
</div>
