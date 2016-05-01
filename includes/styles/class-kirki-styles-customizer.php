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
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Styles_Customizer' ) ) {

	/**
	 * Adds styles to the customizer.
	 */
	class Kirki_Styles_Customizer {

		/**
		 * Background Color.
		 *
		 * @access public
		 * @var string
		 */
		public $color_back = false;

		/**
		 * Font Color.
		 *
		 * @access public
		 * @var string
		 */
		public $color_font = false;

		/**
		 * Accent Color.
		 *
		 * @access public
		 * @var string
		 */
		public $color_accent;

		/**
		 * Border Color.
		 *
		 * @access public
		 * @var string
		 */
		public $border_color;

		/**
		 * Buttons Color.
		 *
		 * @access public
		 * @var string
		 */
		public $buttons_color;

		/**
		 * Controls Color.
		 *
		 * @access public
		 * @var string
		 */
		public $controls_color;

		/**
		 * Arrows Color.
		 *
		 * @access public
		 * @var string
		 */
		public $arrows_color;

		/**
		 * Accent text Color.
		 *
		 * @access public
		 * @var string
		 */
		public $color_accent_text;

		/**
		 * Section Background Color.
		 *
		 * @access public
		 * @var string
		 */
		public $section_background_color;

		/**
		 * Have we already processed styling?
		 *
		 * @access public
		 * @var bool
		 */
		public $process = false;

		/**
		 * Constructor.
		 *
		 * @access public
		 */
		public function __construct() {
			add_action( 'customize_controls_print_styles', array( $this, 'customizer_styles' ), 99 );
		}

		/**
		 * Enqueue the stylesheets required.
		 *
		 * @access public
		 */
		public function customizer_styles() {
			wp_enqueue_style( 'kirki-customizer-css', trailingslashit( Kirki::$url ) . 'assets/css/customizer.css', null );
			wp_add_inline_style( 'kirki-customizer-css', $this->custom_css() );
		}

		/**
		 * Gets the colors used.
		 *
		 * @access public
		 * @return null|void
		 */
		public function get_colors() {

			$config = apply_filters( 'kirki/config', array() );

			// No need to proceed if we haven't set any colors.
			if ( ( ! isset( $config['color_back'] ) || ! $config['color_back'] ) && ( ! isset( $config['color_accent'] ) || ! $config['color_accent'] ) ) {
				return;
			}
			// Set the $process to true.
			$this->process = true;
			// Calculate the accent color.
			if ( isset( $config['color_accent'] ) ) {
				$this->color_accent = Kirki_Color::sanitize_hex( $config['color_accent'] );
			}

			// Calculate the background & font colors.
			if ( isset( $config['color_back'] ) ) {
				$this->color_back = Kirki_Color::sanitize_hex( $config['color_back'] );
				$this->color_font = ( 170 > Kirki_Color::get_brightness( $this->color_back ) ) ? '#f2f2f2' : '#222';
			}

			if ( $this->color_back ) {
				$this->buttons_color = ( 170 > Kirki_Color::get_brightness( $this->color_back ) ) ? Kirki_Color::adjust_brightness( $this->color_back, 80 ) : Kirki_Color::adjust_brightness( $this->color_back, -80 );
				$this->border_color             = ( 170 > Kirki_Color::get_brightness( $this->color_back ) ) ? 'rgba(255,255,255,.2)' : 'rgba(0,0,0,.2)';
				$this->arrows_color             = ( 170 > Kirki_Color::get_brightness( $this->color_back ) ) ? Kirki_Color::adjust_brightness( $this->color_back, 120 ) : Kirki_Color::adjust_brightness( $this->color_back, -120 );
				$this->section_background_color = Kirki_Color::mix_colors( $this->color_back, '#ffffff', 10 );
			}
			$this->controls_color           = ( ( 170 > Kirki_Color::get_brightness( $this->color_accent ) ) ) ? '#ffffff;' : '#333333';
			$this->color_accent_text        = ( 170 > Kirki_Color::get_brightness( $this->color_accent ) ) ? Kirki_Color::adjust_brightness( $this->color_accent, 120 ) : Kirki_Color::adjust_brightness( $this->color_accent, -120 );

		}


		/**
		 * Add custom CSS rules to the head, applying our custom styles.
		 *
		 * @access public
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
		 * Replaces CSS placefolders with our settings.
		 *
		 * @access public
		 * @param string $styles The CSS.
		 * @return string
		 */
		public function replace_placeholders( $styles ) {

			// Replace CSS placeholders with actual values.
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

		/**
		 * Get the stylesheets.
		 *
		 * @access public
		 * @return string
		 */
		public function include_stylesheets() {

			$config = apply_filters( 'kirki/config', array() );
			$styles = '';

			// Include the width CSS if necessary.
			if ( isset( $config['width'] ) ) {
				$path = wp_normalize_path( Kirki::$path . '/assets/css/customizer-dynamic-css-width.php' );
				$styles .= include $path;

				// Replace width placeholder with actual value.
				$styles = str_replace( 'WIDTH', $config['width'], $styles );
			}

			// Include the color modifications CSS if necessary.
			if ( false !== $this->color_back && false !== $this->color_font ) {
				$path = wp_normalize_path( Kirki::$path . '/assets/css/customizer-dynamic-css-colors.php' );
				$styles .= include $path;
			}

			// Include generic CSS for controls.
			$path = wp_normalize_path( Kirki::$path . '/assets/css/customizer-dynamic-css.php' );
			$styles .= include $path;

			return $styles;

		}
	}
}
