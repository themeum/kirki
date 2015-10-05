<?php
/**
 * Repeater Customizer Setting.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2015, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Early exit if the class already exists
if ( class_exists( 'Kirki_Settings_Repeater_Setting' ) ) {
	return;
}

class Kirki_Settings_Repeater_Setting extends WP_Customize_Setting {

	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );

		// Will onvert the setting from JSON to array. Must be triggered very soon
		add_filter( "customize_sanitize_{$this->id}", array( $this, 'sanitize_repeater_setting' ), 10, 1 );
	}

	public function value() {
		$value = parent::value();
		if ( ! is_array( $value ) ) {
					$value = array();
		}

		return $value;
	}

	/**
	 * Convert the JSON encoded setting coming from Customizer to an Array
	 *
	 * @param $value URL Encoded JSON Value
	 *
	 * @return array
	 */
	public function sanitize_repeater_setting( $value ) {

		if ( ! is_array( $value ) ) {
			$value = json_decode( urldecode( $value ) );
		}
		$sanitized = ( empty( $value ) || ! is_array( $value ) ) ? array() : $value;

		// Make sure that every row is an array, not an object
		foreach ( $sanitized as $key => $_value ) {
			if ( empty( $_value ) ) {
				unset( $sanitized[ $key ] );
			} else {
				$sanitized[ $key ] = (array) $_value;
			}
		}

		// Reindex array
		$sanitized = array_values( $sanitized );

		return $sanitized;

	}

}
