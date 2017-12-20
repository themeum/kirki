<?php
/**
 * Custom Sections.
 *
 * @package     Kirki
 * @category    Modules
 * @subpackage  Custom Sections Module
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0.0
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
	 * The object instance.
	 *
	 * @static
	 * @access private
	 * @since 3.0.0
	 * @var object
	 */
	private static $instance;

	/**
	 * Constructor.
	 *
	 * @access protected
	 * @since 3.0.0
	 */
	protected function __construct() {
		// Register the new section types.
		add_filter( 'kirki_section_types', array( $this, 'set_section_types' ) );
		// Register the new panel types.
		add_filter( 'kirki_panel_types', array( $this, 'set_panel_types' ) );
		// Include the section-type files.
		add_action( 'customize_register', array( $this, 'include_sections_and_panels' ) );
		// Enqueue styles & scripts.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_scrips' ), 999 );
	}

	/**
	 * Gets an instance of this object.
	 * Prevents duplicate instances which avoid artefacts and improves performance.
	 *
	 * @static
	 * @access public
	 * @since 3.0.0
	 * @return object
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Add the custom section types.
	 *
	 * @access public
	 * @since 3.0.0
	 * @param array $section_types The registered section-types.
	 * @return array
	 */
	public function set_section_types( $section_types ) {

		$new_types = array(
			'kirki-default'  => 'Kirki_Sections_Default_Section',
			'kirki-expanded' => 'Kirki_Sections_Expanded_Section',
			'kirki-nested'   => 'Kirki_Sections_Nested_Section',
		);
		return array_merge( $section_types, $new_types );

	}

	/**
	 * Add the custom panel types.
	 *
	 * @access public
	 * @since 3.0.0
	 * @param array $panel_types The registered section-types.
	 * @return array
	 */
	public function set_panel_types( $panel_types ) {

		$new_types = array(
			'kirki-nested' => 'Kirki_Panels_Nested_Panel',
		);
		return array_merge( $panel_types, $new_types );

	}

	/**
	 * Include the custom-section classes.
	 *
	 * @access public
	 * @since 3.0.0
	 */
	public function include_sections_and_panels() {

		// Sections.
		$folder_path   = dirname( __FILE__ ) . '/sections/';
		$section_types = apply_filters( 'kirki_section_types', array() );

		foreach ( $section_types as $id => $class ) {
			if ( ! class_exists( $class ) ) {
				$path = wp_normalize_path( $folder_path . 'class-kirki-sections-' . $id . '-section.php' );
				if ( file_exists( $path ) ) {
					include_once $path;
					continue;
				}
				$path = str_replace( 'class-kirki-sections-kirki-', 'class-kirki-sections-', $path );
				if ( file_exists( $path ) ) {
					include_once $path;
				}
			}
		}

		// Panels.
		$folder_path = dirname( __FILE__ ) . '/panels/';
		$panel_types = apply_filters( 'kirki_panel_types', array() );

		foreach ( $panel_types as $id => $class ) {
			if ( ! class_exists( $class ) ) {
				$path = wp_normalize_path( $folder_path . 'class-kirki-panels-' . $id . '-panel.php' );
				if ( file_exists( $path ) ) {
					include_once $path;
					continue;
				}
				$path = str_replace( 'class-kirki-panels-kirki-', 'class-kirki-panels-', $path );
				if ( file_exists( $path ) ) {
					include_once $path;
				}
			}
		}

	}

	/**
	 * Enqueues any necessary scripts and styles.
	 *
	 * @access public
	 * @since 3.0.0
	 */
	public function enqueue_scrips() {

		wp_enqueue_style( 'kirki-custom-sections', trailingslashit( Kirki::$url ) . 'modules/custom-sections/sections.css', array(), KIRKI_VERSION );
		wp_enqueue_script( 'kirki-custom-sections', trailingslashit( Kirki::$url ) . 'modules/custom-sections/sections.js', array( 'jquery', 'customize-base', 'customize-controls' ), KIRKI_VERSION );

	}

}
