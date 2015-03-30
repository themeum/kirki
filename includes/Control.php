<?php

namespace Kirki;

use Kirki;
use Kirki\Controls\CustomControl;
use Kirki\Controls\EditorControl;
use Kirki\Controls\MultiCheckControl;
use Kirki\Controls\NumberControl;
use Kirki\Controls\PaletteControl;
use Kirki\Controls\RadioButtonSetControl;
use Kirki\Controls\RadioImageControl;
use Kirki\Controls\SliderControl;
use Kirki\Controls\SortableControl;
use Kirki\Controls\SwitchControl;
use Kirki\Controls\ToggleControl;

class Control {

	/**
	 * Cleanup a single controls.
	 */
	public static function sanitize( $control ) {

		/**
		 * If ['default'] is not set, set an empty value
		 */
		if ( ! isset( $control['default'] ) ) {
			$control['default'] = '';
		}

		/**
		 * Sanitize label
		 */
		$control['label'] = ( isset( $control['label'] ) ) ? esc_html( $control['label'] ) : '';

		/**
		 * sanitize description
		 */
		$control['description'] = ( isset( $control['description'] ) ) ? esc_html( $control['description'] ) : '';

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
		$control['help'] = isset( $control['help'] ) ? esc_html( $control['help'] ) : '';

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

	/**
	 * Add our fields.
	 * We use the default WordPress Core Customizer fields when possible
	 * and only add our own custom controls when needed.
	 */
	public function add( $wp_customize, $control ) {

		$i18n = Kirki::i18n();

		$control = self::sanitize( $control );

		// Text, Dropdown Pages, Textarea, Select, checkbox & radio controls
		if ( in_array( $control['type'], array( 'text', 'dropdown-pages', 'textarea', 'select', 'checkbox', 'radio' ) ) ) {
			$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, $control['settings'], $control ) );
		}

