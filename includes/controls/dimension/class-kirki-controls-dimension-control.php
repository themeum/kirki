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

		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			wp_enqueue_style( 'kirki-dimension', trailingslashit( kirki_url() ).'includes/controls/dimension/style.css' );
		}
		wp_enqueue_script( 'kirki-dimension', trailingslashit( kirki_url() ).'includes/controls/dimension/script.js', array( 'jquery' ) );

	}

	public function to_json() {
		parent::to_json();
		$this->json['value']           = $this->value();
		$this->json['choices']         = $this->choices;
		$this->json['link']            = $this->get_link();
		$this->json['numeric_value']   = $this->numeric_value();
		$this->json['unit_value']      = $this->unit_value();
		$this->json['available_units'] = $this->get_units();
	}

	public function content_template() { ?>
		<label class="customizer-text">
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<input type="number" min="0" step="any" value="{{ data.numeric_value }}"/>
			<select>
				<# for ( key in data.available_units ) { #>
					<option value="{{ data.available_units[ key ] }}" <# if ( data.available_units[ key ] === data.unit_value ) { #> selected <# } #>>
						{{ data.available_units[ key ] }}
					</option>
				<# } #>
			</select>
		</label>
		<?php
	}

	/**
	 * Get the array of units we're using.
	 *
	 * @return  array
	 */
	public function get_units() {
		$all_units = array( 'em', 'ex', '%', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ch', 'rem', 'vh', 'vw', 'vmin', 'vmax' );
		$defaults  = array( 'px', '%', 'em' );
		if ( isset( $this->choices ) && is_array( $this->choices ) && ! empty( $this->choices ) ) {
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
	 * Get the numeric value of the field
	 *
	 * @return  float|int
	 */
	public function numeric_value() {
		// Sanitize the input field and return numeric values, rounded to 2 decimals.
		return round( filter_var( $this->value(), FILTER_SANITIZE_NUMBER_FLOAT ), 2 );
	}

	/**
	 * Get the value of the units we're using.
	 *
	 * @return  string
	 */
	public function unit_value() {
		foreach ( $this->get_units() as $unit ) {
			if ( false !== strpos( $this->value(), $unit ) ) {
				$located_unit = $unit;
				break;
			}
		}
		return ( isset( $located_unit ) ) ? $located_unit : 'px';
	}
}
