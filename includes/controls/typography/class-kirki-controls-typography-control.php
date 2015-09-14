<?php
/**
 * typography Customizer Control.
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
if ( class_exists( 'Kirki_Controls_Typography_Control' ) ) {
	return;
}

class Kirki_Controls_Typography_Control extends WP_Customize_Control {

	public $type = 'typography';

	public function enqueue() {

		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			wp_enqueue_style( 'kirki-typography', trailingslashit( kirki_url() ) . 'includes/controls/typography/style.css' );
		}
		wp_enqueue_script( 'kirki-typography', trailingslashit( kirki_url() ) . 'includes/controls/typography/script.js', array( 'jquery' ) );

	}

	public function render_content() { ?>
		<?php if ( isset( $this->choices['font-style'] ) && $this->choices['font-style'] ) : ?>
			<?php
			/**
			 * Create controls for font-styles
			 */
			?>
			<div class="font-style">
				<h5>font-style</h5>
				<label>
					<input type="checkbox">
					<span class="dashicons dashicons-editor-bold"></span>
				</label>
				<label>
					<input type="checkbox">
					<span class="dashicons dashicons-editor-italic"></span>
				</label>
				<label>
					<input type="checkbox">
					<span class="dashicons dashicons-editor-underline"></span>
				</label>
			</div>
		<?php endif; ?>

		<?php if ( isset( $this->choices['font-family'] ) && $this->choices['font-family'] ) : ?>
			<?php
			/**
			 * Get font-families
			 */
			?>
			<div class="font-family">
				<h5>font-family</h5>
				<select>
					<?php foreach( $this->get_all_fonts() as $font => $label ) : ?>
						<option value="<?php echo $font; ?>"><?php echo $font; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		<?php endif; ?>

		<?php if ( isset( $this->choices['font-size'] ) && $this->choices['font-size'] ) : ?>
			<?php
			/**
			 * font-size
			 */
			?>
			<div class="font-size">
				<h5>font-size</h5>
				<input type="range" min="1" max="100" step="1" />
			</div>
		<?php endif; ?>

		<?php if ( isset( $this->choices['font-weight'] ) && $this->choices['font-weight'] ) : ?>
			<?php
			/**
			 * font-weights
			 */
			?>
			<div class="font-weight">
				<h5>font-weight</h5>
				<input type="range" min="100" max="900" step="100" />
			</div>
		<?php endif; ?>

		<?php if ( isset( $this->choices['line-height'] ) && $this->choices['line-height'] ) : ?>
			<?php
			/**
			 * line-height
			 */
			?>
			<div class="line-height">
				<h5>line-height</h5>
				<input type="range" min="0" max="4" step="0.01" />
			</div>
		<?php endif; ?>

		<?php if ( isset( $this->choices['letter-spacing'] ) && $this->choices['letter-spacing'] ) : ?>
			<?php
			/**
			 * letter-spacing
			 */
			?>
			<div class="line-height">
				<h5>letter-spacing</h5>
				<input type="range" min="-4" max="4" step="0.01" />
			</div>
		<?php endif; ?>

		<?php
	}

	public function get_standard_fonts() {
		return Kirki()->font_registry->get_standard_fonts();
	}

	public function get_google_fonts() {
		return Kirki()->font_registry->get_google_fonts();
	}

	public function get_all_fonts() {
		return Kirki()->font_registry->get_all_fonts();
	}

}
