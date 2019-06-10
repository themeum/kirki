<?php
/**
 * Try to automatically generate the script necessary for adding icons to panels & section
 *
 * @package     Kirki
 * @category    Core
 * @author      Ari Stathopoulos (@aristath)
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license     https://opensource.org/licenses/MIT
 * @since       3.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds scripts for icons in sections & panels.
 */
class Kirki_Modules_Icons {

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
	 * An array of panels and sections with icons.
	 *
	 * @static
	 * @access private
	 * @var string
	 */
	private static $icons = array();

	/**
	 * The class constructor.
	 *
	 * @access protected
	 */
	protected function __construct() {
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_controls_enqueue_scripts' ), 99 );
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

		wp_enqueue_script( 'kirki_panel_and_section_icons', trailingslashit( Kirki::$url ) . 'modules/icons/icons.js', array( 'jquery', 'customize-base', 'customize-controls' ), KIRKI_VERSION, true );
		wp_localize_script( 'kirki_panel_and_section_icons', 'kirkiIcons', self::$icons );
	}
}
