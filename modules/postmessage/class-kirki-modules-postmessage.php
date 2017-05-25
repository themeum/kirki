<?php
/**
 * Automatic postMessage scripts calculation for Kirki controls.
 *
 * @package     Kirki
 * @category    Modules
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds styles to the customizer.
 */
class Kirki_Modules_PostMessage {

	/**
	 * The script.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @var string
	 */
	protected $script ='';

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 3.0.0
	 */
	public function __construct() {
		add_action( 'customize_preview_init', array( $this, 'postmessage' ) );
	}

	/**
	 * Enqueues the postMessage script
	 * and adds variables to it using the wp_localize_script function.
	 * The rest is handled via JS.
	 */
	public function postmessage() {

		wp_enqueue_script( 'kirki_auto_postmessage', trailingslashit( Kirki::$url ) . 'modules/postmessage/postmessage.js', array( 'jquery', 'customize-preview' ), false, true );
		$js_vars_fields = array();
		$fields = Kirki::$fields;
		foreach ( $fields as $id => $field ) {
			if ( isset( $field['transport'] ) && 'postMessage' === $field['transport'] && isset( $field['js_vars'] ) && ! empty( $field['js_vars'] ) && is_array( $field['js_vars'] ) && isset( $field['settings'] ) ) {
				$this->script .= $this->script( $field );
			}
		}
		wp_add_inline_script( 'kirki_auto_postmessage', $this->script, 'after' );

	}

	/**
	 * Generates script for a single js_var.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @param array $args The arguments.
	 */
	protected function _script( $args ) {
		$script = '';
		$property_script = '';

		$value_key = 'newval' . $args['index_key'];
		$property_script .= $value_key . '=newval;';

		// Make sure everything is defined to avoid "undefined index" errors.
		$args = wp_parse_args( $args, array(
			'element'       => '',
			'property'      => '',
			'prefix'        => '',
			'suffix'        => '',
			'units'         => '',
			'js_callback'   => array( '', '' ),
			'value_pattern' => '',
		));

		// Element should be a string.
		if ( is_array( $args['element'] ) ) {
			$args['element'] = implode( ',', $args['element'] );
		}

		// Make sure arguments that are passed-on to callbacks are strings.
		if ( is_array( $args['js_callback'] ) ) {
			if ( isset( $args['js_callback'][1] ) && is_array( $args['js_callback'][1] ) ) {
				$args['js_callback'][1] = json_encode( $args['js_callback'][1] );
			}
		}

		// Apply callback to the value if a callback is defined.
		if ( ! empty( $args['js_callback'][0] ) ) {
			$script .= $value_key . '=' . $args['js_callback'][0] . '(' . $value_key . ',' . $args['js_callback'][1] . ');';
		}

		// Apply the value_pattern.
		if ( '' !== $args['value_pattern'] ) {
			$value_pattern = str_replace( '$', '\'+' . $value_key . '+\'', $value_key );
			$script .= $value_key . '=' . trim( $value_pattern, '\'+' ) . ';';
		}

		// Apply prefix, units, suffix.
		$value = $value_key;
		if ( '' !== $args['prefix'] ) {
			$value = $args['prefix'] . '+' . $value_key;
		}
		if ( '' !== $args['units'] || '' !== $args['suffix'] ) {
			$value .= '+' . $args['units'] . $args['suffix'];
		}
		$scripts_array = array();
		$scripts_array[ sanitize_key( $args['element'] ) ][ sanitize_key( $args['property'] ) ]['script'] = $property_script . $script;
		$scripts_array[ sanitize_key( $args['element'] ) ][ sanitize_key( $args['property'] ) ]['css']    = $args['element'] . '{' . $args['property'] . ':\'+' . $value_key . '+\';}';

		return $scripts_array;
	}

	/**
	 * Generates script for a single field.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @param array $args The arguments.
	 */
	protected function script( $args ) {

		$field_scripts = array();

		$script = 'wp.customize(\'' . $args['settings'] . '\',function(value){value.bind(function(newval){';
			// append unique style tag if not exist
			// The style ID.
			$style_id = 'kirki-postmessage-' . str_replace( array( '[', ']' ), '', $args['settings'] );
			$script .= 'if(!jQuery(\'' . $style_id . '\').size()){jQuery(\'head\').append(\'<style id="' . $style_id . '"></style>\');}';

			// Loop through the js_vars and generate the script.
			foreach ( $args['js_vars'] as $key => $js_var ) {
				$js_var['index_key'] = $key;
				$field['scripts'][ $key ] = $this->_script( $js_var );
			}
			$combo_extra_script = '';
			$combo_css_script   = '';
			foreach ( $field['scripts'] as $script_l1 ) {
				foreach ( $script_l1 as $script_l2 ) {
					foreach ( $script_l2 as $script_array ) {
						$combo_extra_script .= $script_array['script'];
						$combo_css_script   .= $script_array['css'];
					}
				}
			}
			$script .= $combo_extra_script . 'jQuery(\'#' . $style_id . '\').text(\'' . $combo_css_script . '\');';
		$script .= '});});';
		return $script;
	}
}
