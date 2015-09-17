<?php
/**
 * radio-image Customizer Control.
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
if ( class_exists( 'Kirki_Controls_Radio_Image_Control' ) ) {
	return;
}

class Kirki_Controls_Radio_Image_Control extends WP_Customize_Control {

	public $type = 'radio-image';

	public function enqueue() {
		wp_enqueue_script( 'kirki-radio-image', trailingslashit( kirki_url() ) . 'includes/controls/radio-image/script.js', array( 'jquery', 'jquery-ui-button' ) );
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			wp_enqueue_style( 'kirki-radio-image', trailingslashit( kirki_url() ) . 'includes/controls/radio-image/style.css' );
		}
	}

	public function to_json() {
		parent::to_json();
		$this->json['value']           = $this->value();
		$this->json['choices']         = $this->choices;
		$this->json['link']            = $this->get_link();
	}

	public function content_template() { ?>
		<label class="customizer-text">
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>
		<div id="input_{{ data.id }}" class="image">
			<# for ( key in data.choices ) { #>
				<input class="image-select" type="radio" value="{{ key }}" name="_customize-radio-{{ data.id }}" id="{{ data.id }}{{ key }}" {{{ data.link }}}<# if ( data.value === key ) { #> checked="checked"<# } #>>
					<label for="{{ data.id }}{{ key }}">
						<img src="{{ data.choices[ key ] }}">
					</label>
				</input>
			<# } #>
		</div>
		<?php
	}

}
