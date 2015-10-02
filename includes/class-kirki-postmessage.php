<?php
/**
 * Try to automatically generate the script necessary for postMessage to work.
 * for documentation see https://github.com/reduxframework/kirki/wiki/required
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

class Kirki_PostMessage extends Kirki_Scripts_Enqueue_Script {

	public $postmessage_script = '';

	public function generate_script( $args = array() ) {

		$script = '';
		$args['transport'] = ( isset( $args['transport'] ) ) ? $args['transport'] : 'refresh';
		$args['js_vars']   = Kirki_Field_Sanitize::sanitize_js_vars( $args );
		if ( ! is_null( $args['js_vars'] ) && 'postMessage' == $args['transport'] ) {
			foreach ( $args['js_vars'] as $js_vars ) {
				$units  = ( ! empty( $js_vars['units'] ) ) ? " + '" . $js_vars['units'] . "'" : '';
				$prefix = ( ! empty( $js_vars['prefix'] ) ) ? "'" . $js_vars['prefix'] . "' + " : '';
				$suffix = ( ! empty( $js_vars['suffix'] ) ) ? " + '" . $js_vars['suffix'] . "'" : '';
				$script .= 'wp.customize( \''.Kirki_Field_Sanitize::sanitize_settings( $args ).'\', function( value ) {';
				$script .= 'value.bind( function( newval ) {';
				if ( 'html' == $js_vars['function'] ) {
					$script .= '$(\'' . $js_vars['element'] . '\').html( newval );';
				} else {
					$script .= '$(\'' . $js_vars['element'] . '\').' . $js_vars['function'] . '(\'' . $js_vars['property'] . '\', ' . $prefix . 'newval' . $units . $suffix . ' );';
				}
				$script .= '}); });';
			}
		}

		return $script;

	}

	public function wp_footer() {
		if ( '' != $this->postmessage_script ) {
			echo Kirki_Scripts_Registry::prepare( $this->postmessage_script );
		}
	}

	public function customize_controls_print_scripts() {}

	public function customize_controls_enqueue_scripts() {}

	public function customize_controls_print_footer_scripts() {}

}
