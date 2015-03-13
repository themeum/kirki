<?php


class Kirki_Controls {

	public static function control_clean( $control ) {

		/**
		 * Compatibility tweak
		 *
		 * Previous verions of the Kirki Customizer had the 'description' field mapped to the new 'help'
		 * and instead of 'description' we were using 'subtitle'.
		 * This has been deprecated in favor of WordPress core's 'description' field that was recently introduced.
		 *
		 */
		if ( isset( $control['subtitle'] ) ) {
			// Use old arguments form.
			$control['help'] = ( isset( $control['description'] ) ) ? $control['description'] : '';
			$control['description'] = $control['subtitle'];
		}
		$control['description'] = isset( $control['description'] ) ? $control['description'] : '';
		$control['help'] = isset( $control['help'] ) ? $control['help'] : '';

		$control['label'] = isset( $control['label'] ) ? $control['label'] : '';

		/**
		 * Compatibility tweak
		 *
		 * Previous versions of the Kirki customizer used 'setting' istead of 'settings'.
		 */
		if ( ! isset( $control['settings'] ) && isset( $control['setting'] ) ) {
			$control['settings'] = $control['setting'];
		}

		$control['required']    = isset( $control['required'] ) ? $control['required'] : array();
		$control['transport']   = isset( $control['transport'] ) ? $control['transport'] : 'refresh';

		/**
		 * Sortable controls need a serialized array as the default value.
		 * Since we're using normal arrays to set our defaults when defining the fields, we need to serialize that value here.
		 */
		if ( 'sortable' == $control['type'] && isset( $control['default'] ) && ! empty( $control['default'] ) ) {
			$control['default'] = maybe_serialize( $control['default'] );
		}

		return $control;

	}

