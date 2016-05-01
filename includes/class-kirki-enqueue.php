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
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_controls_enqueue_scripts' ), 7 );
			add_action( 'customize_controls_print_scripts', array( $this, 'branding' ) );
			add_action( 'customize_preview_init', array( $this, 'postmessage' ) );
		}

		/**
		 * Assets that have to be enqueued in 'customize_controls_enqueue_scripts'.
		 */
		public function customize_controls_enqueue_scripts() {

			// Get an array of all our fields.
			$fields = Kirki::$fields;

			// Do we have tooltips anywhere?
			$has_tooltips = false;
			foreach ( $fields as $field ) {
				if ( $has_tooltips ) {
					continue;
				}
				// Field has tooltip.
				if ( isset( $field['tooltip'] ) && ! empty( $field['tooltip'] ) ) {
					$has_tooltips = true;
				}
				// Backwards-compatibility ("help" argument instead of "tooltip").
				if ( isset( $field['help'] ) && ! empty( $field['help'] ) ) {
					$has_tooltips = true;
				}
			}

			// If we have tooltips, enqueue the tooltips script.
			if ( $has_tooltips ) {
				wp_enqueue_script( 'kirki-tooltip', trailingslashit( Kirki::$url ) . 'assets/js/tooltip.js', array( 'jquery', 'customize-controls', 'jquery-ui-tooltip' ) );
			}

			// Enqueue the reset script.
			wp_enqueue_script( 'kirki-reset', trailingslashit( Kirki::$url ) . 'assets/js/reset.js', array( 'jquery', 'kirki-set-setting-value' ) );

			// Register kirki-functions.
			wp_register_script( 'kirki-set-setting-value', trailingslashit( Kirki::$url ) . 'assets/js/functions/set-setting-value.js' );
			wp_register_script( 'kirki-validate-css-value', trailingslashit( Kirki::$url ) . 'assets/js/functions/validate-css-value.js' );

			// Register serialize.js.
			wp_register_script( 'serialize-js', trailingslashit( Kirki::$url ) . 'assets/js/vendor/serialize.js' );

			// Register the color-alpha picker.
			wp_enqueue_style( 'wp-color-picker' );
			wp_register_script( 'wp-color-picker-alpha', trailingslashit( Kirki::$url ) . 'assets/js/vendor/wp-color-picker-alpha.js', array( 'wp-color-picker' ), '1.2', true );

			// Register the jquery-ui-spinner.
			wp_register_script( 'jquery-ui-spinner', trailingslashit( Kirki::$url ) . 'assets/js/vendor/jquery-ui-spinner', array( 'jquery', 'jquery-ui-core', 'jquery-ui-button' ) );

			// Register codemirror.
			wp_register_script( 'codemirror', trailingslashit( Kirki::$url ) . 'assets/js/vendor/codemirror/lib/codemirror.js', array( 'jquery' ) );

			// Register selectize.
			wp_register_script( 'selectize', trailingslashit( Kirki::$url ) . 'assets/js/vendor/selectize.js', array( 'jquery' ) );

			// Register the l10n script.
			wp_register_script( 'kirki-l10n', trailingslashit( Kirki::$url ) . 'assets/js/l10n.js' );

			// An array of control scripts and their dependencies.
			$scripts = array(
				// Add controls scripts.
				'checkbox'        => array( 'jquery', 'customize-base' ),
				'code'            => array( 'jquery', 'customize-base', 'codemirror' ),
				'color'           => array( 'jquery', 'customize-base', 'wp-color-picker-alpha' ),
				'color-palette'   => array( 'jquery', 'customize-base', 'jquery-ui-button' ),
				'dashicons'       => array( 'jquery', 'customize-base' ),
				'date'            => array( 'jquery', 'customize-base', 'jquery-ui', 'jquery-ui-datepicker' ),
				'dimension'       => array( 'jquery', 'customize-base', 'kirki-validate-css-value' ),
				'dropdown-pages'  => array( 'jquery', 'customize-base', 'selectize' ),
				'editor'          => array( 'jquery', 'customize-base', 'kirki-l10n' ),
				'generic'         => array( 'jquery', 'customize-base' ),
				'multicheck'      => array( 'jquery', 'customize-base' ),
				'multicolor'      => array( 'jquery', 'customize-base', 'wp-color-picker-alpha' ),
				'number'          => array( 'jquery', 'customize-base', 'jquery-ui-spinner' ),
				'palette'         => array( 'jquery', 'customize-base', 'jquery-ui-button' ),
				'preset'          => array( 'jquery', 'customize-base', 'selectize', 'kirki-set-setting-value' ),
				'radio-buttonset' => array( 'jquery', 'customize-base' ),
				'radio-image'     => array( 'jquery', 'customize-base' ),
				'radio'           => array( 'jquery', 'customize-base' ),
				'repeater'        => array( 'jquery', 'customize-base', 'jquery-ui-core', 'jquery-ui-sortable' ),
				'select'          => array( 'jquery', 'customize-base', 'selectize' ),
				'slider'          => array( 'jquery', 'customize-base' ),
				'sortable'        => array( 'jquery', 'customize-base', 'jquery-ui-core', 'jquery-ui-sortable', 'serialize-js' ),
				'spacing'         => array( 'jquery', 'customize-base', 'kirki-validate-css-value' ),
				'switch'          => array( 'jquery', 'customize-base' ),
				'toggle'          => array( 'jquery', 'customize-base' ),
				'typography'      => array( 'jquery', 'customize-base', 'selectize', 'wp-color-picker-alpha' ),
			);
			foreach ( $scripts as $id => $dependencies ) {
				wp_register_script( 'kirki-' . $id, trailingslashit( Kirki::$url ) . 'assets/js/controls/' . $id . '.js', $dependencies, false, true );
			}

			// Add localization strings.
			$l10n = Kirki_l10n::get_strings();
			wp_localize_script( 'kirki-l10n', 'kirkiL10n', $l10n );

			// Add fonts to our JS objects.
			$google_fonts   = Kirki_Fonts::get_google_fonts();
			$standard_fonts = Kirki_Fonts::get_standard_fonts();
			$all_variants   = Kirki_Fonts::get_all_variants();
			$all_subsets    = Kirki_Fonts::get_google_font_subsets();

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
							'label' => $all_variants['regular'],
						),
						array(
							'id'    => 'italic',
							'label' => $all_variants['italic'],
						),
						array(
							'id'    => '700',
							'label' => $all_variants['700'],
						),
						array(
							'id'    => '700italic',
							'label' => $all_variants['700italic'],
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
			wp_localize_script( 'kirki-typography', 'kirkiAllFonts', $final );
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
