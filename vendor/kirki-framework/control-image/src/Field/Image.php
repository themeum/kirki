<?php
/**
 * Override field methods
 *
 * @package   kirki-framework/control-image
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Field;

use Kirki\Core\Field;

/**
 * Field overrides.
 */
class Image extends Field {

	/**
	 * Custom labels.
	 * This only exists here for backwards-compatibility purposes.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $button_labels = [];

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_type() {
		$this->type = 'kirki-image';
	}

	/**
	 * Sets the button labels.
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_button_labels() {
		$this->button_labels = wp_parse_args(
			$this->button_labels,
			[
				'select'       => esc_html__( 'Select image', 'kirki' ),
				'change'       => esc_html__( 'Change image', 'kirki' ),
				'default'      => esc_html__( 'Default', 'kirki' ),
				'remove'       => esc_html__( 'Remove', 'kirki' ),
				'placeholder'  => esc_html__( 'No image selected', 'kirki' ),
				'frame_title'  => esc_html__( 'Select image', 'kirki' ),
				'frame_button' => esc_html__( 'Choose image', 'kirki' ),
			]
		);
	}

	/**
	 * Set the choices.
	 * Adds a pseudo-element "controls" that helps with the JS API.
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_choices() {
		if ( ! is_array( $this->choices ) ) {
			$this->choices = (array) $this->choices;
		}
		if ( ! isset( $this->choices['save_as'] ) ) {
			$this->choices['save_as'] = 'url';
		}
		if ( ! isset( $this->choices['labels'] ) ) {
			$this->choices['labels'] = [];
		}
		$this->set_button_labels();
		$this->choices['labels'] = wp_parse_args( $this->choices['labels'], $this->button_labels );
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
	 * The sanitize method that will be used as a falback
	 *
	 * @access public
	 * @since 1.0
	 * @param string|array|int $value The control's value.
	 * @return string|array
	 */
	public function sanitize( $value ) {
		if ( isset( $this->choices['save_as'] ) && 'array' === $this->choices['save_as'] ) {
			return [
				'id'     => ( isset( $value['id'] ) && '' !== $value['id'] ) ? (int) $value['id'] : '',
				'url'    => ( isset( $value['url'] ) && '' !== $value['url'] ) ? esc_url_raw( $value['url'] ) : '',
				'width'  => ( isset( $value['width'] ) && '' !== $value['width'] ) ? (int) $value['width'] : '',
				'height' => ( isset( $value['height'] ) && '' !== $value['height'] ) ? (int) $value['height'] : '',
			];
		}
		if ( isset( $this->choices['save_as'] ) && 'id' === $this->choices['save_as'] ) {
			return absint( $value );
		}
		return ( is_string( $value ) ) ? esc_url_raw( $value ) : $value;
	}
}
