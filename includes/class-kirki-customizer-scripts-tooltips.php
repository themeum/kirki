<?php
/**
 * Injects tooltips to controls when the 'help' argument is used.
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
if ( class_exists( 'Kirki_Scripts_Customizer_Tooltips' ) ) {
	return;
}

class Kirki_Customizer_Scripts_Tooltips extends Kirki_Customizer_Scripts {

	/**
	 * string.
	 * The script generated for ALL fields
	 */
	public static $tooltip_script = '';
	/**
	 * boolean.
	 * Whether the script has already been added to the customizer or not.
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
	 * @param array the field definition
	 * @return void
	 */
	public static function generate_script( $args = array() ) {

		/**
		 * The following control types already have the "help" argument in them
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

		$args['settings'] = Kirki_Field_Sanitize::sanitize_settings( $args );

		$script = '';
		if ( isset( $args['help'] ) && ! empty( $args['help'] ) ) {
			$content = "<a href='#' class='tooltip hint--left' data-hint='" . wp_strip_all_tags( $args['help'] ) . "'><span class='dashicons dashicons-info'></span></a>";
			$script  = '$( "' . $content . '" ).prependTo( "#customize-control-' . $args['settings'] . '" );';
		}

		self::$tooltip_script .= $script;

	}

	/**
	 * Format the script in a way that will be compatible with WordPress.
	 *
	 * @return  void (echoes the script)
	 */
	public function enqueue_script() {
		if ( ! self::$script_added && '' != self::$tooltip_script ) {
			self::$script_added = true;
			echo '<script>jQuery(document).ready(function($) { "use strict"; ' . self::$tooltip_script . '});</script>';
		}
	}

}
