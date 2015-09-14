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
		if ( ! empty( $this->choices ) ) {
			$this->json['min']  = ( isset( $this->choices['min'] ) ) ? 'min="' . esc_attr( $this->choices['min'] ) . '"' : '';
			$this->json['max']  = ( isset( $this->choices['max'] ) ) ? 'max="' . esc_attr( $this->choices['max'] ) . '"' : '';
			$this->json['step'] = ( isset( $this->choices['step'] ) ) ? 'step="' . esc_attr( $this->choices['step'] ) . '"' : '';
		} else {
			$this->json['min']  = '';
			$this->json['max']  = '';
			$this->json['step'] = '';
		}
	}

	public function enqueue() {

		wp_enqueue_script( 'formstone', trailingslashit( kirki_url() ) . 'includes/controls/number/formstone-core.js', array( 'jquery' ) );
		wp_enqueue_script( 'formstone-number', trailingslashit( kirki_url() ) . 'includes/controls/number/formstone-number.js', array( 'jquery', 'formstone' ) );
		wp_enqueue_script( 'kirki-number', trailingslashit( kirki_url() ) . 'includes/controls/number/script.js', array( 'jquery', 'formstone', 'formstone-number' ) );
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			wp_enqueue_style( 'kirki-number', trailingslashit( kirki_url() ) . 'includes/controls/number/style.css' );
		}

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
				<input type="number"{{ data.min }} {{ data.max }} {{ data.step }} <?php $this->link(); ?> value="<?php echo intval( $this->value() ); ?>"/>
			</div>
		</label>
		<?php
	}

}
