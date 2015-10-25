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

// Early exit if the class already exists
if ( class_exists( 'Kirki_Controls_Number_Control' ) ) {
	return;
}

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
		<# if ( data.help ) { #>
			<a href="#" class="tooltip hint--left" data-hint="{{ data.help }}"><span class='dashicons dashicons-info'></span></a>
		<# } #>
		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<div class="customize-control-content">
				<input type="text" {{{ data.link }}} value="{{ data.value }}"
					<# if ( data.choices['min'] ) { #>
						min="{{ data.choices['min'] }}"
					<# } #>
					<# if ( data.choices['max'] ) { #>
						max="{{ data.choices['max'] }}"
					<# } #>
					<# if ( data.choices['step'] ) { #>
						step="{{ data.choices['step'] }}"
					<# } #>
				/>
			</div>
		</label>
		<?php
	}

}
