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

			$l10n = Kirki_Toolkit::i18n();

			wp_enqueue_script( 'kirki-tooltip', trailingslashit( Kirki::$url ) . 'assets/js/kirki-tooltip.js', array( 'jquery', 'customize-controls' ) );
			wp_enqueue_script( 'serialize-js', trailingslashit( Kirki::$url ) . 'assets/js/vendor/serialize.js' );
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-tooltip' );
			wp_enqueue_script( 'jquery-stepper-min-js' );
			wp_enqueue_script( 'wp-color-picker-alpha', trailingslashit( Kirki::$url ) . 'assets/js/vendor/wp-color-picker-alpha.js', array( 'wp-color-picker' ), '1.2' );
			wp_enqueue_style( 'wp-color-picker' );

			if ( ! Kirki_Toolkit::kirki_debug() ) {
				$suffix = '.min';
				if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
					$suffix = '';
				}
			}

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

			wp_enqueue_script( 'kirki-customizer-js', trailingslashit( Kirki::$url ) . 'assets/js/customizer' . $suffix . '.js', $deps, Kirki_Toolkit::$version );

			$fonts = Kirki_Fonts::get_all_fonts();
			$all_variants = array(
				'regular'   => $l10n['regular'],
				'italic'    => $l10n['italic'],
				'100'       => $l10n['100'],
				'200'       => $l10n['200'],
				'300'       => $l10n['300'],
				'500'       => $l10n['500'],
				'600'       => $l10n['600'],
				'700'       => $l10n['700'],
				'700italic' => $l10n['700italic'],
				'900'       => $l10n['900'],
				'900italic' => $l10n['900italic'],
				'100italic' => $l10n['100italic'],
				'300italic' => $l10n['300italic'],
				'500italic' => $l10n['500italic'],
				'800'       => $l10n['800'],
				'800italic' => $l10n['800italic'],
				'600italic' => $l10n['600italic'],
				'200italic' => $l10n['200italic'],
			);

			$all_subsets = array(
				'all'          => $l10n['all'],
				'greek-ext'    => $l10n['greek-ext'],
				'greek'        => $l10n['greek'],
				'cyrillic-ext' => $l10n['cyrillic-ext'],
				'cyrillic'     => $l10n['cyrillic'],
				'latin-ext'    => $l10n['latin-ext'],
				'latin'        => $l10n['latin'],
				'vietnamese'   => $l10n['vietnamese'],
				'arabic'       => $l10n['arabic'],
				'gujarati'     => $l10n['gujarati'],
				'devanagari'   => $l10n['devanagari'],
				'bengali'      => $l10n['bengali'],
				'hebrew'       => $l10n['hebrew'],
				'khmer'        => $l10n['khmer'],
				'tamil'        => $l10n['tamil'],
				'telugu'       => $l10n['telugu'],
				'thai'         => $l10n['thai'],
			);

			foreach ( $fonts as $family => $args ) {
				$label    = ( isset( $args['label'] ) ) ? $args['label'] : $family;
				$variants = ( isset( $args['variants'] ) ) ? $args['variants'] : array( 'regular', '700' );
				$subsets  = ( isset( $args['subsets'] ) ) ? $args['subsets'] : array( 'all' );

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

				$final[] = array(
					'family'       => $family,
					'label'        => $label,
					'variants'     => $available_variants,
					'subsets'      => $available_subsets,
				);
			}
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
