<?php
/**
 * Handles the CSS-variables of fields.
 *
 * @package     Kirki
 * @category    Modules
 * @author      Ari Stathopoulos (@aristath)
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license    https://opensource.org/licenses/MIT
 * @since       3.0.28
 */

namespace Kirki\Module;

use Kirki\Compatibility\Values;
use Kirki\URL;

/**
 * The Module object.
 *
 * @since 3.0.28
 */
class CSS_Vars {

	/**
	 * CSS-variables array [var=>val].
	 *
	 * @access private
	 * @since 3.0.35
	 * @var array
	 */
	private $vars = [];

	/**
	 * Fields array.
	 *
	 * @access private
	 * @since 1.0
	 * @var array
	 */
	private $fields = [];

	/**
	 * Constructor
	 *
	 * @access public
	 * @since 3.0.28
	 */
	public function __construct() {
		add_action( 'kirki_field_init', [ $this, 'field_init' ] );
		add_action( 'init', [ $this, 'populate_vars' ], 20 );
		add_action( 'wp_head', [ $this, 'the_style' ], 999 );
		add_action( 'admin_head', [ $this, 'the_style' ], 999 );
		add_action( 'customize_preview_init', [ $this, 'postmessage' ] );
	}

	/**
	 * Runs when a field gets added.
	 * Adds fields to this object so their styles can later be generated.
	 *
	 * @access public
	 * @since 1.0
	 * @param array $args The field args.
	 * @return void
	 */
	public function field_init( $args ) {
		if ( ! isset( $args['css_vars'] ) ) {
			return;
		}
		$args['css_vars'] = (array) $args['css_vars'];
		if ( isset( $args['css_vars'][0] ) && is_string( $args['css_vars'][0] ) ) {
			$args['css_vars'] = [ $args['css_vars'] ];
		}
		foreach ( $args['css_vars'] as $key => $val ) {
			if ( ! isset( $val[1] ) ) {
				$args['css_vars'][ $key ][1] = '$';
			}
		}
		$this->fields[ $args['settings'] ] = $args;
	}

	/**
	 * Populates the $vars property of this object.
	 *
	 * @access public
	 * @since 3.0.35
	 * @return void
	 */
	public function populate_vars() {

		// Get an array of all fields.
		$fields = class_exists( '\Kirki\Compatibility\Kirki' ) ? \Kirki\Compatibility\Kirki::$fields : [];
		$fields = array_merge( $fields, $this->fields );
		foreach ( $fields as $id => $args ) {
			if ( ! isset( $args['css_vars'] ) || empty( $args['css_vars'] ) ) {
				continue;
			}
			$val = Values::get_value( $args['kirki_config'], $id );
			foreach ( $args['css_vars'] as $css_var ) {
				if ( isset( $css_var[2] ) && is_array( $val ) && isset( $val[ $css_var[2] ] ) ) {
					$this->vars[ $css_var[0] ] = str_replace( '$', $val[ $css_var[2] ], $css_var[1] );
				} else {
					$this->vars[ $css_var[0] ] = str_replace( '$', $val, $css_var[1] );
				}
			}
		}
	}

	/**
	 * Add styles in <head>.
	 *
	 * @access public
	 * @since 3.0.28
	 * @return void
	 */
	public function the_style() {
		if ( empty( $this->vars ) ) {
			return;
		}

		echo '<style id="kirki-css-vars">';
		echo ':root{';
		foreach ( $this->vars as $var => $val ) {
			echo esc_html( $var ) . ':' . esc_html( $val ) . ';';
		}
		echo '}';
		echo '</style>';
	}

	/**
	 * Get an array of all the variables.
	 *
	 * @access public
	 * @since 3.0.35
	 * @return array
	 */
	public function get_vars() {
		return $this->vars;
	}

	/**
	 * Enqueues the script that handles postMessage
	 * and adds variables to it using the wp_localize_script function.
	 * The rest is handled via JS.
	 *
	 * @access public
	 * @since 3.0.28
	 * @return void
	 */
	public function postmessage() {
		wp_enqueue_script( 'kirki_auto_css_vars', URL::get_from_path( __DIR__ . '/script.js' ), [ 'jquery', 'customize-preview' ], '1.0', true );
		$fields = class_exists( '\Kirki\Compatibility\Kirki' ) ? \Kirki\Compatibility\Kirki::$fields : [];
		$fields = array_merge( $fields, $this->fields );
		$data   = [];
		foreach ( $fields as $field ) {
			if ( isset( $field['transport'] ) && 'postMessage' === $field['transport'] && isset( $field['css_vars'] ) && ! empty( $field['css_vars'] ) ) {
				$data[] = $field;
			}
		}
		wp_localize_script( 'kirki_auto_css_vars', 'kirkiCssVarFields', $data );
	}
}
