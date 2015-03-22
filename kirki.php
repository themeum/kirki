<?php
/*
Plugin Name:   Kirki Framework
Plugin URI:    http://kirki.org
Description:   An options framework using and extending the WordPress Customizer
Author:        Aristeides Stathopoulos
Author URI:    http://press.codes
Version:       0.7.1
*/

if ( ! defined( 'KIRKI_PATH' ) ) {
	define( 'KIRKI_PATH', dirname( __FILE__ ) );
}
if ( ! defined( 'KIRKI_URL' ) ) {
	define( 'KIRKI_URL', plugin_dir_url( __FILE__ ) );
}

// Load Kirki_Fonts before everything else
include_once( KIRKI_PATH . '/includes/libraries/class-kirki-fonts.php' );
include_once( KIRKI_PATH . '/includes/libraries/class-kirki-color.php' );
include_once( KIRKI_PATH . '/includes/libraries/class-kirki-colourlovers.php' );
include_once( KIRKI_PATH . '/includes/deprecated.php' );

include_once( KIRKI_PATH . '/includes/class-kirki-customizer-help-tooltips.php' );
include_once( KIRKI_PATH . '/includes/class-kirki-customizer-postmessage.php' );

class Kirki {

}

class Kirki_Controls extends Kirki {

}

class Kirki_Settings extends Kirki {

}

class Kirki_Customizer_Styles extends Kirki {

}

class Kirki_Config extends Kirki {

}

/**
 * Build the controls
 */
function kirki_customizer_builder( $wp_customize ) {

	include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-group-title-control.php' );
	include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-multicheck-control.php' );
	include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-number-control.php' );
	include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-radio-buttonset-control.php' );
	include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-radio-image-control.php' );
	include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-slider-control.php' );
	include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-sortable-control.php' );
	include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-switch-control.php' );
	include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-toggle-control.php' );
	include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-slider-control.php' );
	include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-palette-control.php' );
	include_once( KIRKI_PATH . '/includes/controls/class-kirki-customize-custom-control.php' );

	$controls = kirki_get_controls();

	// Early exit if controls are not set or if they're empty
	if ( empty( $controls ) ) {
		return;
	}

	foreach ( $controls as $control ) {
		kirki_add_setting( $wp_customize, $control );
		kirki_add_control( $wp_customize, $control );
	}

}
add_action( 'customize_register', 'kirki_customizer_builder', 99 );

/**
 * Get the configuration options for the Kirki customizer.
 *
 * @uses 'kirki/config' filter.
 */
function kirki_get_config() {

	$config = apply_filters( 'kirki/config', array() );

	if ( ! isset( $config['stylesheet_id'] ) ) {
		$config['stylesheet_id'] = 'kirki-styles';
	}

	return $config;

}

/**
 * Get the controls for the Kirki customizer.
 *
 * @uses  'kirki/controls' filter.
 */
function kirki_get_controls() {

	$controls = apply_filters( 'kirki/controls', array() );
	$final_controls = array();

	if ( ! empty( $controls ) ) {
		foreach ( $controls as $control ) {
			$final_controls[] = kirki_control_cleanup( $control );
		}
	}

	return $final_controls;

}

/**
 * Cleanup a single controls.
 */
