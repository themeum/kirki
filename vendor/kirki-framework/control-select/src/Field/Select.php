<?php
/**
 * Override field methods
 *
 * @package   kirki-framework/control-select
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Field;

use Kirki\Core\Field;

/**
 * Field overrides.
 *
 * @since 1.0
 */
class Select extends Field {

	/**
	 * Use only on select controls.
	 * Defines if this is a multi-select or not.
	 * If value is > 1, then the maximum number of selectable options
	 * is the number defined here.
	 *
	 * @access protected
	 * @since 1.0
	 * @var integer
	 */
	protected $multiple = 1;

	/**
	 * Placeholder text.
	 *
	 * @access protected
	 * @since 1.0
	 * @var string|false
	 */
	protected $placeholder = false;

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_type() {
		$this->type = 'kirki-select';
	}

	/**
	 * Sets the $multiple
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_multiple() {
		$this->multiple = absint( $this->multiple );
	}

	/**
	 * Sets the $sanitize_callback
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_sanitize_callback() {
		if ( empty( $this->sanitize_callback ) ) {
			$this->sanitize_callback = [ $this, 'sanitize' ];
		}
	}

	/**
	 * Sanitizes select control values.
	 *
	 * @access public
	 * @since 1.0
	 * @param array $value The value.
	 * @return string|array
	 */
	public function sanitize( $value ) {
		if ( is_array( $value ) ) {
			foreach ( $value as $key => $subvalue ) {
				if ( '' !== $subvalue || isset( $this->choices[''] ) ) {
					$key           = sanitize_key( $key );
					$value[ $key ] = sanitize_text_field( $subvalue );
				}
			}
			return $value;
		}
		return sanitize_text_field( $value );
	}

	/**
	 * Sets the default value.
	 *
	 * @access protected
	 * @since 3.0.0
	 */
	protected function set_default() {
		if ( 1 < $this->multiple && ! is_array( $this->default ) ) {
			$this->default = [ $this->default ];
		}
	}
}
