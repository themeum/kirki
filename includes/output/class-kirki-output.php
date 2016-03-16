<?php

class Kirki_Output {

	/**
	 * @access protected
	 * @var string
	 */
	protected $config_id = 'global';

	/**
	 * @access protected
	 * @var array
	 */
	protected $output = array();

	/**
	 * @access protected
	 * @var array
	 */
	protected $styles = array();

	/**
	 * @access protected
	 * @var string|array
	 */
	protected $value;

	/**
	 * The class constructor
	 *
	 * @access public
	 * @param $config_id    string
	 * @param $output       array
	 * @param $value        string|array
	 */
	public function __construct( $config_id, $output, $value ) {
		$this->config_id = $config_id;
		$this->value     = $value;
		$this->output    = $output;

		$this->parse_output();
	}

	/**
	 * If we have a sanitize_callback defined,
	 * apply it to the value
	 *
	 * @param $output  array         the output args
	 * @param $value   string|array  the value
	 *
	 * @return string|array
	 */
	protected function apply_sanitize_callback( $output, $value ) {
		if ( isset( $output['sanitize_callback'] ) && null !== $output['sanitize_callback'] ) {
			// If the sanitize_callback is invalid, return the value
			if ( ! is_callable( $output['sanitize_callback'] ) ) {
				return $value;
			}
			return call_user_func( $output['sanitize_callback'], $this->value );
		}
		return $value;
	}

	/**
	 * Parses the output arguments
	 * Calls the process_output method for each of them.
	 *
	 * @access protected
	 */
	protected function parse_output() {
		foreach ( $this->output as $output ) {
			$skip = false;
			// Apply any sanitization callbacks defined
			$value = $this->apply_sanitize_callback( $output, $this->value );
			// No need to proceed this if the current value is the same as in the "exclude" value.
			if ( isset( $output['exclude'] ) && false !== $output['exclude'] && is_array( $output['exclude'] ) ) {
				foreach ( $output['exclude'] as $exclude ) {
					if ( $skip ) {
						continue;
					}
					if ( $exclude == $value ) {
						$skip = true;
					}
				}
			}
			if ( $skip ) {
				continue;
			}

			$value = $this->process_value( $value, $output );
			$this->process_output( $output, $value );
		}
	}

	/**
	 * Parses an output and creates the styles array for it
	 *
	 * @access protected
	 * @param $output array
	 * @param $value  string
	 *
	 * @return void
	 */
	protected function process_output( $output, $value ) {
		if ( ! isset( $output['element'] ) || ! isset( $output['property'] ) ) {
			return;
		}
		$output['media_query'] = ( isset( $output['media_query'] ) ) ? $output['media_query'] : 'global';
		$output['prefix']      = ( isset( $output['prefix'] ) )      ? $output['prefix']      : '';
		$output['units']       = ( isset( $output['units'] ) )       ? $output['units']       : '';
		$output['suffix']      = ( isset( $output['suffix'] ) )      ? $output['suffix']      : '';

		if ( is_array( $output['element'] ) ) {
			$output['element'] = array_unique( $output['element'] );
			sort( $output['element'] );
			$output['element'] = implode( ',', $output['element'] );
		}

		$this->styles[ $output['media_query'] ][ $output['element'] ][ $output['property'] ] = $output['prefix'] . $value . $output['units'] . $output['suffix'];
	}

	/**
	 * Some CSS properties are unique.
	 * We need to tweak the value to make everything works as expected.
	 *
	 * @access protected
	 * @param $property  string  the CSS property
	 * @param $value     string  the value
	 *
	 * @return array
	 */
	protected function process_property_value( $property, $value ) {
		$properties = apply_filters( 'kirki/' . $this->config_id . '/output/property-classnames', array(
			'font-family'         => 'Kirki_Output_Property_Font_Family',
			'background-image'    => 'Kirki_Output_Property_Background_Image',
			'background-position' => 'Kirki_Output_Property_Background_Position',
		) );
		if ( array_key_exists( $property, $properties ) ) {
			$classname = $properties[ $property ];
			$obj = new $classname( $property, $value );
			return $obj->get_value();
		}
		return $value;
	}

	/**
	 * Returns the value
	 *
	 * @access protected
	 * @param string|array
	 *
	 * @return string|array
	 */
	protected function process_value( $value, $output ) {
		if ( isset( $output['property'] ) ) {
			return $this->process_property_value( $output['property'], $value );
		}
		return $value;
	}

	/**
	 * Exploses the private $styles property to the world
	 *
	 * @access protected
	 * @return array
	 */
	public function get_styles() {
		return $this->styles;
	}
}
