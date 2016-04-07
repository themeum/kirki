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

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Enqueue' ) ) {
	class Kirki_Enqueue {

		public function __construct() {
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_controls_enqueue_scripts' ) );
			add_action( 'customize_controls_print_scripts', array( $this, 'branding' ) );
			add_action( 'customize_preview_init', array( $this, 'postmessage' ) );
		}

		public function customize_controls_enqueue_scripts() {

			// Get an array of all our fields
			$fields = Kirki::$fields;

			// Do we have tooltips anywhere?
			$has_tooltips = false;
			foreach ( $fields as $field ) {
				if ( $has_tooltips ) {
					continue;
				}
				// Field has tooltip
				if ( isset( $field['tooltip'] ) && ! empty( $field['tooltip'] ) ) {
					$has_tooltips = true;
				}
				// backwards-compatibility ("help" argument instead of "tooltip")
				if ( isset( $field['help'] ) && ! empty( $field['help'] ) ) {
					$has_tooltips = true;
				}
			}

			// If we have tooltips, enqueue the tooltips script
			if ( $has_tooltips ) {
				wp_enqueue_script( 'kirki-tooltip', trailingslashit( Kirki::$url ) . 'assets/js/tooltip.js', array( 'jquery', 'customize-controls', 'jquery-ui-tooltip' ) );
			}

			// enqueue the reset script
			wp_enqueue_script( 'kirki-reset', trailingslashit( Kirki::$url ) . 'assets/js/reset.js', array( 'jquery', 'kirki-set-value' ) );

			// register kirki-functions
			wp_register_script( 'kirki-array-to-object', trailingslashit( Kirki::$url ) . 'assets/js/functions/array-to-object.js' );
			wp_register_script( 'kirki-object-to-array', trailingslashit( Kirki::$url ) . 'assets/js/functions/object-to-array.js' );
			wp_register_script( 'kirki-set-value', trailingslashit( Kirki::$url ) . 'assets/js/functions/set-value.js' );
			wp_register_script( 'kirki-validate-css-value', trailingslashit( Kirki::$url ) . 'assets/js/functions/validate-css-value.js' );

			// Register serialize.js
			wp_register_script( 'serialize-js', trailingslashit( Kirki::$url ) . 'assets/js/vendor/serialize.js' );

			// Register the color-alpha picker
			wp_register_script( 'wp-color-picker-alpha', trailingslashit( Kirki::$url ) . 'assets/js/vendor/wp-color-picker-alpha.js', array( 'wp-color-picker' ), '1.2' );
			wp_enqueue_style( 'wp-color-picker' );

			// Register the jquery-ui-spinner
			wp_register_script( 'jquery-ui-spinner', trailingslashit( Kirki::$url ) . 'assets/js/vendor/jquery-ui-spinner', array( 'jquery', 'jquery-ui-core', 'jquery-ui-button' ) );

			// register codemirror
			wp_register_script( 'codemirror', trailingslashit( Kirki::$url ) . 'assets/js/vendor/codemirror/lib/codemirror.js', array( 'jquery' ) );

			// register selectize
			wp_register_script( 'selectize', trailingslashit( Kirki::$url ) . 'assets/js/vendor/selectize.js', array( 'jquery' ) );

			// an array of control scripts and their dependencies
			$controls_scripts = array(
				'checkbox'        => array( 'jquery' ),
				'code'            => array( 'jquery', 'codemirror' ),
				'color-alpha'     => array( 'jquery', 'wp-color-picker-alpha' ),
				'color-palette'   => array( 'jquery', 'jquery-ui-button' ),
				'dashicons'       => array( 'jquery' ),
				'date'            => array( 'jquery', 'jquery-ui', 'jquery-ui-datepicker' ),
				'dimension'       => array( 'jquery', 'kirki-validate-css-value' ),
				'dropdown-pages'  => array( 'jquery', 'selectize' ),
				'editor'          => array( 'jquery' ),
				'generic'         => array( 'jquery' ),
				'multicheck'      => array( 'jquery' ),
				'multicolor'      => array( 'jquery', 'wp-color-picker-alpha' ),
				'number'          => array( 'jquery', 'jquery-ui-spinner' ),
				'palette'         => array( 'jquery', 'jquery-ui-button' ),
				'preset'          => array( 'jquery', 'selectize', 'kirki-set-value' ),
				'radio-buttonset' => array( 'jquery' ),
				'radio-image'     => array( 'jquery' ),
				'radio'           => array( 'jquery' ),
				'repeater'        => array( 'jquery', 'customize-base', 'jquery-ui-core', 'jquery-ui-sortable' ),
				'select'          => array( 'jquery', 'selectize', 'kirki-array-to-object' ),
				'slider'          => array( 'jquery' ),
				'sortable'        => array( 'jquery', 'jquery-ui-core', 'jquery-ui-sortable', 'serialize-js' ),
				'spacing'         => array( 'jquery' ),
				'switch'          => array( 'jquery' ),
				'toggle'          => array( 'jquery' ),
				'typography'      => array( 'jquery', 'selectize', 'wp-color-picker-alpha' ),
			);
			foreach ( $controls_scripts as $id => $dependencies ) {
				wp_register_script( 'kirki-' . $id, trailingslashit( Kirki::$url ) . 'assets/js/controls/' . $id . '.js', $dependencies, false );
			}

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
				wp_register_script( 'kirki-branding', Kirki::$url . '/assets/js/branding.js' );
				wp_localize_script( 'kirki-branding', 'kirkiBranding', $vars );
				wp_enqueue_script( 'kirki-branding' );
			}
		}

		public function postmessage() {
			wp_enqueue_script( 'kirki_auto_postmessage', trailingslashit( Kirki::$url ) . 'assets/js/postmessage.js', array( 'customize-preview' ), time(), true );
			$js_vars_fields = array();
			$fields = Kirki::$fields;
			foreach ( $fields as $field ) {
				if ( isset( $field['transport'] ) && 'postMessage' == $field['transport'] && isset( $field['js_vars'] ) && ! empty( $field['js_vars'] ) && is_array( $field['js_vars'] ) && isset( $field['settings'] ) ) {
					$js_vars_fields[ $field['settings'] ] = $field['js_vars'];
				}
			}
			wp_localize_script( 'kirki_auto_postmessage', 'jsvars', $js_vars_fields );
		}

	}
}
