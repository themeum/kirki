<?php
/**
 * number Customizer Control.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2015, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Controls_Number_Control' ) ) {
	/**
	 * Create a simple number control
	 */
	class Kirki_Controls_Number_Control extends Kirki_Customize_Control {

		public $type = 'number';

		public function enqueue() {
			Kirki_Styles_Customizer::enqueue_customizer_control_script( 'jquery-ui-spinner', 'vendor/jquery-ui-spinner', array( 'jquery', 'jquery-ui-core', 'jquery-ui-button' ) );
			Kirki_Styles_Customizer::enqueue_customizer_control_script( 'kirki-number', 'controls/number', array( 'jquery', 'formstone', 'formstone-number' ) );
		}

		protected function content_template() { ?>
			<# if ( data.tooltip ) { #>
				<a href="#" class="tooltip hint--left" data-hint="{{ data.tooltip }}"><span class='dashicons dashicons-info'></span></a>
			<# } #>
			<label>
				<# if ( data.label ) { #>
					<span class="customize-control-title">{{{ data.label }}}</span>
				<# } #>
				<# if ( data.description ) { #>
					<span class="description customize-control-description">{{{ data.description }}}</span>
				<# } #>
				<div class="customize-control-content">
					<input type="text" {{{ data.link }}} value="{{ data.value }}" />
				</div>
			</label>
			<?php
		}

	}
}
