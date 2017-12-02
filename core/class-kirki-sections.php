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
	 * An array of sections along with their types.
	 *
	 * @static
	 * @since 3.0.17
	 * @var array
	 */
	private $sections = array();

	/**
	 * The object constructor.
	 *
	 * @access public
	 * @param array $args The section parameters.
	 */
	public function __construct() {
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'outer_sections_css' ) );
	}


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
