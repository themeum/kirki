<?php
/**
 * Customizer Control: kirki-checkbox.
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

if ( ! class_exists( 'Kirki_Controls_Checkbox_Control' ) ) {

	/**
	 * Creates a checkbox control in the customizer.
	 * This is an almost verbatim copy of WordPress core's implementation
	 * but we converted the template to use Underscore.js, and added the tooltip.
	 */
	class Kirki_Controls_Checkbox_Control extends Kirki_Customize_Control {

		/**
		 * The control type.
		 *
		 * @access public
		 * @var string
		 */
		public $type = 'kirki-checkbox';

		/**
		 * Enqueue control related scripts/styles.
		 *
		 * @access public
		 */
		public function enqueue() {
			wp_enqueue_script( 'kirki-checkbox' );
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
			<label>
				<input type="checkbox" value="{{ data.value }}" {{{ data.link }}}<# if ( '1' === data.value || 1 === data.value || true === data.value || 'on' === data.value ) { #> checked<# } #> />
				{{ data.label }}
				<# if ( data.description ) { #>
					<span class="description customize-control-description">{{{ data.description }}}</span>
				<# } #>
			</label>
			<?php
		}
	}
}