function kirki_control_cleanup( $control ) {

	/**
	 * If ['default'] is not set, set an empty value
	 */
	if ( ! isset( $control['default'] ) ) {
		$control['default'] = '';
	}

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

/**
 * Takes care of all the migration and compatibility issues with previous versions.
 */
function kirki_update() {

	$version = get_option( 'kirki_version' );
	$version = ( ! $version ) ? '0' : $version;
	// < 0.6.1 -> 0.6.2
	if ( ! get_option( 'kirki_version' ) ) {
		/**
		 * In versions 0.6.0 & 0.6.1 there was a bug and some fields were saved as ID_opacity istead if ID
		 * This will fix the wrong settings naming and save new settings.
		 */
		$control_ids = array();
		$controls = kirki_get_controls();

		foreach ( $controls as $control ) {
			$control = Kirki_Controls::control_clean( $control );

			if ( 'background' != $control['type'] ) {
				$control_ids[] = $control['settings'];
			}

		}

		foreach ( $control_ids as $control_id ) {

			if ( get_theme_mod( $control_id . '_opacity' ) && ! get_theme_mod( $control_id ) ) {
				update_theme_mod( $control_id, get_theme_mod( $control_id . '_opacity' ) );
			}

		}

	}

	// if ( version_compare( $this->version, $version ) ) {
	// 	update_option( 'kirki_version', $this->version );
	// }

}

/**
 * Helper function
 *
 * removes an item from an array
 */
function kirki_array_delete( $idx, $array ) {

	unset( $array[$idx] );
	return ( is_array( $array ) ) ? array_values( $array ) : null;

}

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

/**
 * Sanitize checkbox options
 *
 * @since 0.5
 */
function kirki_sanitize_checkbox( $value ) {
	return ( 'on' != $value ) ? false : $value;
}

/**
 * Sanitize number options
 *
 * @since 0.5
 */
function kirki_sanitize_number( $value ) {
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
function kirki_sanitize_choice( $value, $choices, $default ) {

	$allowed_choices = array_keys( $choices );
	return ( ! in_array( $value, $allowed_choices ) ) ? $default : $value;

}

/**
 * Sanitize background repeat values
 *
 * @since 0.5
 */
function kirki_sanitize_bg_repeat( $value ) {
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
function kirki_sanitize_bg_size( $value ) {
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
function kirki_sanitize_bg_attach( $value ) {
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
function kirki_sanitize_bg_position( $value ) {
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
function kirki_sanitize_unfiltered( $value ) {
	return $value;
}

/**
 * Add our fields.
 * We use the default WordPress Core Customizer fields when possible
 * and only add our own custom controls when needed.
 */
function kirki_add_control( $wp_customize, $control ) {

	$control = kirki_control_cleanup( $control );

	// Color controls
	if ( 'color' == $control['type'] ) {
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $control['settings'], $control ) );
	}

	// Image Controls
	elseif ( 'image' == $control['type'] ) {
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $control['settings'], $control ) );
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

	// Palette Control
	elseif ( 'palette' == $control['type'] ) {
		$wp_customize->add_control( new Kirki_Customize_Palette_Control( $wp_customize, $control['settings'], $control ) );
	}

	// Custom Control
	elseif ( 'custom' == $control['type'] ) {
		$wp_customize->add_control( new Kirki_Customize_Custom_Control( $wp_customize, $control['settings'], $control ) );
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

/**
 * Add the required script.
 */
function kirki_required_script() {

	$controls = kirki_get_controls();

	if ( isset( $controls ) ) {

		foreach ( $controls as $control ) {

			if ( isset( $control['required'] ) && ! is_null( $control['required'] && is_array( $control['required'] ) ) ) {

				foreach ( $control['required'] as $id => $value ) : ?>

					<script>
						jQuery(document).ready(function($) {
							<?php if ( isset( $id ) && isset( $value ) ) : ?>
							 	<?php if ( $value == get_theme_mod( $id ) ) : ?>
									$( '[id="customize-control-<?php echo $control['settings']; ?>"]' ).fadeIn(300);
								<?php else : ?>
									$( '[id="customize-control-<?php echo $control['settings']; ?>"]' ).fadeOut(300);
								<?php endif; ?>
							<?php endif; ?>

							$( "#input_<?php echo $id; ?> input" ).each(function(){
								$(this).click(function(){
									if ( $(this).val() == "<?php echo $value; ?>" ) {
										$( '[id="customize-control-<?php echo $control['settings']; ?>"]' ).fadeIn(300);
									} else {
										$( '[id="customize-control-<?php echo $control['settings']; ?>"]' ).fadeOut(300);
									}
								});
								if ( $(this).val() == "<?php echo $value; ?>" ) {
										$( '[id="customize-control-<?php echo $control['settings']; ?>"]' ).fadeIn(300);
									} else {
										$( '[id="customize-control-<?php echo $control['settings']; ?>"]' ).fadeOut(300);
									}
							});
						});
					</script>
					<?php

				endforeach;

			}

		}

	}

}
add_action( 'customize_controls_print_footer_scripts', 'kirki_required_script' );

function kirki_style_loop_controls() {

	$controls = kirki_get_controls();
	$styles   = array();

	foreach ( $controls as $control ) {
		$element  = '';
		$property = '';
		$units    = '';

		// Only continue if $control['output'] is set
		if ( isset( $control['output'] ) ) {

			// Check if this is an array of style definitions
			$multiple_styles = isset( $control['output'][0]['element'] ) ? true : false;

			if ( ! $multiple_styles ) { // single style

				// If $control['output'] is not an array, then use the string as the target element
				if ( is_string( $control['output'] ) ) {
					$element = $control['output'];
				} else {
					$element  = isset( $control['output']['element'] )  ? $control['output']['element'] : '';
					$property = isset( $control['output']['property'] ) ? $control['output']['property'] : '';
					$units    = isset( $control['output']['units'] )    ? $control['output']['units']    : '';
				}

				$styles = kirki_styles( $control, $styles, $element, $property, $units );

			} else { // Multiple styles set

				foreach ( $control['output'] as $style ) {

					if ( ! array( $style ) ) {
						$element = $style;
					} else {
						$element  = isset( $style['element'] )  ? $style['element'] : '';
						$property = isset( $style['property'] ) ? $style['property'] : '';
						$units    = isset( $style['units'] )    ? $style['units']    : '';
					}

					$styles = kirki_styles( $control, $styles, $element, $property, $units );

				}

			}

		}

	}

	return $styles;

}

function kirki_styles( $control, $styles, $element, $property, $units ) {

	$value = get_theme_mod( $control['settings'], $control['default'] );

	// Color controls
	if ( 'color' == $control['type'] ) {

		$color = Kirki_Color::sanitize_hex( $value );
		$styles[$element][$property] = $color;

	}

	// Background Controls
	elseif ( 'background' == $control['type'] ) {

		if ( isset( $control['default']['color'] ) ) {
			$bg_color = Kirki_Color::sanitize_hex( get_theme_mod( $control['settings'] . '_color', $control['default']['color'] ) );
		}
		if ( isset( $control['default']['image'] ) ) {
			$bg_image = get_theme_mod( $control['settings'] . '_image', $control['default']['image'] );
		}
		if ( isset( $control['default']['repeat'] ) ) {
			$bg_repeat = get_theme_mod( $control['settings'] . '_repeat', $control['default']['repeat'] );
		}
		if ( isset( $control['default']['size'] ) ) {
			$bg_size = get_theme_mod( $control['settings'] . '_size', $control['default']['size'] );
		}
		if ( isset( $control['default']['attach'] ) ) {
			$bg_attach = get_theme_mod( $control['settings'] . '_attach', $control['default']['attach'] );
		}
		if ( isset( $control['default']['position'] ) ) {
			$bg_position = get_theme_mod( $control['settings'] . '_position', $control['default']['position'] );
		}
		if ( isset( $control['default']['opacity'] ) && $control['default']['opacity'] ) {
			$bg_opacity = get_theme_mod( $control['settings'] . '_opacity', $control['default']['opacity'] );
			if ( isset( $bg_color ) ) {
				// If we're using an opacity other than 100, then convert the color to RGBA.
				$bg_color = ( 100 != $bg_opacity ) ? Kirki_Color::get_rgba( $bg_color, $bg_opacity ) : $bg_color;
			} elseif ( isset( $bg_image ) ) {
				$element_opacity = ( $bg_opacity / 100 );
			}

		}

		if ( isset( $bg_color ) ) {
			$styles[$element]['background-color'] = $bg_color;
		}
		if ( isset( $bg_image ) && '' != $bg_image ) {
			$styles[$element]['background-image'] = 'url("' . $bg_image . '")';
			if ( isset( $bg_repeat ) ) {
				$styles[$element]['background-repeat'] = $bg_repeat;
			}
			if ( isset( $bg_size ) ) {
				$styles[$element]['background-size'] = $bg_size;
			}
			if ( isset( $bg_attach ) ) {
				$styles[$element]['background-attachment'] = $bg_attach;
			}
			if ( isset( $bg_position ) ) {
				$styles[$element]['background-position'] = str_replace( '-', ' ', $bg_position );
			}
		}

	}

	// Font controls
	elseif ( array( $control['output'] ) && isset( $control['output']['property'] ) && in_array( $control['output']['property'], array( 'font-family', 'font-size', 'font-weight' ) ) ) {

		$is_font_family = isset( $control['output']['property'] ) && 'font-family' == $control['output']['property'] ? true : false;
		$is_font_size   = isset( $control['output']['property'] ) && 'font-size'   == $control['output']['property'] ? true : false;
		$is_font_weight = isset( $control['output']['property'] ) && 'font-weight' == $control['output']['property'] ? true : false;

		if ( 'font-family' == $property ) {

			$styles[$control['output']['element']]['font-family'] = $value;

		} else if ( 'font-size' == $property ) {

			// Get the unit we're going to use for the font-size.
			$units = empty( $units ) ? 'px' : $units;
			$styles[$element]['font-size'] = $value . $units;

		} else if ( 'font-weight' == $property ) {

			$styles[$element]['font-weight'] = $value;

		}

	} else {

		$styles[$element][$property] = $value . $units;

	}

	return $styles;

}

function kirki_styles_enqueue() {

	$config = kirki_get_config();
	wp_add_inline_style( $config['stylesheet_id'], kirki_styles_parse() );

}
add_action( 'wp_enqueue_scripts', 'kirki_styles_enqueue', 150 );

function kirki_styles_parse() {

	$styles = kirki_style_loop_controls();
	$css = '';

	// Early exit if styles are empty or not an array
	if ( empty( $styles ) || ! is_array( $styles ) ) {
		return;
	}

	foreach ( $styles as $style => $style_array ) {
		$css .= $style . '{';
		foreach ( $style_array as $property => $value ) {
			$css .= $property . ':' . $value . ';';
		}
		$css .= '}';
	}

	return $css;

}

function kirki_google_link() {

	$controls = kirki_get_controls();
	$config   = kirki_get_config();

	// Get an array of all the google fonts
	$google_fonts = Kirki_Fonts::get_google_fonts();

	$fonts = array();
	foreach ( $controls as $control ) {

		// The value of this control
		$value = get_theme_mod( $control['settings'], $control['default'] );

		if ( isset( $control['output'] ) ) {

			// Check if this is a font-family control
			$is_font_family = isset( $control['output']['property'] ) && 'font-family' == $control['output']['property'] ? true : false;
			// Check if this is a font-weight control
			$is_font_weight = isset( $control['output']['property'] ) && 'font-weight' == $control['output']['property'] ? true : false;
			// Check if this is a font subset control
			$is_font_subset = isset( $control['output']['property'] ) && 'font-subset' == $control['output']['property'] ? true : false;

			if ( $is_font_family ) {
				$fonts[]['font-family'] = $value;
			} else if ( $is_font_weight ) {
				$fonts[]['font-weight'] = $value;
			} else if ( $is_font_subset ) {
				$fonts[]['subsets'] = $value;
			}

		}

	}

	foreach ( $fonts as $font ) {

		if ( isset( $font['font-family'] ) ) {

			$font_families   = ( ! isset( $font_families ) ) ? array() : $font_families;
			$font_families[] = $font['font-family'];

			if ( Kirki_Fonts::is_google_font( $font['font-family'] ) ) {
				$has_google_font = true;
			}

		}

		if ( isset( $font['font-weight'] ) ) {

			$font_weights   = ( ! isset( $font_weights ) ) ? array() : $font_weights;
			$font_weights[] = $font['font-weight'];

		}

		if ( isset( $font['subsets'] ) ) {

			$font_subsets   = ( ! isset( $font_subsets ) ) ? array() : $font_subsets;
			$font_subsets[] = $font['subsets'];

		}

	}

	$font_families = ( ! isset( $font_families ) || empty( $font_families ) ) ? false : $font_families;
	$font_weights  = ( ! isset( $font_weights )  || empty( $font_weights ) )  ? '400' : $font_weights;
	$font_subsets  = ( ! isset( $font_subsets )  || empty( $font_subsets ) )  ? 'all' : $font_subsets;

	if ( ! isset( $has_google_font ) || ! $has_google_font ) {
		$font_families = false;
	}

	return ( $font_families ) ? Kirki_Fonts::get_google_font_uri( $font_families, $font_weights, $font_subsets ) : false;

}

/**
 * Enqueue Google fonts if necessary
 */
function kirki_google_font() {

	$google_link = kirki_google_link();

	if ( $google_link ) {
		wp_register_style( 'kirki_google_fonts', $google_link );
		wp_enqueue_style( 'kirki_google_fonts' );
	}

}
add_action( 'wp_enqueue_scripts', 'kirki_google_font', 105 );

/**
 * Enqueue the stylesheets required.
 */
function kirki_customizer_styles() {

	$config = kirki_get_config();

	$kirki_url = isset( $config['url_path'] ) ? $config['url_path'] : KIRKI_URL;

	wp_enqueue_style( 'kirki-customizer-css', $kirki_url . 'assets/css/customizer.css', NULL, '0.5' );
	wp_enqueue_style( 'hint-css', $kirki_url . 'assets/css/hint.css', NULL, '1.3.3' );
	wp_enqueue_style( 'kirki-customizer-ui',  $kirki_url . 'assets/css/jquery-ui-1.10.0.custom.css', NULL, '1.10.0' );

}
add_action( 'customize_controls_print_styles', 'kirki_customizer_styles' );

/**
 * Enqueue the scripts required.
 */
function kirki_customizer_scripts() {

	$config = kirki_get_config();

	$kirki_url = isset( $config['url_path'] ) ? $config['url_path'] : KIRKI_URL;

	wp_enqueue_script( 'kirki_customizer_js', $kirki_url . 'assets/js/customizer.js', array( 'jquery', 'customize-controls' ) );
	wp_enqueue_script( 'serialize-js', $kirki_url . 'assets/js/serialize.js');
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-tooltip' );

}
add_action( 'customize_controls_enqueue_scripts', 'kirki_customizer_scripts' );

/**
 * Add a dummy, empty stylesheet if no stylesheet_id has been defined and we need one.
 */
function kirki_frontend_styles() {

	$config   = kirki_get_config();
	$controls = kirki_get_controls();

	$kirki_url = isset( $config['url_path'] ) ? $config['url_path'] : KIRKI_URL;

	foreach( $controls as $control ) {
		if ( isset( $control['output'] ) ) {
			$uses_output = true;
		}
	}

	if ( isset( $uses_output )  && ( ! isset( $config['stylesheet_id'] ) || $config['stylesheet_id'] === 'kirki-styles' ) ) {
		wp_enqueue_style( 'kirki-styles', $kirki_url . 'assets/css/kirki-styles.css', NULL, NULL );
	}

}
$styles_priority = ( isset( $options['styles_priority'] ) ) ? $styles_priority : 10;
add_action( 'wp_enqueue_scripts', 'kirki_frontend_styles', $styles_priority );

/**
 * If we've specified an image to be used as logo,
 * replace the default theme description with a div that will include our logo.
 */
function kirki_customizer_custom_js() {

	$options = apply_filters( 'kirki/config', array() ); ?>

	<?php if ( isset( $options['logo_image'] ) || isset( $options['description'] ) ) : ?>
		<script>jQuery(document).ready(function($) { "use strict";
			<?php if ( isset( $options['logo_image'] ) ) : ?>
				$( 'div#customize-info .preview-notice' ).replaceWith( '<img src="<?php echo $options['logo_image']; ?>">' );
			<?php endif; ?>
			<?php if ( isset( $options['description'] ) ) : ?>
				$( 'div#customize-info .accordion-section-content' ).replaceWith( '<div class="accordion-section-content"><div class="theme-description"><?php echo $options['description']; ?></div></div>' );
			<?php endif; ?>
		});</script>
	<?php endif;

}
add_action( 'customize_controls_print_scripts', 'kirki_customizer_custom_js', 999 );

/**
 * Get the admin color theme
 */
function kirki_get_admin_colors() {

	// Get the active admin theme
	global $_wp_admin_css_colors;

	// Get the user's admin colors
	$color = get_user_option( 'admin_color' );
	// If no theme is active set it to 'fresh'
	if ( empty( $color ) || ! isset( $_wp_admin_css_colors[$color] ) ) {
		$color = 'fresh';
	}

	$color = (array) $_wp_admin_css_colors[$color];

	return $color;

}

/**
 * Add custom CSS rules to the head, applying our custom styles
 */
function kirki_customizer_custom_css() {

	global $kirki;

	$color   = kirki_get_admin_colors();
	$options = kirki_get_config();

	$color_font    = false;
	$color_active  = isset( $options['color_active'] )  ? $options['color_active']  : $color['colors'][3];
	$color_light   = isset( $options['color_light'] )   ? $options['color_light']   : $color['colors'][2];
	$color_select  = isset( $options['color_select'] )  ? $options['color_select']  : $color['colors'][3];
	$color_accent  = isset( $options['color_accent'] )  ? $options['color_accent']  : $color['icon_colors']['focus'];
	$color_back    = isset( $options['color_back'] )    ? $options['color_back']    : false;

	if ( $color_back ) {
		$color_font = ( 170 > kirki_get_brightness( $color_back ) ) ? '#f2f2f2' : '#222';
	}

	?>

	<style>
	.wp-core-ui .button.tooltip {
		background: <?php echo $color_select; ?>;
		color: #fff;
	}

	.image.ui-buttonset label.ui-button.ui-state-active {
		background: <?php echo $color_select; ?>;
	}

	<?php if ( $color_back ) : ?>

		.wp-full-overlay-sidebar,
		#customize-info .accordion-section-title,
		#customize-info .accordion-section-title:hover,
		#customize-theme-controls .accordion-section-title,
		#customize-theme-controls .control-section .accordion-section-title {
			background: <?php echo $color_back; ?>;
			<?php if ( $color_font ) : ?>color: <?php echo $color_font; ?>;<?php endif; ?>
		}
		<?php if ( $color_font ) : ?>
			#customize-theme-controls .control-section .accordion-section-title:focus,
			#customize-theme-controls .control-section .accordion-section-title:hover,
			#customize-theme-controls .control-section.open .accordion-section-title,
			#customize-theme-controls .control-section:hover .accordion-section-title {
				color: <?php echo $color_font; ?>;
			}
			<?php endif; ?>

		<?php if ( 170 > Kirki_Color::get_brightness( $color_back ) ) : ?>
			.control-section.control-panel>.accordion-section-title:after {
				background: #111;
				color: #f5f5f5;
				border-left: 1px solid #000;
			}
			#customize-theme-controls .control-section.control-panel>h3.accordion-section-title:focus:after,
			#customize-theme-controls .control-section.control-panel>h3.accordion-section-title:hover:after {
				background: #222;
				color: #fff;
				border: 1px solid #222;
			}

			.control-panel-back,
			.customize-controls-close {
				background: #111 !important;
				border-right: 1px solid #111 !important;
			}
			.control-panel-back:before,
			.control-panel-back:after,
			.customize-controls-close:before,
			.customize-controls-close:after {
				color: #f2f2f2 !important;
			}
			.control-panel-back:focus:before,
			.control-panel-back:hover:before,
			.customize-controls-close:focus:before,
			.customize-controls-close:hover:before {
				background: #000;
				color: #fff;
			}
			#customize-header-actions {
				border-bottom: 1px solid #111;
			}
		<?php endif; ?>

	<?php endif; ?>

	.ui-state-default,
	.ui-widget-content .ui-state-default,
	.ui-widget-header .ui-state-default,
	.ui-state-active.ui-button.ui-widget.ui-state-default {
		background-color: <?php echo $color_active; ?>;
		border: 1px solid rgba(0,0,0,.05);
	}

	.ui-button.ui-widget.ui-state-default {
		background-color: #f2f2f2;
	}

	#customize-theme-controls .accordion-section-title {
		border-bottom: 1px solid rgba(0,0,0,.1);
	}

	#customize-theme-controls .control-section .accordion-section-title:focus,
	#customize-theme-controls .control-section .accordion-section-title:hover,
	#customize-theme-controls .control-section.open .accordion-section-title,
	#customize-theme-controls .control-section:hover .accordion-section-title {
		background: <?php echo $color_active; ?>;
	}
	ul.ui-sortable li.kirki-sortable-item {
		border: 1px solid <?php echo $color_active; ?>;
	}

	.Switch span.On,
	ul.ui-sortable li.kirki-sortable-item .visibility {
		color: <?php echo $color_active; ?>;
	}

	#customize-theme-controls .control-section.control-panel.current-panel:hover .accordion-section-title{
		background: none;
	}

	.Switch.Round.On .Toggle,
	#customize-theme-controls .control-section.control-panel.current-panel .accordion-section-title:hover{
		background: <?php echo $color_active; ?>;
	}

	.wp-core-ui .button-primary {
		background: <?php echo $color_active; ?>;
	}

	.wp-core-ui .button-primary.focus,
	.wp-core-ui .button-primary.hover,
	.wp-core-ui .button-primary:focus,
	.wp-core-ui .button-primary:hover {
		background: <?php echo $color_select; ?>;
	}

	.wp-core-ui .button-primary-disabled,
	.wp-core-ui .button-primary.disabled,
	.wp-core-ui .button-primary:disabled,
	.wp-core-ui .button-primary[disabled] {
		background: <?php echo $color_light; ?> !important;
		color: <?php echo $color_select; ?> !important;
	}

	.customize-control input[type="text"]:focus {
		border-color: <?php echo $color_active; ?>;
	}

	.wp-core-ui.wp-customizer .button,
	.press-this.wp-core-ui .button,
	.press-this input#publish,
	.press-this input#save-post,
	.press-this a.preview {
		background-color: <?php echo $color_accent; ?>;
	}

	.wp-core-ui.wp-customizer .button:hover,
	.press-this.wp-core-ui .button:hover,
	.press-this input#publish:hover,
	.press-this input#save-post:hover,
	.press-this a.preview:hover {
		background-color: <?php echo $color_accent; ?>;
	}
	</style>
	<?php
}
add_action( 'customize_controls_print_styles', 'kirki_customizer_custom_css', 999 );
