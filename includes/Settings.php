<?php

namespace Kirki;

use Kirki;

class Settings {

	/**
	 * Add a setting
	 */
	public function add( $wp_customize, $field ) {

		if ( 'background' == $field['type'] ) {
			// Do nothing.
			// The 'background' field is just the sum of its sub-fields
			// which are created individually.
		} else {
			$this->add_setting( $wp_customize, $field );
		}

	}

	public function add_setting( $wp_customize, $field, $id_override = null, $default_override = null, $callback = null ) {

		$id       = ( ! is_null( $id_override ) )      ? $id_override      : $field['settings'];
		$default  = ( ! is_null( $default_override ) ) ? $default_override : $field['default'];
		$callback = ( ! is_null( $callback ) )         ? $callback         : $field['sanitize_callback'];

		$wp_customize->add_setting( $id, array(
			'default'           => $default,
			'type'              => $field['option_type'],
			'capability'        => 'edit_theme_options',
			'transport'         => $field['transport'],
			'sanitize_callback' => $callback,
		) );

	}

}
