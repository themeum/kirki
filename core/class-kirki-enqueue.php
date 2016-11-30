<?php
/**
 * Enqueue the scripts that are required by the customizer.
 * Any additional scripts that are required by individual controls
 * are enqueued in the control classes themselves.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueues JS & CSS assets
 */
class Kirki_Enqueue {

	/**
	 * The class constructor.
	 * Adds actions to enqueue our assets.
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'customize_controls_l10n' ), 1 );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_controls_enqueue_scripts' ), 7 );
	}

	/**
	 * L10n helper for controls.
	 */
	public function customize_controls_l10n() {

		// Register the l10n script.
		wp_register_script( 'kirki-l10n', trailingslashit( Kirki::$url ) . 'assets/js/l10n.js' );

		// Add localization strings.
		// We'll do this on a per-config basis so that the filters are properly applied.
		$configs = Kirki::$config;
		$l10n    = array();
		foreach ( $configs as $id => $args ) {
			$l10n[ $id ] = Kirki_l10n::get_strings( $id );
		}

		wp_localize_script( 'kirki-l10n', 'kirkiL10n', $l10n );
		wp_enqueue_script( 'kirki-l10n' );

	}

	/**
	 * Assets that have to be enqueued in 'customize_controls_enqueue_scripts'.
	 */
	public function customize_controls_enqueue_scripts() {

		// Register selectize.
		wp_register_script( 'selectize', trailingslashit( Kirki::$url ) . 'assets/js/vendor/selectize.js', array( 'jquery' ) );

	}
}
