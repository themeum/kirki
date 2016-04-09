<?php
/**
 * Injects tooltips to controls when the 'tooltip' argument is used.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Scripts_Tooltips' ) ) {

	/**
	 * Adds script for tooltips.
	 */
	class Kirki_Scripts_Tooltips {

		/**
		 * The script generated for ALL fields
		 *
		 * @static
		 * @access public
		 * @var string
		 */
		public static $tooltip_script = '';

		/**
		 * Whether the script has already been added to the customizer or not.
		 *
		 * @static
		 * @access public
		 * @var bool
		 */
		public static $script_added = false;

		/**
		 * The class constructor
		 */
		public function __construct() {
			add_action( 'customize_controls_print_footer_scripts', array( $this, 'enqueue_script' ) );
		}

		/**
		 * Generates the scripts needed for tooltips.
		 * This works on a per-field basis.
		 * Once created, the script is added to the $tooltip_script property.
		 *
		 * @param array $args The field definition.
		 * @return void
		 */
		public static function generate_script( $args = array() ) {

			/**
			 * The following control types already have the "tooltip" argument in them
			 * and they don't need an extra implementation in order to be rendered.
			 * We're going to ignore these control-types and only process the rest.
			 */
			$ready_controls = array(
				'checkbox',
				'code',
				'color-alpha',
				'custom',
				'dimension',
				'editor',
				'multicheck',
				'number',
				'palette',
				'radio-buttonset',
				'radio-image',
				'radio',
				'kirki-radio',
				'repeater',
				'select',
				'kirki-select',
				'select2',
				'select2-multiple',
				'slider',
				'sortable',
				'spacing',
				'switch',
				'textarea',
				'toggle',
				'typography',
			);

			/**
			 * Make sure the field-type has been defined.
			 * If it has not been defined the we don't know what to do with it and should exit.
			 * No error is displayed, we just won't do anything.
			 */
			if ( isset( $args['type'] ) && in_array( $args['type'], $ready_controls ) ) {
				return;
			}

			$script = '';
			if ( isset( $args['tooltip'] ) && ! empty( $args['tooltip'] ) ) {
				$content = "<a href='#' class='tooltip hint--left' data-hint='" . wp_strip_all_tags( $args['tooltip'] ) . "'><span class='dashicons dashicons-info'></span></a>";
				$script  = '$( "' . $content . '" ).prependTo( "#customize-control-' . $args['settings'] . '" );';
			}

			self::$tooltip_script .= $script;

		}

		/**
		 * Format the script in a way that will be compatible with WordPress.
		 */
		public function enqueue_script() {
			if ( ! self::$script_added && '' != self::$tooltip_script ) {
				self::$script_added = true;
				echo '<script>jQuery(document).ready(function($) { "use strict"; ' . wp_kses_post( self::$tooltip_script ) . '});</script>';
			}
		}
	}
}
