<?php
/**
 * Customizer Control: kirki-generic.
 *
 * @package   kirki-framework/control-generic
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Control;

use Kirki\Control\Base;
use Kirki\URL;

/**
 * A generic and pretty abstract control.
 * Allows for great manipulation using the field's "choices" argumnent.
 *
 * @since 1.0
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
	 * The version. Used in scripts & styles for cache-busting.
	 *
	 * @static
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public static $control_ver = '1.0';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function enqueue() {
		parent::enqueue();

		add_action(
			'customize_controls_print_footer_scripts',
			function() {
				$path = apply_filters( 'kirki_control_view_generic', __DIR__ . '/view-generic.php' );
				echo '<script type="text/html" id="tmpl-kirki-input-generic">';
				include $path;
				echo '</script>';
			}
		);

		add_action(
			'customize_controls_print_footer_scripts',
			function() {
				$path = apply_filters( 'kirki_control_view_textarea', __DIR__ . '/view-textarea.php' );
				echo '<script type="text/html" id="tmpl-kirki-input-textarea">';
				include $path;
				echo '</script>';
			}
		);

		// Enqueue the script.
		wp_enqueue_script( 'kirki-control-generic', URL::get_from_path( dirname( __DIR__ ) . '/assets/scripts/control.js' ), [ 'jquery', 'customize-base', 'kirki-dynamic-control' ], self::$control_ver, false );
	}
}
