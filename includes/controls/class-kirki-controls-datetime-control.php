<?php
/**
 * Datetime Field Control.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Controls_Datetime_Control' ) ) {
	class Kirki_Controls_Datetime_Control extends Kirki_Customize_Control {

		public $type = 'kirki-datetime';

		public function enqueue() {
			wp_enqueue_script( 'jquery-ui-datepicker', array( 'jquery', 'jquery-ui' ) );
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
					<input class="datepicker" type="text" id={{ data.id }}" value="{{ data.value }}" {{{ data.link }}} />
					<!-- <input class="timepicker" type="text" id={{ data.id }}" value="{{ data.value }}" {{{ data.link }}} /> -->
				</div>
			</label>
			<?php
		}

	}
}
