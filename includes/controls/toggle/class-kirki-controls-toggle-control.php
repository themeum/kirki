<?php
/**
 * toggle Customizer Control.
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
if ( class_exists( 'Kirki_Controls_Toggle_Control' ) ) {
	return;
}

class Kirki_Controls_Toggle_Control extends WP_Customize_Control {

	public $type = 'toggle';

	public function enqueue() {
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			wp_enqueue_style( 'kirki-toggle', trailingslashit( kirki_url() ) . 'includes/controls/toggle/style.css' );
		}
		wp_enqueue_script( 'kirki-toggle', trailingslashit( kirki_url() ) . 'includes/controls/toggle/script.js', array( 'jquery' ) );
	}

	public function to_json() {
		parent::to_json();
		$this->json['id']      = $this->id;
		$this->json['value']   = $this->value();
		$this->json['choices'] = $this->choices;
		$this->json['link']    = $this->get_link();
	}

	protected function content_template() { ?>
		<label for="toggle_{{ data.id }}">
			<span class="customize-control-title">
				{{{ data.label }}}
				<# if ( data.description ) { #>
					<span class="description customize-control-description">{{{ data.description }}}</span>
				<# } #>
			</span>
			<input name="toggle_{{ data.id }}" id="toggle_{{ data.id }}" type="checkbox" value="{{ data.value }}" {{{ data.link }}}<# if ( '1' == data.value ) { #> checked<# } #> hidden />
			<span  class="switch"></span>
		</label>
		<?php
	}
}
