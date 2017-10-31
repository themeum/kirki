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
	'title'       => esc_attr__( 'Kirki Demo Panel', 'kirki' ),
	'description' => esc_attr__( 'Contains sections for all kirki controls.', 'kirki' ),
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
	'background'      => array( esc_attr__( 'Background', 'kirki' ), '' ),
	'code'            => array( esc_attr__( 'Code', 'kirki' ), '' ),
	'checkbox'        => array( esc_attr__( 'Checkbox', 'kirki' ), '' ),
	'color'           => array( esc_attr__( 'Color', 'kirki' ), '' ),
	'color-palette'   => array( esc_attr__( 'Color Palette', 'kirki' ), '' ),
	'custom'          => array( esc_attr__( 'Custom', 'kirki' ), '' ),
	'dashicons'       => array( esc_attr__( 'Dashicons', 'kirki' ), '' ),
	'date'            => array( esc_attr__( 'Date', 'kirki' ), '' ),
	'dimension'       => array( esc_attr__( 'Dimension', 'kirki' ), '' ),
	'dimensions'      => array( esc_attr__( 'Dimensions', 'kirki' ), '' ),
	'editor'          => array( esc_attr__( 'Editor', 'kirki' ), '' ),
	'fontawesome'     => array( esc_attr__( 'Font-Awesome', 'kirki' ), '' ),
	'generic'         => array( esc_attr__( 'Generic', 'kirki' ), '' ),
	'image'           => array( esc_attr__( 'Image', 'kirki' ), '' ),
	'multicheck'      => array( esc_attr__( 'Multicheck', 'kirki' ), '' ),
	'multicolor'      => array( esc_attr__( 'Multicolor', 'kirki' ), '' ),
	'number'          => array( esc_attr__( 'Number', 'kirki' ), '' ),
	'palette'         => array( esc_attr__( 'Palette', 'kirki' ), '' ),
	'preset'          => array( esc_attr__( 'Preset', 'kirki' ), '' ),
	'radio'           => array( esc_attr__( 'Radio', 'kirki' ), esc_attr__( 'A plain Radio control.', 'kirki' ) ),
	'radio-buttonset' => array( esc_attr__( 'Radio Buttonset', 'kirki' ), esc_attr__( 'Radio-Buttonset controls are essentially radio controls with some fancy styling to make them look cooler.', 'kirki' ) ),
	'radio-image'     => array( esc_attr__( 'Radio Image', 'kirki' ), esc_attr__( 'Radio-Image controls are essentially radio controls with some fancy styles to use images', 'kirki' ) ),
	'repeater'        => array( esc_attr__( 'Repeater', 'kirki' ), '' ),
	'select'          => array( esc_attr__( 'Select', 'kirki' ), '' ),
	'slider'          => array( esc_attr__( 'Slider', 'kirki' ), '' ),
	'sortable'        => array( esc_attr__( 'Sortable', 'kirki' ), '' ),
	'switch'          => array( esc_attr__( 'Switch', 'kirki' ), '' ),
	'toggle'          => array( esc_attr__( 'Toggle', 'kirki' ), '' ),
	'typography'      => array( esc_attr__( 'Typography', 'kirki' ), '' ),
);
foreach ( $sections as $section_id => $section ) {
	Kirki::add_section( str_replace( '-', '_', $section_id ) . '_section', array(
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
	'label'       => esc_attr__( 'Background Control', 'kirki' ),
	'description' => esc_attr__( 'Background conrols are pretty complex! (but useful if properly used)', 'kirki' ),
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
	'label'       => esc_attr__( 'Code Control', 'kirki' ),
	'description' => esc_attr__( 'Description', 'kirki' ),
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
	'label'       => esc_attr__( 'Checkbox Control', 'kirki' ),
	'description' => esc_attr__( 'Description', 'kirki' ),
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
	'label'       => __( 'Color Control (hex-only)', 'kirki' ),
	'description' => esc_attr__( 'This is a color control - without alpha channel.', 'kirki' ),
	'section'     => 'color_section',
	'default'     => '#0088CC',
) );

Kirki::add_field( 'kirki_demo', array(
	'type'        => 'color',
	'settings'    => 'color_setting_rgba',
	'label'       => __( 'Color Control (with alpha channel)', 'kirki' ),
	'description' => esc_attr__( 'This is a color control - with alpha channel.', 'kirki' ),
	'section'     => 'color_section',
	'default'     => '#0088CC',
	'choices'     => array(
		'alpha' => true,
	),
) );

/**
 * Editor Controls
 */
Kirki::add_field( 'kirki_demo', array(
	'type'        => 'editor',
	'settings'    => 'editor_1',
	'label'       => esc_attr__( 'First Editor Control', 'kirki' ),
	'description' => esc_attr__( 'This is an editor control.', 'kirki' ),
	'section'     => 'editor_section',
	'default'     => '',
) );

Kirki::add_field( 'kirki_demo', array(
	'type'        => 'editor',
	'settings'    => 'editor_2',
	'label'       => esc_attr__( 'Second Editor Control', 'kirki' ),
	'description' => esc_attr__( 'This is a 2nd editor control just to check that we do not have issues with multiple instances.', 'kirki' ),
	'section'     => 'editor_section',
	'default'     => esc_attr__( 'Default Text', 'kirki' ),
) );

/**
 * Color-Palette Controls.
 *
 * @link https://aristath.github.io/kirki/docs/controls/color-palette.html
 */
Kirki::add_field( 'kirki_demo', array(
	'type'        => 'color-palette',
	'settings'    => 'color_palette_setting_0',
	'label'       => esc_attr__( 'Color-Palette', 'kirki' ),
	'description' => esc_attr__( 'This is a color-palette control', 'kirki' ),
	'section'     => 'color_palette_section',
	'default'     => '#888888',
	'choices'     => array(
		'colors' => array( '#000000', '#222222', '#444444', '#666666', '#888888', '#aaaaaa', '#cccccc', '#eeeeee', '#ffffff' ),
		'style'  => 'round',
	),
) );

Kirki::add_field( 'kirki_demo', array(
	'type'        => 'color-palette',
	'settings'    => 'color_palette_setting_4',
	'label'       => esc_attr__( 'Color-Palette', 'kirki' ),
	'description' => esc_attr__( 'Material Design Colors - all', 'kirki' ),
	'section'     => 'color_palette_section',
	'default'     => '#F44336',
	'choices'     => array(
		'colors' => Kirki_Helper::get_material_design_colors( 'all' ),
		'size'   => 17,
	),
) );

Kirki::add_field( 'kirki_demo', array(
	'type'        => 'color-palette',
	'settings'    => 'color_palette_setting_1',
	'label'       => esc_attr__( 'Color-Palette', 'kirki' ),
	'description' => esc_attr__( 'Material Design Colors - primary', 'kirki' ),
	'section'     => 'color_palette_section',
	'default'     => '#000000',
	'choices'     => array(
		'colors' => Kirki_Helper::get_material_design_colors( 'primary' ),
		'size'   => 25,
	),
) );

Kirki::add_field( 'kirki_demo', array(
	'type'        => 'color-palette',
	'settings'    => 'color_palette_setting_2',
	'label'       => esc_attr__( 'Color-Palette', 'kirki' ),
	'description' => esc_attr__( 'Material Design Colors - red', 'kirki' ),
	'section'     => 'color_palette_section',
	'default'     => '#FF1744',
	'choices'     => array(
		'colors' => Kirki_Helper::get_material_design_colors( 'red' ),
		'size'   => 16,
	),
) );

Kirki::add_field( 'kirki_demo', array(
	'type'        => 'color-palette',
	'settings'    => 'color_palette_setting_3',
	'label'       => esc_attr__( 'Color-Palette', 'kirki' ),
	'description' => esc_attr__( 'Material Design Colors - A100', 'kirki' ),
	'section'     => 'color_palette_section',
	'default'     => '#FF80AB',
	'choices'     => array(
		'colors' => Kirki_Helper::get_material_design_colors( 'A100' ),
		'size'   => 60,
		'style'  => 'round',
	),
) );

/**
 * Dashicons control.
 *
 * @link https://aristath.github.io/kirki/docs/controls/dashicons.html
 */
Kirki::add_field( 'kirki_demo', array(
	'type'        => 'dashicons',
	'settings'    => 'dashicons_setting_0',
	'label'       => esc_attr__( 'Dashicons Control', 'kirki' ),
	'description' => esc_attr__( 'Using a custom array of dashicons', 'kirki' ),
	'section'     => 'dashicons_section',
	'default'     => 'menu',
	'choices'     => array(
		'menu',
		'admin-site',
		'dashboard',
		'admin-post',
		'admin-media',
		'admin-links',
		'admin-page',
	),
) );

Kirki::add_field( 'kirki_demo', array(
	'type'        => 'dashicons',
	'settings'    => 'dashicons_setting_1',
	'label'       => esc_attr__( 'All Dashicons', 'kirki' ),
	'description' => esc_attr__( 'Showing all dashicons', 'kirki' ),
	'section'     => 'dashicons_section',
	'default'     => 'menu',
) );
