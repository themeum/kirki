<?php
/**
 * Override field methods
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.7
 */

/**
 * Field overrides.
 */
class Kirki_Field_Spacing_Advanced extends Kirki_Field {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {

		$this->type = 'kirki-spacing-advanced';

	}
	/**
	 * The class constructor.
	 * Parses and sanitizes all field arguments.
	 * Then it adds the field to Kirki::$fields.
	 *
	 * @access public
	 * @param string $config_id    The ID of the config we want to use.
	 *                             Defaults to "global".
	 *                             Configs are handled by the Kirki_Config class.
	 * @param array  $args         The arguments of the field.
	 */
	public function __construct( $config_id = 'global', $args = array() ) {
		parent::__construct( $config_id, $args );
		$this->set_default();
	}

	/**
	 * Sets the default value.
	 *
	 * @access protected
	 */
	protected function set_default() {
		
	}

	/**
	 * Sets the $sanitize_callback
	 *
	 * @access protected
	 */
	protected function set_sanitize_callback() {

		// If a custom sanitize_callback has been defined,
		// then we don't need to proceed any further.
		if ( ! empty( $this->sanitize_callback ) ) {
			return;
		}
		$this->sanitize_callback = array( __CLASS__, 'sanitize' );

	}

	/**
	 * Sets the $js_vars
	 *
	 * @access protected
	 */
	protected function set_js_vars() {

		if ( ! is_array( $this->js_vars ) ) {
			$this->js_vars = array();
		}

		// Check if transport is set to auto.
		// If not, then skip the auto-calculations and exit early.
		if ( 'auto' !== $this->transport ) {
			return;
		}

		// Set transport to refresh initially.
		// Serves as a fallback in case we failt to auto-calculate js_vars.
		$this->transport = 'refresh';

		$js_vars = array();

		// Try to auto-generate js_vars.
		// First we need to check if js_vars are empty, and that output is not empty.
		if ( ! empty( $this->output ) ) {

			// Start going through each item in the $output array.
			foreach ( $this->output as $output ) {

				// If 'element' or 'property' are not defined, skip this.
				if ( ! isset( $output['element'] ) ) {
					continue;
				}
				if ( is_array( $output['element'] ) ) {
					$output['element'] = implode( ',', $output['element'] );
				}

				// If we got this far, it's safe to add this.
				$js_vars[] = $output;
			}

			// Did we manage to get all the items from 'output'?
			// If not, then we're missing something so don't add this.
			if ( count( $js_vars ) !== count( $this->output ) ) {
				return;
			}
			$this->js_vars   = $js_vars;
			$this->transport = 'postMessage';

		}

	}

	/**
	 * Sanitizes typography controls
	 *
	 * @static
	 * @since 2.2.0
	 * @param array $value The value.
	 * @return array
	 */
	public static function sanitize( $value ) {
		//TODO: Set proper sanitizing for spacing advanced.
		return $value;
		$valid_units = array( '%', 'cm',' em', 'ex', 'in', 'mm' ,'pc', 'pt', 'px', 'vh', 'vw', 'vmin' );
		if ( ! is_array( $value ) ) {
			return array();
		}
		
		$_sanitize = function ( &$device, $valid_units )
		{
			if ( isset( $device['value'] ) )
				$device['value'] = isset( $device['value'] ) ? floatval( $device['value'] ) : 0;
			else
				$device['value'] = floatval ( $device['value'] );
			if ( isset( $device['unit'] ) && !in_array ( strtolower( $device['unit'] ), $valid_units ) )
				$device['unit'] = '';
			else
				$device['unit'] = strtolower( $device['unit'] );
		};
		
		$value['use_media_queries'] = isset( $value['use_media_queries'] ) ? (bool)$value['use_media_queries'] :
			false;
		if ( isset( $value['desktop'] ) )
			$_sanitize( $value['desktop'],$valid_units );
		if ( isset( $value['tablet'] ) )
			$_sanitize( $value['tablet'], $valid_units );
		if ( isset( $value['mobile'] ) )
			$_sanitize( $value['mobile'], $valid_units );
		
		if ( isset( $value['value'] ) )
			$value['value'] = intval ( $value['value'] );
		if ( isset( $value['unit'] ) )
		{
			if ( !in_array( $value['unit'], $valid_units ) )
				$value['unit'] = 'px';
		}
		
		return $value;
	}

	/**
	 * Sets the $choices
	 *
	 * @access protected
	 * @since 3.0.0
	 */
	protected function set_choices() {
		//TODO: Fix set_choices for spacing advanced.
		if ( ! is_array( $this->choices ) ) {
			$this->choices = array();
		}
		$this->choices = wp_parse_args(
			$this->choices, array(
				'use_media_queries' => true,
				'units' => array (
					'' => array(
						'top' => '',
						'left' => '',
						'bottom' => '',
						'right' => ''
					)
				)
			)
		);
	}
}
