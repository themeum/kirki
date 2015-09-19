<?php
/**
 * textarea Customizer Control.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2015, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.1
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Early exit if the class already exists
if ( class_exists( 'Kirki_Controls_Textarea_Control' ) ) {
	return;
}

/**
 * Create a simple textarea control
 */
class Kirki_Controls_Textarea_Control extends WP_Customize_Control {

	public $type = 'kirki-textarea';

	public function to_json() {
		parent::to_json();
		$this->json['value'] = $this->value();
		$this->json['link'] = $this->get_link();
	}

	public function enqueue() {
		wp_enqueue_script( 'kirki-textarea', trailingslashit( kirki_url() ) . 'includes/controls/textarea/script.js', array( 'jquery', 'formstone', 'formstone-number' ) );
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
				<textarea class="textarea" rows="5" {{{ data.link }}}>{{ data.value }}</textarea>
			</div>
		</label>
		<?php
	}

}
