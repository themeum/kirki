<?php


class Kirki_Settings extends Kirki {

	/**
	 * Build a single setting
	 */
	function add_setting( $wp_customize, $control ) {

		if ( 'background' == $control['type'] ) {

			$wp_customize->add_setting( $control['setting'] . '_color', array(
				'default'           => $control['default']['color'],
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'transport'         => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
				'sanitize_callback' => isset( $control['sanitize_callback'] ) ? $control['sanitize_callback'] : 'sanitize_hex_color'
			) );

			$wp_customize->add_setting( $control['setting'] . '_image', array(
				'default'           => $control['default']['image'],
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'transport'         => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
				'sanitize_callback' => isset( $control['sanitize_callback'] ) ? $control['sanitize_callback'] : 'esc_url_raw'
			) );

			$wp_customize->add_setting( $control['setting'] . '_repeat', array(
				'default'           => $control['default']['repeat'],
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'transport'         => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
				'sanitize_callback' => isset( $control['sanitize_callback'] ) ? $control['sanitize_callback'] : array( $this, 'sanitize_bg_repeat' ),
			) );

			$wp_customize->add_setting( $control['setting'] . '_size', array(
				'default'           => $control['default']['size'],
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'transport'         => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
				'sanitize_callback' => isset( $control['sanitize_callback'] ) ? $control['sanitize_callback'] : array( $this, 'sanitize_bg_size' ),
			) );

			$wp_customize->add_setting( $control['setting'] . '_attach', array(
				'default'           => $control['default']['attach'],
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'transport'         => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
				'sanitize_callback' => isset( $control['sanitize_callback'] ) ? $control['sanitize_callback'] : array( $this, 'sanitize_bg_attach' ),
			) );

			$wp_customize->add_setting( $control['setting'] . '_position', array(
				'default'           => $control['default']['position'],
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'transport'         => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
				'sanitize_callback' => isset( $control['sanitize_callback'] ) ? $control['sanitize_callback'] : array( $this, 'sanitize_bg_position' ),
			) );

			if ( false != $control['default']['opacity'] ) {

				$wp_customize->add_setting( $control['setting'] . '_opacity', array(
					'default'           => $control['default']['opacity'],
					'type'              => 'theme_mod',
					'capability'        => 'edit_theme_options',
					'transport'         => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
					'sanitize_callback' => isset( $control['sanitize_callback'] ) ? $control['sanitize_callback'] : 'absint'
				) );

			}
		} else {

			if ( 'checkbox' == $control['type'] ) {
				$sanitize_callback = array( $this, 'sanitize_checkbox' );
			} elseif ( 'color' == $control['type'] ) {
				$sanitize_callback = 'sanitize_hex_color';
			} elseif ( 'image' == $control['type'] ) {
				$sanitize_callback = 'esc_url_raw';
			} elseif ( 'radio' == $control['type'] ) {
				// TODO: Find a way to handle these
				$sanitize_callback = array( $this, 'unfiltered' );
			} elseif ( 'select' == $control['type'] ) {
				// TODO: Find a way to handle these
				$sanitize_callback = array( $this, 'unfiltered' );
			} elseif ( 'slider' == $control['type'] ) {
				$sanitize_callback = array( $this, 'sanitize_number' );
			} elseif ( 'text' == $control['type'] ) {
				$sanitize_callback = 'esc_textarea';
			} elseif ( 'textarea' == $control['type'] ) {
				$sanitize_callback = 'esc_textarea';
			} elseif ( 'upload' == $control['type'] ) {
				$sanitize_callback = 'esc_url_raw';
			} elseif ( 'number' == $control['type'] ) {
				$sanitize_callback = 'intval';
			} elseif ( 'multicheck' == $control['type'] ) {
				$sanitize_callback = 'esc_attr';
			} elseif ( 'group_title' == $control['type'] ) {
				$sanitize_callback = 'esc_attr';
			} else {
				$sanitize_callback = array( $this, 'unfiltered' );
			}

			// Add settings
			$wp_customize->add_setting( $control['setting'], array(
				'default'           => isset( $control['default'] ) ? $control['default'] : '',
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'transport'         => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
				'sanitize_callback' => isset( $control['sanitize_callback'] ) ? $control['sanitize_callback'] : $sanitize_callback,
			) );

		}

	}

