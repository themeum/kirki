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

		$styles = '';

		// Width
		if ( isset( $config['width'] ) ) {
			$styles .= '.wp-full-overlay-sidebar{width:'.esc_attr( $config['width'] ).';}';
			$styles .= '.wp-full-overlay.expanded{margin-left:'.esc_attr( $config['width'] ).';}';
		}

		if ( false !== $color_back && false !== $color_font ) {

			// Generic background color
			$styles .= '.wp-full-overlay-sidebar{background:'.$color_back.';}';

			// Title background color
			$styles .= '#customize-controls .customize-info .accordion-section-title, #customize-controls .panel-meta.customize-info .accordion-section-title:hover{background:'.$color_back.';}';

			// Borders
			$border_color = ( 170 > Kirki_Color::get_brightness( $color_back ) ) ? 'rgba(255,255,255,.2)' : 'rgba(0,0,0,.2)';
			$styles      .= '#customize-controls .customize-info{border-top-color:'.$border_color.';border-bottom-color:'.$border_color.';}';
			$styles      .= '.customize-section-title{border-bottom-color:'.$border_color.';}';
			$styles      .= '.customize-panel-back, .customize-section-back{border-right-color:'.$border_color.';}';
			$styles      .= '#customize-header-actions{border-bottom-color:'.$border_color.';}';
			$styles      .= '.customize-controls-close, .customize-overlay-close{border-right-color:'.$border_color.'!important;}';

			// back & close buttons color
			if ( 170 > Kirki_Color::get_brightness( $color_back ) ) {
				$color = Kirki_Color::adjust_brightness( $color_back, 80 );
			} else {
				$color = Kirki_Color::adjust_brightness( $color_back, -80 );
			}
			$styles .= '.customize-panel-back:focus, .customize-panel-back:hover, .customize-section-back:focus, .customize-section-back:hover, .customize-panel-back, .customize-section-back, .customize-controls-close, .customize-overlay-close{background:'.$color.';}';
			$styles .= '.control-panel-back:focus, .control-panel-back:hover, .customize-controls-close:focus, .customize-controls-close:hover, .customize-controls-preview-toggle:focus, .customize-controls-preview-toggle:hover, .customize-overlay-close:focus, .customize-overlay-close:hover{background:'.$color.'}';

			// Sections list titles
			$styles .= '#customize-theme-controls .accordion-section-title{background:'.$color_back.';color:'.$color_font.';}';
			$color   = ( ( 170 > Kirki_Color::get_brightness( $color_accent ) ) ) ? 'color:#ffffff;' : '';
			$styles .= '#customize-controls .control-section .accordion-section-title:focus, #customize-controls .control-section .accordion-section-title:hover, #customize-controls .control-section.open .accordion-section-title, #customize-controls .control-section:hover>.accordion-section-title{background:'.$color_accent.';'.$color.'}';

			// Arrows
			if ( 170 > Kirki_Color::get_brightness( $color_back ) ) {
				$color = Kirki_Color::adjust_brightness( $color_back, 120 );
			} else {
				$color = Kirki_Color::adjust_brightness( $color_back, -120 );
			}
			$styles .= '.accordion-section-title:after, .handlediv, .item-edit, .sidebar-name-arrow, .widget-action{color:'.$color.'}';
			if ( 170 > Kirki_Color::get_brightness( $color_accent ) ) {
				$color = Kirki_Color::adjust_brightness( $color_accent, 120 );
			} else {
				$color = Kirki_Color::adjust_brightness( $color_accent, -120 );
			}
			$styles .= '#customize-theme-controls .control-section .accordion-section-title:focus:after, #customize-theme-controls .control-section .accordion-section-title:hover:after, #customize-theme-controls .control-section.open .accordion-section-title:after, #customize-theme-controls .control-section:hover>.accordion-section-title:after{color:'.$color.'}';

			// Title for active section
			$styles .= '.customize-section-title{background:'.$color_back.';}';
			$styles .= '.customize-section-title h3, h3.customize-section-title{color:'.$color_font.';}';

			// Active section background
			$styles .= '#customize-theme-controls .accordion-section-content{background:'.Kirki_Color::mix_colors( $color_back, '#ffffff', 10 ).';}';

			// Title color for active panels etc.
			$styles .= '#customize-controls .customize-info .preview-notice{color:'.$color_font.';}';

		}

		// Button styles
		$color   = ( ( 170 > Kirki_Color::get_brightness( $color_accent ) ) ) ? '#fff' : '#222';
		$styles .= '.wp-core-ui .button-primary-disabled, .wp-core-ui .button-primary.disabled, .wp-core-ui .button-primary:disabled, .wp-core-ui .button-primary[disabled]{background:'.$color_accent.' !important;color:'.$color.' !important;border-color:rgba(0,0,0,.1) !important;opacity:.7;}';
		$styles .= '.wp-core-ui .button-primary{background-color:'.$color_accent.';color:'.$color.';opacity:1;}';

		// Tooltip styles
		$styles .= '#customize-controls .customize-info .customize-help-toggle{color:'.$color_accent.';}';

		// Image-Radio styles
		$styles .= '.customize-control-radio-image .image.ui-buttonset label.ui-state-active{border:2px solid '.$color_accent.';}';

		// Buttonset-Radio styles
		$color   = ( ( 170 > Kirki_Color::get_brightness( $color_accent ) ) ) ? '#fff;' : '#222';
		$styles .= '.customize-control-radio-buttonset label.ui-state-active{background-color:'.$color_accent.';color:'.$color.';}';

		// Slider Controls
		$styles .= '.customize-control-slider .ui-slider .ui-slider-handle{background-color:'.$color_accent.';}';

		// Switch Controls
		$styles .= '.customize-control-switch .fs-checkbox-toggle.fs-checkbox-checked .fs-checkbox-flag{background:'.$color_accent.';}';

		// Toggle Controls
		$styles .= '.customize-control-toggle .fs-checkbox-toggle.fs-checkbox-checked .fs-checkbox-flag{background:'.$color_accent.';}';

		// Sortable Controls
		$styles .= '.customize-control-sortable ul.ui-sortable li .dashicons.visibility{color:'.$color_accent.';}';

		// Palette Controls
		$styles .= '.customize-control-palette label.ui-state-active.ui-button.ui-widget span.ui-button-text{border-color:'.$color_accent.';}';

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
