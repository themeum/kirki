<?php
/**
 * Additional tweaks for sections.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license    https://opensource.org/licenses/MIT
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
		echo '<style>';
		$css = '';
		if ( ! empty( Kirki::$sections ) ) {
			foreach ( Kirki::$sections as $section_args ) {
				if ( isset( $section_args['id'] ) && isset( $section_args['type'] ) && 'outer' === $section_args['type'] || 'kirki-outer' === $section_args['type'] ) {
					echo '#customize-theme-controls li#accordion-section-' . esc_html( $section_args['id'] ) . '{display:list-item!important;}';
				}
			}
		}
		echo '</style>';
	}
}
