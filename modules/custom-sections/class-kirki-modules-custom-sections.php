<?php
/**
 * Custom Sections.
 *
 * @package     Kirki
 * @category    Modules
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.4.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds styles to the customizer.
 */
class Kirki_Modules_Custom_Sections {

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 2.4.0
	 */
	public function __construct() {

		// Register the new section types.
		add_filter( 'kirki/section_types', array( $this, 'set_section_types' ) );

		// Include the section-type files.
		add_action( 'customize_register', array( $this, 'include_sections' ) );

		// Enqueue styles & scripts.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_scrips' ), 999 );

	}

	/**
	 * Add the custom section types.
	 *
	 * @access public
	 * @since 2.4.0
	 * @param array $section_types The registered section-types.
	 * @return array
	 */
	public function set_section_types( $section_types ) {

		$new_types = array(
			'kirki-default'  => 'Kirki_Sections_Default_Section',
			'kirki-expanded' => 'Kirki_Sections_Expanded_Section',
		);
		return array_merge( $section_types, $new_types );

	}

	/**
	 * Include the custom-section classes.
	 *
	 * @access public
	 * @since 2.4.0
	 */
	public function include_sections() {

		$folder_path = dirname( __FILE__ ) . '/sections/';

		include_once wp_normalize_path( $folder_path . 'class-kirki-sections-default-section.php' );
		include_once wp_normalize_path( $folder_path . 'class-kirki-sections-expanded-section.php' );

	}

	/**
	 * Enqueues any necessary scripts and styles.
	 *
	 * @access public
	 * @since 2.4.0
	 */
	public function enqueue_scrips() {

		wp_enqueue_style( 'kirki-custom-sections', trailingslashit( Kirki::$url ) . 'modules/custom-sections/sections.css' );
		wp_enqueue_script( 'kirki-custom-sections', trailingslashit( Kirki::$url ) . 'modules/custom-sections/sections.js', array( 'jquery', 'customize-base', 'customize-controls' ) );

	}

}
