<?php
/**
 * Try to automatically generate the script necessary for adding icons to panels & section
 *
 * @package     Kirki
 * @category    Core
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
 * Adds scripts for icons in sections & panels.
 */
class Section_Icons {

	/**
	 * An array of panels and sections with icons.
	 *
	 * @static
	 * @access private
	 * @var string
	 */
	private static $icons = [];

	/**
	 * The class constructor.
	 *
	 * @access public
	 */
	public function __construct() {
		add_action( 'customize_controls_enqueue_scripts', [ $this, 'customize_controls_enqueue_scripts' ], 99 );
	}

	/**
	 * Adds icon for a section/panel.
	 *
	 * @access public
	 * @since 3.0.0
	 * @param string $id      The panel or section ID.
	 * @param string $icon    The icon to add.
	 * @param string $context Lowercase 'section' or 'panel'.
	 */
	public function add_icon( $id, $icon, $context = 'section' ) {
		self::$icons[ $context ][ $id ] = trim( $icon );
	}

	/**
	 * Format the script in a way that will be compatible with WordPress.
	 */
	public function customize_controls_enqueue_scripts() {
		$sections = Kirki::$sections;
		$panels   = Kirki::$panels;

		// Parse sections and find ones with icons.
		foreach ( $sections as $section ) {
			if ( isset( $section['icon'] ) ) {
				$this->add_icon( $section['id'], $section['icon'], 'section' );
			}
		}

		// Parse panels and find ones with icons.
		foreach ( $panels as $panel ) {
			if ( isset( $panel['icon'] ) ) {
				$this->add_icon( $panel['id'], $panel['icon'], 'panel' );
			}
		}

		wp_enqueue_script( 'kirki_panel_and_section_icons', URL::get_from_path( __DIR__ . '/icons.js' ), [ 'jquery', 'customize-base', 'customize-controls' ], KIRKI_VERSION, true );
		wp_localize_script( 'kirki_panel_and_section_icons', 'kirkiIcons', self::$icons );
	}
}
