<?php
/**
 * Add the logo and description to the customizer.
 * Logo and customizer are defined using the kirki/config filter.
 * See https://github.com/aristath/kirki/wiki/Styling-the-Customizer for documentation
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2015, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Customizer_Scripts_Branding' ) ) {
	class Kirki_Customizer_Scripts_Branding {

		public function __construct() {
			add_action( 'customize_controls_print_scripts', array( $this, 'enqueue' ) );
		}

		public function enqueue() {

			$config = apply_filters( 'kirki/config', array() );
			$vars   = array(
				'logoImage'   => '',
				'description' => '',
			);
			if ( isset( $config['logo_image'] ) && '' != $config['logo_image'] ) {
				$vars['logoImage'] = esc_url_raw( $config['logo_image'] );
			}
			if ( isset( $config['description'] ) && '' != $config['description'] ) {
				$vars['description'] = esc_textarea( $config['description'] );
			}

			if ( ! empty( $vars['logoImage'] ) || ! empty( $vars['description'] ) ) {
				wp_register_script( 'kirki-branding', Kirki::$url . '/assets/js/kirki-branding.js' );
				wp_localize_script( 'kirki-branding', 'kirkiBranding', $vars );
				wp_enqueue_script( 'kirki-branding' );
			}

		}

	}
}
