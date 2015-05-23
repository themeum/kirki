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

	public static function setSection( $config_id, $args = array() ) {

		if ( ! isset( $args['fields'] ) || ! isset( $args['subsection'] ) || ( isset( $args['subsection'] ) && ! $args['subsection'] ) ) { // This is a panel
			self::$panels[] = array(
				'id'          => isset( $args['id'] ) ? sanitize_key( $args['id'] ) : substr(str_shuffle("abcdefghijklmnopqrstuvwxyz-_"), 0, 7),
				'title'       => isset( $args['title'] ) ? $args['title'] : '',
				'priority'    => ( isset( $args['priority'] ) ) ? $args['priority'] : 10,
				'description' => ( isset( $args['desc'] ) ) ? $args['desc'] : '',
			);
		} else { // This is a section
			// Get the section ID
			if ( isset( $args['subsection'] ) && $args['subsection'] ) {
				$panel    = end( array_values( self::$panels ) );
				$panel_id = $panel['id'];
			}

			self::$sections[] = array(
				'id'          => isset( $args['id'] ) ? sanitize_key( $args['id'] ) : substr(str_shuffle("abcdefghijklmnopqrstuvwxyz-_"), 0, 7),
				'title'       => $args['title'],
				'priority'    => ( isset( $args['priority'] ) ) ? $args['priority'] : 10,
				'panel'       => ( isset( $panel_id ) ) ? $panel_id : '',
				'description' => ( isset( $args['desc'] ) ) ? $args['desc'] : '',
			);

			foreach ( $args['fields'] as $field ) {

				$field['section']     = isset( $args['id'] ) ? sanitize_key( $args['id'] ) : substr(str_shuffle("abcdefghijklmnopqrstuvwxyz-_"), 0, 7);
				$field['settings']    = $field['id'];
				$field['help']        = ( isset( $field['desc'] ) ) ? $field['desc'] : '';
				$field['description'] = ( isset( $field['subtitle'] ) ) ? $field['subtitle'] : '';
				$field['choices']     = ( isset( $field['options'] ) ) ? $field['options'] : '';

				switch ( $field['type'] ) {

					case 'ace_editor' :
						$field['type'] = 'textarea';
						break;
					case 'background' :
						// TODO
						break;
					case 'border' :
						// TODO
						break;
					case 'button_set' :
						$field['type'] = 'radio-buttonset';
						break;
					case 'checkbox' :
						if ( isset( $field['options'] ) && is_array( $field['options'] ) ) {
							$field['type'] = 'multicheck';
						}
					case 'color_gradient' :
						// TODO
						break;
					case 'color_rgba' :
						$field['type'] = 'color-alpha';
						break;
					case 'date' :
						// TODO
						break;
					case 'dimensions' :
						// TODO
						break;
					case 'divide' :
						// TODO
						break;
					case 'gallery' :
						// TODO
						break;
					case 'image_select' :
						$field['type'] = 'radio-image';
						break;
					case 'import_export' :
						// TODO
						break;
					case 'info' :
						$fiel['label'] = '';
						$field['help'] = '';
						$field['type'] = 'custom';
						$background_color = '#fcf8e3';
						$border_color     = '#faebcc';
						$text_color       = '#8a6d3b';
						if ( isset( $field['style'] ) ) {
							if ( 'success' == $field['style'] ) {
								$background_color = '#dff0d8';
								$border_color     = '#d6e9c6';
								$text_color       = '#3c763d';
							} elseif ( 'critical' == $field['style'] ) {
								$background_color = '#f2dede';
								$border_color     = '#ebccd1';
								$text_color       = '#a94442';
							}
						}
						$field['default']  = '<div style="background:' . $background_color . ';border-radius:4px;border:1px solid ' . $border_color . ';color:' . $text_color . ';">';
						$field['default'] .= ( isset( $field['title'] ) ) ? '<h4>' . $field['title'] . '</h4>' : '';
						$field['default'] .= ( isset( $field['desc'] ) ) ? $field['desc'] : '';
						$field['default'] .= '</div>';
						break;
					case 'link_color' :
						// TODO
						break;
					case 'media' :
						// TODO
						break;
					case 'multi_text' :
						// TODO
						break;
					case 'password' :
						// TODO
						break;
					case 'raw' :
						$field['default'] = $field['content'];
						break;
					case 'section' :
						// TODO
						break;
					case 'select_image' :
						// TODO
						break;
					case 'slides' :
						// TODO
						break;
					case 'sortable' :
						// TODO
						break;
					case 'sorter' :
						// TODO
						break;
					case 'spacing' :
						// TODO
						break;
					case 'spinner' :
						// TODO
						break;
					case 'switch' :
						// TODO
						break;
					case 'typography' :
						// TODO
						break;

				}

				self::add_field( $config_id, $field );

			}

		}

	}

}
