<?php
/**
 * Automatic preset scripts calculation for Kirki controls.
 *
 * @package     Kirki
 * @category    Modules
 * @author      Ari Stathopoulos (@aristath)
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license    https://opensource.org/licenses/MIT
 * @since       3.0.26
 */

namespace Kirki\Modules\Preset;

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
	 * @since 3.0.26
	 * @var object
	 */
	private static $instance;

	/**
	 * Constructor.
	 *
	 * @access protected
	 * @since 3.0.26
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
	 * @since 3.0.26
	 * @return object
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Enqueue scripts.
	 *
	 * @access public
	 * @since 3.0.26
	 */
	public function customize_controls_print_footer_scripts() {
		$url = apply_filters(
			'kirki_package_url_module_preset',
			trailingslashit( Kirki::$url ) . 'vendor/kirki-framework/module-preset/src'
		);

		wp_enqueue_script(
			'kirki-set-setting-value',
			trailingslashit( Kirki::$url ) . 'assets/scripts/set-setting-value.js',
			array( 'jquery' ),
			KIRKI_VERSION,
			false
		);

		wp_enqueue_script(
			'kirki-preset',
			trailingslashit( Kirki::$url ) . 'assets/scripts/preset.js',
			array( 'jquery', 'kirki-set-setting-value' ),
			KIRKI_VERSION,
			false
		);
	}
}
