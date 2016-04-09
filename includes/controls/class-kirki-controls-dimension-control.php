<?php
/**
 * Customizer Control: dimension
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Controls_Dimension_Control' ) ) {
	class Kirki_Controls_Dimension_Control extends Kirki_Customize_Control {

		public $type = 'dimension';

		public function enqueue() {
			wp_enqueue_script( 'kirki-dimension' );
		}

		protected function content_template() { ?>
			<# if ( data.tooltip ) { #>
				<a href="#" class="tooltip hint--left" data-hint="{{ data.tooltip }}"><span class='dashicons dashicons-info'></span></a>
			<# } #>
			<label class="customizer-text">
				<# if ( data.label ) { #>
					<span class="customize-control-title">{{{ data.label }}}</span>
				<# } #>
				<# if ( data.description ) { #>
					<span class="description customize-control-description">{{{ data.description }}}</span>
				<# } #>
				<div class="input-wrapper">
					<input type="text" value="{{ data.value }}"/>
					<span class="invalid-value">{{ data.i18n['invalid-value'] }}</span>
				</div>
			</label>
			<?php
		}

	}
}
