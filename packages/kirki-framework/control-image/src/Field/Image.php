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

use Kirki\Field;

/**
 * Field overrides.
 */
class Image extends Field {

	/**
	 * The control class-name.
	 *
	 * @access protected
	 * @since 0.1
	 * @var string
	 */
	protected $control_class = '\Kirki\Control\Image';

	/**
	 * Whether we should register the control class for JS-templating or not.
	 *
	 * @access protected
	 * @since 0.1
	 * @var bool
	 */
	protected $control_has_js_template = true;

	/**
	 * Filter arguments before creating the setting.
	 *
	 * @access public
	 * @since 0.1
	 * @param array                $args         The field arguments.
	 * @param WP_Customize_Manager $wp_customize The customizer instance.
	 * @return array
	 */
	public function filter_setting_args( $args, $wp_customize ) {
		if ( $args['settings'] === $this->args['settings'] ) {
			$args = parent::filter_setting_args( $args, $wp_customize );

			// Set the sanitize-callback if none is defined.
			if ( ! isset( $args['sanitize_callback'] ) || ! $args['sanitize_callback'] ) {
				$args['sanitize_callback'] = function( $value ) {
					if ( isset( $this->args['choices']['save_as'] ) && 'array' === $this->args['choices']['save_as'] ) {
						return [
							'id'     => ( isset( $value['id'] ) && '' !== $value['id'] ) ? (int) $value['id'] : '',
							'url'    => ( isset( $value['url'] ) && '' !== $value['url'] ) ? esc_url_raw( $value['url'] ) : '',
							'width'  => ( isset( $value['width'] ) && '' !== $value['width'] ) ? (int) $value['width'] : '',
							'height' => ( isset( $value['height'] ) && '' !== $value['height'] ) ? (int) $value['height'] : '',
						];
					}
					if ( isset( $this->args['choices']['save_as'] ) && 'id' === $this->args['choices']['save_as'] ) {
						return absint( $value );
					}
					return ( is_string( $value ) ) ? esc_url_raw( $value ) : $value;		
				};
			}
		}
		return $args;
	}

	/**
	 * Filter arguments before creating the control.
	 *
	 * @access public
	 * @since 0.1
	 * @param array                $args         The field arguments.
	 * @param WP_Customize_Manager $wp_customize The customizer instance.
	 * @return array
	 */
	public function filter_control_args( $args, $wp_customize ) {
		if ( $args['settings'] === $this->args['settings'] ) {
			$args = parent::filter_control_args( $args, $wp_customize );

			$args['button_labels'] = isset( $args['button_labels'] ) ? $args['button_labels'] : [];
			$args['button_labels'] = wp_parse_args(
				$args['button_labels'],
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

			$args['choices']            = isset( $args['choices'] ) ? (array) $args['choices'] : [];
			$args['choices']['save_as'] = isset( $args['choices']['save_as'] ) ? $args['choices']['save_as'] : 'url';
			$args['choices']['labels']  = isset( $args['choices']['labels'] ) ? $args['choices']['labels'] : [];
			$args['choices']['labels']  = wp_parse_args( $args['choices']['labels'], $args['button_labels'] );

			// Set the control-type.
			$args['type'] = 'kirki-image';
		}
		return $args;
	}
}