		// Color controls
		elseif ( 'color' == $control['type'] ) {
			$wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, $control['settings'], $control ) );
		}

		// Image Controls
		elseif ( 'image' == $control['type'] ) {
			$wp_customize->add_control( new \WP_Customize_Image_Control( $wp_customize, $control['settings'], $control ) );
		}

		// Upload Controls
		elseif ( 'upload' == $control['type'] ) {
			$wp_customize->add_control( new \WP_Customize_Upload_Control( $wp_customize, $control['settings'], $control ) );
		}

		// Switch Controls
		elseif ( 'switch' == $control['type'] || ( 'checkbox' == $control['type'] && isset( $control['mode'] ) && 'switch' == $control['mode'] ) ) {
			$wp_customize->add_control( new SwitchControl( $wp_customize, $control['settings'], $control ) );
		}

		// Toggle Controls
		elseif ( 'toggle' == $control['type'] || ( 'checkbox' == $control['type'] && isset( $control['mode'] ) && 'toggle' == $control['mode'] ) ) {
			$wp_customize->add_control( new ToggleControl( $wp_customize, $control['settings'], $control ) );
		}

		// Radio-Buttonset Controls
		elseif ( 'radio-buttonset' == $control['type'] || ( 'radio' == $control['type'] && isset( $control['mode'] ) && 'buttonset' == $control['mode'] ) ) {
			$wp_customize->add_control( new RadioButtonSetControl( $wp_customize, $control['settings'], $control ) );
		}

		// Radio-Image Controls
		elseif ( 'radio-image' == $control['type'] || ( 'radio' == $control['type'] && isset( $control['mode'] ) && 'image' == $control['mode'] ) ) {
			$wp_customize->add_control( new RadioImageControl( $wp_customize, $control['settings'], $control ) );
		}

		// Sortable Controls
		elseif ( 'sortable' == $control['type'] ) {
			$wp_customize->add_control( new SortableControl( $wp_customize, $control['settings'], $control ) );
		}

		// Slider Controls
		elseif ( 'slider' == $control['type'] ) {
			$wp_customize->add_control( new SliderControl( $wp_customize, $control['settings'], $control ) );
		}

		// Number Controls
		elseif ( 'number' == $control['type'] ) {
			$wp_customize->add_control( new NumberControl( $wp_customize, $control['settings'], $control ) );
		}

		// Multicheck Controls
		elseif ( 'multicheck' == $control['type'] ) {
			$wp_customize->add_control( new MultiCheckControl( $wp_customize, $control['settings'], $control ) );
		}

		// Palette Control
		elseif ( 'palette' == $control['type'] ) {
			$wp_customize->add_control( new PaletteControl( $wp_customize, $control['settings'], $control ) );
		}

		// Custom Control
		elseif ( in_array( $control['type'], array( 'custom', 'group-title', 'group_title' ) ) ) {
			$wp_customize->add_control( new CustomControl( $wp_customize, $control['settings'], $control ) );
		}

		// Custom Control
		elseif ( 'editor' == $control['type'] ) {
			$wp_customize->add_control( new EditorControl( $wp_customize, $control['settings'], $control ) );
		}

		// Background Controls
		elseif ( 'background' == $control['type'] ) {
			/**
			 * The background control is a multi-control element
			 * so it requires extra steps to be created
			 */
			if ( isset( $control['default']['color'] ) ) {
				$wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, $control['settings'] . '_color', array(
					'label'       => isset( $control['label'] ) ? $control['label'] : '',
					'section'     => $control['section'],
					'settings'    => $control['settings'] . '_color',
					'priority'    => $control['priority'],
					'help'        => $control['help'],
					'description' => $i18n['background-color'],
					'required'    => $control['required'],
					'transport'   => $control['transport']
				) ) );
			}

			if ( isset( $control['default']['image'] ) ) {
				$wp_customize->add_control( new \WP_Customize_Image_Control( $wp_customize, $control['settings'] . '_image', array(
					'label'       => '',
					'section'     => $control['section'],
					'settings'    => $control['settings'] . '_image',
					'priority'    => $control['priority'] + 1,
					'help'        => '',
					'description' => $i18n['background-image'],
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
						'no-repeat' => $i18n['no-repeat'],
						'repeat'    => $i18n['repeat-all'],
						'repeat-x'  => $i18n['repeat-x'],
						'repeat-y'  => $i18n['repeat-y'],
						'inherit'   => $i18n['inherit'],
					),
					'help'        => '',
					'description' => $i18n['background-repeat'],
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
						'inherit' => $i18n['inherit'],
						'cover'   => $i18n['cover'],
						'contain' => $i18n['contain'],
					),
					'help'        => '',
					'mode'        => 'buttonset',
					'description' => $i18n['background-size'],
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
						'inherit' => $i18n['inherit'],
						'fixed'   => $i18n['fixed'],
						'scroll'  => $i18n['scroll'],
					),
					'help'        => '',
					'mode'        => 'buttonset',
					'description' => $i18n['background-attachment'],
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
						'left-top'      => $i18n['left-top'],
						'left-center'   => $i18n['left-center'],
						'left-bottom'   => $i18n['left-bottom'],
						'right-top'     => $i18n['right-top'],
						'right-center'  => $i18n['right-center'],
						'right-bottom'  => $i18n['right-bottom'],
						'center-top'    => $i18n['center-top'],
						'center-center' => $i18n['center-center'],
						'center-bottom' => $i18n['center-bottom'],
					),
					'help'        => '',
					'description' => $i18n['background-position'],
					'required'    => $control['required'],
					'transport'   => $control['transport']
				) );
			}

			if ( isset( $control['default']['opacity'] ) && $control['default']['opacity'] ) {
				$wp_customize->add_control( new SliderControl( $wp_customize, $control['settings'] . '_opacity', array(
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
					'description' => $i18n['background-opacity'],
					'required'    => $control['required'],
					'transport'   => $control['transport']
				) ) );

			}

		}

	}

}
