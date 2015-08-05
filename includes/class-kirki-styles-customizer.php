<?php
/**
 * Changes the styling of the customizer
 * based on the settings set using the kirki/config filter.
 * For documentation please see
 * https://github.com/reduxframework/kirki/wiki/Styling-the-Customizer
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

// Early exit if the class already exists
if ( class_exists( 'Kirki_Styles_Customizer' ) ) {
	return;
}

class Kirki_Styles_Customizer {

	public function __construct() {
		add_action( 'customize_controls_print_styles', array( $this, 'customizer_styles' ), 99 );
	}

	/**
	 * Enqueue the stylesheets required.
	 */
	public function customizer_styles() {
		wp_enqueue_style( 'kirki-customizer-css', trailingslashit( kirki_url() ).'assets/css/customizer.css', null, '0.5' );
		wp_add_inline_style( 'kirki-customizer-css', $this->custom_css() );
	}

	/**
	 * Add custom CSS rules to the head, applying our custom styles
	 */
	public function custom_css() {

		$color  = $this->get_admin_colors();
		$config = apply_filters( 'kirki/config', array() );

		// Calculate the accent color
		$color_accent = ( isset( $color['icon_colors'] ) && isset( $color['icon_colos']['focus'] ) ) ? $color['icon_colors']['focus'] : '#3498DB';
		if ( isset( $config['color_accent'] ) ) {
			$color_accent = Kirki_Color::sanitize_hex( $config['color_accent'] );
		}

		// Calculate the background & font colors
		$color_back = false;
		$color_font = false;
		if ( isset( $config['color_back'] ) ) {
			$color_back = Kirki_Color::sanitize_hex( $config['color_back'] );
			$color_font = ( 170 > Kirki_Color::get_brightness( $color_back ) ) ? '#f2f2f2' : '#222';
		}

		$border_color             = ( 170 > Kirki_Color::get_brightness( $color_back ) ) ? 'rgba(255,255,255,.2)' : 'rgba(0,0,0,.2)';
		$buttons_color            = ( 170 > Kirki_Color::get_brightness( $color_back ) ) ? Kirki_Color::adjust_brightness( $color_back, 80 ) : Kirki_Color::adjust_brightness( $color_back, -80 );
		$controls_color           = ( ( 170 > Kirki_Color::get_brightness( $color_accent ) ) ) ? '#ffffff;' : '#333333';
		$arrows_color             = ( 170 > Kirki_Color::get_brightness( $color_back ) ) ? Kirki_Color::adjust_brightness( $color_back, 120 ) : Kirki_Color::adjust_brightness( $color_back, -120 );
		$color_accent_text        = ( 170 > Kirki_Color::get_brightness( $color_accent ) ) ? Kirki_Color::adjust_brightness( $color_accent, 120 ) : Kirki_Color::adjust_brightness( $color_accent, -120 );
		$section_background_color = Kirki_Color::mix_colors( $color_back, '#ffffff', 10 );

		/**
		 * Initialize the WP_Filesystem
		 */
		global $wp_filesystem;
		if ( empty( $wp_filesystem ) ) {
			require_once ( ABSPATH.'/wp-admin/includes/file.php' );
			WP_Filesystem();
		}

		$styles  = '';
		/**
		 * Include the width CSS if necessary
		 */
		if ( isset( $config['width'] ) ) {
			$styles .= $wp_filesystem->get_contents( KIRKI_PATH.'/assets/css/customizer-dynamic-css-width.css' );
			/**
			 * Replace width placeholder with actual value
			 */
			$styles  = str_replace( 'WIDTH', $config['width'], $styles );
		}

		/**
		 * Include the color modifications CSS if necessary
		 */
		if ( false !== $color_back && false !== $color_font ) {
			$styles .= $wp_filesystem->get_contents( KIRKI_PATH.'/assets/css/customizer-dynamic-css-colors.css' );
		}

		/**
		 * Include generic CSS for controls
		 */
		$styles .= $wp_filesystem->get_contents( KIRKI_PATH.'/assets/css/customizer-dynamic-css.css' );

		/**
		 * replace CSS placeholders with actual values
		 */
		$styles = str_replace( 'COLOR_BACK', $color_back, $styles );
		$styles = str_replace( 'COLOR_ACCENT_TEXT', $color_accent_text, $styles );
		$styles = str_replace( 'COLOR_ACCENT', $color_accent, $styles );
		$styles = str_replace( 'BORDER_COLOR', $border_color, $styles );
		$styles = str_replace( 'BUTTONS_COLOR', $buttons_color, $styles );
		$styles = str_replace( 'COLOR_FONT', $color_font, $styles );
		$styles = str_replace( 'CONTROLS_COLOR', $controls_color, $styles );
		$styles = str_replace( 'ARROWS_COLOR', $arrows_color, $styles );
		$styles = str_replace( 'SECTION_BACKGROUND_COLOR', $section_background_color, $styles );

		return $styles;

	}


	/**
	 * Get the admin color theme
	 */
	public function get_admin_colors() {

		// Get the active admin theme
		global $_wp_admin_css_colors;

		// Get the user's admin colors
		$color = get_user_option( 'admin_color' );
		// If no theme is active set it to 'fresh'
		if ( empty( $color ) || ! isset( $_wp_admin_css_colors[ $color ] ) ) {
			$color = 'fresh';
		}

		$color = (array) $_wp_admin_css_colors[ $color ];

		return $color;

	}

}
