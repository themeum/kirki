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
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Enqueue' ) ) {
	class Kirki_Enqueue {

		public function __construct() {
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_controls_enqueue_scripts' ) );
			add_action( 'customize_controls_print_scripts', array( $this, 'branding' ) );
		}

		public function customize_controls_enqueue_scripts() {

			wp_enqueue_script( 'kirki-tooltip', trailingslashit( Kirki::$url ) . 'assets/js/kirki-tooltip.js', array( 'jquery', 'customize-controls' ) );
			wp_enqueue_script( 'serialize-js', trailingslashit( Kirki::$url ) . 'assets/js/vendor/serialize.js' );
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-tooltip' );
			wp_enqueue_script( 'jquery-stepper-min-js' );
			wp_enqueue_script( 'wp-color-picker-alpha', trailingslashit( Kirki::$url ) . 'assets/js/vendor/wp-color-picker-alpha.js', array( 'wp-color-picker' ), '1.2' );
			wp_enqueue_style( 'wp-color-picker' );

			$suffix = ( ! Kirki_Toolkit::is_debug() ) ? '.min' : '';

			Kirki_Styles_Customizer::enqueue_customizer_control_script( 'codemirror', 'vendor/codemirror/lib/codemirror', array( 'jquery' ) );
			Kirki_Styles_Customizer::enqueue_customizer_control_script( 'selectize', 'vendor/selectize', array( 'jquery' ) );
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'jquery-ui-button' );

			$deps = array(
				'jquery',
				'customize-base',
				'jquery-ui-core',
				'jquery-ui-button',
				'jquery-ui-sortable',
				'codemirror',
				'jquery-ui-spinner',
				'selectize',
			);

			wp_enqueue_script( 'kirki-customizer-js', trailingslashit( Kirki::$url ) . 'assets/js/customizer' . $suffix . '.js', $deps, Kirki_Toolkit::get_version() );

			$google_fonts   = Kirki_Fonts::get_google_fonts();
			$standard_fonts = Kirki_Fonts::get_standard_fonts();
			$all_variants   = Kirki_Fonts::get_all_variants();
			$all_subsets    = Kirki_Fonts::get_all_subsets();

			$standard_fonts_final = array();
			foreach ( $standard_fonts as $key => $value ) {
				$standard_fonts_final[] = array(
					'family'      => $value['stack'],
					'label'       => $value['label'],
					'subsets'     => array(),
					'is_standard' => true,
					'variants'    => array(
						array(
							'id'    => 'regular',
							'label' => $all_variants['regular']
						),
						array(
							'id'    => 'italic',
							'label' => $all_variants['italic']
						),
						array(
							'id'    => '700',
							'label' => $all_variants['700']
						),
						array(
							'id'    => '700italic',
							'label' => $all_variants['700italic']
						),
					),
				);
			}

			$google_fonts_final = array();
			foreach ( $google_fonts as $family => $args ) {
				$label    = ( isset( $args['label'] ) ) ? $args['label'] : $family;
				$variants = ( isset( $args['variants'] ) ) ? $args['variants'] : array( 'regular', '700' );
				$subsets  = ( isset( $args['subsets'] ) ) ? $args['subsets'] : array();

				$available_variants = array();
				foreach ( $variants as $variant ) {
					if ( array_key_exists( $variant, $all_variants ) ) {
						$available_variants[] = array( 'id' => $variant, 'label' => $all_variants[ $variant ] );
					}
				}

				$available_subsets = array();
				foreach ( $subsets as $subset ) {
					if ( array_key_exists( $subset, $all_subsets ) ) {
						$available_subsets[] = array( 'id' => $subset, 'label' => $all_subsets[ $subset ] );
					}
				}

				$google_fonts_final[] = array(
					'family'       => $family,
					'label'        => $label,
					'variants'     => $available_variants,
					'subsets'      => $available_subsets,
				);
			}
			$final = array_merge( $standard_fonts_final, $google_fonts_final );
			wp_localize_script( 'kirki-customizer-js', 'kirkiAllFonts', $final );
		}
		public function branding() {

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
