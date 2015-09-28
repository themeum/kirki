<?php
/**
 * select2 Customizer Control.
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
if ( class_exists( 'Kirki_Controls_Preset_Control' ) ) {
	return;
}

class Kirki_Controls_Preset_Control extends WP_Customize_Control {

	public $type = 'preset';

	public $multiple = 1;

	public function to_json() {
		parent::to_json();

		$this->json['value']    = $this->value();
		$this->json['choices']  = $this->choices;
		$this->json['link']     = $this->get_link();
	}

	public function enqueue() {
		Kirki_Styles_Customizer::enqueue_customizer_control_script( 'selectize', 'vendor/selectize', array( 'jquery' ) );
		Kirki_Styles_Customizer::enqueue_customizer_control_script( 'kirki-select', 'controls/select', array( 'jquery', 'selectize' ) );
	}

	public function render_content() {}

	protected function content_template() { ?>

		<# if ( ! data.choices ) return; #>
		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{ data.label }}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<select {{{ data.link }}} data-multiple="1">
				<# for ( key in data.choices ) { #>
					<option value="{{ key }}"<# if ( key === data.value ) { #>selected<# } #>>
						{{ data.choices[ key ]['label'] }}
					</option>
				<# } #>
			</select>
		</label>
		<?php
	}
}
