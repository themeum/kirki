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
	protected $script = '';

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
		$fields = Kirki::$fields;
		foreach ( $fields as $field ) {
			if ( isset( $field['transport'] ) && 'postMessage' === $field['transport'] && isset( $field['js_vars'] ) && ! empty( $field['js_vars'] ) && is_array( $field['js_vars'] ) && isset( $field['settings'] ) ) {
				$this->script .= $this->script( $field );
			}
		}
		$this->script = apply_filters( 'kirki/postmessage/script', $this->script );
		wp_add_inline_script( 'kirki_auto_postmessage', $this->script, 'after' );

	}

	/**
	 * Generates script for a single field.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @param array $args The arguments.
	 */
	protected function script( $args ) {

		$script = 'wp.customize(\'' . $args['settings'] . '\',function(value){value.bind(function(newval){';
		// append unique style tag if not exist
		// The style ID.
		$style_id = 'kirki-postmessage-' . str_replace( array( '[', ']' ), '', $args['settings'] );
		$script .= 'if(!jQuery(\'' . $style_id . '\').size()){jQuery(\'head\').append(\'<style id="' . $style_id . '"></style>\');}';

		// Loop through the js_vars and generate the script.
		foreach ( $args['js_vars'] as $key => $js_var ) {
			$js_var['index_key'] = $key;
			$func_name = 'script_var_' . str_replace( array( 'kirki-', '-' ), array( '', '_' ), $args['type'] );
			if ( method_exists( $this, $func_name ) ) {
				$field['scripts'][ $key ] = call_user_func_array( array( $this, $func_name ), array( $js_var, $args ) );
				continue;
			}
			$field['scripts'][ $key ] = $this->script_var( $js_var, $args );
		}
		$combo_extra_script = '';
		$combo_css_script   = '';
		foreach ( $field['scripts'] as $script_array ) {
			$combo_extra_script .= $script_array['script'];
			$combo_css_script   .= $script_array['css'];
		}
		$text = ( 'css' === $combo_css_script ) ? 'css' : '\'' . $combo_css_script . '\'';
		$script .= $combo_extra_script . 'jQuery(\'#' . $style_id . '\').text(' . $text . ');';
		$script .= '});});';
		return $script;
	}

	/**
	 * Generates script for a single js_var.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @param array $args  The arguments for this js_var.
	 */
	protected function script_var( $args ) {
		$script = '';
		$property_script = '';

		$value_key = 'newval' . $args['index_key'];
		$property_script .= $value_key . '=newval;';

		$args = $this->get_args( $args );

		// Apply callback to the value if a callback is defined.
		if ( ! empty( $args['js_callback'][0] ) ) {
			$script .= $value_key . '=' . $args['js_callback'][0] . '(' . $value_key . ',' . $args['js_callback'][1] . ');';
		}

		// Apply the value_pattern.
		if ( '' !== $args['value_pattern'] ) {
			$script .= $this->value_pattern_replacements( $value_key, $args );
		}

		// Apply prefix.
		$value = $value_key;
		if ( '' !== $args['prefix'] ) {
			$value = $args['prefix'] . '+' . $value_key;
		}

		return array(
			'script' => $property_script . $script,
			'css'    => $args['element'] . '{' . $args['property'] . ':\'+' . $value . '+\'' . $args['units'] . $args['suffix'] . ';}',
		);
	}

	/**
	 * Processes script generation for fields that save an array.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @param array $args  The arguments for this js_var.
	 */
	protected function script_var_array( $args ) {

		$script = 'css=\'\';';
		$property_script = '';

		$value_key = 'newval' . $args['index_key'];
		$property_script .= $value_key . '=newval;';

		$args = $this->get_args( $args );

		// Apply callback to the value if a callback is defined.
		if ( ! empty( $args['js_callback'][0] ) ) {
			$script .= $value_key . '=' . $args['js_callback'][0] . '(' . $value_key . ',' . $args['js_callback'][1] . ');';
		}
		$script .= '_.each(' . $value_key . ', function(subValue,subKey){';
		// Apply the value_pattern.
		if ( '' !== $args['value_pattern'] ) {
			$script .= $this->value_pattern_replacements( 'subValue', $args );
		}
		// Apply prefix.
		$value = $value_key;
		if ( '' !== $args['prefix'] ) {
			$value = '\'' . $args['prefix'] . '\'+subValue';
		}
		$script .= 'if(!_.isUndefined(' . $value_key . '.choice)){if(' . $value_key . '.choice===subKey){';
		$script .= 'css+=\'' . $args['element'] . '{' . $args['property'] . ':\'+subValue+\';}\';';
		$script .= '}}else{';

		// Mostly used for padding, margin & position properties.
		$script .= 'if(_.contains([\'top\',\'bottom\',\'left\',\'right\'],subKey)){';
		$script .= 'css+=\'' . $args['element'] . '{' . $args['property'] . '-\'+subKey+\':\'+subValue+\'' . $args['units'] . $args['suffix'] . ';}\';';
		$script .= '}else{';

		// This is where most object-based fields will go.
		$script .= 'css+=\'' . $args['element'] . '{\'+subKey+\':\'+subValue+\'' . $args['units'] . $args['suffix'] . ';}\';';
		$script .= '}}';
		$script .= '});';

		return array(
			'script' => $property_script . $script,
			'css'    => 'css',
		);
	}

	/**
	 * Processes values for dimensions fields.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @param array $args  The arguments for this js_var.
	 * @param array $field The whole field arguments.
	 */
	protected function script_var_dimensions( $args, $field ) {
		return $this->script_var_array( $args, $field );
	}

	/**
	 * Sanitizes the arguments and makes sure they are all there.
	 *
	 * @access private
	 * @since 3.0.0
	 * @param array $args The arguments.
	 * @return array
	 */
	private function get_args( $args ) {

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
		if ( is_array( $args['js_callback'] ) && isset( $args['js_callback'][1] ) && is_array( $args['js_callback'][1] ) ) {
			$args['js_callback'][1] = wp_json_encode( $args['js_callback'][1] );
		}
		return $args;

	}

	/**
	 * Returns script for value_pattern & replacements.
	 *
	 * @access private
	 * @since 3.0.0
	 * @param string $value   The value placeholder.
	 * @param array  $js_vars The js_vars argument.
	 * @return string         The script.
	 */
	private function value_pattern_replacements( $value, $js_vars ) {
		$script = '';
		$alias  = $value;
		if ( isset( $js_vars['replacements'] ) ) {
			$script .= 'settings=window.wp.customize.get();';
			foreach ( $js_vars['replacements'] as $search => $replace ) {
				$replace = '\'+settings["' . $replace . '"]+\'';
				$value = str_replace( $search, $replace, $js_vars['value_pattern'] );
				$value = trim( $value, '+' );
			}
		}
		$value_compiled = str_replace( '$', '\'+' . $alias . '+\'', $value );
		$value_compiled = trim( $value_compiled, '+' );
		return $script . $alias . '=\'' . $value_compiled . '\';';
	}
}
