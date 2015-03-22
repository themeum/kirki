<?php

/**
 * Build a single setting
 */
function kirki_add_setting( $wp_customize, $control ) {

	if ( 'background' == $control['type'] ) {

		if ( isset( $control['default']['color'] ) ) {
			$wp_customize->add_setting( $control['settings'] . '_color', array(
				'default'           => $control['default']['color'],
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'transport'         => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
				'sanitize_callback' => isset( $control['sanitize_callback'] ) ? $control['sanitize_callback'] : 'sanitize_hex_color'
			) );
		}

		if ( isset( $control['default']['image'] ) ) {
			$wp_customize->add_setting( $control['settings'] . '_image', array(
				'default'           => $control['default']['image'],
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'transport'         => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
				'sanitize_callback' => isset( $control['sanitize_callback'] ) ? $control['sanitize_callback'] : 'esc_url_raw'
			) );
		}

		if ( isset( $control['default']['repeat'] ) ) {
			$wp_customize->add_setting( $control['settings'] . '_repeat', array(
				'default'           => $control['default']['repeat'],
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'transport'         => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
				'sanitize_callback' => isset( $control['sanitize_callback'] ) ? $control['sanitize_callback'] : 'kirki_sanitize_bg_repeat',
			) );
		}

		if ( isset( $control['default']['size'] ) ) {
			$wp_customize->add_setting( $control['settings'] . '_size', array(
				'default'           => $control['default']['size'],
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'transport'         => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
				'sanitize_callback' => isset( $control['sanitize_callback'] ) ? $control['sanitize_callback'] : 'kirki_sanitize_bg_size',
			) );
		}

		if ( isset( $control['default']['attach'] ) ) {
			$wp_customize->add_setting( $control['settings'] . '_attach', array(
				'default'           => $control['default']['attach'],
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'transport'         => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
				'sanitize_callback' => isset( $control['sanitize_callback'] ) ? $control['sanitize_callback'] : 'kirki_sanitize_bg_attach',
			) );
		}

		if ( isset( $control['default']['position'] ) ) {
			$wp_customize->add_setting( $control['settings'] . '_position', array(
				'default'           => $control['default']['position'],
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'transport'         => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
				'sanitize_callback' => isset( $control['sanitize_callback'] ) ? $control['sanitize_callback'] : 'kirki_sanitize_bg_position',
			) );
		}

		if ( isset( $control['default']['opacity'] ) && $control['default']['opacity'] ) {
			$wp_customize->add_setting( $control['settings'] . '_opacity', array(
				'default'           => $control['default']['opacity'],
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'transport'         => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
				'sanitize_callback' => isset( $control['sanitize_callback'] ) ? $control['sanitize_callback'] : 'absint'
			) );

		}
	} else {

		if ( 'checkbox' == $control['type'] ) {
			$sanitize_callback = 'kirki_sanitize_checkbox';
		} elseif ( 'color' == $control['type'] ) {
			$sanitize_callback = 'sanitize_hex_color';
		} elseif ( 'image' == $control['type'] ) {
			$sanitize_callback = 'esc_url_raw';
		} elseif ( 'radio' == $control['type'] ) {
			// TODO: Find a way to handle these
			$sanitize_callback = 'kirki_sanitize_unfiltered';
		} elseif ( 'select' == $control['type'] ) {
			// TODO: Find a way to handle these
			$sanitize_callback = 'kirki_sanitize_unfiltered';
		} elseif ( 'slider' == $control['type'] ) {
			$sanitize_callback = 'kirki_sanitize_number';
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
			$sanitize_callback = 'kirki_sanitize_unfiltered';
		}

		// Add settings
		$wp_customize->add_setting( $control['settings'], array(
			'default'           => isset( $control['default'] ) ? $control['default'] : '',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'transport'         => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
			'sanitize_callback' => isset( $control['sanitize_callback'] ) ? $control['sanitize_callback'] : $sanitize_callback,
		) );

	}

}
