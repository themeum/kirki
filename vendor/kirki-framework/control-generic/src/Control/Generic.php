<?php
/**
 * Customizer Control: kirki-generic.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license    https://opensource.org/licenses/MIT
 * @since       2.0
 */

namespace Kirki\Control;

use Kirki\Control\Base;
use Kirki\Core\Kirki;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A generic and pretty abstract control.
 * Allows for great manipulation using the field's "choices" argumnent.
 */
class Generic extends Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-generic';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		parent::enqueue();

		$url = apply_filters(
			'kirki_package_url_control_generic',
			trailingslashit( Kirki::$url ) . 'vendor/kirki-framework/control-generic/src'
		);

		// Enqueue the script.
		wp_enqueue_script(
			'kirki-control-generic',
			"$url/assets/scripts/control.js",
			[
				'jquery',
				'customize-base',
				'kirki-dynamic-control',
			],
			KIRKI_VERSION,
			false
		);
	}
}
