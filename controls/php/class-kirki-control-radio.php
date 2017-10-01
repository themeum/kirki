<?php
/**
 * Customizer Control: kirki-radio.
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
 * Radio control
 */
class Kirki_Control_Radio extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-radio';

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

		wp_enqueue_script( 'kirki-control', trailingslashit( Kirki::$url ) . 'controls/js/kirki.control.js', array( 'jquery', 'customize-base' ), false, true );
		wp_enqueue_script( 'kirki-input', trailingslashit( Kirki::$url ) . 'controls/js/kirki.input.js', array( 'jquery', 'customize-base' ), false, true );
		wp_enqueue_script( 'kirki-setting', trailingslashit( Kirki::$url ) . 'controls/js/kirki.setting.js', array( 'jquery', 'customize-base' ), false, true );
		wp_enqueue_script( 'kirki-util', trailingslashit( Kirki::$url ) . 'controls/js/kirki.util.js', array( 'jquery', 'customize-base' ), false, true );
		wp_enqueue_script( 'kirki-value', trailingslashit( Kirki::$url ) . 'controls/js/kirki.value.js', array( 'jquery', 'customize-base' ), false, true );

		wp_enqueue_script( 'kirki-dynamic-control', trailingslashit( Kirki::$url ) . 'assets/js/dynamic-control.js', array( 'jquery', 'customize-base' ), false, true );
		wp_enqueue_script( 'kirki-radio', trailingslashit( Kirki::$url ) . 'controls/js/radio.js', array( 'jquery', 'kirki-dynamic-control', 'customize-base', 'kirki-control', 'kirki-input', 'kirki-setting', 'kirki-util', 'kirki-value' ), false, true );
		wp_enqueue_style( 'kirki-controls-css', trailingslashit( Kirki::$url ) . 'controls/css/controls.css', null );
	}

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
	protected function content_template() {}
}
