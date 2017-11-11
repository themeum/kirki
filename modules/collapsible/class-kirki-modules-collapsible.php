<?php
/**
 * Allows fields to collapse.
 *
 * @package     Kirki
 * @category    Modules
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
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
class Kirki_Modules_Collapsible {

	/**
	 * The object instance.
	 *
	 * @static
	 * @access private
	 * @since 3.0.0
	 * @var object
	 */
	private static $instance;

	/**
	 * Constructor.
	 *
	 * @access protected
	 * @since 3.0.0
	 */
	protected function __construct() {
		add_action( 'customize_controls_print_scripts', array( $this, 'customize_controls_print_scripts' ) );
	}

	/**
	 * Gets an instance of this object.
	 * Prevents duplicate instances which avoid artefacts and improves performance.
	 *
	 * @static
	 * @access public
	 * @since 3.0.0
	 * @return object
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Enqueues the script responsible for branding the customizer
	 * and also adds variables to it using the wp_localize_script function.
	 * The actual branding is handled via JS.
	 *
	 * @access public
	 * @since 3.0.0
	 */
	public function customize_controls_print_scripts() {

		wp_enqueue_script( 'kirki-collapsible', trailingslashit( Kirki::$url ) . 'modules/collapsible/collapsible.js', array( 'customize-preview' ), KIRKI_VERSION, true );
		wp_enqueue_style( 'kirki-collapsible', trailingslashit( Kirki::$url ) . 'modules/collapsible/collapsible.css', array(), KIRKI_VERSION );

		$collapsible_fields = array();
		$fields = Kirki::$fields;
		foreach ( $fields as $field ) {
			if ( isset( $field['collapsible'] ) && true === $field['collapsible'] && isset( $field['settings'] ) && isset( $field['label'] ) ) {
				$collapsible_fields[ $field['settings'] ] = $field['label'];
			}
		}
		$collapsible_fields = array_unique( $collapsible_fields );
		wp_localize_script( 'kirki-collapsible', 'collapsible', $collapsible_fields );

	}
}
