<?php
/**
 * Try to automatically generate the script necessary for adding icons to panels & section
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

if ( ! class_exists( 'Kirki_Customizer_Scripts_Icons' ) ) {

	class Kirki_Customizer_Scripts_Icons {

		/**
		 * string.
		 * The script generated for ALL fields
		 */
		public static $icons_script = '';
		/**
		 * boolean.
		 * Whether the script has already been added to the customizer or not.
		 */
		public static $script_added = false;

		/**
		 * The class constructor
		 */
		public function __construct() {
			add_action( 'customize_controls_print_footer_scripts', array( $this, 'enqueue_script' ), 99 );
		}

		/**
		 * This works on a per-field basis.
		 * Once created, the script is added to the $icons_script property.
		 *
		 * @param array the field definition
		 * @return void
		 */
		public static function generate_script( $args = array() ) {

			/**
			 * If "icon" is not specified
			 * then no need to proceed.
			 */
			if ( ! isset( $args['icon'] ) || '' == $args['icon'] ) {
				return;
			}
			/**
			 * If this is not a panel or section
			 * then no need to proceed.
			 */
			if ( ! isset( $args['context'] ) || ! in_array( $args['context'], array( 'panel', 'section' ) ) ) {
				return;
			}
			/**
			 * If the panel or section ID is not defined
			 * then early exit.
			 */
			if ( ! isset( $args['id'] ) ) {
				return;
			}

			$element = '#accordion-' . $args['context'] . '-' . $args['id'] . ' h3';
			if ( false !== strpos( $args['icon'], 'dashicons' ) ) {
				$args['icon'] = 'dashicons ' . $args['icon'];
			}

			$script = '$("' . $element . '").prepend(\'<span class="' . esc_attr( $args['icon'] ) . '"></span>\');';

			if ( false === strpos( self::$icons_script, $script ) ) {
				self::$icons_script .= $script;
			}

		}

		/**
		 * Format the script in a way that will be compatible with WordPress.
		 *
		 * @return  void (echoes the script)
		 */
		public function enqueue_script() {
			if ( ! self::$script_added && '' != self::$icons_script ) {
				self::$script_added = true;
				echo '<script>jQuery(document).ready(function($) { "use strict"; ' . self::$icons_script . '});</script>';
			}
		}

	}
}
