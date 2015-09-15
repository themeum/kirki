<?php
/**
 * slider Customizer Control.
 *
 * Creates a jQuery slider control.
 * TODO: Migrate to an HTML5 range control. Range control are hard to style 'cause they don't display the value
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
if ( class_exists( 'Kirki_Controls_Slider_Control' ) ) {
	return;
}

class Kirki_Controls_Slider_Control extends WP_Customize_Control {

	public $type = 'slider';

	public function enqueue() {

		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			wp_enqueue_style( 'kirki-slider', trailingslashit( kirki_url() ) . 'includes/controls/slider/style.css' );
		}
		wp_enqueue_script( 'kirki-slider', trailingslashit( kirki_url() ) . 'includes/controls/slider/script.js', array( 'jquery' ) );

	}

	public function render_content() { ?>
		<label>

			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
				<?php if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo $this->description; ?></span>
				<?php endif; ?>
			</span>
			<div class="wrapper">
				<?php
				/**
				 * Get the defined min, max & step values
				 */
				$min  = ( $this->choices['min'] ) ? esc_attr( $this->choices['min'] ) : '0';
				$max  = ( $this->choices['max'] ) ? esc_attr( $this->choices['max'] ) : '100';
				$step = ( $this->choices['step'] ) ? esc_attr( $this->choices['step'] ) : '1';
				?>
				<?php
				/**
				 * Create the input
				 */
				?>
				<input type="range" min="<?php echo esc_attr( $min ); ?>" max="<?php echo esc_attr( $max ); ?>" step="<?php echo esc_attr( $step ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> data-reset_value="<?php echo esc_attr( $this->setting->default ); ?>" />
				<?php
				/**
				 * Append the value
				 */
				?>
				<div class="kirki_range_value">
					<span class="value"><?php echo esc_attr( $this->value() ); ?></span>
					<?php if ( isset( $this->choices['suffix'] ) && '' != $this->choices['suffix'] ) : ?>
						<?php echo esc_attr( $this->choices['suffix'] ); ?>
					<?php endif; ?>
				</div>
				<?php
				/**
				 * Add the reset button
				 * We can disable the reset button by adding to our options:
				 * 'reset' => false
				 */
				?>
				<?php if ( ! isset( $this->choices['reset'] ) || false != $this->choices['reset'] ) : ?>
					<div class="kirki-slider-reset">
						<span class="dashicons dashicons-image-rotate"></span>
					</div>
				<?php endif; ?>
			</div>
		</label>
		<?php

	}
}
