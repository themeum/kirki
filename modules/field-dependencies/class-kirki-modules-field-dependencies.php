<?php
/**
 * Automatic field-dependencies scripts calculation for Kirki controls.
 *
 * @package     Kirki
 * @category    Modules
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds styles to the customizer.
 */
class Kirki_Modules_Field_Dependencies {

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 3.0.0
	 */
	public function __construct() {
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'field_dependencies' ) );
	}

	/**
	 * Enqueues the field-dependencies script
	 * and adds variables to it using the wp_localize_script function.
	 * The rest is handled via JS.
	 */
	public function field_dependencies() {

		wp_enqueue_script( 'kirki_field_dependencies', trailingslashit( Kirki::$url ) . 'modules/field-dependencies/field-dependencies.js', array( 'jquery', 'customize-base', 'customize-controls' ), false, true );
		$field_dependencies = array();
		$fields = Kirki::$fields;
		foreach ( $fields as $field ) {
			$process_field = false;
			if ( isset( $field['active_callback'] ) && is_array( $field['active_callback'] ) ) {
				if ( array( 'Kirki_Active_Callback', 'evaluate' ) === $field['active_callback'] ) {
					$process_field = true;
				}
			}
			if ( $process_field && isset( $field['required'] ) && ! empty( $field['required'] ) ) {
				$field_dependencies[ $field['id'] ] = $field['required'];
			}
		}
		wp_localize_script( 'kirki_field_dependencies', 'fieldDependencies', $field_dependencies );

	}
}
