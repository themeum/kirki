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
			add_action( 'customize_controls_print_scripts', array( $this, 'branding' ) );
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

			// Register kirki-functions.
			wp_register_script( 'kirki-set-setting-value', trailingslashit( Kirki::$url ) . 'assets/js/functions/set-setting-value.js' );
			wp_register_script( 'kirki-validate-css-value', trailingslashit( Kirki::$url ) . 'assets/js/functions/validate-css-value.js' );
			wp_register_script( 'kirki-notifications', trailingslashit( Kirki::$url ) . 'assets/js/functions/notifications.js', array( 'kirki-l10n', 'kirki-validate-css-value' ) );

			// Register serialize.js.
			wp_register_script( 'serialize-js', trailingslashit( Kirki::$url ) . 'assets/js/vendor/serialize.js' );

			// Register the color-alpha picker.
			wp_enqueue_style( 'wp-color-picker' );
			wp_register_script( 'wp-color-picker-alpha', trailingslashit( Kirki::$url ) . 'assets/js/vendor/wp-color-picker-alpha.js', array( 'wp-color-picker' ), '1.2', true );

			// Register the jquery-ui-spinner.
			wp_register_script( 'jquery-ui-spinner', trailingslashit( Kirki::$url ) . 'assets/js/vendor/jquery-ui-spinner', array( 'jquery', 'jquery-ui-core', 'jquery-ui-button' ) );

			// Register selectize.
			wp_register_script( 'selectize', trailingslashit( Kirki::$url ) . 'assets/js/vendor/selectize.js', array( 'jquery' ) );

		}

		/**
		 * Enqueues the script responsible for branding the customizer
		 * and also adds variables to it using the wp_localize_script function.
		 * The actual branding is handled via JS.
		 */
		public function branding() {

			$config = apply_filters( 'kirki/config', array() );
			$vars   = array(
				'logoImage'   => '',
				'description' => '',
			);
			if ( isset( $config['logo_image'] ) && '' !== $config['logo_image'] ) {
				$vars['logoImage'] = esc_url_raw( $config['logo_image'] );
			}
			if ( isset( $config['description'] ) && '' !== $config['description'] ) {
				$vars['description'] = esc_textarea( $config['description'] );
			}

			if ( ! empty( $vars['logoImage'] ) || ! empty( $vars['description'] ) ) {
				wp_register_script( 'kirki-branding', Kirki::$url . '/assets/js/branding.js' );
				wp_localize_script( 'kirki-branding', 'kirkiBranding', $vars );
				wp_enqueue_script( 'kirki-branding' );
			}
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
