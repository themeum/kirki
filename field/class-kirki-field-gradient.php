<?php
/**
 * Override field methods
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0.0
 */

/**
 * Field overrides.
 */
class Kirki_Field_Gradient extends Kirki_Field {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {

		$this->type = 'kirki-gradient';

	}

	/**
	 * Sets the $choices
	 *
	 * @access protected
	 */
	protected function set_choices() {

		if ( ! is_array( $this->choices ) ) {
			$this->choices = array();
		}

		$defaults = array(
			'alpha'   => true,
			'preview' => array(
				'width'  => '100%',
				'height' => '60px',
			),
		);
		$this->choices = wp_parse_args( $this->choices, $defaults );

	}

	/**
	 * Sets the $sanitize_callback.
	 *
	 * @access protected
	 */
	protected function set_sanitize_callback() {

		$this->sanitize_callback = array( $this, 'sanitize' );

	}

	/**
	 * Sets the $transport.
	 *
	 * @access protected
	 */
	protected function set_transport() {
		$this->transport = 'refresh';
	}

	/**
	 * Sanitizes checkbox values.
	 *
	 * @access public
	 * @param boolean|integer|string|null $value The checkbox value.
	 * @return array
	 */
	public function sanitize( $value = null ) {

		// Make sure value in an array.
		$value = (array) $value;

		// Sanitize the type.
		if ( ! isset( $value['mode'] ) || 'linear' !== $value['mode'] || 'radial' !== $value['mode'] ) {
			$value['mode'] = 'linear';
		}
		foreach ( array( 'start', 'end' ) as $context ) {

			// Make sure value is array.
			if ( ! isset( $value[ $context ] ) ) {
				$value[ $context ] = array();
			}

			// Make sure color is defined.
			if ( ! isset( $value[ $context ]['color'] ) ) {
				$value[ $context ]['color'] = '';
			}
			// Sanitize colors.
			$color_obj = ariColor::newColor( $value[ $context ]['color'] );
			$value[ $context ]['color'] = $color_obj->toCSS( $color_obj->mode );

			// Make sure position is defined.
			if ( ! isset( $value[ $context ]['position'] ) ) {
				$value[ $context ]['position'] = 0;
			};
			// Sanitize positions.
			$value[ $context ]['position'] = (int) $value[ $context ]['position'];
			$value[ $context ]['position'] = max( min( $value[ $context ]['position'], 100 ), 0 );
		}

		// Make siure angle exists.
		if ( ! isset( $value['angle'] ) ) {
			$value['angle'] = 0;
		}
		// Sanitize angle.
		$value['angle'] = (int) $value['angle'];
		$value['angle'] = max( min( $value['angle'], 90 ), -90 );

		return $value;

	}

}
