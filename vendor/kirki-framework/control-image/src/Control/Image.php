<?php
/**
 * Customizer Control: image.
 *
 * @package   kirki-framework/control-image
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Control;

use Kirki\Control\Base;
use Kirki\URL;

/**
 * Adds the image control.
 *
 * @since 1.0
 */
class Image extends Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $type = 'kirki-image';

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
	 */
	public function enqueue() {
		parent::enqueue();

		add_action(
			'customize_controls_print_footer_scripts',
			function() {
				$path = apply_filters( 'kirki_control_view_image', __DIR__ . '/view.php' );
				echo '<script type="text/html" id="tmpl-kirki-input-image">';
				include $path;
				echo '</script>';
			}
		);

		// Enqueue the script.
		wp_enqueue_script( 'kirki-control-image', URL::get_from_path( dirname( __DIR__ ) . '/assets/scripts/control.js' ), [ 'jquery', 'customize-base', 'kirki-dynamic-control', 'wp-mediaelement', 'media-upload' ], self::$control_ver, false );
	}
}
