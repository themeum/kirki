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
class Kirki_Field_Slider_Advanced extends Kirki_Field {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {

		$this->type = 'kirki-slider-advanced';

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
	 * Sanitizes slider-advanced controls
	 *
	 * @static
	 * @since 2.2.0
	 * @param array $value The value.
	 * @return array
	 */
	public static function sanitize( $value ) {
		// TODO: Rethink sanitize....
		return $value;
	}
	
	public static function normalize_default( $value, $field )
	{
		$val_unit_arr = function( $value, $unit )
		{
			return [
				'value' => $value,
				'unit' => $unit
			];
		};
		
		$use_media_queries = $field['use_media_queries'];
		$has_units         = ( isset( $field['choices']['units'] ) );
		$is_value_array    = is_array( $value );
		$default_unit      = $has_units ? array_keys( $field['choices']['units'] )[0] : '';
		
		if ( $use_media_queries )
		{
			if ( $has_units && !$is_value_array )
			{
				$value = [
					'desktop' => $val_unit_arr( $value, $default_unit ),
					'tablet' => $val_unit_arr( $value, $default_unit ),
					'mobile' => $val_unit_arr( $value, $default_unit )
				];
			}
			else
			{
				if ( !$is_value_array )
				{
					$value = [
						'desktop' => $value,
						'tablet' => $value,
						'mobile' => $value
					];
				}
			}
		}
		else
		{
			if ( $has_units && !$is_value_array )
			{
				$value = $val_unit_arr( $value, $default_unit );
			}
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

		if ( ! is_array( $this->choices ) ) {
			$this->choices = array();
		}
	}
}
