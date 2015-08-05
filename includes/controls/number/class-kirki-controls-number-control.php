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

	public function enqueue() {

		wp_enqueue_script( 'formstone', trailingslashit( kirki_url() ).'includes/controls/number/formstone-core.js', array( 'jquery' ) );
		wp_enqueue_script( 'formstone-number', trailingslashit( kirki_url() ).'includes/controls/number/formstone-number.js', array( 'jquery', 'formstone' ) );
		wp_enqueue_style( 'kirki-number', trailingslashit( kirki_url() ).'includes/controls/number/style.css' );

	}

	public function render_content() {

		if ( ! empty( $this->choices ) ) {
			$min  = ( isset( $this->choices['min'] ) ) ? ' min="'.esc_attr( $this->choices['min'] ).'"' : '';
			$max  = ( isset( $this->choices['max'] ) ) ? ' max="'.esc_attr( $this->choices['max'] ).'"' : '';
			$step = ( isset( $this->choices['step'] ) ) ? ' step="'.esc_attr( $this->choices['step'] ).'"' : '';
		} else {
			$min  = '';
			$max  = '';
			$step = '';
		}
		?>

		<label class="customizer-text">
			<span class="customize-control-title">
				<?php echo esc_attr( $this->label ); ?>
				<?php if ( ! empty( $this->description ) ) : ?>
					<?php // The description has already been sanitized in the Fields class, no need to re-sanitize it. ?>
					<span class="description customize-control-description"><?php echo $this->description; ?></span>
				<?php endif; ?>
			</span>
			<input type="number"<?php echo $min.$max.$step; ?> <?php $this->link(); ?> value="<?php echo intval( $this->value() ); ?>"/>
		</label>
		<script>
			jQuery(document).ready(function($) {
				"use strict";
				$( "#customize-control-<?php echo $this->id; ?> input[type='number']").number();
			});
		</script>

		<?php
	}
}
