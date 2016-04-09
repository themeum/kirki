<?php
/**
 * Customizer Control: number.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2015, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
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
			wp_enqueue_script( 'kirki-number' );
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
