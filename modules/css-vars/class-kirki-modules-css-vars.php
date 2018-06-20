<?php
/**
 * Handles the CSS-variables of fields.
 *
 * @package     Kirki
 * @category    Modules
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0.28
 */

/**
 * The Kirki_Modules_CSS_Vars object.
 *
 * @since 3.0.28
 */
class Kirki_Modules_CSS_Vars {

	/**
	 * The object instance.
	 *
	 * @static
	 * @access private
	 * @since 3.0.28
	 * @var object
	 */
	private static $instance;

	/**
	 * Fields with variables.
	 *
	 * @access private
	 * @since 3.0.28
	 * @var array
	 */
	private $fields = array();

	/**
	 * Constructor
	 *
	 * @access protected
	 * @since 3.0.28
	 */
	protected function __construct() {
		add_action( 'wp_head', array( $this, 'the_style' ), 0 );
		add_action( 'customize_preview_init', array( $this, 'postmessage' ) );
	}

	/**
	 * Gets an instance of this object.
	 * Prevents duplicate instances which avoid artefacts and improves performance.
	 *
	 * @static
	 * @access public
	 * @since 3.0.28
	 * @return object
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Add styles in <head>.
	 *
	 * @access public
	 * @since 3.0.28
	 * @return void
	 */
	public function the_style() {
		// Get an array of all fields.
		$fields = Kirki::$fields;
		echo '<style id="kirki-css-vars">';
		echo ':root{';
		foreach ( $fields as $id => $args ) {
			if ( ! isset( $args['css_vars'] ) || empty( $args['css_vars'] ) ) {
				continue;
			}
			$val = Kirki_Values::get_value( $args['kirki_config'], $id );
			foreach ( $args['css_vars'] as $css_var ) {
			if ( isset( $css_var[2] ) && is_array( $val ) && isset( $val[ $css_var[2] ] ) ) {
				$val = $val[ $css_var[2] ];
			}
			echo esc_attr( $css_var[0] ) . ':' . esc_attr( str_replace( '$', $val, $css_var[1] ) ) . ';';
		}
		}
		echo '}';
		echo '</style>';
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
		wp_enqueue_script( 'kirki_auto_css_vars', trailingslashit( Kirki::$url ) . 'modules/css-vars/script.js', array( 'jquery', 'customize-preview' ), KIRKI_VERSION, true );
		$fields = Kirki::$fields;
		$data   = array();
		foreach ( $fields as $field ) {
			if ( isset( $field['transport'] ) && 'postMessage' === $field['transport'] && isset( $field['css_vars'] ) && ! empty( $field['css_vars'] ) ) {
				$data[] = $field;
			}
		}
		wp_localize_script( 'kirki_auto_css_vars', 'kirkiCssVarFields', $data );
	}
}
