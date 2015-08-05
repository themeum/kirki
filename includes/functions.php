<?php
/**
 * Helper functions
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

if ( ! function_exists( 'kirki_path' ) ) {
	/**
	 * Returns the absolute path to the plugin.
	 * @return string
	 */
	function kirki_path() {
		return KIRKI_PATH;
	}
}

if ( ! function_exists( 'kirki_url' ) ) {
	/**
	 * Returns the URL of the plugin.
	 * @return string
	 */
	function kirki_url() {
		$config = apply_filters( 'kirki/config', array() );
		if ( isset( $config['url_path'] ) ) {
			return esc_url_raw( $config['url_path'] );
		} else {
			return KIRKI_URL;
		}
	}
}

if ( ! function_exists( 'kirki_active_callback' ) ) {
	/**
	 * Figure out whether the current object should be displayed or not.
	 *
	 * @param $object 	the current field
	 * @return boolean
	 */
	function kirki_active_callback( $object ) {

		// Get all fields
		$fields = Kirki::$fields;

		if ( ! isset( $fields[ $object->id ] ) ) {
			return true;
		}

		$current_object = $fields[ $object->id ];

		if ( isset( $current_object['required'] ) ) {

			foreach ( $current_object['required'] as $requirement ) {

				if ( ! is_object( $object->manager->get_setting( $fields[ $requirement['setting'] ]['settings'] ) ) ) {
					return true;
				}

				if ( isset( $show ) && ! $show ) {
					return false;
				}

				$value = $object->manager->get_setting( $fields[ $requirement['setting'] ]['settings'] )->value();
				switch ( $requirement['operator'] ) {
					case '===':
						$show = ( $requirement['value'] === $value ) ? true : false;
						break;
					case '==':
						$show = ( $requirement['value'] == $value ) ? true : false;
						break;
					case '!==':
						$show = ( $requirement['value'] !== $value ) ? true : false;
						break;
					case '!=':
						$show = ( $requirement['value'] != $value ) ? true : false;
						break;
					case '>=':
						$show = ( $requirement['value'] >= $value ) ? true : false;
						break;
					case '<=':
						$show = ( $requirement['value'] <= $value ) ? true : false;
						break;
					case '>':
						$show = ( $requirement['value'] > $value ) ? true : false;
						break;
					case '<':
						$show = ( $requirement['value'] < $value ) ? true : false;
						break;
					default:
						$show = ( $requirement['value'] == $value ) ? true : false;

				}

			}

		}

		return ( isset( $show ) && ( false === $show ) ) ? false : true;

	}
}
