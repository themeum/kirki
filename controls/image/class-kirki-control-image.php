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

		Kirki_Custom_Build::register_dependency( 'jquery' );

		if ( ! Kirki_Custom_Build::is_custom_build() ) {
			wp_enqueue_script( 'kirki-image', trailingslashit( Kirki::$url ) . 'controls/image/image.js', array( 'jquery', 'customize-base' ) );
			wp_enqueue_style( 'kirki-image', trailingslashit( Kirki::$url ) . 'controls/image/image.css', null );
		}
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
		$config_id = 'global';
		$this->json['l10n'] = $this->l10n( $config_id );
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
		<# saveAs = ( ! _.isUndefined( data.choices ) && ! _.isUndefined( data.choices.save_as ) && 'array' === data.choices.save_as ) ? 'array' : url; #>
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
					{{ data.l10n['no-file-selected'] }}
				</div>
			<# } #>
			<div class="actions">
				<button class="button image-upload-remove-button<# if ( '' === url ) { #> hidden <# } #>">
					{{ data.l10n['remove'] }}
				</button>
				<button type="button" class="button image-upload-button">
					{{ data.l10n['select-file'] }}
				</button>
			</div>
		</div>
		<# value = ( 'array' === saveAs ) ? JSON.stringify( data.value ) : data.value; #>
		<input class="image-hidden-value" type="hidden" value='{{{ value }}}' {{{ data.link }}}>
		<?php
	}

	/**
	 * Returns an array of translation strings.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @param string|false $config_id The string-ID.
	 * @return array
	 */
	protected function l10n( $config_id ) {
		$translation_strings = array(
			'no-file-selected'      => esc_attr__( 'No File Selected', 'kirki' ),
			'remove'                => esc_attr__( 'Remove', 'kirki' ),
			'select-file'           => esc_attr__( 'Select File', 'kirki' ),
		);
		return apply_filters( "kirki/{$config_id}/l10n", $translation_strings );
	}
}
