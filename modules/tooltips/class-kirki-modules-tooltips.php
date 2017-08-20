<?php
/**
 * Injects tooltips to controls when the 'tooltip' argument is used.
 *
 * @package     Kirki
 * @category    Modules
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
 * Adds script for tooltips.
 */
class Kirki_Modules_Tooltips {

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
	 * An array containing field identifieds and their tooltips.
	 *
	 * @access private
	 * @since 3.0.0
	 * @var array
	 */
	private $tooltips_content = array();

	/**
	 * The class constructor
	 *
	 * @access protected
	 * @since 3.0.0
	 */
	protected function __construct() {
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'customize_controls_print_footer_scripts' ) );
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
	 * Parses fields and if any tooltips are found, they are added to the
	 * object's $tooltips_content property.
	 *
	 * @access private
	 * @since 3.0.0
	 */
	private function parse_fields() {

		foreach ( Kirki::$fields as $field ) {
			if ( isset( $field['tooltip'] ) && ! empty( $field['tooltip'] ) ) {
				$this->tooltips_content[ $field['settings'] ] = array(
					'id'      => str_replace( array( '[', ']' ), array( '-', '' ), $field['settings'] ),
					'content' => wp_kses_post( $field['tooltip'] ),
				);
			}
		}
	}

	/**
	 * Allows us to add a tooltip to any control.
	 *
	 * @access public
	 * @since 4.2.0
	 * @param string $field_id The field-ID.
	 * @param string $tooltip  The tooltip content.
	 */
	public function add_tooltip( $field_id, $tooltip ) {

		$this->tooltips_content[ $field_id ] = array(
			'id'      => sanitize_key( $field_id ),
			'content' => wp_kses_post( $tooltip ),
		);

	}

	/**
	 * Enqueue scripts.
	 *
	 * @access public
	 * @since 3.0.0
	 */
	public function customize_controls_print_footer_scripts() {

		$this->parse_fields();

		wp_enqueue_script( 'kirki-dynamic-control', kirki_controls()->get_url( 'js/dynamic-control.js' ), array( 'jquery', 'customize-base' ), false, true );
		wp_enqueue_script( 'kirki-tooltip', trailingslashit( Kirki::$url ) . 'modules/tooltips/tooltip.js', array( 'jquery', 'kirki-dynamic-control' ) );
		wp_localize_script( 'kirki-tooltip', 'kirkiTooltips', $this->tooltips_content );
		wp_enqueue_style( 'kirki-tooltip', trailingslashit( Kirki::$url ) . 'modules/tooltips/tooltip.css', null );

	}
}
