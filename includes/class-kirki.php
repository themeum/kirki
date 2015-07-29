<?php
/**
 * The Kirki API class.
 * Takes care of adding panels, sections & fields to the customizer.
 * For documentation please see https://github.com/reduxframework/kirki/wiki
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2015, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Early exit if the class already exists
if ( class_exists( 'Kirki' ) ) {
	return;
}

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
	 * @return void
	 */
	public function add_to_customizer() {
		$this->fields_from_filters();
		add_action( 'customize_register', array( $this, 'add_panels' ), 97 );
		add_action( 'customize_register', array( $this, 'add_sections' ), 98 );
		add_action( 'customize_register', array( $this, 'add_fields' ), 99 );
	}

	/**
	 * Process fields added using the 'kirki/fields' and 'kirki/controls' filter.
	 * These filters are no longer used, this is simply for backwards-compatibility
	 */
	public function fields_from_filters() {

		$fields = apply_filters( 'kirki/controls', array() );
		$fields = apply_filters( 'kirki/fields', $fields );

		if ( ! empty( $fields ) ) {
			foreach ( $fields as $field ) {
				self::add_field( 'global', $field );
			}
		}

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
	public static function get_option( $config_id = '', $field_id = '' ) {

		/**
		 * Make sure value is defined
		 */
		$value = '';

		/**
		 * This allows us to skip the $config_id argument.
		 * If we skip adding a $config_id, use the 'global' configuration.
		 */
		if ( ( '' == $field_id ) && '' != $config_id ) {
			$field_id  = $config_id;
			$config_id = 'global';
		}

		/**
		 * If $config_id is empty, set it to 'global'.
		 */
		$config_id = ( '' == $config_id ) ? 'global' : $config_id;

		if ( 'theme_mod' == self::$config[ $config_id ]['option_type'] ) {
			/**
			 * We're using theme_mods.
			 * so just get the value using get_theme_mod
			 */
			$value = get_theme_mod( $field_id, self::$fields[ $field_id ]['default'] );

			/**
			 * If the field is a background field, then get the sub-fields
			 * and return an array of the values.
			 */
			if ( 'background' == self::$fields[ $field_id ]['type'] ) {
				$value = array();
				foreach ( self::$fields[ $field_id ]['default'] as $property_key => $property_default ) {
					$value[ $property_key ] = get_theme_mod( $field_id.'_'.$property_key, $property_default );
				}
			}

		} elseif ( 'option' == self::$config[ $config_id ]['option_type'] ) {
			/**
			 * We're using options.
			 */
			if ( '' != self::$config[ $config_id ]['option_name'] ) {
				/**
				 * Options are serialized as a single option in the db.
				 * We'll have to get the option and then get the item from the array.
				 */
				$options = get_option( self::$config[ $config_id ]['option_name'] );

				if ( ! isset( self::$fields[ $field_id ] ) && isset( self::$fields[ self::$config[ $config_id ]['option_name'].'['.$field_id.']' ] ) ) {
					$field_id = self::$config[ $config_id ]['option_name'].'['.$field_id.']';
				}
				$setting_modified = str_replace( ']', '', str_replace( self::$config[ $config_id ]['option_name'].'[', '', $field_id ) );

				/**
				 * If this is a background field, get the individual sub-fields and return an array.
				 */
				if ( 'background' == self::$fields[ $field_id ]['type'] ) {
					$value = array();

					foreach ( self::$fields[ $field_id ]['default'] as $property => $property_default ) {

						if ( isset( $options[ $setting_modified.'_'.$property ] ) ) {
							$value[ $property ] = $options[ $setting_modified.'_'.$property ];
						} else {
							$value[ $property ] = $property_default;
						}
					}
				} else {
					/**
					 * This is not a background field so continue and get the value.
					 */
					$value = ( isset( $options[ $setting_modified ] ) ) ? $options[ $setting_modified ] : self::$fields[ $field_id ]['default'];
					$value = maybe_unserialize( $value );
				}

			} else {
				/**
				 * Each option separately saved in the db
				 */
				$value = get_option( $field_id, self::$fields[ $field_id ]['default'] );

				/**
				 * If the field is a background field, then get the sub-fields
				 * and return an array of the values.
				 */
				if ( 'background' == self::$fields[ $field_id ]['type'] ) {
					$value = array();
					foreach ( self::$fields[ $field_id ]['default'] as $property_key => $property_default ) {
						$value[ $property_key ] = get_option( $field_id.'_'.$property_key, $property_default );
					}
				}

			}

		}

		/**
		 * reduxframework compatibility tweaks.
		 * If KIRKI_REDUX_COMPATIBILITY is defined as true then modify the output of the values
		 * and make them compatible with Redux.
		 */
		if ( defined( 'KIRKI_REDUX_COMPATIBILITY' ) && KIRKI_REDUX_COMPATIBILITY ) {

			switch ( self::$fields[ $field_id ]['type'] ) {

				case 'image':
					$value = Kirki_Helper::get_image_from_url( $value );
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
			'capability'  => 'edit_theme_options',
			'option_type' => 'theme_mod',
			'option_name' => '',
			'compiler'    => array(),
		);
		$args = array_merge( $default_args, $args );

		/**
		 * Allow empty value as the config ID by setting the id to global.
		 */
		$config_id = ( '' == $config_id ) ? 'global' : $config_id;
		/**
		 * Set the config
		 */
		self::$config[ $config_id ] = $args;

	}

	/**
	 * register our panels to the WordPress Customizer
	 * @var	object	The WordPress Customizer object
	 */
	public function add_panels( $wp_customize ) {

		if ( ! empty( self::$panels ) ) {

			foreach ( self::$panels as $panel ) {
				$wp_customize->add_panel( sanitize_key( $panel['id'] ), array(
					'title'           => esc_textarea( $panel['title'] ),
					'priority'        => esc_attr( $panel['priority'] ),
					'description'     => esc_textarea( $panel['description'] ),
					'active_callback' => $panel['active_callback'],
				) );
			}

		}
	}

	/**
	 * register our sections to the WordPress Customizer
	 * @var	object	The WordPress Customizer object
	 */
	public function add_sections( $wp_customize ) {

		if ( ! empty( self::$sections ) ) {

			foreach ( self::$sections as $section ) {
				$wp_customize->add_section( sanitize_key( $section['id'] ), array(
					'title'           => esc_textarea( $section['title'] ),
					'priority'        => esc_attr( $section['priority'] ),
					'panel'           => esc_attr( $section['panel'] ),
					'description'     => esc_textarea( $section['description'] ),
					'active_callback' => $section['active_callback'],
				) );
			}

		}

	}

	/**
	 * Create the settings and controls from the $fields array and register them.
	 * @var	object	The WordPress Customizer object
	 */
	public function add_fields( $wp_customize ) {

		$control_types = apply_filters( 'kirki/control_types', array(
			'color'            => 'WP_Customize_Color_Control',
			'color-alpha'      => 'Kirki_Controls_Color_Alpha_Control',
			'image'            => 'WP_Customize_Image_Control',
			'upload'           => 'WP_Customize_Upload_Control',
			'switch'           => 'Kirki_Controls_Switch_Control',
			'toggle'           => 'Kirki_Controls_Toggle_Control',
			'radio-buttonset'  => 'Kirki_Controls_Radio_ButtonSet_Control',
			'radio-image'      => 'Kirki_Controls_Radio_Image_Control',
			'sortable'         => 'Kirki_Controls_Sortable_Control',
			'slider'           => 'Kirki_Controls_Slider_Control',
			'number'           => 'Kirki_Controls_Number_Control',
			'multicheck'       => 'Kirki_Controls_MultiCheck_Control',
			'palette'          => 'Kirki_Controls_Palette_Control',
			'custom'           => 'Kirki_Controls_Custom_Control',
			'editor'           => 'Kirki_Controls_Editor_Control',
			'select2'          => 'Kirki_Controls_Select2_Control',
			'select2-multiple' => 'Kirki_Controls_Select2_Multiple_Control',
			'dimension'        => 'Kirki_Controls_Dimension_Control',
		) );

		foreach ( self::$fields as $field ) {

			if ( 'background' == $field['type'] ) {
				continue;
			}

			$wp_customize->add_setting( Kirki_Field::sanitize_settings( $field ), array(
				'default'           => Kirki_Field::sanitize_default( $field ),
				'type'              => Kirki_Field::sanitize_type( $field ),
				'capability'        => Kirki_Field::sanitize_capability( $field ),
				'transport'         => Kirki_Field::sanitize_transport( $field ),
				'sanitize_callback' => Kirki_Field::sanitize_callback( $field ),
			) );

			if ( array_key_exists( $field['type'], $control_types ) ) {

				$class_name = $control_types[ $field['type'] ];
				$wp_customize->add_control( new $class_name(
					$wp_customize,
					Kirki_Field::sanitize_id( $field ),
					Kirki_Field::sanitize_field( $field )
				) );

			} else {

				$wp_customize->add_control( new WP_Customize_Control(
					$wp_customize,
					Kirki_Field::sanitize_id( $field ),
					Kirki_Field::sanitize_field( $field )
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
	public static function add_panel( $id = '', $args = array() ) {

		$args['id']          = esc_attr( $id );
		$args['description'] = ( isset( $args['description'] ) ) ? esc_textarea( $args['description'] ) : '';
		$args['priority']    = ( isset( $args['priority'] ) ) ? esc_attr( $args['priority'] ) : 10;
		if ( ! isset( $args['active_callback'] ) ) {
			$args['active_callback'] = ( isset( $args['required'] ) ) ? 'kirki_active_callback' : '__return_true';
		}

		self::$panels[ $args['id'] ] = $args;

	}

	/**
	 * Create a new section
	 *
	 * @var		string		the ID for this section
	 * @var		array		the section arguments
	 */
	public static function add_section( $id, $args ) {

		$args['id']          = esc_attr( $id );
		$args['panel']       = ( isset( $args['panel'] ) ) ? esc_attr( $args['panel'] ) : '';
		$args['description'] = ( isset( $args['description'] ) ) ? esc_textarea( $args['description'] ) : '';
		$args['priority']    = ( isset( $args['priority'] ) ) ? esc_attr( $args['priority'] ) : 10;
		if ( ! isset( $args['active_callback'] ) ) {
			$args['active_callback'] = ( isset( $args['required'] ) ) ? 'kirki_active_callback' : '__return_true';
		}

		self::$sections[ $args['id'] ] = $args;

	}

	/**
	 * Create a new field
	 *
	 * @var		string		the configuration ID for this field
	 * @var		array		the field arguments
	 */
	public static function add_field( $config_id, $args ) {

		if ( is_array( $config_id ) && empty( $args ) ) {
			$args      = $config_id;
			$config_id = 'global';
		}

		$config_id = ( '' == $config_id ) ? 'global' : $config_id;

		/**
		 * Get the configuration options
		 */
		$config = self::$config[ $config_id ];

		/**
		 * If we've set an option in the configuration
		 * then make sure we're using options and not theme_mods
		 */
		if ( '' != $config['option_name'] ) {
			$config['option_type'] = 'option';
		}

		/**
		 * If no option name has been set for the field,
		 * use the one from the configuration
		 */
		if ( ! isset( $args['option_name'] ) ) {
			$args['option_name'] = $config['option_name'];
		}

		/**
		 * If no capability has been set for the field,
		 * use the one from the configuration
		 */
		if ( ! isset( $args['capability'] ) ) {
			$args['capability'] = $config['capability'];
		}

		/**
		 * Check if [settings] is set.
		 * If not set, check for [setting]
		 */
		if ( ! isset( $args['settings'] ) && isset( $args['setting'] ) ) {
			$args['settings'] = $args['setting'];
		}

		/**
		 * If no option-type has been set for the field,
		 * use the one from the configuration
		 */
		if ( ! isset( $args['option_type'] ) ) {
			$args['option_type'] = $config['option_type'];
		}

		/**
		 * Add the field to the static $fields variable properly indexed
		 */
		self::$fields[ Kirki_Field::sanitize_settings( $args ) ] = $args;

		if ( 'background' == $args['type'] ) {
			/**
			 * Build the background fields
			 */
			self::$fields = Kirki_Explode_Background_Field::process_fields( self::$fields );
		}

	}

	/**
	 * Find the config ID based on the field options
	 */
	public static function get_config_id( $field ) {

		/**
		 * Get the array of configs from the Kirki class
		 */
		$configs = Kirki::$config;
		/**
		 * Loop through all configs and search for a match
		 */
		foreach ( $configs as $config_id => $config_args ) {
			$option_type = ( isset( $config_args['option_type'] ) ) ? $config_args['option_type'] : 'theme_mod';
			$option_name = ( isset( $config_args['option_name'] ) ) ? $config_args['option_name'] : '';
			$types_match = false;
			$names_match = false;
			if ( isset( $field['option_type'] ) ) {
				$types_match = ( $option_type == $field['option_type'] ) ? true : false;
			}
			if ( isset( $field['option_name'] ) ) {
				$names_match = ( $option_name == $field['option_name'] ) ? true : false;
			}

			if ( $types_match && $names_match ) {
				$active_config = $config_id;
			}
		}

		return $config_id;

	}

	/**
	 * Build the variables.
	 *
	 * @return array 	('variable-name' => value)
	 */
	public function get_variables() {

		$variables = array();

		/**
		 * Loop through all fields
		 */
		foreach ( self::$fields as $field ) {
			/**
			 * Check if we have variables for this field
			 */
			if ( isset( $field['variables'] ) && false != $field['variables'] && ! empty( $field['variables'] ) ) {
				/**
				 * Loop through the array of variables
				 */
				foreach ( $field['variables'] as $field_variable ) {
					/**
					 * Is the variable ['name'] defined?
					 * If yes, then we can proceed.
					 */
					if ( isset( $field_variable['name'] ) ) {
						/**
						 * Sanitize the variable name
						 */
						$variable_name     = esc_attr( $field_variable['name'] );
						/**
						 * Do we have a callback function defined?
						 * If not then set $variable_callback to false.
						 */
						$variable_callback = ( isset( $field_variable['callback'] ) && is_callable( $field_variable['callback'] ) ) ? $field_variable['callback'] : false;
						/**
						 * If we have a variable_callback defined then get the value of the option
						 * and run it through the callback function.
						 * If no callback is defined (false) then just get the value.
						 */
						if ( $variable_callback ) {
							$variables[ $variable_name ] = call_user_func( $field_variable['callback'], self::get_option( Kirki_Field::sanitize_settings( $field ) ) );
						} else {
							$variables[ $variable_name ] = self::get_option( $field['settings'] );
						}

					}

				}

			}

		}
		/**
		 * Pass the variables through a filter ('kirki/variable')
		 * and return the array of variables
		 */
		return apply_filters( 'kirki/variable', $variables );

	}

}
