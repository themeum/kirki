<?php
/**
 * Initializes Kirki
 *
 * @package     Kirki
 * @category    Core
 * @author      Ari Stathopoulos (@aristath)
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license    https://opensource.org/licenses/MIT
 * @since       1.0
 */

namespace Kirki\Core;

/**
 * Initialize Kirki
 */
class Init {

	/**
	 * Control types.
	 *
	 * @access private
	 * @since 3.0.0
	 * @var array
	 */
	private $control_types = [];

	/**
	 * The class constructor.
	 */
	public function __construct() {
		self::set_url();
		add_action( 'after_setup_theme', [ $this, 'set_url' ] );
		add_action( 'wp_loaded', [ $this, 'add_to_customizer' ], 1 );
		add_filter( 'kirki_control_types', [ $this, 'default_control_types' ] );

		add_action( 'customize_register', [ $this, 'remove_panels' ], 99999 );
		add_action( 'customize_register', [ $this, 'remove_sections' ], 99999 );
		add_action( 'customize_register', [ $this, 'remove_controls' ], 99999 );

		new Values();
		new Sections();
		new Telemetry();
	}

	/**
	 * Properly set the Kirki URL for assets.
	 *
	 * @static
	 * @access public
	 */
	public static function set_url() {
		if ( Util::is_plugin() ) {
			return;
		}

		// Get correct URL and path to wp-content.
		$content_url = untrailingslashit( dirname( dirname( get_stylesheet_directory_uri() ) ) );
		$content_dir = wp_normalize_path( untrailingslashit( WP_CONTENT_DIR ) );

		Kirki::$url = str_replace( $content_dir, $content_url, wp_normalize_path( Kirki::$path ) );

		// Apply the kirki_config filter.
		$config = apply_filters( 'kirki_config', [] );
		if ( isset( $config['url_path'] ) ) {
			Kirki::$url = $config['url_path'];
		}

		// Make sure the right protocol is used.
		Kirki::$url = set_url_scheme( Kirki::$url );
	}

	/**
	 * Add the default Kirki control types.
	 *
	 * @access public
	 * @since 3.0.0
	 * @param array $control_types The control types array.
	 * @return array
	 */
	public function default_control_types( $control_types = [] ) {
		$this->control_types = [
			'kirki-composite'       => '\Kirki\Control\Composite',
			'checkbox'              => '\Kirki\Control\Checkbox',
			'code_editor'           => '\Kirki\Control\Code',
			'kirki-color'           => '\Kirki\Control\Color',
			'kirki-color-palette'   => '\Kirki\Control\Color_Palette',
			'kirki-custom'          => '\Kirki\Control\Custom',
			'kirki-date'            => '\Kirki\Control\Date',
			'kirki-dashicons'       => '\Kirki\Control\Dashicons',
			'kirki-dimension'       => '\Kirki\Control\Dimension',
			'kirki-dimensions'      => '\Kirki\Control\Dimensions',
			'kirki-editor'          => '\Kirki\Control\Editor',
			'kirki-fontawesome'     => '\Kirki\Control\FontAwesome',
			'kirki-image'           => '\Kirki\Control\Image',
			'kirki-multicolor'      => '\Kirki\Control\Multicolor',
			'kirki-multicheck'      => '\Kirki\Control\MultiCheck',
			'kirki-number'          => '\Kirki\Control\Number',
			'kirki-palette'         => '\Kirki\Control\Palette',
			'kirki-radio'           => '\Kirki\Control\Radio',
			'kirki-radio-buttonset' => '\Kirki\Control\Radio_ButtonSet',
			'kirki-radio-image'     => '\Kirki\Control\Radio_Image',
			'repeater'              => '\Kirki\Control\Repeater',
			'kirki-select'          => '\Kirki\Control\Select',
			'kirki-slider'          => '\Kirki\Control\Slider',
			'kirki-sortable'        => '\Kirki\Control\Sortable',
			'kirki-spacing'         => '\Kirki\Control\Dimensions',
			'kirki-switch'          => '\Kirki\Control\Checkbox_Switch',
			'kirki-generic'         => '\Kirki\Control\Generic',
			'kirki-toggle'          => '\Kirki\Control\Checkbox_Toggle',
			'kirki-typography'      => '\Kirki\Control\Typography',
			'image'                 => '\Kirki\Control\Image',
			'cropped_image'         => '\Kirki\Control\Cropped_Image',
			'upload'                => '\Kirki\Control\Upload',
		];
		return array_merge( $this->control_types, $control_types );
	}

	/**
	 * Helper function that adds the fields, sections and panels to the customizer.
	 */
	public function add_to_customizer() {
		$this->fields_from_filters();
		add_action( 'customize_register', [ $this, 'register_control_types' ] );
		add_action( 'customize_register', [ $this, 'add_panels' ], 97 );
		add_action( 'customize_register', [ $this, 'add_sections' ], 98 );
		add_action( 'customize_register', [ $this, 'add_fields' ], 99 );
	}

