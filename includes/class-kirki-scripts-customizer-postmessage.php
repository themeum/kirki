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
if ( class_exists( 'Kirki_Scripts_Customizer_PostMessage' ) ) {
	return;
}

class Kirki_Scripts_Customizer_PostMessage extends Kirki_Scripts_Enqueue_Script {

	public function generate_script() {

		global $wp_customize;
		// Early exit if we're not in the customizer
		if ( ! isset( $wp_customize ) ) {
			return;
		}

		// Get an array of all the fields
		$fields = Kirki::$fields;

		$script = 'jQuery( "#kirki-styles-inline-css" ).remove();';
		$styles = array();

		// Parse the fields and create the script.
		foreach ( $fields as $field ) {
			$field['transport'] = Kirki_Field::sanitize_transport( $field );
			$field['js_vars']   = Kirki_Field::sanitize_js_vars( $field );

			if ( ! empty( $field['setting'] ) ) {
				$inline_id = 'kirki-' . $field['setting'];
				$styles[] = '<style id="' . esc_attr( $inline_id ) . '">' . Kirki_Output::generate_css_by_fields( array( $field ) ) . '</style>';
			}

			if ( 'postMessage' == $field['transport'] ) {

				$script .= 'wp.customize( \''.Kirki_Field::sanitize_settings( $field ).'\', function( value ) {';
				$script .= 'value.bind( function( newval ) {';

				if ( ! is_null( $field['js_vars'] ) ) {
					foreach ( $field['js_vars'] as $js_vars ) {
						if ( 'html' == $js_vars['function'] ) {
							$script .= '$(\''.esc_js( $js_vars['element'] ).'\').html( newval );';
						} elseif ( 'css' == $js_vars['function'] ) {
							$script .= '$(\''.esc_js( $js_vars['element'] ).'\').css(\''.esc_js( $js_vars['property'] ).'\', newval'.( ! empty( $js_vars['units'] ) ? ' + \''.$js_vars['units']."'" : '' ).' );';
						}
					}
				} else {
					$inline_id = 'kirki-' . $field['setting'];
					$placeholder_inline_css = Kirki_Output::generate_css_by_fields( array( $field ), true );
					$script .= 'jQuery( "#'. $inline_id .'" )[0].innerHTML = "' . str_replace( array( '{value}', '&gt;' ), array( '" + newval + "', '>' ), esc_js ($placeholder_inline_css ) ) . '";';
				}

				$script .= '}); });';
			}
		}

		return array($script, $styles);
	}

	public function wp_footer() {
		$code = $this->generate_script();

		if ( empty( $code ) ) {
			return;
		}

		if ( '' != $code[0] ) {
			echo Kirki_Scripts_Registry::prepare( $code[0] );
		}

		echo implode( '', $code[1] );
	}

	public function customize_controls_print_scripts() {}

	public function customize_controls_enqueue_scripts() {}

	public function customize_controls_print_footer_scripts() {}

}
