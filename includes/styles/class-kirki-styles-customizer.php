<?php
/**
 * Changes the styling of the customizer
 * based on the settings set using the kirki/config filter.
 * For documentation please see
 * https://github.com/aristath/kirki/wiki/Styling-the-Customizer
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

if ( ! class_exists( 'Kirki_Styles_Customizer' ) ) {
	class Kirki_Styles_Customizer {

		public $color_back;
		public $color_font;
		public $color_accent;
		public $border_color;
		public $buttons_color;
		public $controls_color;
		public $arrows_color;
		public $color_accent_text;
		public $section_background_color;

		public $process = false;

		public function __construct() {

			add_action( 'customize_controls_print_styles', array( $this, 'customizer_styles' ), 99 );
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'customizer_scripts' ), 99 );

		}

		/**
		 * Enqueue the stylesheets required.
		 */
		public function customizer_styles() {
			wp_enqueue_style( 'kirki-customizer-css', trailingslashit( Kirki::$url ) . 'assets/css/customizer.css', null, Kirki_Toolkit::$version );
			wp_add_inline_style( 'kirki-customizer-css', $this->custom_css() );
		}

		/**
		 * Enqueue the scripts required.
		 */
		public function customizer_scripts() {
			if ( ! Kirki_Toolkit::kirki_debug() ) {
				$suffix = '.min';
				if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
					$suffix = '';
				}

				self::enqueue_customizer_control_script( 'codemirror', 'vendor/codemirror/lib/codemirror', array( 'jquery' ) );
				self::enqueue_customizer_control_script( 'selectize', 'vendor/selectize', array( 'jquery' ) );
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
					'regular'   => esc_attr__( 'Normal 400', 'kirki' ),
					'italic'    => esc_attr__( 'Normal 400 Italic', 'kirki' ),
					'100'       => esc_attr__( 'Ultra-Light 100', 'kirki' ),
					'200'       => esc_attr__( 'Light 200', 'kirki' ),
					'300'       => esc_attr__( 'Book 300', 'kirki' ),
					'500'       => esc_attr__( 'Medium 500', 'kirki' ),
					'600'       => esc_attr__( 'Semi-Bold 600', 'kirki' ),
					'700'       => esc_attr__( 'Bold 700', 'kirki' ),
					'700italic' => esc_attr__( 'Bold 700 Italic', 'kirki' ),
					'900'       => esc_attr__( 'Normal 400', 'kirki' ),
					'900italic' => esc_attr__( 'Ultra-Bold 900 Italic', 'kirki' ),
					'100italic' => esc_attr__( 'Ultra-Light 100 Italic', 'kirki' ),
					'300italic' => esc_attr__( 'Book 300 Italic', 'kirki' ),
					'500italic' => esc_attr__( 'Medium 500 Italic', 'kirki' ),
					'800'       => esc_attr__( 'Extra-Bold 800', 'kirki' ),
					'800italic' => esc_attr__( 'Extra-Bold 800 Italic', 'kirki' ),
					'600italic' => esc_attr__( 'Semi-Bold 600 Italic', 'kirki' ),
					'200italic' => esc_attr__( 'Light 200 Italic', 'kirki' ),
				);

				$all_subsets = array(
					'all'          => esc_attr__( 'All', 'kirki' ),
					'greek-ext'    => esc_attr__( 'Greek Extended', 'kirki' ),
					'greek'        => esc_attr__( 'Greek', 'kirki' ),
					'cyrillic-ext' => esc_attr__( 'Cyrillic Extended', 'kirki' ),
					'cyrillic'     => esc_attr__( 'Cyrillic', 'kirki' ),
					'latin-ext'    => esc_attr__( 'Latin Extended', 'kirki' ),
					'latin'        => esc_attr__( 'Latin', 'kirki' ),
					'vietnamese'   => esc_attr__( 'Vietnamese', 'kirki' ),
					'arabic'       => esc_attr__( 'Arabic', 'kirki' ),
					'gujarati'     => esc_attr__( 'Gujarati', 'kirki' ),
					'devanagari'   => esc_attr__( 'Devanagari', 'kirki' ),
					'bengali'      => esc_attr__( 'Bengali', 'kirki' ),
					'hebrew'       => esc_attr__( 'Hebrew', 'kirki' ),
					'khmer'        => esc_attr__( 'Khmer', 'kirki' ),
					'tamil'        => esc_attr__( 'Tamil', 'kirki' ),
					'telugu'       => esc_attr__( 'Telugu', 'kirki' ),
					'thai'         => esc_attr__( 'Thai', 'kirki' ),
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
		}

		/**
		 * Helper that enqueues a script for a control.
		 *
		 * Every Kirki Control should use this function to enqueue
		 * its main JS file (not dependencies like jQuery or jQuery UI).
		 *
		 * These files are only enqueued when debugging Kirki
		 *
		 * @param string $handle
		 * @param string $file
		 * @param array  $deps
		 */
		public static function enqueue_customizer_control_script( $handle, $file = null, $deps = array(), $in_footer = false ) {
			if ( ( false !== strpos( $file, 'controls/' ) && Kirki_Toolkit::kirki_debug() ) || false === strpos( $file, 'controls/' ) ) {
				$file = trailingslashit( Kirki::$url ) . 'assets/js/' . $file . '.js';
				foreach ( $deps as $dep ) {
					wp_enqueue_script( $dep );
				}
				// We are debugging, no need of version or suffix
				wp_enqueue_script( $handle, $file, $deps, '', $in_footer );
			}
		}

		public function get_colors() {

			$config = apply_filters( 'kirki/config', array() );

			// No need to proceed if we haven't set any colors
			if ( ! isset( $config['color_back'] ) && ! isset( $config['color_accent'] ) ) {
				return;
			}
			// set the $process to true.
			$this->process = true;
			// Calculate the accent color
			if ( isset( $config['color_accent'] ) ) {
				$this->color_accent = Kirki_Color::sanitize_hex( $config['color_accent'] );
			}

			// Calculate the background & font colors
			$this->color_back = false;
			$this->color_font = false;
			if ( isset( $config['color_back'] ) ) {
				$this->color_back = Kirki_Color::sanitize_hex( $config['color_back'] );
				$this->color_font = ( 170 > Kirki_Color::get_brightness( $this->color_back ) ) ? '#f2f2f2' : '#222';
			}

			$this->border_color             = ( 170 > Kirki_Color::get_brightness( $this->color_back ) ) ? 'rgba(255,255,255,.2)' : 'rgba(0,0,0,.2)';
			$this->buttons_color            = ( 170 > Kirki_Color::get_brightness( $this->color_back ) ) ? Kirki_Color::adjust_brightness( $this->color_back, 80 ) : Kirki_Color::adjust_brightness( $this->color_back, -80 );
			$this->controls_color           = ( ( 170 > Kirki_Color::get_brightness( $this->color_accent ) ) ) ? '#ffffff;' : '#333333';
			$this->arrows_color             = ( 170 > Kirki_Color::get_brightness( $this->color_back ) ) ? Kirki_Color::adjust_brightness( $this->color_back, 120 ) : Kirki_Color::adjust_brightness( $this->color_back, -120 );
			$this->color_accent_text        = ( 170 > Kirki_Color::get_brightness( $this->color_accent ) ) ? Kirki_Color::adjust_brightness( $this->color_accent, 120 ) : Kirki_Color::adjust_brightness( $this->color_accent, -120 );
			$this->section_background_color = Kirki_Color::mix_colors( $this->color_back, '#ffffff', 10 );

		}


		/**
		 * Add custom CSS rules to the head, applying our custom styles
		 */
		public function custom_css() {

			$this->get_colors();
			if ( ! $this->process ) {
				return;
			}
			$styles = $this->include_stylesheets();
			$styles = $this->replace_placeholders( $styles );

			return $styles;

		}

		/**
		 * @param string $styles
		 */
		public function replace_placeholders( $styles ) {
			/**
			 * replace CSS placeholders with actual values
			 */
			$replacements = array(
				'COLOR_BACK'               => $this->color_back,
				'COLOR_ACCENT_TEXT'        => $this->color_accent_text,
				'COLOR_ACCENT'             => $this->color_accent,
				'BORDER_COLOR'             => $this->border_color,
				'BUTTONS_COLOR'            => $this->buttons_color,
				'COLOR_FONT'               => $this->color_font,
				'CONTROLS_COLOR'           => $this->controls_color,
				'ARROWS_COLOR'             => $this->arrows_color,
				'SECTION_BACKGROUND_COLOR' => $this->section_background_color,
			);
			foreach ( $replacements as $placeholder => $replacement ) {
				$styles = str_replace( $placeholder, $replacement, $styles );
			}

			return $styles;

		}

		public function include_stylesheets() {

			$config = apply_filters( 'kirki/config', array() );
			$styles = '';

			Kirki_Helper::init_filesystem();
			global $wp_filesystem;

			/**
			 * Include the width CSS if necessary
			 */
			if ( isset( $config['width'] ) ) {
				$styles .= $wp_filesystem->get_contents( Kirki::$path . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'customizer-dynamic-css-width.css' );
				/**
				 * Replace width placeholder with actual value
				 */
				$styles = str_replace( 'WIDTH', $config['width'], $styles );
			}

			/**
			 * Include the color modifications CSS if necessary
			 */
			if ( false !== $this->color_back && false !== $this->color_font ) {
				$styles .= $wp_filesystem->get_contents( Kirki::$path . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'customizer-dynamic-css-colors.css' );
			}

			/**
			 * Include generic CSS for controls
			 */
			$styles .= $wp_filesystem->get_contents( Kirki::$path . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'customizer-dynamic-css.css' );

			return $styles;

		}

	}

}
