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

if ( ! class_exists( 'Kirki_Controls_Color_Palette_Control' ) ) {

	/**
	 * Adds a color-palette control.
	 * This is essentially a radio control, styled as a palette.
	 */
	class Kirki_Controls_Color_Palette_Control extends Kirki_Customize_Control {

		/**
		 * The control type.
		 *
		 * @access public
		 * @var string
		 */
		public $type = 'kirki-color-palette';

		/**
		 * Enqueue control related scripts/styles.
		 *
		 * @access public
		 */
		public function enqueue() {
			wp_enqueue_script( 'kirki-color-palette' );
		}

		/**
		 * Refresh the parameters passed to the JavaScript via JSON.
		 *
		 * @access public
		 */
		public function to_json() {
			parent::to_json();
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
		 * export custom variables by overriding {@see Kirki_Customize_Control::to_json()}.
		 *
		 * @see WP_Customize_Control::print_template()
		 *
		 * @access protected
		 */
		protected function content_template() {
			?>
			<# if ( data.tooltip ) { #>
				<a href="#" class="tooltip hint--left" data-hint="{{ data.tooltip }}"><span class='dashicons dashicons-info'></span></a>
			<# } #>
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
}
