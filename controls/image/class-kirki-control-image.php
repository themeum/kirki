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
class Kirki_Control_Image extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-image';

	/**
	 * Used to automatically generate all CSS output.
	 *
	 * @access public
	 * @var array
	 */
	public $output = array();

	/**
	 * Data type
	 *
	 * @access public
	 * @var string
	 */
	public $option_type = 'theme_mod';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {

		wp_enqueue_script( 'kirki-image', trailingslashit( Kirki::$url ) . 'controls/image/image.js', array( 'jquery', 'customize-base' ) );
		wp_enqueue_style( 'kirki-image', trailingslashit( Kirki::$url ) . 'controls/image/image.css', null );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @access public
	 */
	public function to_json() {
		parent::to_json();

		$this->json['default'] = $this->setting->default;
		if ( isset( $this->default ) ) {
			$this->json['default'] = $this->default;
		}
		$this->json['output']  = $this->output;
		$this->json['value']   = $this->value();
		$this->json['choices'] = $this->choices;
		$this->json['link']    = $this->get_link();
		$this->json['id']      = $this->id;

		$this->json['inputAttrs'] = '';
		foreach ( $this->input_attrs as $attr => $value ) {
			$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
		}
	}

	/**
	 * Render the control's content.
	 *
	 * @see WP_Customize_Control::render_content()
	 */
	protected function render_content() {}

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
		<div class="kirki-controls-loading-spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>
		<# saveAs = ( ! _.isUndefined( data.choices ) && ! _.isUndefined( data.choices.save_as ) && 'array' === data.choices.save_as ) ? 'array' : 'url'; #>
		<# url = ( 'array' === saveAs && data.value['url'] ) ? data.value['url'] : data.value; #>
		<label>
			<span class="customize-control-title">
				{{{ data.label }}}
			</span>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>
		<div class="image-wrapper attachment-media-view image-upload">
			<# if ( data.value['url'] ) { #>
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
		<# value = ( 'array' === saveAs ) ? JSON.stringify( data.value ) : data.value; #>
		<input class="image-hidden-value" type="hidden" value='{{{ value }}}' {{{ data.link }}}>
		<?php
	}
}
