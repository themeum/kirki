<?php
/**
 * Customizer Control: color-palette.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.6
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds a color-palette control.
 * This is essentially a radio control, styled as a palette.
 */
class Kirki_Control_Color_Palette extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-color-palette';

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
		wp_enqueue_script( 'kirki-color-palette', trailingslashit( Kirki::$url ) . 'controls/color-palette/color-palette.js', array( 'jquery', 'customize-base', 'jquery-ui-button' ), false, true );
		wp_enqueue_style( 'kirki-color-palette-css', trailingslashit( Kirki::$url ) . 'controls/color-palette/color-palette.css', null );
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

		if ( 'user_meta' === $this->option_type ) {
			$this->json['value'] = get_user_meta( get_current_user_id(), $this->id, true );
		}

		$this->json['inputAttrs'] = '';
		foreach ( $this->input_attrs as $attr => $value ) {
			$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
		}

		// If no palette has been defined, use Material Design Palette.
		if ( ! isset( $this->json['choices']['colors'] ) || empty( $this->json['choices']['colors'] ) ) {
			$this->json['choices']['colors'] = Kirki_Helper::get_material_design_colors( 'primary' );
		}
		if ( ! isset( $this->json['choices']['size'] ) || empty( $this->json['choices']['size'] ) ) {
			$this->json['choices']['size']   = 42;
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
	protected function content_template() {
		?>
		<# if ( ! data.choices ) { return; } #>
		<span class="customize-control-title">
			{{ data.label }}
		</span>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		<div id="input_{{ data.id }}" class="colors-wrapper">
			<# for ( key in data.choices['colors'] ) { #>
				<input type="radio" {{{ data.inputAttrs }}} value="{{ data.choices['colors'][ key ] }}" name="_customize-color-palette-{{ data.id }}" id="{{ data.id }}{{ key }}" {{{ data.link }}}<# if ( data.value == data.choices['colors'][ key ] ) { #> checked<# } #>>
					<label for="{{ data.id }}{{ key }}">
						<span class="color-palette-color" style='background: {{ data.choices['colors'][ key ] }}; width: {{ data.choices['size'] }}px; height: {{ data.choices['size'] }}px;'>{{ data.choices['colors'][ key ] }}</span>
					</label>
				</input>
			<# } #>
		</div>
		<?php
	}
}
