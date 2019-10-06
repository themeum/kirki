<?php
/**
 * Override field methods
 *
 * @package   kirki-framework/react-color
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Field;

use Kirki\Field;

/**
 * Field overrides.
 *
 * @since 1.0
 */
class ReactColor extends Field {

	/**
	 * The field type.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $type = 'kirki-react-color';

	/**
	 * The control class-name.
	 *
	 * @access protected
	 * @since 0.1
	 * @var string
	 */
	protected $control_class = '\Kirki\Control\ReactColor';

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
				$args['sanitize_callback'] = [ __CLASS__, 'sanitize' ];

				// If this is a hue control then its value should be an integer.
				if ( isset( $args['mode'] ) && 'hue' === $args['mode'] ) {
					$args['sanitize_callback'] = 'absint';
				}
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
			$args         = parent::filter_control_args( $args, $wp_customize );
			$args['type'] = 'kirki-react-color';
		}
		return $args;
	}

	/**
	 * Sanitize colors.
	 *
	 * @static
	 * @access public
	 * @since 1.0.2
	 * @param string $value The color.
	 * @return string
	 */
	public static function sanitize( $value ) {

		// This pattern will check and match 3/6/8-character hex, rgb, rgba, hsl, & hsla colors.
		$pattern = '/^(\#[\da-f]{3}|\#[\da-f]{6}|\#[\da-f]{8}|rgba\(((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*,\s*){2}((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*)(,\s*(0\.\d+|1))\)|hsla\(\s*((\d{1,2}|[1-2]\d{2}|3([0-5]\d|60)))\s*,\s*((\d{1,2}|100)\s*%)\s*,\s*((\d{1,2}|100)\s*%)(,\s*(0\.\d+|1))\)|rgb\(((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*,\s*){2}((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*)|hsl\(\s*((\d{1,2}|[1-2]\d{2}|3([0-5]\d|60)))\s*,\s*((\d{1,2}|100)\s*%)\s*,\s*((\d{1,2}|100)\s*%)\))$/';
		\preg_match( $pattern, $value, $matches );

		// Return the 1st match found.
		if ( isset( $matches[0] ) ) {
			if ( is_string( $matches[0] ) ) {
				return $matches[0];
			}
			if ( is_array( $matches[0] ) && isset( $matches[0][0] ) ) {
				return $matches[0][0];
			}
		}

		// If no match was found, return an empty string.
		return '';
	}
}
