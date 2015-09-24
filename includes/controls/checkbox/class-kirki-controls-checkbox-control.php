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
if ( class_exists( 'Kirki_Controls_Checkbox_Control' ) ) {
	return;
}

class Kirki_Controls_Checkbox_Control extends WP_Customize_Control {

	public $type = 'kirki-checkbox';

	public function to_json() {
		parent::to_json();

		$this->json['value']    = $this->value();
		$this->json['link']     = $this->get_link();
	}

	public function enqueue() {
		wp_enqueue_script( 'kirki-checkbox', trailingslashit( kirki_url() ) . 'includes/controls/checkbox/script.js', array( 'jquery' ) );
	}

	protected function content_template() { ?>
		<label>
			<input type="checkbox" value="{{ data.value }}" {{{ data.link }}}<# if ( data.value ) { #> checked<# } #> />
			{{ data.label }}
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>
		<?php
	}

}
