<?php
/**
 * Handles the CSS-variables of fields.
 *
 * @package     Kirki
 * @category    Modules
 * @author      Ari Stathopoulos (@aristath)
 * @copyright   Copyright (c) 2020, David Vongries
 * @license     https://opensource.org/licenses/MIT
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
	 * CSS-variables array [var=>val].
	 *
	 * @access private
	 * @since 3.0.35
	 * @var array
	 */
	private $vars = array();

	/**
	 * Constructor
	 *
	 * @access protected
	 * @since 3.0.28
	 */
	protected function __construct() {
		add_action( 'init', array( $this, 'populate_vars' ) );
		add_action( 'wp_head', array( $this, 'the_style' ), 999 );
		add_action( 'admin_head', array( $this, 'the_style' ), 999 );
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
	 * Populates the $vars property of this object.
	 *
	 * @access public
	 * @since 3.0.35
	 * @return void
	 */
	public function populate_vars() {

		// Get an array of all fields.
		$fields = Kirki::$fields;
		foreach ( $fields as $id => $args ) {
			if ( ! isset( $args['css_vars'] ) || empty( $args['css_vars'] ) ) {
				continue;
			}
			$val = Kirki_Values::get_value( $args['kirki_config'], $id );
			if ( isset( $args['type'] ) && in_array( $args['type'], array( 'typography', 'kirki-typography' ), true ) ) {
				if ( isset( $val['font-weight'] ) && 'regular' === $val['font-weight'] ) {
					$val['font-weight'] = '400';
				}
			}
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
