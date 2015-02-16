<?php


class Kirki_Controls extends Kirki {

	function add_control( $wp_customize, $control ) {

		// Checkbox control
		if ( 'checkbox' == $control['type'] ) {

			$wp_customize->add_control( new Kirki_Customize_Checkbox_Control( $wp_customize, $control['setting'], array(
				'label'       => isset( $control['label'] ) ? $control['label'] : '',
				'section'     => $control['section'],
				'settings'    => $control['setting'],
				'priority'    => $control['priority'],
				'description' => isset( $control['description'] ) ? $control['description'] : null,
				'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
				'required'    => isset( $control['required'] ) ? $control['required'] : array(),
				'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
			) ) );

		// Background Control
		} elseif ( 'background' == $control['type'] ) {

			$wp_customize->add_control( new Kirki_Customize_Color_Control( $wp_customize, $control['setting'] . '_color', array(
				'label'       => isset( $control['label'] ) ? $control['label'] : '',
				'section'     => $control['section'],
				'settings'    => $control['setting'] . '_color',
				'priority'    => $control['priority'],
				'description' => isset( $control['description'] ) ? $control['description'] : null,
				'subtitle'    => __( 'Background Color', 'kirki' ),
				'required'    => isset( $control['required'] ) ? $control['required'] : array(),
				'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
			) ) );

			$wp_customize->add_control( new Kirki_Customize_Image_Control( $wp_customize, $control['setting'] . '_image', array(
				'label'       => null,
				'section'     => $control['section'],
				'settings'    => $control['setting'] . '_image',
				'priority'    => $control['priority'] + 1,
				'description' => null,
				'subtitle'    => __( 'Background Image', 'kirki' ),
				'required'    => isset( $control['required'] ) ? $control['required'] : array(),
				'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
			) ) );

			$wp_customize->add_control( new Kirki_Select_Control( $wp_customize, $control['setting'] . '_repeat', array(
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
				'required'    => isset( $control['required'] ) ? $control['required'] : array(),
				'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
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
				'required'    => isset( $control['required'] ) ? $control['required'] : array(),
				'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
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
				'required'    => isset( $control['required'] ) ? $control['required'] : array(),
				'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
			) ) );

			$wp_customize->add_control( new Kirki_Select_Control( $wp_customize, $control['setting'] . '_position', array(
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
				'required'    => isset( $control['required'] ) ? $control['required'] : array(),
				'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
			) ) );

			if ( false != $control['default']['opacity'] ) {
				$wp_customize->add_control( new Kirki_Customize_Sliderui_Control( $wp_customize, $control['setting'] . '_opacity', array(
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
					'required'    => isset( $control['required'] ) ? $control['required'] : array(),
					'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
				) ) );
			}

		// Color Control
		} elseif ( 'color' == $control['type'] ) {

			$wp_customize->add_control( new Kirki_Customize_Color_Control( $wp_customize, $control['setting'], array(
				'label'       => isset( $control['label'] ) ? $control['label'] : '',
				'section'     => $control['section'],
				'settings'    => $control['setting'],
				'priority'    => isset( $control['priority'] ) ? $control['priority'] : '',
				'description' => isset( $control['description'] ) ? $control['description'] : null,
				'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
				'required'    => isset( $control['required'] ) ? $control['required'] : array(),
				'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
			) ) );

		// Image Control
		} elseif ( 'image' == $control['type'] ) {

			$wp_customize->add_control( new Kirki_Customize_Image_Control( $wp_customize, $control['setting'], array(
				'label'       => isset( $control['label'] ) ? $control['label'] : '',
				'section'     => $control['section'],
				'settings'    => $control['setting'],
				'priority'    => $control['priority'],
				'description' => isset( $control['description'] ) ? $control['description'] : null,
				'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
				'required'    => isset( $control['required'] ) ? $control['required'] : array(),
				'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
			) ) );

		// Radio Control
		} elseif ( 'radio' == $control['type'] ) {

			$wp_customize->add_control( new Kirki_Customize_Radio_Control( $wp_customize, $control['setting'], array(
				'label'       => isset( $control['label'] ) ? $control['label'] : '',
				'section'     => $control['section'],
				'settings'    => $control['setting'],
				'priority'    => $control['priority'],
				'choices'     => $control['choices'],
				'description' => isset( $control['description'] ) ? $control['description'] : null,
				'mode'        => isset( $control['mode'] ) ? $control['mode'] : 'radio', // Can be 'radio', 'image' or 'buttonset'.
				'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
				'required'    => isset( $control['required'] ) ? $control['required'] : array(),
				'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
			) ) );

		// Select Control
		} elseif ( 'select' == $control['type'] ) {

			$wp_customize->add_control( new Kirki_Select_Control( $wp_customize, $control['setting'], array(
				'label'       => isset( $control['label'] ) ? $control['label'] : '',
				'section'     => $control['section'],
				'settings'    => $control['setting'],
				'priority'    => $control['priority'],
				'choices'     => $control['choices'],
				'description' => isset( $control['description'] ) ? $control['description'] : null,
				'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
				'required'    => isset( $control['required'] ) ? $control['required'] : array(),
				'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
			) ) );

		// Slider Control
		} elseif ( 'slider' == $control['type'] ) {

			$wp_customize->add_control( new Kirki_Customize_Sliderui_Control( $wp_customize, $control['setting'], array(
				'label'       => isset( $control['label'] ) ? $control['label'] : '',
				'section'     => $control['section'],
				'settings'    => $control['setting'],
				'priority'    => $control['priority'],
				'choices'     => $control['choices'],
				'description' => isset( $control['description'] ) ? $control['description'] : null,
				'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
				'required'    => isset( $control['required'] ) ? $control['required'] : array(),
				'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
			) ) );

		// Text Control
		} elseif ( 'text' == $control['type'] ) {

			$wp_customize->add_control( new Kirki_Customize_Text_Control( $wp_customize, $control['setting'], array(
				'label'       => isset( $control['label'] ) ? $control['label'] : '',
				'section'     => $control['section'],
				'settings'    => $control['setting'],
				'priority'    => $control['priority'],
				'description' => isset( $control['description'] ) ? $control['description'] : null,
				'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
				'required'    => isset( $control['required'] ) ? $control['required'] : array(),
				'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
			) ) );

		// Text Control
		} elseif ( 'textarea' == $control['type'] ) {

			$wp_customize->add_control( new Kirki_Customize_Textarea_Control( $wp_customize, $control['setting'], array(
				'label'       => $control['label'],
				'section'     => $control['section'],
				'settings'    => $control['setting'],
				'priority'    => $control['priority'],
				'description' => isset( $control['description'] ) ? $control['description'] : null,
				'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
				'required'    => isset( $control['required'] ) ? $control['required'] : array(),
				'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
			) ) );

		// Upload Control
		} elseif ( 'upload' == $control['type'] ) {

			$wp_customize->add_control( new Kirki_Customize_Upload_Control( $wp_customize, $control['setting'], array(
				'label'       => $control['label'],
				'section'     => $control['section'],
				'settings'    => $control['setting'],
				'priority'    => $control['priority'],
				'choices'     => $control['choices'],
				'description' => isset( $control['description'] ) ? $control['description'] : null,
				'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
				'required'    => isset( $control['required'] ) ? $control['required'] : array(),
				'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
			) ) );

		// Number Control
		} elseif ( 'number' == $control['type'] ) {

			$wp_customize->add_control( new Kirki_Customize_Number_Control( $wp_customize, $control['setting'], array(
				'label'       => $control['label'],
				'section'     => $control['section'],
				'settings'    => $control['setting'],
				'priority'    => $control['priority'],
				'description' => isset( $control['description'] ) ? $control['description'] : null,
				'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
				'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
			) ) );

		// Multicheck Control
		} elseif ( 'multicheck' == $control['type'] ) {

			$wp_customize->add_control( new Kirki_Customize_Multicheck_Control( $wp_customize, $control['setting'], array(
				'label'       => $control['label'],
				'section'     => $control['section'],
				'settings'    => $control['setting'],
				'priority'    => $control['priority'],
				'choices'     => $control['choices'],
				'description' => isset( $control['description'] ) ? $control['description'] : null,
				'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
				'required'    => isset( $control['required'] ) ? $control['required'] : array(),
				'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
			) ) );

		// Separator Controls
		} elseif ( 'group_title' == $control['type'] ) {

			$wp_customize->add_control( new Kirki_Customize_Group_Title_Control( $wp_customize, $control['setting'], array(
				'label'       => $control['label'],
				'section'     => $control['section'],
				'settings'    => $control['setting'],
				'priority'    => $control['priority'],
				'description' => isset( $control['description'] ) ? $control['description'] : null,
				'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
				'required'    => isset( $control['required'] ) ? $control['required'] : array(),
				'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
			) ) );

		}

	}

}
