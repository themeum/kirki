<?php
/**
 * dimension Customizer Control.
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
if ( class_exists( 'Kirki_Controls_Dimension_Control' ) ) {
	return;
}

class Kirki_Controls_Dimension_Control extends WP_Customize_Control {

	public $type = 'dimension';

	public function enqueue() {

		wp_enqueue_style( 'kirki-dimension', trailingslashit( kirki_url() ).'includes/controls/dimension/style.css' );
		wp_enqueue_script( 'kirki-dimension', trailingslashit( kirki_url() ).'includes/controls/dimension/kirki-dimension.js', array( 'jquery' ) );

	}

	public function render_content() { ?>

		<label class="customizer-text">
			<span class="customize-control-title">
				<?php echo esc_attr( $this->label ); ?>
				<?php if ( ! empty( $this->description ) ) : ?>
					<?php // The description has already been sanitized in the Fields class, no need to re-sanitize it. ?>
					<span class="description customize-control-description"><?php echo $this->description; ?></span>
				<?php endif; ?>
			</span>
			<input type="text" value="<?php echo esc_attr( $this->numeric_value() ); ?>"/>
			<select <?php $this->link(); ?>>
				<?php foreach ( $this->get_units() as $unit ) : ?>
					<option value="<?php echo esc_attr( $unit ); ?>" <?php echo selected( $this->unit_value(), $unit, false ); ?>>
						<?php echo $unit; ?>
					</option>
				<?php endforeach; ?>
			</select>
			<input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr( $this->numeric_value() . $this->unit_value() ); ?>" />
		</label>
		<?php
	}

	/**
	 * Get the numeric value of the field
	 *
	 * @return  float|int
	 */
	public function numeric_value() {
		return filter_var( $this->value(), FILTER_SANITIZE_NUMBER_FLOAT );
	}

	/**
	 * Get the array of units we're using.
	 *
	 * @return  array
	 */
	public function get_units() {
		$all_units = array( 'em', 'ex', '%', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ch', 'rem', 'vh', 'vw', 'vmin', 'vmax' );
		$defaults  = array( 'px', '%', 'em' );
		if ( isset( $this->choices ) && is_array( $this->choices ) ) {
			$choices = array();
			foreach ( $this->choices as $choice ) {
				if ( in_array( $choice, $all_units ) ) {
					$choices[] = $choice;
				}
			}
			if ( ! empty( $choices ) ) {
				return $choices;
			}
		}

		return $defaults;
	}

	/**
	 * Get the value of the units we're using.
	 *
	 * @return  string
	 */
	public function unit_value() {
		foreach ( $this->get_units() as $unit ) {
			if ( false !== strpos( $this->value, $unit ) ) {
				$located_unit = $unit;
				break;
			}
		}
		return ( isset( $located_unit ) ) ? $located_unit : 'px';
	}
}
