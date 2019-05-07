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
				do_action( 'kirki_field_init', $this->args );
			} 
		);
		add_action(
			'wp',
			function() {
				do_action( 'kirki_field_wp', $this->args );
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
		$args['type'] = 'theme_mod';
		if ( isset( $args['option_type'] ) ) {
			$args['type'] = $args['option_type'];
			if ( isset( $args['option_name'] ) && ! empty( $args['option_name'] ) ) {
				if ( isset( $args['settings'] ) && false === strpos( $args['settings'], $args['option_name'] . '[' ) ) {
					$args['settings'] = $args['option_name'] . '[' . $args['settings'] . ']';
				}
			}
		}
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
	 * @param WP_Customize_Manager $wp_customize The customizer instance.
	 * @return void
	 */
	public function add_setting( $wp_customize ) {

		/**
		 * Allow filtering the arguments.
		 *
		 * @since 0.1
		 * @param array                $this->args   The arguments.
		 * @param WP_Customize_Manager $wp_customize The customizer instance.
		 * @return array                             Return the arguments.
		 */
		$args = apply_filters( 'kirki_field_add_setting_args', $this->args, $wp_customize );
		if ( isset( $args['settings'] ) ) {
			$wp_customize->add_setting( $args['settings'], $args );
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
