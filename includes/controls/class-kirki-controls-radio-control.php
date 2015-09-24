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
if ( class_exists( 'Kirki_Controls_Radio_Control' ) ) {
	return;
}

class Kirki_Controls_Radio_Control extends WP_Customize_Control {

	public $type = 'kirki-radio';

	public function to_json() {
		parent::to_json();

		$this->json['value']   = $this->value();
		$this->json['link']    = $this->get_link();
		$this->json['choices'] = $this->choices;
		$this->json['id']      = $this->id;
	}

	public function enqueue() {
		Kirki_Styles_Customizer::enqueue_customizer_control_script( 'kirki-radio', 'controls/radio', array( 'jquery' ) );
	}

	protected function content_template() { ?>
		<# if ( ! data.choices ) { return; } #>

		<# if ( data.label ) { #>
			<span class="customize-control-title">{{ data.label }}</span>
		<# } #>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{ data.description }}</span>
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
