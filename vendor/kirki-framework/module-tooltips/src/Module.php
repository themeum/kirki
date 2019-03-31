<?php
/**
 * Injects tooltips to controls when the 'tooltip' argument is used.
 *
 * @package     Kirki
 * @category    Modules
 * @author      Ari Stathopoulos (@aristath)
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license    https://opensource.org/licenses/MIT
 * @since       3.0.0
 */

namespace Kirki\Modules\Tooltips;

use Kirki\Core\Kirki;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds script for tooltips.
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
	 * An array containing field identifieds and their tooltips.
	 *
	 * @access private
	 * @since 3.0.0
	 * @var array
	 */
	private $tooltips_content = [];

	/**
	 * The class constructor
	 *
	 * @access protected
	 * @since 3.0.0
	 */
	protected function __construct() {
		add_action( 'customize_controls_print_footer_scripts', [ $this, 'customize_controls_print_footer_scripts' ] );
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
		$fields = Kirki::$fields;
		foreach ( $fields as $field ) {
			if ( isset( $field['tooltip'] ) && ! empty( $field['tooltip'] ) ) {
				// Get the control ID and properly format it for the tooltips.
				$id = str_replace( '[', '-', str_replace( ']', '', $field['settings'] ) );
				// Add the tooltips content.
				$this->tooltips_content[ $id ] = [
					'id'      => $id,
					'content' => $field['tooltip'],
				];
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
		$this->tooltips_content[ $field_id ] = [
			'id'      => sanitize_key( $field_id ),
			'content' => wp_kses_post( $tooltip ),
		];
	}

	/**
	 * Enqueue scripts.
	 *
	 * @access public
	 * @since 3.0.0
	 */
	public function customize_controls_print_footer_scripts() {
		$this->parse_fields();

		$url = apply_filters(
			'kirki_package_url_module_tooltips',
			trailingslashit( Kirki::$url ) . 'vendor/kirki-framework/module-tooltips/src'
		);

		wp_enqueue_script( 'kirki-tooltip', $url . '/assets/scripts/script.js', [ 'jquery' ], KIRKI_VERSION, false );
		wp_localize_script( 'kirki-tooltip', 'kirkiTooltips', $this->tooltips_content );
		wp_enqueue_style( 'kirki-tooltip', $url . '/assets/styles/styles.css', [], KIRKI_VERSION );
	}
}
