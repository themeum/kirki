<?php
/**
 * Instantiates all other needed scripts.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Scripts_Registry' ) ) {
	class Kirki_Scripts_Registry {

		public $dependencies;
		public $branding;
		public $postmessage;
		public $tooltips;
		public $googlefonts;
		public $icons;

		public function __construct() {

			$this->dependencies = new Kirki_Enqueue();
			$this->tooltips     = new Kirki_Customizer_Scripts_Tooltips();
			$this->icons        = new Kirki_Customizer_Scripts_Icons();

		}

		/**
		 * @param string $script
		 */
		public static function prepare( $script ) {
			return '<script>jQuery(document).ready(function($) { "use strict"; ' . $script . '});</script>';
		}

	}
}
