<?php
/**
 * Generates the styles for the frontend.
 * Handles the 'output' argument of fields.
 * Usage instructions on https://github.com/reduxframework/kirki/wiki/output
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
if ( class_exists( 'Kirki_Styles_Frontend' ) ) {
	return;
}

class Kirki_Styles_Frontend {

	public function __construct() {

		$priority = ( isset( $config['styles_priority'] ) ) ? intval( $config['styles_priority'] ) : 150;

		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_styles' ), $priority );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), $priority );

	}

	/**
	 * Add the inline styles
	 */
	public function enqueue_styles() {

		$config = apply_filters( 'kirki/config', array() );

		/**
		 * If we have set $config['disable_output'] to true,
		 * then do not proceed any further.
		 */
		if ( isset( $config['disable_output'] ) && true == $config['disable_output'] ) {
			return;
		}
		wp_add_inline_style( 'kirki-styles', $this->loop_controls() );

	}

	/**
	 * Add a dummy, empty stylesheet.
	 */
	public function frontend_styles() {

		$config = apply_filters( 'kirki/config', array() );

		/**
		 * If we have set $config['disable_output'] to true,
		 * then do not proceed any further.
		 */
		if ( isset( $config['disable_output'] ) && true == $config['disable_output'] ) {
			return;
		}
		wp_enqueue_style( 'kirki-styles', trailingslashit( kirki_url() ).'assets/css/kirki-styles.css', null, null );

	}

	/**
	 * loop through all fields and create an array of style definitions
	 */
	public function loop_controls() {

		$fields = Kirki::$fields;
		$css    = array();

		// Early exit if no fields are found.
		if ( empty( $fields ) ) {
			return;
		}

		foreach ( $fields as $field ) {

			// Only continue if $field['output'] is set
			if ( isset( $field['output'] ) && ! empty( $field['output'] ) && 'background' != $field['type'] ) {

				$css = array_merge_recursive( $css, Kirki_Output::css(
					Kirki_Field::sanitize_field( $field )
				) );

			}

		}

		if ( is_array( $css ) ) {
			return Kirki_Output::styles_parse( Kirki_Output::add_prefixes( $css ) );
		}

		return;

	}

}
