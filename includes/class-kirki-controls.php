<?php


class Kirki_Controls extends Kirki {

	function add_control( $wp_customize, $control ) {

		$control['label']       = isset( $control['label'] ) ? $control['label'] : '';
		$control['settings']    = $control['setting'];
		$control['description'] = isset( $control['description'] ) ? $control['description'] : null;
		$control['subtitle']    = isset( $control['subtitle'] ) ? $control['subtitle'] : '';
		$control['required']    = isset( $control['required'] ) ? $control['required'] : array();
		$control['transport']   = isset( $control['transport'] ) ? $control['transport'] : 'refresh';
		$control['default']     = 'sortable' == $control['type'] ? maybe_serialize( $control['default'] ) : $control['default'];

		if ( 'background' != $control['type'] ) {

			$control_class = 'Kirki_Customize_' . ucfirst( $control['type'] ) . '_Control';
			$control_class = ( 'group_title' == $control['type'] ) ? 'Kirki_Customize_Group_Title_Control' : $control_class;
			$wp_customize->add_control( new $control_class( $wp_customize, $control['setting'], $control ) );

		} else {

			/**
			 * The background control is a multi-control element
			 * so it requires extra steps to be created
			 */
			$wp_customize->add_control( new Kirki_Customize_Color_Control( $wp_customize, $control['setting'] . '_color', array(
				'label'       => isset( $control['label'] ) ? $control['label'] : '',
				'section'     => $control['section'],
				'settings'    => $control['setting'] . '_color',
				'priority'    => $control['priority'],
				'description' => $control['description'],
				'subtitle'    => __( 'Background Color', 'kirki' ),
				'required'    => $control['required'],
				'transport'   => $control['transport']
			) ) );

			$wp_customize->add_control( new Kirki_Customize_Image_Control( $wp_customize, $control['setting'] . '_image', array(
				'label'       => null,
				'section'     => $control['section'],
				'settings'    => $control['setting'] . '_image',
				'priority'    => $control['priority'] + 1,
				'description' => null,
				'subtitle'    => __( 'Background Image', 'kirki' ),
				'required'    => $control['required'],
				'transport'   => $control['transport']
			) ) );

			$wp_customize->add_control( new Kirki_Customize_Select_Control( $wp_customize, $control['setting'] . '_repeat', array(
				'label'       => null,
				'section'     => $control['section'],
				'settings'    => $control['setting'] . '_repeat',
				'priority'    => $control['priority'] + 2,
				'choices'     => array(
					'no-repeat' => __( 'No Repeat', 'kirki' ),
					'repeat'    => __( 'Repeat All', 'kirki' ),
					'repeat-x'  => __( 'Repeat Horizontally', 'kirki' ),
					'repeat-y'  => __( 'Repeat Vertically', 'kirki' ),
					'inherit'   => __( 'Inherit', 'kirki' )
				),
				'description' => null,
				'subtitle'    => __( 'Background Repeat', 'kirki' ),
				'required'    => $control['required'],
				'transport'   => $control['transport']
			) ) );

			$wp_customize->add_control( new Kirki_Customize_Radio_Control( $wp_customize, $control['setting'] . '_size', array(
				'label'       => null,
				'section'     => $control['section'],
				'settings'    => $control['setting'] . '_size',
				'priority'    => $control['priority'] + 3,
				'choices'     => array(
					'inherit' => __( 'Inherit', 'kirki' ),
					'cover'   => __( 'Cover', 'kirki' ),
					'contain' => __( 'Contain', 'kirki' ),
				),
				'description' => null,
				'mode'        => 'buttonset',
				'subtitle'    => __( 'Background Size', 'kirki' ),
				'required'    => $control['required'],
				'transport'   => $control['transport']
			) ) );

			$wp_customize->add_control( new Kirki_Customize_Radio_Control( $wp_customize, $control['setting'] . '_attach', array(
				'label'       => null,
				'section'     => $control['section'],
				'settings'    => $control['setting'] . '_attach',
				'priority'    => $control['priority'] + 4,
				'choices'     => array(
					'inherit' => __( 'Inherit', 'kirki' ),
					'fixed'   => __( 'Fixed', 'kirki' ),
					'scroll'  => __( 'Scroll', 'kirki' ),
				),
				'description' => null,
				'mode'        => 'buttonset',
				'subtitle'    => __( 'Background Attachment', 'kirki' ),
				'required'    => $control['required'],
				'transport'   => $control['transport']
			) ) );

			$wp_customize->add_control( new Kirki_Customize_Select_Control( $wp_customize, $control['setting'] . '_position', array(
				'label'       => null,
				'section'     => $control['section'],
				'settings'    => $control['setting'] . '_position',
				'priority'    => $control['priority'] + 5,
				'choices'     => array(
					'left-top'      => __( 'Left Top', 'kirki' ),
					'left-center'   => __( 'Left Center', 'kirki' ),
					'left-bottom'   => __( 'Left Bottom', 'kirki' ),
					'right-top'     => __( 'Right Top', 'kirki' ),
					'right-center'  => __( 'Right Center', 'kirki' ),
					'right-bottom'  => __( 'Right Bottom', 'kirki' ),
					'center-top'    => __( 'Center Top', 'kirki' ),
					'center-center' => __( 'Center Center', 'kirki' ),
					'center-bottom' => __( 'Center Bottom', 'kirki' ),
				),
				'description' => null,
				'subtitle'    => __( 'Background Position', 'kirki' ),
				'required'    => $control['required'],
				'transport'   => $control['transport']
			) ) );

			if ( false != $control['default']['opacity'] ) {
				$wp_customize->add_control( new Kirki_Customize_Slider_Control( $wp_customize, $control['setting'] . '_opacity', array(
					'label'       => null,
					'section'     => $control['section'],
					'settings'    => $control['setting'] . '_opacity',
					'priority'    => $control['priority'] + 6,
					'choices'     => array(
						'min'     => 0,
						'max'     => 100,
						'step'    => 1,
					),
					'description' => null,
					'subtitle'    => __( 'Background Opacity', 'kirki' ),
					'required'    => $control['required'],
					'transport'   => $control['transport']
				) ) );

			}

		}

	}

}
