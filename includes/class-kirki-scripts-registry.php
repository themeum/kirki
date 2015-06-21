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

class Kirki_Scripts_Registry {

	public function __construct() {

		$dependencies = new Kirki_Scripts_Customizer_Default_Scripts();
		$branding     = new Kirki_Scripts_Customizer_Branding();
		$postmessage  = new Kirki_Scripts_Customizer_PostMessage();
		$tooltips     = new Kirki_Scripts_Customizer_Tooltips();
		$googlefonts  = new Kirki_Scripts_Frontend_Google_Fonts();

	}

	/**
	 * @param string $script
	 */
	public static function prepare( $script ) {
		return '<script>jQuery(document).ready(function($) { "use strict"; '.$script.'});</script>';
	}

}