	/**
	 * Register control types
	 */
	public function register_control_types() {
		global $wp_customize;

		$section_types = apply_filters( 'kirki_section_types', [] );
		foreach ( $section_types as $section_type ) {
			$wp_customize->register_section_type( $section_type );
		}

		$this->control_types = $this->default_control_types();
		if ( ! class_exists( 'WP_Customize_Code_Editor_Control' ) ) {
			unset( $this->control_types['code_editor'] );
		}
		foreach ( $this->control_types as $key => $classname ) {
			if ( ! class_exists( $classname ) ) {
				unset( $this->control_types[ $key ] );
			}
		}

		$skip_control_types = apply_filters(
			'kirki_control_types_exclude',
			[
				'\Kirki\Control\Repeater',
				'\WP_Customize_Control',
			]
		);

		foreach ( $this->control_types as $control_type ) {
			if ( ! in_array( $control_type, $skip_control_types, true ) && class_exists( $control_type ) ) {
				$wp_customize->register_control_type( $control_type );
			}
		}
	}

	/**
	 * Register our panels to the WordPress Customizer.
	 *
	 * @access public
	 */
	public function add_panels() {
		if ( ! empty( Kirki::$panels ) ) {
			foreach ( Kirki::$panels as $panel_args ) {
				// Extra checks for nested panels.
				if ( isset( $panel_args['panel'] ) ) {
					if ( isset( Kirki::$panels[ $panel_args['panel'] ] ) ) {
						// Set the type to nested.
						$panel_args['type'] = 'kirki-nested';
					}
				}

				new Panel( $panel_args );
			}
		}
	}

	/**
	 * Register our sections to the WordPress Customizer.
	 *
	 * @var object The WordPress Customizer object
	 */
	public function add_sections() {
		if ( ! empty( Kirki::$sections ) ) {
			foreach ( Kirki::$sections as $section_args ) {
				// Extra checks for nested sections.
				if ( isset( $section_args['section'] ) ) {
					if ( isset( Kirki::$sections[ $section_args['section'] ] ) ) {
						// Set the type to nested.
						$section_args['type'] = 'kirki-nested';
						// We need to check if the parent section is nested inside a panel.
						$parent_section = Kirki::$sections[ $section_args['section'] ];
						if ( isset( $parent_section['panel'] ) ) {
							$section_args['panel'] = $parent_section['panel'];
						}
					}
				}
				new Section( $section_args );
			}
		}
	}

	/**
	 * Create the settings and controls from the $fields array and register them.
	 *
	 * @var object The WordPress Customizer object.
	 */
	public function add_fields() {
		global $wp_customize;
		foreach ( Kirki::$fields as $args ) {

			// Create the settings.
			new Settings( $args );

			// Check if we're on the customizer.
			// If we are, then we will create the controls, add the scripts needed for the customizer
			// and any other tweaks that this field may require.
			if ( $wp_customize ) {

				// Create the control.
				new Control( $args );

			}
		}
	}

	/**
	 * Process fields added using the 'kirki_fields' and 'kirki_controls' filter.
	 * These filters are no longer used, this is simply for backwards-compatibility.
	 *
	 * @access private
	 * @since 2.0.0
	 */
	private function fields_from_filters() {
		$fields = apply_filters( 'kirki_controls', [] );
		$fields = apply_filters( 'kirki_fields', $fields );

		if ( ! empty( $fields ) ) {
			foreach ( $fields as $field ) {
				Kirki::add_field( 'global', $field );
			}
		}
	}

	/**
	 * Alias for the is_plugin static method in the Kirki\Core\Util class.
	 * This is here for backwards-compatibility purposes.
	 *
	 * @static
	 * @access public
	 * @since 3.0.0
	 * @return bool
	 */
	public static function is_plugin() {
		return Util::is_plugin();
	}

	/**
	 * Alias for the get_variables static method in the Kirki\Core\Util class.
	 * This is here for backwards-compatibility purposes.
	 *
	 * @static
	 * @access public
	 * @since 2.0.0
	 * @return array Formatted as array( 'variable-name' => value ).
	 */
	public static function get_variables() {

		// Log error for developers.
		_doing_it_wrong( __METHOD__, esc_html__( 'We detected you\'re using Kirki\Core\Init::get_variables(). Please use \Kirki\Core\Util::get_variables() instead.', 'kirki' ), '3.0.10' );
		return Util::get_variables();
	}

	/**
	 * Remove panels.
	 *
	 * @since 3.0.17
	 * @param object $wp_customize The customizer object.
	 * @return void
	 */
	public function remove_panels( $wp_customize ) {
		foreach ( Kirki::$panels_to_remove as $panel ) {
			$wp_customize->remove_panel( $panel );
		}
	}

	/**
	 * Remove sections.
	 *
	 * @since 3.0.17
	 * @param object $wp_customize The customizer object.
	 * @return void
	 */
	public function remove_sections( $wp_customize ) {
		foreach ( Kirki::$sections_to_remove as $section ) {
			$wp_customize->remove_section( $section );
		}
	}

	/**
	 * Remove controls.
	 *
	 * @since 3.0.17
	 * @param object $wp_customize The customizer object.
	 * @return void
	 */
	public function remove_controls( $wp_customize ) {
		foreach ( Kirki::$controls_to_remove as $control ) {
			$wp_customize->remove_control( $control );
		}
	}
}
