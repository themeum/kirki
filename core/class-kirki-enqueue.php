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

if ( ! class_exists( 'Kirki_Enqueue' ) ) {

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
			add_action( 'customize_preview_init', array( $this, 'postmessage' ) );
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

		/**
		 * Enqueues the postMessage script
		 * and adds variables to it using the wp_localize_script function.
		 * The rest is handled via JS.
		 */
		public function postmessage() {
			wp_enqueue_script( 'kirki_auto_postmessage', trailingslashit( Kirki::$url ) . 'assets/js/postmessage.js', array( 'customize-preview' ), false, true );
			$js_vars_fields = array();
			$fields = Kirki::$fields;
			foreach ( $fields as $field ) {
				if ( isset( $field['transport'] ) && 'postMessage' === $field['transport'] && isset( $field['js_vars'] ) && ! empty( $field['js_vars'] ) && is_array( $field['js_vars'] ) && isset( $field['settings'] ) ) {
					$js_vars_fields[ $field['settings'] ] = $field['js_vars'];
				}
			}
			wp_localize_script( 'kirki_auto_postmessage', 'jsvars', $js_vars_fields );
		}
	}
}
