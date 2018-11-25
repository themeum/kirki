<?php
/**
 * Automatic postMessage scripts calculation for Kirki controls.
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
class Kirki_Modules_PostMessage {

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
		add_action( 'customize_preview_init', array( $this, 'postmessage' ) );
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
	 * Enqueues the postMessage script
	 * and adds variables to it using the wp_localize_script function.
	 * The rest is handled via JS.
	 */
	public function postmessage() {
		$i = self::get_instance();
		wp_enqueue_script( 'kirki_auto_postmessage', trailingslashit( Kirki::$url ) . 'modules/postmessage/postmessage.js', array( 'jquery', 'customize-preview' ), KIRKI_VERSION, true );
		$fields = Kirki::$fields;
		$data   = array();
		$breakpoints = null;
		foreach ( $fields as $field ) {
			if ( $breakpoints === null ) {
				$breakpoints = Kirki::get_config_param( $field['kirki_config'], 'media_queries' );
			}
			if ( isset( $field['transport'] ) && 'postMessage' === $field['transport'] && isset( $field['js_vars'] ) && ! empty( $field['js_vars'] ) && is_array( $field['js_vars'] ) && isset( $field['settings'] ) ) {
				$data[] = $field;
			}
		}
		// Reset this to null to fix media query check inside JS if its global.
		if ( $breakpoints['desktop'] === 'global' )
			$breakpoints['desktop'] = null;
		wp_localize_script( 'kirki_auto_postmessage', 'kirkiMediaQueries', $breakpoints );
		wp_localize_script( 'kirki_auto_postmessage', 'kirkiPostMessageFields', $data );
	}
}
