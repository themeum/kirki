<?php
/**
 * Additional tweaks for sections.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0.17
 */

/**
 * Additional tweaks for sections.
 */
class Kirki_Sections {

	/**
	 * The object constructor.
	 *
	 * @access public
	 * @since 3.0.17
	 */
	public function __construct() {
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'outer_sections_css' ) );
	}

	/**
	 * Generate CSS for the outer sections.
	 * These are by default hidden, we need to expose them.
	 *
	 * @since 3.0.17
	 * @return void
	 */
	public function outer_sections_css() {
		$css = '';
		if ( ! empty( Kirki::$sections ) ) {
			foreach ( Kirki::$sections as $section_args ) {
				if ( isset( $section_args['id'] ) && isset( $section_args['type'] ) && 'outer' === $section_args['type'] || 'kirki-outer' === $section_args['type'] ) {
					$css .= '#customize-theme-controls li#accordion-section-' . $section_args['id'] . '{display:list-item!important;}';
				}
			}
		}
		if ( ! empty( $css ) ) {
			echo '<style>' . esc_attr( $css ) . '</style>';
		}
	}
}
