<?php
/**
 * Handles sections created via the Kirki API.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

/**
 * Handle selective refreshes introduced in WordPress 4.5.
 */
class Kirki_Selective_Refresh {

	/**
	 * Adds any necessary actions & filters.
	 */
	public function __construct() {
		add_action( 'customize_register', array( $this, 'register_partials' ), 99 );
	}

	/**
	 * Parses all fields and searches for the "partial_refresh" argument inside them.
	 * If that argument is found, then it starts parsing the array of arguments.
	 * Registers a selective_refresh in the customizer for each one of them.
	 *
	 * @param object $wp_customize WP_Customize_Manager.
	 */
	public function register_partials( $wp_customize ) {

		// Abort if selective refresh is not available.
		if ( ! isset( $wp_customize->selective_refresh ) ) {
			return;
		}

		// Get an array of all fields.
		$fields = Kirki::$fields;

		// Start parsing the fields.
		foreach ( $fields as $field_id => $args ) {
			if ( isset( $args['partial_refresh'] ) && ! empty( $args['partial_refresh'] ) ) {
				// Start going through each item in the array of partial refreshes.
				foreach ( $args['partial_refresh'] as $partial_refresh => $partial_refresh_args ) {
					// If we have all we need, create the selective refresh call.
					if ( isset( $partial_refresh_args['render_callback'] ) && isset( $partial_refresh_args['selector'] ) ) {
						$partial_refresh_args = wp_parse_args( $partial_refresh_args, array(
							'settings' => $args['settings'],
						) );
						$wp_customize->selective_refresh->add_partial( $partial_refresh, $partial_refresh_args );
					}
				}
			}
		}
	}
}
