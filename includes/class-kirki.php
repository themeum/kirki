<?php

/**
 * The API class.
 */
class Kirki {

	public static $config   = array();
	public static $fields   = array();
	public static $panels   = array();
	public static $sections = array();

	/**
	 * the class constructor
	 */
	public function __construct() {
		add_action( 'wp_loaded', array( $this, 'add_to_customizer' ), 1 );
	}

	/**
	 * Helper function that adds the fields, sections and panels to the customizer.
	 */
	public function add_to_customizer( $wp_customize ) {
		add_filter( 'kirki/fields', array( $this, 'merge_fields' ) );
		add_action( 'customize_register', array( $this, 'add_panels' ), 998 );
		add_action( 'customize_register', array( $this, 'add_sections' ), 999 );
	}

	/**
	 * Merge the fields arrays
	 */
	public function merge_fields( $fields ) {
		return array_merge( $fields, self::$fields );
	}

	/**
	 * Sets the configuration options.
	 *
	 * @var		string		the configuration ID.
	 * @var		array		the configuration options.
	 */
	public static function add_config( $config_id, $args ) {

		$default_args = array(
			'capability'    => 'edit_theme_options',
			'option_type'   => 'theme_mod',
			'option'        => '',
			'compiler'      => array(),
		);
		$args = array_merge( $default_args, $args );

		// Set the config
		self::$config[$config_id] = $args;

	}

	public function add_panels( $wp_customize ) {

		if ( ! empty( self::$panels ) ) {

			foreach ( self::$panels as $panel ) {
				$wp_customize->add_panel( sanitize_key( $panel['id'] ), array(
					'title'       => $panel['title'],
					'priority'    => $panel['priority'],
					'description' => $panel['description'],
				) );
			}

		}
	}

	public function add_sections( $wp_customize ) {

		if ( ! empty( self::$sections ) ) {

			foreach ( self::$sections as $section ) {
				$wp_customize->add_section( sanitize_key( $section['id'] ), array(
					'title'       => $section['title'],
					'priority'    => $section['priority'],
					'panel'       => $section['panel'],
					'description' => $section['description'],
				) );
			}

		}

	}

	/**
	 * Create a new field
	 *
	 * @var		string		the configuration ID for this field
	 * @var		array		the field arguments
	 */
	public static function add_field( $config_id, $args ) {

		// Get the configuration options
		$config = self::$config[$config_id];

		/**
		 * If we've set an option in the configuration
		 * then make sure we're using options and not theme_mods
		 */
		if ( '' != $config['option'] ) {
			$config['option_type'] = 'option';
		}

		/**
		 * If no option name has been set for the field,
		 * use the one from the configuration
		 */
		if ( ! isset( $args['option'] ) ) {
			$args['option'] = $config['option'];
		}

		/**
		 * If no capability has been set for the field,
		 * use the one from the configuration
		 */
		if ( ! isset( $args['capability'] ) ) {
			$args['capability'] = $config['capability'];
		}

		/**
		 * If no option-type has been set for the field,
		 * use the one from the configuration
		 */
		if ( ! isset( $args['option_type'] ) ) {
			$args['option_type'] = $config['option_type'];
		}

		// Add the field to the Kirki_API class
		self::$fields[] = $args;

	}

}
