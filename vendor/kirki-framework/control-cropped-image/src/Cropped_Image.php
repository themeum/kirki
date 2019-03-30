<?php
/**
 * Customizer Control: cropped-image.
 *
 * @package   kirki-framework/control-cropped-image
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Control;

/**
 * Adds the image control.
 *
 * @since 1.0
 */
class Cropped_Image extends \WP_Customize_Cropped_Image_Control {

	/**
	 * Whitelisting the "required" argument.
	 *
	 * @since 1.0
	 * @access public
	 * @var array
	 */
	public $required = [];

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @access public
	 * @since 1.0
	 * @uses WP_Customize_Media_Control::to_json()
	 * @return void
	 */
	public function to_json() {
		parent::to_json();
		$this->json['required'] = $this->required;
	}
}
