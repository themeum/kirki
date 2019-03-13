<?php
/**
 * Customizer Control: image.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license    https://opensource.org/licenses/MIT
 * @since       3.0.0
 */

namespace Kirki\Control;

use Kirki\Control\Base;

/**
 * Adds the image control.
 */
class Image extends Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-image';

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
	}
}
