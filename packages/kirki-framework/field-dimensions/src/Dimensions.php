<?php
/**
 * Override field methods
 *
 * @package   kirki-framework/field-dimensions
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Field;

use Kirki;
use Kirki\Field;
use Kirki\URL;

/**
 * Field overrides.
 *
 * @since 1.0
 */
class Dimensions extends Field {

	/**
	 * The field type.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $type = 'kirki-dimensions';

	/**
	 * Extra logic for the field.
	 *
	 * Adds all sub-fields.
	 *
	 * @access public
	 * @param array $args The arguments of the field.
	 */
	public function init( $args = [] ) {

		add_action( 'customize_controls_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'customize_preview_init', [ $this, 'enqueue_customize_preview_scripts' ] );
		add_filter( 'kirki_output_control_classnames', [ $this, 'output_control_classnames' ] );

		$args['required'] = isset( $args['required'] ) ? (array) $args['required'] : [];
		$config_id        = isset( $args['kirki_config'] ) ? $args['kirki_config'] : 'global';

		$labels = [
			'left-top'       => esc_html__( 'Left Top', 'kirki' ),
			'left-center'    => esc_html__( 'Left Center', 'kirki' ),
			'left-bottom'    => esc_html__( 'Left Bottom', 'kirki' ),
			'right-top'      => esc_html__( 'Right Top', 'kirki' ),
			'right-center'   => esc_html__( 'Right Center', 'kirki' ),
			'right-bottom'   => esc_html__( 'Right Bottom', 'kirki' ),
			'center-top'     => esc_html__( 'Center Top', 'kirki' ),
			'center-center'  => esc_html__( 'Center Center', 'kirki' ),
			'center-bottom'  => esc_html__( 'Center Bottom', 'kirki' ),
			'font-size'      => esc_html__( 'Font Size', 'kirki' ),
			'font-weight'    => esc_html__( 'Font Weight', 'kirki' ),
			'line-height'    => esc_html__( 'Line Height', 'kirki' ),
			'font-style'     => esc_html__( 'Font Style', 'kirki' ),
			'letter-spacing' => esc_html__( 'Letter Spacing', 'kirki' ),
			'word-spacing'   => esc_html__( 'Word Spacing', 'kirki' ),
			'top'            => esc_html__( 'Top', 'kirki' ),
			'bottom'         => esc_html__( 'Bottom', 'kirki' ),
			'left'           => esc_html__( 'Left', 'kirki' ),
			'right'          => esc_html__( 'Right', 'kirki' ),
			'center'         => esc_html__( 'Center', 'kirki' ),
			'size'           => esc_html__( 'Size', 'kirki' ),
			'spacing'        => esc_html__( 'Spacing', 'kirki' ),
			'width'          => esc_html__( 'Width', 'kirki' ),
			'height'         => esc_html__( 'Height', 'kirki' ),
			'invalid-value'  => esc_html__( 'Invalid Value', 'kirki' ),
		];

		/**
		 * Add a hidden field, the label & description.
		 */
		new \Kirki\Field\Generic(
			wp_parse_args(
				[
					'type'    => 'kirki-generic',
					'default' => '',
					'choices' => [
						'type'        => 'hidden',
						'parent_type' => 'kirki-dimensions',
					],
				],
				$args
			)
		);

		$args['choices']           = isset( $args['choices'] ) ? $args['choices'] : [];
		$args['choices']['labels'] = isset( $args['choices']['labels'] ) ? $args['choices']['labels'] : [];

		if ( isset( $args['transport'] ) && 'auto' === $args['transport'] ) {
			$args['transport'] = 'postMessage';
		}

		foreach ( $args['default'] as $choice => $default ) {
			$label = $choice;
			$label = isset( $labels[ $choice ] ) ? $labels[ $choice ] : $label;
			$label = isset( $args['choices']['labels'][ $choice ] ) ? $args['choices']['labels'][ $choice ] : $label;
			new \Kirki\Field\Dimension(
				wp_parse_args(
					[
						'type'           => 'kirki-dimension',
						'settings'       => $args['settings'] . '[' . $choice . ']',
						'parent_setting' => $args['settings'],
						'label'          => '',
						'description'    => $label,
						'default'        => $default,
						'wrapper_atts'   => [
							'data-kirki-parent-control-type' => 'kirki-dimensions',
						],
						'js_vars'        => [],
						'css_vars'       => [],
						'output'         => [],
					],
					$args
				)
			);
		}
	}

	/**
	 * Sanitizes dimension controls.
	 *
	 * @static
	 * @access public
	 * @since 1.0
	 * @param array $value The value.
	 * @return array
	 */
	public static function sanitize( $value ) {
		if ( ! is_array( $value ) ) {
			return [];
		}
		foreach ( $value as $key => $val ) {
			$value[ $key ] = sanitize_text_field( $val );
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
	 * Enqueue scripts & styles.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'kirki-field-dimensions', URL::get_from_path( __DIR__ . '/style.css' ), [], '1.0' );
	}

	/**
	 * Enqueue scripts & styles on customize_preview_init.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function enqueue_customize_preview_scripts() {
		wp_enqueue_script( 'kirki-field-dimensions', URL::get_from_path( __DIR__ ) . '/script.js', [ 'wp-hooks' ], '1.0', true );
	}

	/**
	 * Adds a custom output class for typography fields.
	 *
	 * @access public
	 * @since 1.0
	 * @param array $classnames The array of classnames.
	 * @return array
	 */
	public function output_control_classnames( $classnames ) {
		$classnames['kirki-dimensions'] = '\Kirki\Field\CSS\Dimensions';
		return $classnames;
	}
}
