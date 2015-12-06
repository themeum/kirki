<?php
/**
 * Try to automatically generate the script necessary for postMessage to work.
 * for documentation see https://github.com/aristath/kirki/wiki/required
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
if ( class_exists( 'Kirki_PostMessage' ) ) {
	return;
}

class Kirki_Customizer_Scripts_PostMessage extends Kirki_Customizer_Scripts {

	/**
	 * string.
	 * The script generated for ALL fields
	 */
	public static $postmessage_script = '';
	/**
	 * boolean.
	 * Whether the script has already been added to the customizer or not.
	 */
	public static $script_added = false;

	/**
	 * The class constructor
	 */
	public function __construct() {
		add_action( 'wp_footer', array( $this, 'enqueue_script' ), 21 );
	}

	/**
	 * Generates the scripts needed for postMessage.
	 * This works on a per-field basis.
	 * Once created, the script is added to the $postmessage_script property.
	 *
	 * @param array the field definition
	 * @return void
	 */
	public static function generate_script( $args = array() ) {

		$script = '';
		/**
		 * Make sure "transport" is defined
		 */
		$args['transport'] = ( isset( $args['transport'] ) ) ? $args['transport'] : 'refresh';
		/**
		 * Make sure that we need to proceed
		 */
		if ( isset( $args['js_vars'] ) && 'postMessage' == $args['transport'] ) {
			/**
			 * Make sure that "js_vars" is an array.
			 * If not, then early exit with return.
			 */
			if ( ! is_array( $args['js_vars'] ) || empty( $args['js_vars'] ) ) {
				return;
			}
			/**
			 * Start looping through all the "js_vars" items in the array.
			 * Documentation on how to use the "js_vars" argument and its syntax
			 * can be found on https://github.com/aristath/kirki/wiki/js_vars
			 */
			foreach ( $args['js_vars'] as $js_vars ) {
				/**
				 * Sanitize the arguments
				 */
				$js_vars = array(
					'element'  => ( isset( $js_vars['element'] ) ) ? sanitize_text_field( $js_vars['element'] ) : '',
					'function' => ( isset( $js_vars['function'] ) ) ? esc_js( $js_vars['function'] ) : '',
					'property' => ( isset( $js_vars['property'] ) ) ? esc_js( $js_vars['property'] ) : '',
					'units'    => ( isset( $js_vars['units'] ) ) ? esc_js( $js_vars['units'] ) : '',
					'prefix'   => ( isset( $js_vars['prefix'] ) ) ? esc_js( $js_vars['prefix'] ) : '',
					'suffix'   => ( isset( $js_vars['suffix'] ) ) ? esc_js( $js_vars['suffix'] ) : '',
				);

				$settings = Kirki_Field_Sanitize::sanitize_settings( $args );
				$units    = ( ! empty( $js_vars['units'] ) ) ? " + '" . $js_vars['units'] . "'" : '';
				$prefix   = ( ! empty( $js_vars['prefix'] ) ) ? "'" . $js_vars['prefix'] . "' + " : '';
				$suffix   = ( ! empty( $js_vars['suffix'] ) ) ? " + '" . $js_vars['suffix'] . "'" : '';

				$script .= 'wp.customize( \'' . $settings . '\', function( value ) {';
				$script .= 'value.bind( function( newval ) {';

				if ( 'html' == $js_vars['function'] ) {

					$script .= '$(\'' . $js_vars['element'] . '\').html( newval );';

				} else if ( 'style' == $js_vars['function'] ) {

					$styleID = uniqid( 'kirki-style-' );
					$script .= 'if( !$(\'#' . $styleID . '\').size() ) {';
					$script .= '$(\'head\').append(\'<style id="' . $styleID . '"></style>\');';
					$script .= '}';
					$script .= 'if( newval !== \'\') {';
					$script .= '$(\'#' . $styleID . '\').text(\'' . $js_vars['element'] . '{ ' . $js_vars['property'] . ':' . $prefix . '\' + newval + \'' . $units . $suffix . ';}\');';
					$script .= '}else{';
					$script .= '$(\'#' . $styleID . '\').text(\'\');';
					$script .= "}";

				} else {

					$script .= '$(\'' . $js_vars['element'] . '\').' . $js_vars['function'] . '(\'' . $js_vars['property'] . '\', ' . $prefix . 'newval' . $units . $suffix . ' );';

				}

				$script .= '}); });';

			}

		}

		self::$postmessage_script .= $script;

	}

	/**
	 * Format the script in a way that will be compatible with WordPress.
	 *
	 * @return  void (echoes the script)
	 */
	public function enqueue_script() {
		if ( ! self::$script_added && '' != self::$postmessage_script ) {
			self::$script_added = true;
			echo '<script>jQuery(document).ready(function($) { "use strict"; ' . self::$postmessage_script . '});</script>';
		}
	}

}
