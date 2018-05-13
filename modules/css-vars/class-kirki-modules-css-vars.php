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
			if ( ! isset( $args['css_var'] ) || empty( $args['css_var'] ) ) {
				continue;
			}
			if ( is_string( $args['css_var'] ) ) {
				$args['css_var'] = array( $args['css_var'], '$' );
			}
			echo esc_attr( $args['css_var'][0] ) . ':' . esc_attr( str_replace( '$', Kirki_Values::get_value( $args['kirki_config'], $id ), $args['css_var'][1] ) ) . ';';
		}
		echo '}';
		echo '</style>';
	}
}
