<?php
/**
 * The Kirki API class.
 * Takes care of adding panels, sections & fields to the customizer.
 * For documentation please see https://github.com/aristath/kirki/wiki
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license    https://opensource.org/licenses/MIT
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This class acts as an interface.
 * Developers may use this object to add configurations, fields, panels and sections.
 * You can also access all available configurations, fields, panels and sections
 * by accessing the object's static properties.
 */
class Kirki extends Kirki_Init {

	/**
	 * Absolute path to the Kirki folder.
	 *
	 * @static
	 * @access public
	 * @var string
	 */
	public static $path;

	/**
	 * URL to the Kirki folder.
	 *
	 * @static
	 * @access public
	 * @var string
	 */
	public static $url;

	/**
	 * An array containing all configurations.
	 *
	 * @static
	 * @access public
	 * @var array
	 */
	public static $config = array();

	/**
	 * An array containing all fields.
	 *
	 * @static
	 * @access public
	 * @var array
	 */
	public static $fields = array();

	/**
	 * An array containing all panels.
	 *
	 * @static
	 * @access public
	 * @var array
	 */
	public static $panels = array();

	/**
	 * An array containing all sections.
	 *
	 * @static
	 * @access public
	 * @var array
	 */
	public static $sections = array();

	/**
	 * An array containing all panels to be removed.
	 *
	 * @static
	 * @access public
	 * @since 3.0.17
	 * @var array
	 */
	public static $panels_to_remove = array();

	/**
	 * An array containing all sections to be removed.
	 *
	 * @static
	 * @access public
	 * @since 3.0.17
	 * @var array
	 */
	public static $sections_to_remove = array();

	/**
	 * An array containing all controls to be removed.
	 *
	 * @static
	 * @access public
	 * @since 3.0.17
	 * @var array
	 */
	public static $controls_to_remove = array();

	/**
	 * Modules object.
	 *
	 * @access public
	 * @since 3.0.0
	 * @var object
	 */
	public $modules;

	/**
	 * Get the value of an option from the db.
	 *
	 * @static
	 * @access public
	 * @param string $config_id The ID of the configuration corresponding to this field.
	 * @param string $field_id  The field_id (defined as 'settings' in the field arguments).
	 * @return mixed The saved value of the field.
	 */
	public static function get_option( $config_id = '', $field_id = '' ) {

		return Kirki_Values::get_value( $config_id, $field_id );
	}

	/**
	 * Sets the configuration options.
	 *
	 * @static
	 * @access public
	 * @param string $config_id The configuration ID.
	 * @param array  $args      The configuration options.
	 */
	public static function add_config( $config_id, $args = array() ) {

		$config                             = Kirki_Config::get_instance( $config_id, $args );
		$config_args                        = $config->get_config();
		self::$config[ $config_args['id'] ] = $config_args;
	}

	/**
	 * Create a new panel.
	 *
	 * @static
	 * @access public
	 * @param string $id   The ID for this panel.
	 * @param array  $args The panel arguments.
	 */
	public static function add_panel( $id = '', $args = array() ) {

		$args['id']          = esc_attr( $id );
		$args['description'] = ( isset( $args['description'] ) ) ? $args['description'] : '';
		$args['priority']    = ( isset( $args['priority'] ) ) ? absint( $args['priority'] ) : 10;
		$args['type']        = ( isset( $args['type'] ) ) ? $args['type'] : 'default';
		$args['type']        = 'kirki-' . $args['type'];

		self::$panels[ $args['id'] ] = $args;
	}

	/**
	 * Remove a panel.
	 *
	 * @static
	 * @access public
	 * @since 3.0.17
	 * @param string $id   The ID for this panel.
	 */
	public static function remove_panel( $id = '' ) {
		if ( ! in_array( $id, self::$panels_to_remove, true ) ) {
			self::$panels_to_remove[] = $id;
		}
	}

	/**
	 * Create a new section.
	 *
	 * @static
	 * @access public
	 * @param string $id   The ID for this section.
	 * @param array  $args The section arguments.
	 */
	public static function add_section( $id, $args ) {

		$args['id']          = esc_attr( $id );
		$args['panel']       = ( isset( $args['panel'] ) ) ? esc_attr( $args['panel'] ) : '';
		$args['description'] = ( isset( $args['description'] ) ) ? $args['description'] : '';
		$args['priority']    = ( isset( $args['priority'] ) ) ? absint( $args['priority'] ) : 10;
		$args['type']        = ( isset( $args['type'] ) ) ? $args['type'] : 'default';
		$args['type']        = 'kirki-' . $args['type'];

		self::$sections[ $args['id'] ] = $args;
	}

	/**
	 * Remove a section.
	 *
	 * @static
	 * @access public
	 * @since 3.0.17
	 * @param string $id   The ID for this panel.
	 */
	public static function remove_section( $id = '' ) {
		if ( ! in_array( $id, self::$sections_to_remove, true ) ) {
			self::$sections_to_remove[] = $id;
		}
	}

	/**
	 * Create a new field.
	 *
	 * @static
	 * @access public
	 * @param string $config_id The configuration ID for this field.
	 * @param array  $args      The field arguments.
	 */
	public static function add_field( $config_id, $args ) {

		if ( doing_action( 'customize_register' ) ) {
			_doing_it_wrong( __METHOD__, esc_attr__( 'Kirki fields should not be added on customize_register. Please add them directly, or on init.', 'kirki' ), '3.0.10' );
		}

		// Early exit if 'type' is not defined.
		if ( ! isset( $args['type'] ) ) {
			return;
		}

		// If the field is font-awesome, enqueue the icons on the frontend.
		if ( class_exists( 'Kirki_Modules_CSS' ) && ( 'fontawesome' === $args['type'] || 'kirki-fontawesome' === $args['type'] ) ) {
			Kirki_Modules_CSS::add_fontawesome_script();
		}

		$str       = str_replace( array( '-', '_' ), ' ', $args['type'] );
		$classname = 'Kirki_Field_' . str_replace( ' ', '_', ucwords( $str ) );
		if ( class_exists( $classname ) ) {
			new $classname( $config_id, $args );
			return;
		}
		if ( false !== strpos( $classname, 'Kirki_Field_Kirki_' ) ) {
			$classname = str_replace( 'Kirki_Field_Kirki_', 'Kirki_Field_', $classname );
			if ( class_exists( $classname ) ) {
				new $classname( $config_id, $args );
				return;
			}
		}

		new Kirki_Field( $config_id, $args );

	}

	/**
	 * Remove a control.
	 *
	 * @static
	 * @access public
	 * @since 3.0.17
	 * @param string $id The field ID.
	 */
	public static function remove_control( $id ) {
		if ( ! in_array( $id, self::$controls_to_remove, true ) ) {
			self::$controls_to_remove[] = $id;
		}
	}

	/**
	 * Gets a parameter for a config-id.
	 *
	 * @static
	 * @access public
	 * @since 3.0.10
	 * @param string $id    The config-ID.
	 * @param string $param The parameter we want.
	 * @return string
	 */
	public static function get_config_param( $id, $param ) {

		if ( ! isset( self::$config[ $id ] ) || ! isset( self::$config[ $id ][ $param ] ) ) {
			return '';
		}
		return self::$config[ $id ][ $param ];
	}
}
