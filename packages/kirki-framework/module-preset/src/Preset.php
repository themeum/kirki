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
class Preset {

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 3.0.26
	 */
	public function __construct() {
		add_action( 'customize_controls_print_footer_scripts', [ $this, 'customize_controls_print_footer_scripts' ] );
	}

	/**
	 * Enqueue scripts.
	 *
	 * @access public
	 * @since 3.0.26
	 */
	public function customize_controls_print_footer_scripts() {
		wp_enqueue_script(
			'kirki-set-setting-value',
			URL::get_from_path( __DIR__ . '/assets/scripts/set-setting-value.js' ),
			[ 'jquery' ],
			KIRKI_VERSION,
			false
		);

		wp_enqueue_script(
			'kirki-preset',
			URL::get_from_path( __DIR__ . '/assets/scripts/preset.js' ),
			[ 'jquery', 'kirki-set-setting-value' ],
			KIRKI_VERSION,
			false
		);
	}
}
