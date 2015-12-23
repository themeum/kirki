<?php
/**
 * Generates the styles for the frontend.
 * Handles the 'output' argument of fields.
 * Usage instructions on https://github.com/aristath/kirki/wiki/output
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

	public $processed = false;

	public function __construct() {

		global $wp_customize;

		$config   = apply_filters( 'kirki/config', array() );
		$priority = ( isset( $config['styles_priority'] ) ) ? intval( $config['styles_priority'] ) : 999;

		if ( isset( $config['disable_output'] ) && true !== $config['disable_output'] ) {
			return;
		}

		// /**
		//  * If we are in the customizer, load CSS using inline-styles.
		//  * If we are in the frontend AND $config['inline_css'] == false
		//  * Then load dynamic CSS using AJAX.
		//  */
		// if ( ! $wp_customize && ( isset( $config['inline_css'] ) && false == $config['inline_css'] ) ) {
		// 	add_action( 'wp_enqueue_scripts', array( $this, 'frontend_styles' ), $priority );
		// 	add_action( 'wp_ajax_kirki_dynamic_css', array( $this, 'ajax_dynamic_css' ) );
		// 	add_action( 'wp_ajax_nopriv_kirki_dynamic_css', array( $this, 'ajax_dynamic_css' ) );
		// } else {
			add_action( 'wp_enqueue_scripts', array( $this, 'inline_dynamic_css' ), $priority );
		// }

	}

	public function inline_dynamic_css() {
		if ( ! $this->processed ) {
			wp_enqueue_style( 'kirki-styles', trailingslashit( Kirki::$url ) . 'assets/css/kirki-styles.css', null, null );
			wp_add_inline_style( 'kirki-styles', self::loop_controls() );
			$this->processed = true;
		}
	}

	// public function ajax_dynamic_css() {
	// 	require( Kirki::$path . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'dynamic-css.php' );
	// 	exit;
	// }
	//
	// public function frontend_styles() {
	// 	wp_enqueue_style( 'kirki-styles-php', admin_url( 'admin-ajax.php' ) . '?action=kirki_dynamic_css', null, null );
	// }

	/**
	 * loop through all fields and create an array of style definitions
	 */
	public static function loop_controls() {

		$fields = Kirki::$fields;
		$css    = array();

		// Early exit if no fields are found.
		if ( empty( $fields ) ) {
			return;
		}

		foreach ( $fields as $field ) {

			// Only continue if $field['output'] is set
			if ( isset( $field['output'] ) && ! empty( $field['output'] ) && 'background' != $field['type'] ) {

				if ( function_exists( 'array_replace_recursive' ) ) {
					$css = array_replace_recursive( $css, Kirki_Styles_Output_CSS::css( $field ) );
				} else {
					$css = Kirki_Helper::array_replace_recursive( $css, Kirki_Styles_Output_CSS::css( $field ) );
				}

			}

		}

		if ( is_array( $css ) ) {
			return Kirki_Styles_Output_CSS::styles_parse( Kirki_Styles_Output_CSS::add_prefixes( $css ) );
		}

		return;

	}

}
