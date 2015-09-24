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
class Kirki_Controls_Number_Control extends WP_Customize_Control {

	public $type = 'number';

	public function to_json() {
		parent::to_json();
		$this->json['value'] = $this->value();
		$this->json['choices'] = $this->choices;
		$this->json['link'] = $this->get_link();
	}

	public function enqueue() {
		Kirki_Styles_Customizer::enqueue_customizer_control_script( 'formstone', 'vendor/formstone-core', array( 'jquery' ) );
		Kirki_Styles_Customizer::enqueue_customizer_control_script( 'formstone-number', 'vendor/formstone-number', array( 'jquery', 'formstone' ) );
		Kirki_Styles_Customizer::enqueue_customizer_control_script( 'kirki-number', 'controls/number', array( 'jquery', 'formstone', 'formstone-number' ) );
	}

	public function content_template() {
		?>
		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<div class="customize-control-content">
				<input type="number" {{{ data.link }}} value="{{ data.value }}"
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
