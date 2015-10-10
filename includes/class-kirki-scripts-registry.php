<?php
/**
 * Instantiates all other needed scripts.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2015, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Early exit if the class already exists
if ( class_exists( 'Kirki_Scripts_Registry' ) ) {
	return;
}

class Kirki_Scripts_Registry {

	public $dependencies;
	public $branding;
	public $postmessage;
	public $tooltips;
	public $googlefonts;

	public function __construct() {

		$this->dependencies = new Kirki_Customizer_Scripts_Default_Scripts();
		$this->branding     = new Kirki_Customizer_Scripts_Branding();
		$this->postmessage  = new Kirki_Customizer_Scripts_PostMessage();
		$this->tooltips     = new Kirki_Customizer_Scripts_Tooltips();
		$this->icons        = new Kirki_Customizer_Scripts_Icons();
		$this->googlefonts  = new Kirki_Google_Fonts_Scripts();

	}

	/**
	 * @param string $script
	 */
	public static function prepare( $script ) {
		return '<script>jQuery(document).ready(function($) { "use strict"; ' . $script . '});</script>';
	}

}