	/**
	 * Sanitize checkbox options
	 *
	 * @since 0.5
	 */
	public function sanitize_checkbox( $value ) {
		return ( 'on' != $value ) ? false : $value;
	}

	/**
	 * Sanitize number options
	 *
	 * @since 0.5
	 */
	public function sanitize_number( $value ) {
		return ( is_int( $value ) || is_float( $value ) ) ? $value : intval( $value );
	}

	/**
	 * Sanitize a value from a list of allowed values.
	 *
	 * @since 0.5
	 *
	 * @param  mixed    $value      The value to sanitize.
	 * @param  mixed    $setting    The setting for which the sanitizing is occurring.
	 * @return mixed                The sanitized value.
	 */
	function sanitize_choice( $value, $choices, $default ) {

		$allowed_choices = array_keys( $choices );
		return ( ! in_array( $value, $allowed_choices ) ) ? $default : $value;

	}

	/**
	 * Sanitize background repeat values
	 *
	 * @since 0.5
	 */
	function sanitize_bg_repeat( $value ) {
		$valid = array(
			'no-repeat' => __( 'No Repeat', 'kirki' ),
			'repeat'    => __( 'Repeat All', 'kirki' ),
			'repeat-x'  => __( 'Repeat Horizontally', 'kirki' ),
			'repeat-y'  => __( 'Repeat Vertically', 'kirki' ),
			'inherit'   => __( 'Inherit', 'kirki' )
		);

		return ( array_key_exists( $value, $valid ) ) ? $value : 'inherit';

	}

	/**
	 * Sanitize background size values
	 *
	 * @since 0.5
	 */
	function sanitize_bg_size( $value ) {
		$valid = array(
			'inherit' => __( 'Inherit', 'kirki' ),
			'cover'   => __( 'Cover', 'kirki' ),
			'contain' => __( 'Contain', 'kirki' ),
		);

		return ( array_key_exists( $value, $valid ) ) ? $value : 'inherit';

	}

	/**
	 * Sanitize background attachment values
	 *
	 * @since 0.5
	 */
	function sanitize_bg_attach( $value ) {
		$valid = array(
			'inherit' => __( 'Inherit', 'kirki' ),
			'fixed'   => __( 'Fixed', 'kirki' ),
			'scroll'  => __( 'Scroll', 'kirki' ),
		);

		return ( array_key_exists( $value, $valid ) ) ? $value : 'inherit';

	}

	/**
	 * Sanitize background position values
	 *
	 * @since 0.5
	 */
	function sanitize_bg_position( $value ) {
		$valid = array(
			'left-top'      => __( 'Left Top', 'kirki' ),
			'left-center'   => __( 'Left Center', 'kirki' ),
			'left-bottom'   => __( 'Left Bottom', 'kirki' ),
			'right-top'     => __( 'Right Top', 'kirki' ),
			'right-center'  => __( 'Right Center', 'kirki' ),
			'right-bottom'  => __( 'Right Bottom', 'kirki' ),
			'center-top'    => __( 'Center Top', 'kirki' ),
			'center-center' => __( 'Center Center', 'kirki' ),
			'center-bottom' => __( 'Center Bottom', 'kirki' ),
		);

		return ( array_key_exists( $value, $valid ) ) ? $value : 'center-center';

	}

	/**
	 * DOES NOT SANITIZE ANYTHING.
	 *
	 * @since 0.5
	 */
	function unfiltered( $value ) {
		return $value;
	}

}
