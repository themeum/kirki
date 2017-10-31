<?php
/**
 * An example file demonstrating how to add all controls.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0.12
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Do not proceed if Kirki does not exist.
if ( ! class_exists( 'Kirki' ) ) {
    return;
}

/**
 * First of all, add the config.
 *
 * @link https://aristath.github.io/kirki/docs/getting-started/config.html
 */
Kirki::add_config( 'kirki_demo', array(
    'capability'  => 'edit_theme_options',
	'option_type' => 'theme_mod',
) );

/**
 * Add a panel.
 *
 * @link https://aristath.github.io/kirki/docs/getting-started/panels.html
 */
Kirki::add_panel( 'kirki_demo_panel', array(
    'priority'    => 10,
    'title'       => esc_attr__( 'Kirki Demo Panel', 'textdomain' ),
    'description' => esc_attr__( 'Contains sections for all kirki controls.', 'textdomain' ),
) );

/**
 * Add Sections.
 *
 * We'll be doing things a bit differently here, just to demonstrate an example.
 * We're going to define 1 section per control-type just to keep things clean and separate.
 *
 * @link https://aristath.github.io/kirki/docs/getting-started/sections.html
 */
$sections = array(
    'background'      => array( esc_attr__( 'Background', 'textdomain' ), '' ),
    'code'            => array( esc_attr__( 'Code', 'textdomain' ), '' ),
    'checkbox'        => array( esc_attr__( 'Checkbox', 'textdomain' ), '' ),
    'color'           => array( esc_attr__( 'Color', 'textdomain' ), '' ),
    'color-palette'   => array( esc_attr__( 'Color Palette', 'textdomain' ), '' ),
    'custom'          => array( esc_attr__( 'Custom', 'textdomain' ), '' ),
    'dashicons'       => array( esc_attr__( 'Dashicons', 'textdomain' ), '' ),
    'date'            => array( esc_attr__( 'Date', 'textdomain' ), '' ),
    'dimension'       => array( esc_attr__( 'Dimension', 'textdomain' ), '' ),
    'dimensions'      => array( esc_attr__( 'Dimensions', 'textdomain' ), '' ),
    'editor'          => array( esc_attr__( 'Editor', 'textdomain' ), '' ),
    'fontawesome'     => array( esc_attr__( 'Font-Awesome', 'textdomain' ), '' ),
    'generic'         => array( esc_attr__( 'Generic', 'textdomain' ), '' ),
    'image'           => array( esc_attr__( 'Image', 'textdomain' ), '' ),
    'multicheck'      => array( esc_attr__( 'Multicheck', 'textdomain' ), '' ),
    'multicolor'      => array( esc_attr__( 'Multicolor', 'textdomain' ), '' ),
    'number'          => array( esc_attr__( 'Number', 'textdomain' ), '' ),
    'palette'         => array( esc_attr__( 'Palette', 'textdomain' ), '' ),
    'preset'          => array( esc_attr__( 'Preset', 'textdomain' ), '' ),
    'radio'           => array( esc_attr__( 'Radio', 'textdomain' ), esc_attr__( 'A plain Radio control.', 'textdomain' ) ),
    'radio-buttonset' => array( esc_attr__( 'Radio Buttonset', 'textdomain' ), esc_attr__( 'Radio-Buttonset controls are essentially radio controls with some fancy styling to make them look cooler.', 'textdomain' ) ),
    'radio-image'     => array( esc_attr__( 'Radio Image', 'textdomain' ), esc_attr__( 'Radio-Image controls are essentially radio controls with some fancy styles to use images', 'textdomain' ) ),
    'repeater'        => array( esc_attr__( 'Repeater', 'textdomain' ), '' ),
    'select'          => array( esc_attr__( 'Select', 'textdomain' ), '' ),
    'slider'          => array( esc_attr__( 'Slider', 'textdomain' ), '' ),
    'sortable'        => array( esc_attr__( 'Sortable', 'textdomain' ), '' ),
    'switch'          => array( esc_attr__( 'Switch', 'textdomain' ), '' ),
    'toggle'          => array( esc_attr__( 'Toggle', 'textdomain' ), '' ),
    'typography'      => array( esc_attr__( 'Typography', 'textdomain' ), '' ),
);
foreach ( $sections as $section_id => $section ) {
    Kirki::add_section( $section_id . '_section', array(
        'title'       => $section[0],
        'description' => $section[1],
        'panel'       => 'kirki_demo_panel',
    ) );
}

/**
 * Background Control.
 */
Kirki::add_field( 'kirki_demo', array(
    'type'        => 'background',
    'settings'    => 'background_setting',
    'label'       => esc_attr__( 'Background Control', 'textdomain' ),
    'description' => esc_attr__( 'Background conrols are pretty complex! (but useful if properly used)', 'textdomain' ),
    'section'     => 'background_section',
    'default'     => array(
        'background-color'      => 'rgba(20,20,20,.8)',
        'background-image'      => '',
        'background-repeat'     => 'repeat-all',
        'background-position'   => 'center center',
        'background-size'       => 'cover',
        'background-attachment' => 'scroll',
    ),
) );

/**
 * Code control.
 *
 * @link https://aristath.github.io/kirki/docs/controls/code.html
 */
Kirki::add_field( 'kirki_demo', array(
    'type'        => 'code',
    'settings'    => 'code_setting',
    'label'       => esc_attr__( 'Code Control', 'textdomain' ),
    'description' => esc_attr__( 'Description', 'textdomain' ),
    'section'     => 'code_section',
    'default'     => '',
    'choices'     => array(
        'language' => 'css',
        'theme'    => 'monokai',
    ),
) );

/**
 * Checkbox control.
 *
 * @link https://aristath.github.io/kirki/docs/controls/checkbox.html
 */
Kirki::add_field( 'kirki_demo', array(
    'type'        => 'checkbox',
    'settings'    => 'checkbox_setting',
    'label'       => esc_attr__( 'Checkbox Control', 'textdomain' ),
    'description' => esc_attr__( 'Description', 'textdomain' ),
    'section'     => 'checkbox_section',
    'default'     => true,
) );

/**
 * Color Controls.
 *
 * @link https://aristath.github.io/kirki/docs/controls/color.html
 */
Kirki::add_field( 'kirki_demo', array(
	'type'        => 'color',
	'settings'    => 'color_setting_hex',
	'label'       => __( 'Color Control (hex-only)', 'textdomain' ),
    'description' => esc_attr__( 'This is a color control - without alpha channel.', 'textdomain' ),
	'section'     => 'color_section',
	'default'     => '#0088CC',
) );

Kirki::add_field( 'kirki_demo', array(
	'type'        => 'color',
	'settings'    => 'color_setting_rgba',
	'label'       => __( 'Color Control (with alpha channel)', 'textdomain' ),
    'description' => esc_attr__( 'This is a color control - with alpha channel.', 'textdomain' ),
	'section'     => 'color_section',
	'default'     => '#0088CC',
	'choices'     => array(
		'alpha' => true,
	),
) );
