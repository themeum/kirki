<?php

namespace Kirki\Styles;
use Kirki;
use Kirki\Styles;

class Customizer {

	function __construct() {
		add_action( 'customize_controls_print_styles', array( $this, 'custom_css' ), 999 );
		add_action( 'customize_controls_print_styles', array( $this, 'customizer_styles' ) );
	}

	/**
	 * Enqueue the stylesheets required.
	 */
	function customizer_styles() {
		$config = Kirki::config()->get_all();
		$root = ( '' != $config['url_path'] ) ? $config['url_path'] : KIRKI_URL;
		wp_enqueue_style( 'kirki-customizer-css', trailingslashit( $root ) . 'assets/css/customizer.css', NULL, '0.5' );
	}

	/**
	 * Add custom CSS rules to the head, applying our custom styles
	 */
	function custom_css() {

		$color   = $this->get_admin_colors();
		$config  = Kirki::config();

		$color_font    = false;
		$color_accent  = $config->get( 'color_accent', $color['icon_colors']['focus']);
		$color_back    = $config->get( 'color_back',   '#ffffff' );
		$color_font    = ( 170 > \Kirki_Color::get_brightness( $color_back ) ) ? '#f2f2f2' : '#222';

		$styles = '<style>';

		// Background styles
		$styles .= '#customize-controls .wp-full-overlay-sidebar-content{background-color:' . $color_back . ';}';
		$styles .= '#customize-theme-controls .accordion-section-title, #customize-info .accordion-section-title,#customize-info .accordion-section-title:hover,#customize-info.open .accordion-section-title{background-color:' . $color_back . ';color:' . $color_font . ';}';
		$styles .= '#customize-theme-controls .control-section .accordion-section-title:hover,#customize-theme-controls .control-section .accordion-section-title:focus,.control-section.control-panel>.accordion-section-title:after{background-color:' . \Kirki_Color::adjust_brightness( $color_back, -10 ) . ';color:' . $color_font . ';}';
		$styles .= '#customize-theme-controls .control-section.control-panel>h3.accordion-section-title:focus:after, #customize-theme-controls .control-section.control-panel>h3.accordion-section-title:hover:after{background-color:' . \Kirki_Color::adjust_brightness( $color_back, -20 ) . ';color:' . $color_font . ';}';
		$styles .= '#customize-theme-controls .control-section.open .accordion-section-title{background-color:' . $color_accent . ' !important;color:' . $color_font . ' !important;}';

		// Tooltip styles
		// $styles .= 'li.customize-control a.button.tooltip.hint--left {color:' . $color_accent . ';}';

		// Image-Radio styles
		$styles .= '.customize-control-radio-image .image.ui-buttonset label.ui-state-active {border-color:' . $color_accent . ';}';

		// Buttonset-Radio styles
		$styles .= '.customize-control-radio-buttonset label.ui-state-active{background-color:' . $color_accent . ';color:' . $color_font . ';}';

		// Slider Controls
		$styles .= '.customize-control-slider .ui-slider .ui-slider-handle{background-color:' . $color_accent . ';border-color:' . $color_accent . ';}';

		// Switch Controls
		$styles .= '.customize-control-switch .Switch .On, .customize-control-toggle .Switch .On{color:' . $color_accent . ';}';

		// Toggle Controls
		$styles .= '.customize-control-switch .Switch.Round.On, .customize-control-toggle .Switch.Round.On{background-color:' . \Kirki_Color::adjust_brightness( $color_accent, -10 ) . ';}';

		// Sortable Controls
		$styles .= '.customize-control-sortable ul.ui-sortable li .dashicons.visibility{color:' . $color_accent . ';}';

		// Palette Controls
		$styles .= '.customize-control-palette label.ui-state-active.ui-button.ui-widget span.ui-button-text {border-color:' . $color_accent . ';}';

		$styles .= '</style>';

		echo $styles;

	}

	/**
	 * Get the admin color theme
	 */
	function get_admin_colors() {

		// Get the active admin theme
		global $_wp_admin_css_colors;

		// Get the user's admin colors
		$color = get_user_option( 'admin_color' );
		// If no theme is active set it to 'fresh'
		if ( empty( $color ) || ! isset( $_wp_admin_css_colors[$color] ) ) {
			$color = 'fresh';
		}

		$color = (array) $_wp_admin_css_colors[$color];

		return $color;

	}

}
