<?php
/**
 * Override field methods
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license     https://opensource.org/licenses/MIT
 * @since       2.2.7
 */

/**
 * Field overrides.
 */
class Kirki_Field_Typography extends Kirki_Field {

	/**
	 * Sets the control type.
	 *
	 * @access protected
	 */
	protected function set_type() {
		$this->type = 'kirki-typography';
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

		// Accomodate the use of font-weight and convert to variant.
		if ( isset( $this->default['font-weight'] ) ) {
			$this->default['variant'] = ( 'regular' === $this->default['font-weight'] ) ? 400 : (string) intval( $this->default['font-weight'] );
		}

		// Make sure letter-spacing has units.
		if ( isset( $this->default['letter-spacing'] ) && is_numeric( $this->default['letter-spacing'] ) && $this->default['letter-spacing'] ) {
			$this->default['letter-spacing'] .= 'px';
		}
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
		if ( ! is_array( $value ) ) {
			return array();
		}

		foreach ( $value as $key => $val ) {
			switch ( $key ) {
				case 'font-family':
					$value['font-family'] = sanitize_text_field( $val );
					break;
				case 'font-weight':
					if ( isset( $value['variant'] ) ) {
						break;
					}
					$value['variant'] = $val;
					if ( isset( $value['font-style'] ) && 'italic' === $value['font-style'] ) {
						$value['variant'] = ( '400' !== $val || 400 !== $val ) ? $value['variant'] . 'italic' : 'italic';
					}
					break;
				case 'variant':
					// Use 'regular' instead of 400 for font-variant.
					$value['variant'] = ( 400 === $val || '400' === $val ) ? 'regular' : $val;

					// Get font-weight from variant.
					$value['font-weight'] = filter_var( $value['variant'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
					$value['font-weight'] = ( 'regular' === $value['variant'] || 'italic' === $value['variant'] ) ? 400 : absint( $value['font-weight'] );

					// Get font-style from variant.
					if ( ! isset( $value['font-style'] ) ) {
						$value['font-style'] = ( false === strpos( $value['variant'], 'italic' ) ) ? 'normal' : 'italic';
					}
					break;
				case 'font-size':
				case 'letter-spacing':
				case 'word-spacing':
				case 'line-height':
					$value[ $key ] = '' === trim( $value[ $key ] ) ? '' : sanitize_text_field( $val );
					break;
				case 'text-align':
					if ( ! in_array( $val, array( '', 'inherit', 'left', 'center', 'right', 'justify' ), true ) ) {
						$value['text-align'] = '';
					}
					break;
				case 'text-transform':
					if ( ! in_array( $val, array( '', 'none', 'capitalize', 'uppercase', 'lowercase', 'initial', 'inherit' ), true ) ) {
						$value['text-transform'] = '';
					}
					break;
				case 'text-decoration':
					if ( ! in_array( $val, array( '', 'none', 'underline', 'overline', 'line-through', 'initial', 'inherit' ), true ) ) {
						$value['text-transform'] = '';
					}
					break;
				case 'color':
					$value['color'] = '' === $value['color'] ? '' : ariColor::newColor( $val )->toCSS( 'hex' );
					break;
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
		$this->choices = wp_parse_args(
			$this->choices,
			array(
				'variant' => array(),
				'fonts'   => array(
					'standard' => array(),
					'google'   => array(),
				),
			)
		);
	}
}
