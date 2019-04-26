<?php
/**
 * Custom Sections.
 *
 * @package     Kirki
 * @category    Modules
 * @subpackage  Custom Sections Module
 * @author      Ari Stathopoulos (@aristath)
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license    https://opensource.org/licenses/MIT
 * @since       3.0.0
 */

namespace Kirki\Modules\Custom_Sections;

use Kirki\Core\Kirki;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds styles to the customizer.
 */
class Module {

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
		add_filter( 'kirki_section_types', [ $this, 'set_section_types' ] );

		// Register the new panel types.
		add_filter( 'kirki_panel_types', [ $this, 'set_panel_types' ] );

		// Include the section-type files.
		add_action( 'customize_register', [ $this, 'include_sections_and_panels' ] );

		// Enqueue styles & scripts.
		add_action( 'customize_controls_enqueue_scripts', [ $this, 'enqueue_scrips' ], 999 );
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
		return array_merge(
			$section_types,
			[
				'kirki-default'  => '\Kirki\Modules\Custom_Sections\Section_Default',
				'kirki-expanded' => '\Kirki\Modules\Custom_Sections\Section_Expanded',
				'kirki-nested'   => '\Kirki\Modules\Custom_Sections\Section_Nested',
				'kirki-link'     => '\Kirki\Modules\Custom_Sections\Section_Link',
			]
		);
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
		return array_merge(
			$panel_types,
			[
				'kirki-nested' => '\Kirki\Modules\Custom_Panels\Panel_Nested',
			]
		);
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
		$section_types = apply_filters( 'kirki_section_types', [] );

		foreach ( $section_types as $id => $class ) {
			if ( ! class_exists( $class ) ) {
				$path = wp_normalize_path( $folder_path . 'class-kirki-sections-' . $id . '-section.php' );
				if ( file_exists( $path ) ) {
					include_once $path; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude
					continue;
				}
				$path = str_replace( 'class-kirki-sections-kirki-', 'class-kirki-sections-', $path );
				if ( file_exists( $path ) ) {
					include_once $path; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude
				}
			}
		}

		// Panels.
		$folder_path = dirname( __FILE__ ) . '/panels/';
		$panel_types = apply_filters( 'kirki_panel_types', [] );

		foreach ( $panel_types as $id => $class ) {
			if ( ! class_exists( $class ) ) {
				$path = wp_normalize_path( $folder_path . 'class-kirki-panels-' . $id . '-panel.php' );
				if ( file_exists( $path ) ) {
					include_once $path; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude
					continue;
				}
				$path = str_replace( 'class-kirki-panels-kirki-', 'class-kirki-panels-', $path );
				if ( file_exists( $path ) ) {
					include_once $path; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude
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
		$url = apply_filters(
			'kirki_package_url_module_custom_sections',
			trailingslashit( Kirki::$url ) . 'vendor/kirki-framework/module-custom-sections/src'
		);

		wp_enqueue_style( 'kirki-custom-sections', $url . '/assets/styles/sections.css', [], KIRKI_VERSION );
		wp_enqueue_script( 'kirki-custom-sections', $url . '/assets/scripts/sections.js', [ 'jquery', 'customize-base', 'customize-controls' ], KIRKI_VERSION, false );
	}
}