	function add_control( $wp_customize, $control ) {

		$control = self::control_clean( $control );

		/**
		 * Add our fields.
		 * We use the default WordPress Core Customizer fields when possible
		 * and only add our own custom controls when needed.
		 */

		// Color controls
		if ( 'color' == $control['type'] ) {
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $control['settings'] . '_color', $control ) );
		}

		// Image Controls
		elseif ( 'image' == $control['type'] ) {
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $control['settings'] . '_color', $control ) );
		}

		// Text, Dropdown Pages, Textarea and Select controls
		elseif ( in_array( $control['type'], array( 'text', 'dropdown-pages', 'textarea', 'select' ) ) ) {
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, $control['settings'], $control ) );
		}

		// Upload Controls
		elseif ( 'upload' == $control['type'] ) {
			$wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, $control['settings'], $control ) );
		}

		// Switch Controls
		elseif ( 'switch' == $control['type'] || ( 'checkbox' == $control['type'] && isset( $control['mode'] ) && 'switch' == $control['mode'] ) ) {
			$wp_customize->add_control( new Kirki_Customize_Switch_Control( $wp_customize, $control['settings'], $control ) );
		}

		// Toggle Controls
		elseif ( 'toggle' == $control['type'] || ( 'checkbox' == $control['type'] && isset( $control['mode'] ) && 'toggle' == $control['mode'] ) ) {
			$wp_customize->add_control( new Kirki_Customize_Toggle_Control( $wp_customize, $control['settings'], $control ) );
		}

		// Checkbox Controls
		elseif ( 'checkbox' == $control['type'] ) {
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, $control['settings'], $control ) );
		}

		// Radio-Buttonset Controls
		elseif ( 'radio-buttonset' == $control['type'] || ( 'radio' == $control['type'] && isset( $control['mode'] ) && 'buttonset' == $control['mode'] ) ) {
			$wp_customize->add_control( new Kirki_Customize_Radio_Buttonset_Control( $wp_customize, $control['settings'], $control ) );
		}

		// Radio-Image Controls
		elseif ( 'radio-image' == $control['type'] || ( 'radio' == $control['type'] && isset( $control['mode'] ) && 'image' == $control['mode'] ) ) {
			$wp_customize->add_control( new Kirki_Customize_Radio_Image_Control( $wp_customize, $control['settings'], $control ) );
		}

		// Radio Controls
		elseif ( 'radio' == $control['type'] ) {
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, $control['settings'], $control ) );
		}

		// Sortable Controls
		elseif ( 'sortable' == $control['type'] ) {
			$wp_customize->add_control( new Kirki_Customize_Sortable_Control( $wp_customize, $control['settings'], $control ) );
		}

		// Slider Controls
		elseif ( 'slider' == $control['type'] ) {
			$wp_customize->add_control( new Kirki_Customize_Slider_Control( $wp_customize, $control['settings'], $control ) );
		}

		// Number Controls
		elseif ( 'number' == $control['type'] ) {
			$wp_customize->add_control( new Kirki_Customize_Number_Control( $wp_customize, $control['settings'], $control ) );
		}

		// Multicheck Controls
		elseif ( 'multicheck' == $control['type'] ) {
			$wp_customize->add_control( new Kirki_Customize_Multicheck_Control( $wp_customize, $control['settings'], $control ) );
		}

		// Group-Title Controls
		elseif ( 'group-title' == $control['type'] ) {
			$wp_customize->add_control( new Kirki_Customize_Group_Title_Control( $wp_customize, $control['settings'], $control ) );
		}

		// Background Controls
		elseif ( 'background' == $control['type'] ) {
			/**
			 * The background control is a multi-control element
			 * so it requires extra steps to be created
			 */
			if ( isset( $control['default']['color'] ) ) {
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $control['settings'] . '_color', array(
					'label'       => isset( $control['label'] ) ? $control['label'] : '',
					'section'     => $control['section'],
					'settings'    => $control['settings'] . '_color',
					'priority'    => $control['priority'],
					'help'        => $control['help'],
					'description' => __( 'Background Color', 'kirki' ),
					'required'    => $control['required'],
					'transport'   => $control['transport']
				) ) );
			}

			if ( isset( $control['default']['image'] ) ) {
				$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $control['settings'] . '_image', array(
					'label'       => '',
					'section'     => $control['section'],
					'settings'    => $control['settings'] . '_image',
					'priority'    => $control['priority'] + 1,
					'help'        => '',
					'description' => __( 'Background Image', 'kirki' ),
					'required'    => $control['required'],
					'transport'   => $control['transport']
				) ) );
			}

			if ( isset( $control['default']['repeat'] ) ) {
				$wp_customize->add_control( $control['settings'] . '_repeat', array(
					'type'        => 'select',
					'label'       => '',
					'section'     => $control['section'],
					'settings'    => $control['settings'] . '_repeat',
					'priority'    => $control['priority'] + 2,
					'choices'     => array(
						'no-repeat' => __( 'No Repeat', 'kirki' ),
						'repeat'    => __( 'Repeat All', 'kirki' ),
						'repeat-x'  => __( 'Repeat Horizontally', 'kirki' ),
						'repeat-y'  => __( 'Repeat Vertically', 'kirki' ),
						'inherit'   => __( 'Inherit', 'kirki' )
					),
					'help'        => '',
					'description' => __( 'Background Repeat', 'kirki' ),
					'required'    => $control['required'],
					'transport'   => $control['transport']
				) );
			}

			if ( isset( $control['default']['size'] ) ) {
				$wp_customize->add_control( $control['settings'] . '_size', array(
					'type'        => 'radio',
					'label'       => '',
					'section'     => $control['section'],
					'settings'    => $control['settings'] . '_size',
					'priority'    => $control['priority'] + 3,
					'choices'     => array(
						'inherit' => __( 'Inherit', 'kirki' ),
						'cover'   => __( 'Cover', 'kirki' ),
						'contain' => __( 'Contain', 'kirki' ),
					),
					'help'        => '',
					'mode'        => 'buttonset',
					'description' => __( 'Background Size', 'kirki' ),
					'required'    => $control['required'],
					'transport'   => $control['transport']
				) );
			}

			if ( isset( $control['default']['attach'] ) ) {
				$wp_customize->add_control( $control['settings'] . '_attach', array(
					'label'       => '',
					'type'        => 'radio',
					'section'     => $control['section'],
					'settings'    => $control['settings'] . '_attach',
					'priority'    => $control['priority'] + 4,
					'choices'     => array(
						'inherit' => __( 'Inherit', 'kirki' ),
						'fixed'   => __( 'Fixed', 'kirki' ),
						'scroll'  => __( 'Scroll', 'kirki' ),
					),
					'help'        => '',
					'mode'        => 'buttonset',
					'description' => __( 'Background Attachment', 'kirki' ),
					'required'    => $control['required'],
					'transport'   => $control['transport']
				) );
			}

			if ( isset( $control['default']['position'] ) ) {
				$wp_customize->add_control( $control['settings'] . '_position', array(
					'type'        => 'select',
					'label'       => '',
					'section'     => $control['section'],
					'settings'    => $control['settings'] . '_position',
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
					'help'        => '',
					'description' => __( 'Background Position', 'kirki' ),
					'required'    => $control['required'],
					'transport'   => $control['transport']
				) );
			}

			if ( isset( $control['default']['opacity'] ) && $control['default']['opacity'] ) {
				$wp_customize->add_control( new Kirki_Customize_Slider_Control( $wp_customize, $control['settings'] . '_opacity', array(
					'label'       => '',
					'section'     => $control['section'],
					'settings'    => $control['settings'] . '_opacity',
					'priority'    => $control['priority'] + 6,
					'choices'     => array(
						'min'     => 0,
						'max'     => 100,
						'step'    => 1,
					),
					'help'        => '',
					'description' => __( 'Background Opacity', 'kirki' ),
					'required'    => $control['required'],
					'transport'   => $control['transport']
				) ) );

			}

		}

	}

}
