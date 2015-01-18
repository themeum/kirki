<?php


class Kirki_Settings {

	/**
	 * Build a single setting
	 */
	public static function add_setting( $wp_customize, $control ) {

		if ( 'background' == $control['type'] ) {

			$wp_customize->add_setting( $control['setting'] . '_color', array(
				'default'    => $control['default']['color'],
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options',
				'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'postMessage',
			) );

			$wp_customize->add_setting( $control['setting'] . '_image', array(
				'default'    => $control['default']['image'],
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options',
				'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'postMessage',
			) );

			$wp_customize->add_setting( $control['setting'] . '_repeat', array(
				'default'    => $control['default']['repeat'],
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options',
				'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'postMessage',
			) );

			$wp_customize->add_setting( $control['setting'] . '_size', array(
				'default'    => $control['default']['size'],
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options',
				'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'postMessage',
			) );

			$wp_customize->add_setting( $control['setting'] . '_attach', array(
				'default'    => $control['default']['attach'],
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options',
				'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'postMessage',
			) );

			$wp_customize->add_setting( $control['setting'] . '_position', array(
				'default'    => $control['default']['position'],
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options',
				'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'postMessage',
			) );

			if ( false != $control['default']['opacity'] ) {

				$wp_customize->add_setting( $control['setting'] . '_opacity', array(
					'default'    => $control['default']['opacity'],
					'type'       => 'theme_mod',
					'capability' => 'edit_theme_options',
					'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'postMessage',
				) );

			}
		} else {

			// Add settings
			$wp_customize->add_setting( $control['setting'], array(
				'default'    => isset( $control['default'] ) ? $control['default'] : '',
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options',
				'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'postMessage',
			) );

		}

	}

}
