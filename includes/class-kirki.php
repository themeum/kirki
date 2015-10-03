<?php
/**
 * The Kirki API class.
 * Takes care of adding panels, sections & fields to the customizer.
 * For documentation please see https://github.com/aristath/kirki/wiki
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

class Kirki extends Kirki_Init {

	public static $path;
	public static $url;

	public static $config   = array();
	public static $fields   = array();
	public static $panels   = array();
	public static $sections = array();

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
		return Kirki_Values::get_value( $config_id, $field_id );
	}

	/**
	 * Sets the configuration options.
	 *
	 * @var		string		the configuration ID.
	 * @var		array		the configuration options.
	 * @param string $config_id
	 */
	public static function add_config( $config_id, $args = array() ) {
		new Kirki_Config( $config_id, $args );
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
			$args['active_callback'] = ( isset( $args['required'] ) ) ? array( 'Kirki_Active_Callback', 'evaluate' ) : '__return_true';
		}

		self::$panels[ $args['id'] ] = $args;

	}

	/**
	 * Create a new section
	 *
	 * @var		string		the ID for this section
	 * @var		array		the section arguments
	 * @param string $id
	 */
	public static function add_section( $id, $args ) {

		$args['id']          = esc_attr( $id );
		$args['panel']       = ( isset( $args['panel'] ) ) ? esc_attr( $args['panel'] ) : '';
		$args['description'] = ( isset( $args['description'] ) ) ? esc_textarea( $args['description'] ) : '';
		$args['priority']    = ( isset( $args['priority'] ) ) ? esc_attr( $args['priority'] ) : 10;
		if ( ! isset( $args['active_callback'] ) ) {
			$args['active_callback'] = ( isset( $args['required'] ) ) ? array( 'Kirki_Active_Callback', 'evaluate' ) : '__return_true';
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
		Kirki_Field::add_field( $config_id, $args );
	}

	/**
	 * Find the config ID based on the field options
	 */
	public static function get_config_id( $field ) {
		return Kirki_Field::get_config_id( $field );
	}

}
