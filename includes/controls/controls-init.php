<?php

/**
 * Build the controls
 */
function kirki_customizer_controls( $wp_customize ) {

	$controls = apply_filters( 'kirki/controls', array() );

	if ( isset( $controls ) ) {
		foreach ( $controls as $control ) {

			if ( 'background' == $control['type'] ) {

				$wp_customize->add_setting( $control['setting'] . '_color', array(
					'default'    => $control['default']['color'],
					'type'       => 'theme_mod',
					'transport'  => 'postMessage',
					'capability' => 'edit_theme_options'
				) );

				$wp_customize->add_setting( $control['setting'] . '_image', array(
					'default'    => $control['default']['image'],
					'type'       => 'theme_mod',
					'transport'  => 'postMessage',
					'capability' => 'edit_theme_options'
				) );

				$wp_customize->add_setting( $control['setting'] . '_repeat', array(
					'default'    => $control['default']['repeat'],
					'type'       => 'theme_mod',
					'transport'  => 'postMessage',
					'capability' => 'edit_theme_options'
				) );

				$wp_customize->add_setting( $control['setting'] . '_size', array(
					'default'    => $control['default']['size'],
					'type'       => 'theme_mod',
					'transport'  => 'postMessage',
					'capability' => 'edit_theme_options'
				) );

				$wp_customize->add_setting( $control['setting'] . '_attach', array(
					'default'    => $control['default']['attach'],
					'type'       => 'theme_mod',
					'transport'  => 'postMessage',
					'capability' => 'edit_theme_options'
				) );

				$wp_customize->add_setting( $control['setting'] . '_position', array(
					'default'    => $control['default']['position'],
					'type'       => 'theme_mod',
					'transport'   => 'postMessage',
					'capability' => 'edit_theme_options'
				) );

				if ( false != $control['default']['opacity'] ) {

					$wp_customize->add_setting( $control['setting'] . '_opacity', array(
						'default'    => $control['default']['opacity'],
						'type'       => 'theme_mod',
						'transport'  => 'postMessage',
						'capability' => 'edit_theme_options'
					) );

				}
			} else {

				// Add settings
				$wp_customize->add_setting( $control['setting'], array(
					'default'    => isset( $control['default'] ) ? $control['default'] : '',
					'type'       => 'theme_mod',
					'transport'  => 'postMessage',
					'capability' => 'edit_theme_options'
				) );

			}

			// Checkbox controls
			if ( 'checkbox' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Customize_Checkbox_Control( $wp_customize, $control['setting'], array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

			// Background Controls
			} elseif ( 'background' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Customize_Color_Control( $wp_customize, $control['setting'] . '_color', array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control['setting'] . '_color',
						'priority'    => $control['priority'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => __( 'Background Color', 'kirki' ),
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

				$wp_customize->add_control( new Kirki_Customize_Image_Control( $wp_customize, $control['setting'] . '_image', array(
						'label'       => null,
						'section'     => $control['section'],
						'settings'    => $control['setting'] . '_image',
						'priority'    => $control['priority'] + 1,
						'description' => null,
						'subtitle'    => __( 'Background Image', 'kirki' ),
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

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
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

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
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

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
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

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
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

				if ( false != $control['default']['opacity'] ) {
					$wp_customize->add_control( new Kirki_Customize_Sliderui_Control( $wp_customize, $control['setting'] . '_opacity', array(
							'label'       => null,
							'section'     => $control['section'],
							'settings'    => $control['setting'] . '_opacity',
							'priority'    => $control['priority'] + 6,
							'choices'  => array(
								'min'  => 0,
								'max'  => 100,
								'step' => 1,
							),
							'description' => null,
							'subtitle'    => __( 'Background Opacity', 'kirki' ),
							'required'    => isset( $control['required'] ) ? $control['required'] : array(),
							'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
						) )
					);
				}

			// Color Controls
			} elseif ( 'color' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Customize_Color_Control( $wp_customize, $control['setting'], array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => isset( $control['priority'] ) ? $control['priority'] : '',
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

			// Image Controls
			} elseif ( 'image' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Customize_Image_Control( $wp_customize, $control['setting'], array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

			// Radio Controls
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
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

			// Select Controls
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
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

			// Slider Controls
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
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

			// Text Controls
			} elseif ( 'text' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Customize_Text_Control( $wp_customize, $control['setting'], array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

			// Text Controls
			} elseif ( 'textarea' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Customize_Textarea_Control( $wp_customize, $control['setting'], array(
						'label'       => $control['label'],
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

			// Upload Controls
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
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

			// Number Controls
			} elseif ( 'number' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Customize_Number_Control( $wp_customize, $control['setting'], array(
						'label'       => $control['label'],
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

			// Multicheck Controls
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
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);

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
						'less_var'    => isset( $control['framework_var'] ) ? $control['framework_var'] : null,
					) )
				);
			}
		}
	}
}
add_action( 'customize_register', 'kirki_customizer_controls', 99 );
