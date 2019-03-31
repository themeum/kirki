<?php
/**
 * Automatic field-dependencies scripts calculation for Kirki controls.
 *
 * @package     Kirki
 * @category    Modules
 * @author      Ari Stathopoulos (@aristath)
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license    https://opensource.org/licenses/MIT
 * @since       3.0.0
 */

namespace Kirki\Modules\Field_Dependencies;

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
		add_action( 'customize_controls_enqueue_scripts', [ $this, 'field_dependencies' ] );
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
	 * Enqueues the field-dependencies script
	 * and adds variables to it using the wp_localize_script function.
	 * The rest is handled via JS.
	 *
	 * @access public
	 * @return void
	 */
	public function field_dependencies() {
		$url = apply_filters(
			'kirki_package_url_module_field_dependencies',
			trailingslashit( Kirki::$url ) . 'vendor/kirki-framework/module-field-dependencies/src'
		);
		wp_enqueue_script( 'kirki_field_dependencies', $url . '/assets/scripts/script.js', [ 'jquery', 'customize-base', 'customize-controls' ], KIRKI_VERSION, true );
	}
}
