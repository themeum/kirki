<?php
/**
 * Initializes Kirki
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

/**
 * Initialize Kirki
 */
class Kirki_Init {

	/**
	 * Control types.
	 *
	 * @access private
	 * @since 3.0.0
	 * @var array
	 */
	private $control_types = array();

	/**
	 * The class constructor.
	 */
	public function __construct() {

		$this->set_url();
		add_action( 'after_setup_theme', array( $this, 'set_url' ) );
		add_action( 'wp_loaded', array( $this, 'add_to_customizer' ), 1 );
		add_filter( 'kirki/control_types', array( $this, 'default_control_types' ) );
	}

	/**
	 * Properly set the Kirki URL for assets.
	 * Determines if Kirki is installed as a plugin, in a child theme, or a parent theme
	 * and then does some calculations to get the proper URL for its CSS & JS assets.
	 */
	public function set_url() {

		Kirki::$path = wp_normalize_path( dirname( KIRKI_PLUGIN_FILE ) );

		// Works in most cases.
		// Serves as a fallback in case all other checks fail.
		if ( defined( 'WP_CONTENT_DIR' ) ) {
			$content_dir = wp_normalize_path( WP_CONTENT_DIR );
			if ( false !== strpos( Kirki::$path, $content_dir ) ) {
				$relative_path = str_replace( $content_dir, '', Kirki::$path );
				Kirki::$url = content_url( $relative_path );
			}
		}

		// If Kirki is installed as a plugin, use that for the URL.
		if ( Kirki_Util::is_plugin() ) {
			Kirki::$url = plugin_dir_url( KIRKI_PLUGIN_FILE );
		}

		// Get the path to the theme.
		$theme_path = wp_normalize_path( get_template_directory() );

		// Is Kirki included in the theme?
		if ( false !== strpos( Kirki::$path, $theme_path ) ) {
			Kirki::$url = get_template_directory_uri() . str_replace( $theme_path, '', Kirki::$path );
		}

		// Is there a child-theme?
		$child_theme_path = wp_normalize_path( get_stylesheet_directory_uri() );
		if ( $child_theme_path !== $theme_path ) {
			// Is Kirki included in a child theme?
			if ( false !== strpos( Kirki::$path, $child_theme_path ) ) {
				Kirki::$url = get_template_directory_uri() . str_replace( $child_theme_path, '', Kirki::$path );
			}
		}

		// Apply the kirki/config filter.
		$config = apply_filters( 'kirki/config', array() );
		if ( isset( $config['url_path'] ) ) {
			Kirki::$url = $config['url_path'];
		}

		// Escapes the URL.
		Kirki::$url = esc_url_raw( Kirki::$url );
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
	public function default_control_types( $control_types = array() ) {

		$this->control_types = array(
			'checkbox'              => 'WP_Customize_Control',
			'kirki-background'      => 'Kirki_Control_Background',
			'kirki-code'            => 'Kirki_Control_Code',
			'kirki-color'           => 'Kirki_Control_Color',
			'kirki-color-palette'   => 'Kirki_Control_Color_Palette',
			'kirki-custom'          => 'Kirki_Control_Custom',
			'kirki-date'            => 'Kirki_Control_Date',
			'kirki-dashicons'       => 'Kirki_Control_Dashicons',
			'kirki-dimension'       => 'Kirki_Control_Dimension',
			'kirki-dimensions'      => 'Kirki_Control_Dimensions',
			'kirki-editor'          => 'Kirki_Control_Editor',
			'kirki-fontawesome'     => 'Kirki_Control_FontAwesome',
			'kirki-gradient'        => 'Kirki_Control_Gradient',
			'kirki-image'           => 'Kirki_Control_Image',
			'kirki-multicolor'      => 'Kirki_Control_Multicolor',
			'kirki-multicheck'      => 'Kirki_Control_MultiCheck',
			'kirki-number'          => 'Kirki_Control_Number',
			'kirki-palette'         => 'Kirki_Control_Palette',
			'kirki-preset'          => 'Kirki_Control_Preset',
			'kirki-radio'           => 'Kirki_Control_Radio',
			'kirki-radio-buttonset' => 'Kirki_Control_Radio_ButtonSet',
			'kirki-radio-image'     => 'Kirki_Control_Radio_Image',
			'repeater'              => 'Kirki_Control_Repeater',
			'kirki-select'          => 'Kirki_Control_Select',
			'kirki-slider'          => 'Kirki_Control_Slider',
			'kirki-sortable'        => 'Kirki_Control_Sortable',
			'kirki-spacing'         => 'Kirki_Control_Dimensions',
			'kirki-switch'          => 'Kirki_Control_Switch',
			'kirki-generic'         => 'Kirki_Control_Generic',
			'kirki-toggle'          => 'Kirki_Control_Toggle',
			'kirki-typography'      => 'Kirki_Control_Typography',
			'image'                 => 'Kirki_Control_Image',
			'cropped_image'         => 'WP_Customize_Cropped_Image_Control',
			'upload'                => 'WP_Customize_Upload_Control',
		);
		return array_merge( $control_types, $this->control_types );

	}

	/**
	 * Helper function that adds the fields, sections and panels to the customizer.
	 *
	 * @return void
	 */
	public function add_to_customizer() {
		$this->fields_from_filters();
		add_action( 'customize_register', array( $this, 'register_control_types' ) );
		add_action( 'customize_register', array( $this, 'add_panels' ), 97 );
		add_action( 'customize_register', array( $this, 'add_sections' ), 98 );
		add_action( 'customize_register', array( $this, 'add_fields' ), 99 );
	}

	/**
	 * Register control types
	 *
	 * @return  void
	 */
	public function register_control_types() {
		global $wp_customize;

		$section_types = apply_filters( 'kirki/section_types', array() );
		foreach ( $section_types as $section_type ) {
			$wp_customize->register_section_type( $section_type );
		}
		if ( empty( $this->control_types ) ) {
			$this->control_types = $this->default_control_types();
		}
		$do_not_register_control_types = apply_filters( 'kirki/control_types/exclude', array(
			'Kirki_Control_Repeater',
		) );
		foreach ( $this->control_types as $control_type ) {
			if ( 0 === strpos( $control_type, 'Kirki' ) && ! in_array( $control_type, $do_not_register_control_types, true ) && class_exists( $control_type ) ) {
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

				new Kirki_Panel( $panel_args );
			}
		}
	}

	/**
	 * Register our sections to the WordPress Customizer.
	 *
	 * @var	object	The WordPress Customizer object
	 * @return  void
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
				new Kirki_Section( $section_args );
			}
		}
	}

	/**
	 * Create the settings and controls from the $fields array and register them.
	 *
	 * @var	object	The WordPress Customizer object
	 * @return  void
	 */
	public function add_fields() {

		global $wp_customize;
		foreach ( Kirki::$fields as $args ) {

			// Create the settings.
			new Kirki_Settings( $args );

			// Check if we're on the customizer.
			// If we are, then we will create the controls, add the scripts needed for the customizer
			// and any other tweaks that this field may require.
			if ( $wp_customize ) {

				// Create the control.
				new Kirki_Control( $args );

			}
		}
	}

	/**
	 * Process fields added using the 'kirki/fields' and 'kirki/controls' filter.
	 * These filters are no longer used, this is simply for backwards-compatibility.
	 *
	 * @access private
	 * @since 2.0.0
	 */
	private function fields_from_filters() {

		$fields = apply_filters( 'kirki/controls', array() );
		$fields = apply_filters( 'kirki/fields', $fields );

		if ( ! empty( $fields ) ) {
			foreach ( $fields as $field ) {
				Kirki::add_field( 'global', $field );
			}
		}
	}

	/**
	 * Alias for the is_plugin static method in the Kirki_Util class.
	 * This is here for backwards-compatibility purposes.
	 *
	 * @static
	 * @access public
	 * @since 3.0.0
	 * @return bool
	 */
	public static function is_plugin() {
		// Log error for developers.
		// @codingStandardsIgnoreLine
		error_log( 'We detected you\'re using Kirki_Init::is_plugin(). Please use Kirki_Util::is_plugin() instead. This message was added in Kirki 3.0.9.' );
		// Return result using the Kirki_Util class.
		return Kirki_Util::is_plugin();
	}

	/**
	 * Alias for the get_variables static method in the Kirki_Util class.
	 * This is here for backwards-compatibility purposes.
	 *
	 * @static
	 * @access public
	 * @since 2.0.0
	 * @return array Formatted as array( 'variable-name' => value ).
	 */
	public static function get_variables() {
		// Log error for developers.
		// @codingStandardsIgnoreLine
		error_log( 'We detected you\'re using Kirki_Init::get_variables(). Please use Kirki_Util::get_variables() instead. This message was added in Kirki 3.0.9.' );
		// Return result using the Kirki_Util class.
		return Kirki_Util::get_variables();
	}

}
