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
	 * Get the value of an option from the db.
	 *
	 * @var 	string	the ID of the configuration corresponding to this field
	 * @var		string	the field_id (defined as 'settings' in the field arguments)
	 *
	 * @return 	mixed 	the saved value of the field.
	 *
	 */
	public static function get_option(  $config_id = '', $field_id = '' ) {

		if ( ( '' == $field_id ) ) {
			return null;
		}

		// Are we using options or theme_mods?
		$mode = self::$config[$config_id]['option_type'];
		// Is there an option name set?
		$option_name = ( 'option' == $mode && isset( self::$config[$config_id]['option'] ) ) ? self::$config[$config_id]['option'] : false;

		if ( 'theme_mod' == $mode ) {

			// We're using theme_mods
			$value = get_theme_mod( $field_id, self::$fields[$field_id]['default'] );

		} elseif ( 'option' == $mode ) {

			// We're using options
			if ( $option_name ) {

				// Options are serialized as a single option in the db
				$options = get_option( $option_name );
				$value   = ( isset( $options[$field_id] ) ) ? $options[$field_id] : self::$fields[$field_id]['default'];
				$value   = maybe_unserialize( $value );

			} else {

				// Each option separately saved in the db
				$value = get_option( $field_id, self::$fields[$field_id]['default'] );

			}

		}

		if ( defined( 'KIRKI_REDUX_COMPATIBILITY' ) && KIRKI_REDUX_COMPATIBILITY ) {

			switch ( $this->fields[$field_id]['type'] ) {

				case 'image' :
					$value = Kirki_Helpers::get_image_from_url( $value );
					break;

			}

		}

		return $value;

	}

	/**
	 * Sets the configuration options.
	 *
	 * @var		string		the configuration ID.
	 * @var		array		the configuration options.
	 */
	public static function add_config( $config_id, $args = array() ) {

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
	 * Create a new panel
	 *
	 * @var		string		the ID for this panel
	 * @var		array		the panel arguments
	 */
	public static function add_panel( $id, $args ) {

		// Add the section to the $fields variable
		$args['id']          = $id;
		$args['description'] = ( isset( $args['description'] ) ) ? $args['description'] : '';
		$args['priority']    = ( isset( $args['priority'] ) ) ? $args['priority'] : 10;
		self::$panels[]      = $args;

	}

	/**
	 * Create a new section
	 *
	 * @var		string		the ID for this section
	 * @var		array		the section arguments
	 */
	public static function add_section( $id, $args ) {

		// Add the section to the $fields variable
		$args['id']          = $id;
		$args['panel']       = ( isset( $args['panel'] ) ) ? $args['panel'] : '';
		$args['description'] = ( isset( $args['description'] ) ) ? $args['description'] : '';
		$args['priority']    = ( isset( $args['priority'] ) ) ? $args['priority'] : 10;
		self::$sections[]    = $args;

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

	/**
	 * Build the variables.
	 *
	 * @return array 	('variable-name' => value)
	 */
	function get_variables() {

		$variables = array();

		foreach ( $this->fields as $field ) {

			if ( isset( $field['variables'] ) && false != $field['variables'] ) {

				foreach ( $field['variables'] as $field_variable ) {

					if ( isset( $field_variable['name'] ) ) {
						$variable_name     = esc_attr( $field_variable['name'] );
						$variable_callback = ( isset( $field_variable['callback'] ) && is_callable( $field_variable['callback'] ) ) ? $field_variable['callback'] : false;

						if ( $variable_callback ) {
							$variables[$field_variable['name']] = call_user_func( $field_variable['callback'], kirki_get_option( $field['settings'] ) );
						} else {
							$variables[$field_variable['name']] = self::get_option( $field['settings'] );
						}

					}

				}

			}

		}

		return apply_filters( 'kirki/variable', $variables );

	}

}
