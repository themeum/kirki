<?php
/**
 * Handles the reset buttons on sections.
 *
 * @package     Kirki
 * @category    Modules
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0.0
 */

/**
 * The Kirki_Modules_Reset object.
 */
class Kirki_Modules_Reset {

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
	 */
	protected function __construct() {
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_controls_enqueue_scripts' ), 20 );
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
	 * Enqueue scripts
	 *
	 * @access public
	 * @since 3.0.0
	 */
	public function customize_controls_enqueue_scripts() {

		$translation_strings = array(
			/* translators: Icon followed by reset label. */
			'reset-with-icon' => sprintf( esc_attr__( '%s Reset', 'kirki' ), '<span class="dashicons dashicons-update"></span><span class="label">' ) . '</span>',
		);
		// Enqueue the reset script.
		wp_enqueue_script( 'kirki-set-setting-value', trailingslashit( Kirki::$url ) . 'modules/reset/set-setting-value.js', array( 'jquery', 'customize-base', 'customize-controls' ) );
		wp_enqueue_script( 'kirki-reset', trailingslashit( Kirki::$url ) . 'modules/reset/reset.js', array( 'jquery', 'customize-base', 'customize-controls', 'kirki-set-setting-value' ) );
		wp_localize_script( 'kirki-reset', 'kirkiResetButtonLabel', $translation_strings );
		wp_enqueue_style( 'kirki-reset', trailingslashit( Kirki::$url ) . 'modules/reset/reset.css', null );

	}
}
