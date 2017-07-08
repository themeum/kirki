<?php
/**
 * Customizer Control: slider.
 *
 * Creates a jQuery slider control.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Slider control (range).
 */
class Kirki_Control_Slider extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-slider';

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
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see WP_Customize_Control::to_json()
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

		$this->json['choices']['min']  = ( isset( $this->choices['min'] ) ) ? $this->choices['min'] : '0';
		$this->json['choices']['max']  = ( isset( $this->choices['max'] ) ) ? $this->choices['max'] : '100';
		$this->json['choices']['step'] = ( isset( $this->choices['step'] ) ) ? $this->choices['step'] : '1';
	}

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {

		wp_enqueue_script( 'kirki-slider', trailingslashit( Kirki::$url ) . 'controls/slider/slider.js', array( 'jquery', 'customize-base' ), false, true );
		wp_enqueue_style( 'kirki-slider-css', trailingslashit( Kirki::$url ) . 'controls/slider/slider.css', null );
	}

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
		<label>
			<# if ( data.label ) { #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
			<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
			<div class="wrapper">
				<input {{{ data.inputAttrs }}} type="range" min="{{ data.choices['min'] }}" max="{{ data.choices['max'] }}" step="{{ data.choices['step'] }}" value="{{ data.value }}" {{{ data.link }}} data-reset_value="{{ data.default }}" />
				<div class="kirki_range_value">
					<span class="value">{{ data.value }}</span>
					<# if ( data.choices['suffix'] ) { #>
						{{ data.choices['suffix'] }}
					<# } #>
				</div>
				<div class="kirki-slider-reset">
					<span class="dashicons dashicons-image-rotate"></span>
				</div>
			</div>
		</label>
		<?php
	}
}
