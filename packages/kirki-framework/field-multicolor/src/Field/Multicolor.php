<?php
/**
 * Override field methods
 *
 * @package   kirki-framework/control-multicolor
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Field;

use Kirki;
use Kirki\Field;

/**
 * Field overrides.
 *
 * @since 1.0
 */
class Multicolor extends Field {

	/**
	 * The field type.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $type = 'kirki-multicolor';

	/**
	 * Extra logic for the field.
	 *
	 * Adds all sub-fields.
	 *
	 * @access public
	 * @param array $args The arguments of the field.
	 */
	public function init( $args ) {

		add_filter( 'kirki_output_control_classnames', [ $this, 'output_control_classnames' ] );

		/**
		 * Add a hidden field, the label & description.
		 */
		new \Kirki\Field\Generic(
			wp_parse_args(
				[
					'type'        => 'kirki-generic',
					'default'     => '',
					'input_attrs' => '',
					'choices'     => [
						'type' => 'hidden',
					],
				],
				$args
			)
		);

		foreach ( $args['choices'] as $choice => $choice_label ) {
			new \Kirki\Field\ReactColor(
				wp_parse_args(
					[
						'settings'       => $args['settings'] . '[' . $choice . ']',
						'parent_setting' => $args['settings'],
						'label'          => '',
						'description'    => $choice_label,
						'default'        => $this->filter_preferred_choice_setting( 'default', $choice, $args ),
						'input_attrs'    => $this->filter_preferred_choice_setting( 'input_attrs', $choice, $args ),
						'choices'        => [
							'alpha' => $this->filter_preferred_choice_setting( 'alpha', $choice, $args ),
						],
						'css_vars'       => [],
						'output'         => [],
					],
					$args
				)
			);
		}
	}

	/**
	 * Prefer control specific value over field value
	 *
	 * @access public
	 * @since 4.0
	 * @param $setting
	 * @param $choice
	 * @param $args
	 *
	 * @return string
	 */
	public function filter_preferred_choice_setting( $setting, $choice, $args ) {
		// Fail early
		if ( ! isset( $args[ $setting ] ) ) {
			return '';
		}

		// If a specific field for the choice is set
		if ( isset( $args[ $setting ][ $choice ] ) ) {
			return $args[ $setting ][ $choice ];
		}

		// Unset input_attrs of all other choices
		foreach ( $args['choices'] as $id => $set ) {
			if ( $id !== $choice && isset( $args[ $setting ][ $id ] ) ) {
				unset( $args[ $setting ][ $id ] );
			} else if ( ! isset( $args[ $setting ][ $id ] ) ) {
				$args[ $setting ] = '';
			}
		}

		return $args[ $setting ];
	}

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

		if ( $args['settings'] !== $this->args['settings'] ) {
			return $args;
		}

		// Set the sanitize-callback if none is defined.
		if ( ! isset( $args['sanitize_callback'] ) || ! $args['sanitize_callback'] ) {
			$args['sanitize_callback'] = [ __CLASS__, 'sanitize' ];
		}
		return $args;
	}

	/**
	 * Sanitizes background controls
	 *
	 * @static
	 * @access public
	 * @since 1.0
	 * @param array $value The value.
	 * @return array
	 */
	public static function sanitize( $value ) {

		foreach ( $value as $key => $subvalue ) {
			$value[ $key ] = \Kirki\Field\Color::sanitize( $subvalue );
		}
		return $value;
	}

	/**
	 * Override parent method. No need to register any setting.
	 *
	 * @access public
	 * @since 0.1
	 * @param WP_Customize_Manager $wp_customize The customizer instance.
	 * @return void
	 */
	public function add_setting( $wp_customize ) {}

	/**
	 * Override the parent method. No need for a control.
	 *
	 * @access public
	 * @since 0.1
	 * @param WP_Customize_Manager $wp_customize The customizer instance.
	 * @return void
	 */
	public function add_control( $wp_customize ) {}

	/**
	 * Adds a custom output class for typography fields.
	 *
	 * @access public
	 * @since 1.0
	 * @param array $classnames The array of classnames.
	 * @return array
	 */
	public function output_control_classnames( $classnames ) {
		$classnames['kirki-multicolor'] = '\Kirki\Field\CSS\Multicolor';
		return $classnames;
	}
}
