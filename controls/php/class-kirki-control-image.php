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
					<img src="{{ url }}" alt="" />
				</div>
			<# } else { #>
				<div class="placeholder">
					<?php esc_attr_e( 'No File Selected', 'kirki' ); ?>
				</div>
			<# } #>
			<div class="actions">
				<button class="button image-upload-remove-button<# if ( '' === url ) { #> hidden <# } #>">
					<?php esc_attr_e( 'Remove', 'kirki' ); ?>
				</button>
				<# if ( data.default && '' !== data.default ) { #>
					<button type="button" class="button image-default-button"<# if ( data.default === data.value || ( ! _.isUndefined( data.value.url ) && data.default === data.value.url ) ) { #> style="display:none;"<# } #>>
						<?php esc_attr_e( 'Default', 'kirki' ); ?>
					</button>
				<# } #>
				<button type="button" class="button image-upload-button">
					<?php esc_attr_e( 'Select File', 'kirki' ); ?>
				</button>
			</div>
		</div>
		<?php
	}
}
