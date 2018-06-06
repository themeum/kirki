<?php
/**
 * Customizer Control: image.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0.0
 */

/**
 * Adds the image control.
 */
class Kirki_Control_Image extends Kirki_Control_Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-image';

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 */
	protected function content_template() {
		?>
		<#
		var saveAs = 'url';
		if ( ! _.isUndefined( data.choices ) && ! _.isUndefined( data.choices.save_as ) ) {
			saveAs = data.choices.save_as;
		}
		url = data.value;
		if ( _.isObject( data.value ) && ! _.isUndefined( data.value.url ) ) {
			url = data.value.url;
		}

		data.choices.labels = _.isObject( data.choices.labels ) ? data.choices.labels : {};
		data.choices.labels = _.defaults( data.choices.labels, {
			select: '<?php esc_attr_e( 'Select image', 'kirki' ); ?>',
			change: '<?php esc_attr_e( 'Change image', 'kirki' ); ?>',
			'default': '<?php esc_attr_e( 'Default', 'kirki' ); ?>',
			remove: '<?php esc_attr_e( 'Remove', 'kirki' ); ?>',
			placeholder: '<?php esc_attr_e( 'No image selected', 'kirki' ); ?>',
			frame_title: '<?php esc_attr_e( 'Select image', 'kirki' ); ?>',
			frame_button: '<?php esc_attr_e( 'Choose image', 'kirki' ); ?>',
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
		<?php
	}
}
