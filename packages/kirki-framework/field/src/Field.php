<?php // phpcs:disable PHPCompatibility.FunctionDeclarations.NewClosure
/**
 * WordPress Customizer API abstraction.
 *
 * @package   kirki-framework/field
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     0.1
 */

namespace Kirki;

/**
 * Make it easier to create customizer settings & controls with a single call,
 * register the control type if needed, run extra actions the the customizer.
 * This is a simple abstraction which makes adding simple controls to the Customizer.
 *
 * This class is not meant to be used as-is, you'll need to extend it from a child class.
 *
 * @since 0.1
 */
abstract class Field {

	/**
	 * The field arguments.
	 *
	 * @access protected
	 * @since 0.1
	 * @var array
	 */
	protected $args;

	/**
	 * The control class-name.
	 *
	 * Use the full classname, with namespace included.
	 * Example: '\Kirki\Control\Color'.
	 *
	 * @access protected
	 * @since 0.1
	 * @var string
	 */
	protected $control_class;

	/**
	 * The setting class-name.
	 *
	 * @access protected
	 * @since 0.1
	 * @var string|null
	 */
	protected $settings_class;

	/**
	 * Whether we should register the control class for JS-templating or not.
	 *
	 * @access protected
	 * @since 0.1
	 * @var bool
	 */
	protected $control_has_js_template = false;

	/**
	 * Constructor.
	 * Registers any hooks we need to run.
	 *
	 * @access public
	 * @since 0.1
	 * @param array $args The field arguments.
	 */
	public function __construct( $args ) {

		// Set the arguments in this object.
		$this->args = $args;

		if ( ! isset( $this->args['settings'] ) ) {
			$this->args['settings'] = md5( wp_json_encode( $this->args ) );
		}

		add_action(
			'init',
			function() {
				do_action( 'kirki_field_init', $this->args, $this );
			}
		);
		add_action(
			'wp',
			function() {
				do_action( 'kirki_field_wp', $this->args, $this );
			}
		);

		$this->init( $this->args );

		// Register control-type for JS-templating in the customizer.
		add_action( 'customize_register', [ $this, 'register_control_type' ] );

		// Add customizer setting.
		add_action( 'customize_register', [ $this, 'add_setting' ] );

		// Add customizer control.
		add_action( 'customize_register', [ $this, 'add_control' ] );

		// Add default filters. Can be overriden in child classes.
		add_filter( 'kirki_field_add_setting_args', [ $this, 'filter_setting_args' ], 10, 2 );
		add_filter( 'kirki_field_add_control_args', [ $this, 'filter_control_args' ], 10, 2 );
	}

	/**
	 * Runs in the constructor. Can be used by child-classes to define extra logic.
	 *
	 * @access protected
	 * @since 0.1
	 * @param array $args The field arguments.
	 * @return void
	 */
	protected function init( $args ) {}

	/**
	 * Register the control-type.
	 *
	 * @access public
	 * @since 0.1
	 * @param WP_Customize_Manager $wp_customize The customizer instance.
	 * @return void
	 */
	public function register_control_type( $wp_customize ) {
		if ( $this->control_class ) {
			$wp_customize->register_control_type( $this->control_class );
		}
	}

	/**
	 * Filter setting args.
	 *
	 * @access public
	 * @since 0.1
	 * @param array                $args         The field arguments.
	 * @param WP_Customize_Manager $wp_customize The customizer instance.
	 * @return array
	 */
	public function filter_setting_args( $args, $wp_customize ) {
		$args['type'] = isset( $args['option_type'] ) ? $args['option_type'] : 'theme_mod';
		return $args;
	}

	/**
	 * Filter control args.
	 *
	 * @access public
	 * @since 0.1
	 * @param array                $args         The field arguments.
	 * @param WP_Customize_Manager $wp_customize The customizer instance.
	 * @return array
	 */
	public function filter_control_args( $args, $wp_customize ) {
		return $args;
	}

	/**
	 * Registers the setting.
	 *
	 * @access public
	 * @since 0.1
	 * @param WP_Customize_Manager $customizer The customizer instance.
	 * @return void
	 */
	public function add_setting( $customizer ) {

		/**
		 * Allow filtering the arguments.
		 *
		 * @since 0.1
		 * @param array                $this->args The arguments.
		 * @param WP_Customize_Manager $customizer The customizer instance.
		 * @return array                           Return the arguments.
		 */
		$args = apply_filters( 'kirki_field_add_setting_args', $this->args, $customizer );
		if ( isset( $args['settings'] ) ) {
			$classname = $this->settings_class;

			$setting_id = $args['settings'];

			$args = [
				'type'                 => isset( $args['type'] ) ? $args['type'] : 'theme_mod',
				'capability'           => isset( $args['capability'] ) ? $args['capability'] : 'edit_theme_options',
				'theme_supports'       => isset( $args['theme_supports'] ) ? $args['theme_supports'] : '',
				'default'              => isset( $args['default'] ) ? $args['default'] : '',
				'transport'            => isset( $args['transport'] ) ? $args['transport'] : 'refresh',
				'sanitize_callback'    => isset( $args['sanitize_callback'] ) ? $args['sanitize_callback'] : '',
				'sanitize_js_callback' => isset( $args['sanitize_js_callback'] ) ? $args['sanitize_js_callback'] : '',
			];
			if ( $this->settings_class ) {
				$customizer->add_setting( new $classname( $customizer, $settings_id, $args ) );
				return;
			}
			$customizer->add_setting( $setting_id, $args );
		}
	}

	/**
	 * Registers the control.
	 *
	 * @access public
	 * @since 0.1
	 * @param WP_Customize_Manager $wp_customize The customizer instance.
	 * @return void
	 */
	public function add_control( $wp_customize ) {

		$control_class = $this->control_class;

		// If no class-name is defined, early exit.
		if ( ! $control_class ) {
			return;
		}

		/**
		 * Allow filtering the arguments.
		 *
		 * @since 0.1
		 * @param array                $this->args   The arguments.
		 * @param WP_Customize_Manager $wp_customize The customizer instance.
		 * @return array                             Return the arguments.
		 */
		$args = apply_filters( 'kirki_field_add_control_args', $this->args, $wp_customize );
		$wp_customize->add_control( new $control_class( $wp_customize, $this->args['settings'], $args ) );
	}
}
