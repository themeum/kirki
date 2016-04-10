<?php
/**
 * Customizer Control: kirki-radio.
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

if ( ! class_exists( 'Kirki_Controls_Radio_Control' ) ) {

	/**
	 * Radio control
	 */
	class Kirki_Controls_Radio_Control extends Kirki_Customize_Control {

		/**
		 * The control type.
		 *
		 * @access public
		 * @var string
		 */
		public $type = 'kirki-radio';

		/**
		 * Enqueue control related scripts/styles.
		 *
		 * @access public
		 */
		public function enqueue() {
			wp_enqueue_script( 'kirki-radio' );
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
			<# if ( ! data.choices ) { return; } #>

			<# if ( data.tooltip ) { #>
				<a href="#" class="tooltip hint--left" data-hint="{{ data.tooltip }}"><span class='dashicons dashicons-info'></span></a>
			<# } #>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{ data.label }}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<# for ( key in data.choices ) { #>
				<label>
					<input type="radio" value="{{ key }}" name="_customize-radio-{{ data.id }}" {{{ data.link }}}<# if ( data.value === key ) { #> checked<# } #> />
					<# if ( _.isArray( data.choices[ key ] ) ) { #>
						{{ data.choices[ key ][0] }}
						<span class="option-description">{{ data.choices[ key ][1] }}</span>
					<# } else { #>
						{{ data.choices[ key ] }}
					<# } #>
				</label>
			<# } #>
			<?php
		}
	}
}
