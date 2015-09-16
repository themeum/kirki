<?php
/**
 * radio-buttonset Customizer Control.
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
if ( class_exists( 'Kirki_Controls_Radio_Buttonset_Control' ) ) {
	return;
}

class Kirki_Controls_Radio_Buttonset_Control extends WP_Customize_Control {

	public $type = 'radio-buttonset';

	public function enqueue() {
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			wp_enqueue_style( 'kirki-radio-buttonset', trailingslashit( kirki_url() ) . 'includes/controls/radio-buttonset/style.css' );
		}
		wp_enqueue_script( 'kirki-radio-buttonset', trailingslashit( kirki_url() ) . 'includes/controls/radio-buttonset/script.js', array( 'jquery' ) );
	}

	public function to_json() {
		parent::to_json();
		$this->json['id']      = $this->id;
		$this->json['choices'] = $this->choices;
		$this->json['link']    = $this->get_link();
		$this->json['value']   = $this->value();
	}

	public function content_template() { ?>
		<# if ( data.label ) { #>
			<span class="customize-control-title">{{{ data.label }}}</span>
		<# } #>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		<div id="input_<?php echo $this->id; ?>" class="buttonset">
			<# for ( key in data.choices ) { #>
				<input class="switch-input" type="radio" value="{{ key }}" name="_customize-radio-{{{ data.id }}}" id="{{ data.id }}{{ key }}" {{{ data.link }}}<# if ( key === data.value ) { #> checked="checked" <# } #>>
					<label class="switch-label switch-label-<# if ( key === data.value ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}{{ key }}">
						{{ data.choices[ key ] }}
					</label>
				</input>
			<# } #>
		</div>
		<?php
	}

}
