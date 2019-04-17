<?php
/**
 * Customizer Control: background.
 *
 * Creates a new custom control.
 * Custom controls contains all background-related options.
 *
 * @package   kirki-framework\control-background
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license  https://opensource.org/licenses/MIT
 * @since    1.0
 */

namespace Kirki\Control;

use Kirki\Control\Composite;

/**
 * Adds multiple input fiels that combined make up the background control.
 *
 * @since 1.0
 */
class Background extends Composite {

	/**
	 * The control type.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $type = 'kirki-composite';

	/**
	 * The version. Used in scripts & styles for cache-busting.
	 *
	 * @static
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public static $control_ver = '1.0.2';

	/**
	 * Script dependencies.
	 *
	 * @access protected
	 * @since 0.1
	 * @var array
	 */
	protected $script_dependencies = [ 'kirki-control-color', 'kirki-control-image', 'kirki-control-select', 'kirki-control-radio' ];

	/**
	 * Constructor.
	 * Supplied `$args` override class property defaults.
	 * If `$args['settings']` is not defined, use the $id as the setting ID.
	 *
	 * @access public
	 * @since 0.1
	 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
	 * @param string               $id      Control ID.
	 * @param array                $args    {@see WP_Customize_Control::__construct}.
	 */
	public function __construct( $manager, $id, $args = [] ) {
		$this->fields = [
			[
				'type'        => 'kirki-custom',
				'settings'    => $id . '[--label-and-description]',
				'label'       => isset( $args['label'] ) ? $args['label'] : '',
				'description' => isset( $args['description'] ) ? $args['description'] : '',
				'default'     => '',
			],
			[
				'type'        => 'kirki-color',
				'settings'    => $id . '[background-color]',
				'label'       => '',
				'description' => esc_html__( 'Background Color', 'kirki' ),
				'default'     => isset( $args['default']['background-color'] ) ? $args['default']['background-color'] : '',
				'choices'     => [
					'alpha' => true,
				],
			],
			[
				'type'        => 'kirki-image',
				'settings'    => $id . '[background-image]',
				'label'       => '',
				'description' => esc_html__( 'Background Image', 'kirki' ),
				'default'     => isset( $args['default']['background-image'] ) ? $args['default']['background-image'] : '',
			],
			[
				'type'        => 'kirki-select',
				'settings'    => $id . '[background-repeat]',
				'label'       => '',
				'description' => esc_html__( 'Background Repeat', 'kirki' ),
				'default'     => isset( $args['default']['background-repeat'] ) ? $args['default']['background-repeat'] : '',
				'choices'     => [
					'no-repeat' => esc_html__( 'No Repeat', 'kirki' ),
					'repeat'    => esc_html__( 'Repeat All', 'kirki' ),
					'repeat-x'  => esc_html__( 'Repeat Horizontally', 'kirki' ),
					'repeat-y'  => esc_html__( 'Repeat Vertically', 'kirki' ),
				],
			],
			[
				'type'        => 'kirki-select',
				'settings'    => $id . '[background-position]',
				'label'       => '',
				'description' => esc_html__( 'Background Position', 'kirki' ),
				'default'     => isset( $args['default']['background-position'] ) ? $args['default']['background-position'] : '',
				'choices'     => [
					'left top'      => esc_html__( 'Left Top', 'kirki' ),
					'left center'   => esc_html__( 'Left Center', 'kirki' ),
					'left bottom'   => esc_html__( 'Left Bottom', 'kirki' ),
					'center top'    => esc_html__( 'Center Top', 'kirki' ),
					'center center' => esc_html__( 'Center Center', 'kirki' ),
					'center bottom' => esc_html__( 'Center Bottom', 'kirki' ),
					'right top'     => esc_html__( 'Right Top', 'kirki' ),
					'right center'  => esc_html__( 'Right Center', 'kirki' ),
					'right bottom'  => esc_html__( 'Right Bottom', 'kirki' ),
				],
			],
			[
				'type'        => 'kirki-radio-buttonset',
				'settings'    => $id . '[background-size]',
				'label'       => '',
				'description' => esc_html__( 'Background Size', 'kirki' ),
				'default'     => isset( $args['default']['background-size'] ) ? $args['default']['background-size'] : '',
				'choices'     => [
					'cover'   => esc_html__( 'Cover', 'kirki' ),
					'contain' => esc_html__( 'Contain', 'kirki' ),
					'auto'    => esc_html__( 'Auto', 'kirki' ),
				],
			],
			[
				'type'        => 'kirki-radio-buttonset',
				'settings'    => $id . '[background-attachment]',
				'description' => esc_html__( 'Background Attachment', 'kirki' ),
				'label'       => '',
				'default'     => isset( $args['default']['background-attachment'] ) ? $args['default']['background-attachment'] : '',
				'choices'     => [
					'scroll' => esc_html__( 'Scroll', 'kirki' ),
					'fixed'  => esc_html__( 'Fixed', 'kirki' ),
				],
			],
		];
		parent::__construct( $manager, $id, $args );
	}
}
