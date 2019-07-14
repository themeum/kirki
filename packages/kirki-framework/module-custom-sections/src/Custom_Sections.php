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

namespace Kirki\Module;

use Kirki\Compatibility\Kirki;
use Kirki\URL;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds styles to the customizer.
 */
class Custom_Sections {

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 3.0.0
	 */
	public function __construct() {

		// Register the new section types.
		add_filter( 'kirki_section_types', [ $this, 'set_section_types' ] );

		// Include the section-type files.
		add_action( 'customize_register', [ $this, 'include_sections' ] );

		// Enqueue styles & scripts.
		add_action( 'customize_controls_enqueue_scripts', [ $this, 'enqueue_scrips' ], 999 );
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
				'kirki-default'  => '\Kirki\Module\Custom_Sections\Section_Default',
				'kirki-expanded' => '\Kirki\Module\Custom_Sections\Section_Expanded',
				'kirki-nested'   => '\Kirki\Module\Custom_Sections\Section_Nested',
				'kirki-link'     => '\Kirki\Module\Custom_Sections\Section_Link',
				'kirki-outer'    => '\Kirki\Module\Custom_Sections\Section_Outer',
			]
		);
	}

	/**
	 * Include the custom-section classes.
	 *
	 * @access public
	 * @since 3.0.0
	 */
	public function include_sections() {

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
	}

	/**
	 * Enqueues any necessary scripts and styles.
	 *
	 * @access public
	 * @since 3.0.0
	 */
	public function enqueue_scrips() {
		wp_enqueue_style( 'kirki-custom-sections', URL::get_from_path( __DIR__ . '/assets/styles/sections.css' ), [], '4.0' );
		wp_enqueue_script( 'kirki-custom-sections', URL::get_from_path( __DIR__ . '/assets/scripts/sections.js' ), [ 'jquery', 'customize-base', 'customize-controls' ], '4.0', false );
	}
}
