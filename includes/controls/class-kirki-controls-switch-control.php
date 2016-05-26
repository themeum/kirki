<?php
/**
 * Customizer Control: switch.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Controls_Switch_Control' ) ) {

	/**
	 * Switch control (modified checkbox).
	 */
	class Kirki_Controls_Switch_Control extends Kirki_Controls_Checkbox_Control {

		/**
		 * The control type.
		 *
		 * @access public
		 * @var string
		 */
		public $type = 'kirki-switch';

		/**
		 * Enqueue control related scripts/styles.
		 *
		 * @access public
		 */
		public function enqueue() {
			wp_enqueue_script( 'kirki-switch' );
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
			<style>
			#customize-control-{{ data.id }} .switch label {
				width: calc({{ data.choices['on'].length }}ch + {{ data.choices['off'].length }}ch + 40px);
			}
			#customize-control-{{ data.id }} .switch label:after {
				width: calc({{ data.choices['on'].length }}ch + 10px);
			}
			#customize-control-{{ data.id }} .switch input:checked + label:after {
				left: calc({{ data.choices['on'].length }}ch + 25px);
				width: calc({{ data.choices['off'].length }}ch + 10px);
			}
			</style>
			<div class="switch<# if ( data.choices['round'] ) { #> round<# } #>">
				<span class="customize-control-title">
					{{{ data.label }}}
				</span>
				<# if ( data.description ) { #>
					<span class="description customize-control-description">{{{ data.description }}}</span>
				<# } #>
				<input name="switch_{{ data.id }}" id="switch_{{ data.id }}" type="checkbox" value="{{ data.value }}" {{{ data.link }}}<# if ( '1' == data.value ) { #> checked<# } #> />
				<label class="switch-label" for="switch_{{ data.id }}">
					<span class="switch-on">{{ data.choices['on'] }}</span>
					<span class="switch-off">{{ data.choices['off'] }}</span>
				</label>
			</div>
			<?php
		}
	}
}
