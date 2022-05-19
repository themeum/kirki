<?php
/**
 * An example file demonstrating how to add all controls.
 *
 * @package Kirki
 * @category Core
 * @author Ari Stathopoulos (@aristath)
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license https://opensource.org/licenses/MIT
 * @since 3.0.12
 */

use Kirki\Util\Helper;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Do not proceed if Kirki does not exist.
if ( ! class_exists( 'Kirki' ) ) {
	return;
}

Kirki::add_config(
	'kirki_demo_config',
	[
		'option_type' => 'theme_mod',
		'capability'  => 'manage_options',
	]
);

/**
 * Add a panel.
 *
 * @link https://kirki.org/docs/getting-started/panels.html
 */
new \Kirki\Panel(
	'kirki_demo_panel',
	[
		'priority'    => 10,
		'title'       => esc_html__( 'Kirki Demo Panel', 'kirki' ),
		'description' => esc_html__( 'Contains sections for all kirki controls.', 'kirki' ),
	]
);

/**
 * Add Sections.
 *
 * We'll be doing things a bit differently here, just to demonstrate an example.
 * We're going to define 1 section per control-type just to keep things clean and separate.
 *
 * @link https://kirki.org/docs/getting-started/sections.html
 */
$sections = [
	'background'      => [ esc_html__( 'Background', 'kirki' ), '' ],
	'code'            => [ esc_html__( 'Code', 'kirki' ), '' ],
	'checkbox'        => [ esc_html__( 'Checkbox', 'kirki' ), '' ],
	'color'           => [ esc_html__( 'Color', 'kirki' ), '' ],
	'color_advanced'  => [ esc_html__( 'Color — Advanced', 'kirki' ), '' ],
	'color_palette'   => [ esc_html__( 'Color Palette', 'kirki' ), '' ],
	'custom'          => [ esc_html__( 'Custom', 'kirki' ), '' ],
	'dashicons'       => [ esc_html__( 'Dashicons', 'kirki' ), '' ],
	'date'            => [ esc_html__( 'Date', 'kirki' ), '' ],
	'dimension'       => [ esc_html__( 'Dimension', 'kirki' ), '' ],
	'dimensions'      => [ esc_html__( 'Dimensions', 'kirki' ), '' ],
	'dropdown-pages'  => [ esc_html__( 'Dropdown Pages', 'kirki' ), '' ],
	'editor'          => [ esc_html__( 'Editor', 'kirki' ), '' ],
	'fontawesome'     => [ esc_html__( 'Font-Awesome', 'kirki' ), '' ],
	'generic'         => [ esc_html__( 'Generic', 'kirki' ), '' ],
	'image'           => [ esc_html__( 'Image', 'kirki' ), '' ],
	'multicheck'      => [ esc_html__( 'Multicheck', 'kirki' ), '' ],
	'multicolor'      => [ esc_html__( 'Multicolor', 'kirki' ), '' ],
	'number'          => [ esc_html__( 'Number', 'kirki' ), '' ],
	'palette'         => [ esc_html__( 'Palette', 'kirki' ), '' ],
	'preset'          => [ esc_html__( 'Preset', 'kirki' ), '' ],
	'radio'           => [ esc_html__( 'Radio', 'kirki' ), esc_html__( 'A plain Radio control.', 'kirki' ) ],
	'radio-buttonset' => [ esc_html__( 'Radio Buttonset', 'kirki' ), esc_html__( 'Radio-Buttonset controls are essentially radio controls with some fancy styling to make them look cooler.', 'kirki' ) ],
	'radio-image'     => [ esc_html__( 'Radio Image', 'kirki' ), esc_html__( 'Radio-Image controls are essentially radio controls with some fancy styles to use images', 'kirki' ) ],
	'repeater'        => [ esc_html__( 'Repeater', 'kirki' ), '' ],
	'select'          => [ esc_html__( 'Select', 'kirki' ), '' ],
	'slider'          => [ esc_html__( 'Slider', 'kirki' ), '' ],
	'sortable'        => [ esc_html__( 'Sortable', 'kirki' ), '' ],
	'switch'          => [ esc_html__( 'Switch', 'kirki' ), '', 'outer' ],
	'toggle'          => [ esc_html__( 'Toggle', 'kirki' ), '', 'outer' ],
	'typography'      => [ esc_html__( 'Typography', 'kirki' ), '' ],
	'upload'          => [ esc_html__( 'Upload', 'kirki' ), '' ],
];

foreach ( $sections as $section_id => $section ) {
	$section_args = [
		'title'       => $section[0],
		'description' => $section[1],
		'panel'       => 'kirki_demo_panel',
	];
	if ( isset( $section[2] ) ) {
		$section_args['type'] = $section[2];
	}
	new \Kirki\Section( str_replace( '-', '_', $section_id ) . '_section', $section_args );
}

new \Kirki\Section(
	'pro_test',
	[
		'title'       => esc_html__( 'Test Link Section', 'kirki' ),
		'type'        => 'link',
		'button_text' => esc_html__( 'Pro', 'kirki' ),
		'button_url'  => 'https://kirki.org',
	]
);

/**
 * Background Control.
 *
 * @todo Triggers change on load.
 */
new \Kirki\Field\Background(
	[
		'settings'    => 'kirki_demo_background',
		'label'       => esc_html__( 'Background Control', 'kirki' ),
		'description' => esc_html__( 'Background conrols are pretty complex! (but useful if properly used)', 'kirki' ),
		'section'     => 'background_section',
		'default'     => [
			'background-color'      => 'rgba(20,20,20,.8)',
			'background-image'      => '',
			'background-repeat'     => 'repeat',
			'background-position'   => 'center center',
			'background-size'       => 'cover',
			'background-attachment' => 'scroll',
		],
	]
);

/**
 * Code control.
 *
 * @link https://kirki.org/docs/controls/code.html
 */
new \Kirki\Field\Code(
	[
		'settings'    => 'kirki_demo_code_css',
		'label'       => esc_html__( 'Code Control — CSS', 'kirki' ),
		'description' => esc_html__( 'Sample of code control in CSS format', 'kirki' ),
		'section'     => 'code_section',
		'default'     => '',
		'choices'     => [
			'language' => 'css',
		],
	]
);

/**
 * Checkbox control.
 *
 * @link https://kirki.org/docs/controls/checkbox.html
 */
new \Kirki\Field\Checkbox(
	[
		'settings'    => 'kirki_demo_checkbox',
		'label'       => esc_html__( 'Checkbox Control', 'kirki' ),
		'description' => esc_html__( 'Sample of checkbox control', 'kirki' ),
		'section'     => 'checkbox_section',
		'default'     => true,
	]
);

/**
 * Color Controls.
 *
 * @link https://kirki.org/docs/controls/color.html
 */
Kirki::add_field(
	'kirki_demo_config',
	[
		'type'        => 'color',
		'settings'    => 'kirki_demo_color_alpha_old',
		'label'       => 'Using <code>Kirki::add_field</code> — With alpha',
		'description' => esc_html__( 'This is a color control registered using `Kirki::add_field` with "alpha" => true (the old Kirki API).', 'kirki' ),
		'section'     => 'color_section',
		'transport'   => 'postMessage',
		'default'     => '#ff0055',
		'choices'     => [
			'alpha' => true,
		],
	]
);

new \Kirki\Field\Color(
	[
		'settings'    => 'kirki_demo_color_hex',
		'label'       => __( 'Hex only', 'kirki' ),
		'description' => esc_html__( 'This is a color control without alpha channel.', 'kirki' ),
		'section'     => 'color_section',
		'transport'   => 'postMessage',
		'default'     => '#0008DC',
	]
);

new \Kirki\Field\Color(
	[
		'settings'    => 'kirki_demo_color_alpha',
		'label'       => __( 'With alpha channel', 'kirki' ),
		'description' => esc_html__( 'This is a color control with alpha channel.', 'kirki' ),
		'section'     => 'color_section',
		'transport'   => 'postMessage',
		'choices'     => [
			'alpha' => true,
		],
	]
);

new \Kirki\Field\Color(
	[
		'settings'    => 'kirki_demo_color_hue',
		'label'       => __( 'Hue only.', 'kirki' ),
		'description' => esc_html__( 'This is a color control with "mode" => "hue" (hue mode).', 'kirki' ),
		'section'     => 'color_section',
		'transport'   => 'postMessage',
		'default'     => 160,
		'mode'        => 'hue',
	]
);

/**
 * Color Control (Advanced)
 */

/**
 * Color control with form_component value is HexColorPicker.
 *
 * The saved value will always be a string, for instance:
 * "#ff0000"
 */
new \Kirki\Field\Color(
	[
		'settings'    => 'kirki_demo_color_form_component_hex',
		'label'       => __( 'v4 — form_component — HexColorPicker', 'kirki' ),
		'description' => esc_html__( 'This is a color control with form_component value is HexColorPicker.', 'kirki' ),
		'section'     => 'color_advanced_section',
		'default'     => '#ffff00',
		'choices'     => [
			'form_component' => 'HexColorPicker',
		],
		'transport'   => 'postMessage',
	]
);

/**
 * Color control with form_component value is RgbColorPicker.
 *
 * The saved value will be an rgba array.
 * The format is following the `react-colorful` and `colord` formatting, for instance:
 * [
 *   'r' => 255,
 *   'g' => 255,
 *   'b' => 45,
 *   'a' => 0.5
 * ]
 */
new \Kirki\Field\Color(
	[
		'settings'    => 'kirki_demo_color_form_component_rgb',
		'label'       => __( 'v4 — form_component — RgbColorPicker', 'kirki' ),
		'description' => esc_html__( 'This is a color control with form_component value is RgbColorPicker. The saved value will be an array.', 'kirki' ),
		'section'     => 'color_advanced_section',
		'default'     => '#ffff00',
		'choices'     => [
			'form_component' => 'RgbColorPicker',
		],
		'transport'   => 'postMessage',
	]
);

/**
 * Color control with form_component value is RgbStringColorPicker.
 *
 * The saved value will be an rgb string.
 * The format is following the `react-colorful` and `colord` formatting, for instance:
 * "rgba(255, 255, 45)"
 */
new \Kirki\Field\Color(
	[
		'settings'    => 'kirki_demo_color_form_component_rgb_string',
		'label'       => __( 'v4 — form_component — RgbStringColorPicker', 'kirki' ),
		'description' => esc_html__( 'This is a color control with form_component value is RgbStringColorPicker. The saved value will be a string.', 'kirki' ),
		'section'     => 'color_advanced_section',
		'default'     => '#ffff00',
		'choices'     => [
			'form_component' => 'RgbStringColorPicker',
		],
		'transport'   => 'postMessage',
	]
);

/**
 * Color control with form_component value is RgbaColorPicker.
 *
 * The saved value will be an rgba array.
 * The format is following the `react-colorful` and `colord` formatting, for instance:
 * [
 *   'r' => 255,
 *   'g' => 255,
 *   'b' => 45,
 *   'a' => 0.5
 * ]
 */
new \Kirki\Field\Color(
	[
		'settings'    => 'kirki_demo_color_form_component_rgba',
		'label'       => __( 'v4 — form_component — RgbaColorPicker', 'kirki' ),
		'description' => esc_html__( 'This is a color control with form_component value is RgbaColorPicker.  The saved value will be an array.', 'kirki' ),
		'section'     => 'color_advanced_section',
		'default'     => '#ffff00',
		'choices'     => [
			'form_component' => 'RgbaColorPicker',
		],
		'transport'   => 'postMessage',
	]
);

/**
 * Color control with form_component value is RgbaStringColorPicker.
 *
 * The saved value will be an rgba string.
 * The format is following the `react-colorful` and `colord` formatting, for instance:
 * "rgba(255, 255, 45, 0.5)"
 */
new \Kirki\Field\Color(
	[
		'settings'    => 'kirki_demo_color_form_component_rgba_string',
		'label'       => __( 'v4 — form_component — RgbaStringColorPicker', 'kirki' ),
		'description' => esc_html__( 'This is a color control with form_component value is RgbaStringColorPicker. The saved value will be a string.', 'kirki' ),
		'section'     => 'color_advanced_section',
		'default'     => '#ffff00',
		'choices'     => [
			'form_component' => 'RgbaStringColorPicker',
		],
		'transport'   => 'postMessage',
	]
);

/**
 * Color control with form_component value is HslColorPicker.
 *
 * The saved value will be an hsl array.
 * The format is following the `react-colorful` and `colord` formatting (int, without the percent sign), for instance:
 * [
 *   'h' => 180,
 *   's' => 40, // Is int, without the percent sign.
 *   'l' => 50, // Is int, without the percent sign.
 * ]
 */
new \Kirki\Field\Color(
	[
		'settings'    => 'kirki_demo_color_form_component_hsl',
		'label'       => __( 'v4 — form_component — HslColorPicker', 'kirki' ),
		'description' => esc_html__( 'This is a color control with form_component value is HslColorPicker. The saved value will be an array', 'kirki' ),
		'section'     => 'color_advanced_section',
		'default'     => 'hsl(206, 23%, 25%)',
		'choices'     => [
			'form_component' => 'HslColorPicker',
		],
		'transport'   => 'postMessage',
	]
);

/**
 * Color control with form_component value is HslStringColorPicker.
 *
 * The saved value will be an hsl string.
 * The format is following the `react-colorful` and `colord` formatting, for instance:
 * "hsl(180, 40%, 50%)"
 */
new \Kirki\Field\Color(
	[
		'settings'    => 'kirki_demo_color_form_component_hsl_string',
		'label'       => __( 'v4 — form_component — HslStringColorPicker', 'kirki' ),
		'description' => esc_html__( 'This is a color control with form_component value is HslStringColorPicker. The saved value will be a string', 'kirki' ),
		'section'     => 'color_advanced_section',
		'default'     => 'hsl(206, 23%, 25%)',
		'choices'     => [
			'form_component' => 'HslStringColorPicker',
		],
		'transport'   => 'postMessage',
	]
);

/**
 * Color control with form_component value is HslaColorPicker.
 *
 * The saved value will be an hsla array.
 * The format is following the `react-colorful` and `colord` formatting (int, without the percent sign), for instance:
 * [
 *   'h' => 180,
 *   's' => 40, // Is int, without the percent sign.
 *   'l' => 50, // Is int, without the percent sign.
 *   'a' => 0.5
 * ]
 */
new \Kirki\Field\Color(
	[
		'settings'    => 'kirki_demo_color_form_component_hsla',
		'label'       => __( 'v4 — form_component — HslaColorPicker', 'kirki' ),
		'description' => esc_html__( 'This is a color control with form_component value is HslaColorPicker. The saved value will be an array', 'kirki' ),
		'section'     => 'color_advanced_section',
		'default'     => 'hsla(206, 23%, 25%, 0.7)',
		'choices'     => [
			'form_component' => 'HslaColorPicker',
		],
		'transport'   => 'postMessage',
	]
);

/**
 * Color control with form_component value is HslaStringColorPicker.
 *
 * The saved value will be an hsla string.
 * The format is following the `react-colorful` and `colord` formatting, for instance:
 * "hsla(180, 40%, 50%, 0.5)"
 */
new \Kirki\Field\Color(
	[
		'settings'    => 'kirki_demo_color_form_component_hsla_string',
		'label'       => __( 'v4 — form_component — HslaStringColorPicker', 'kirki' ),
		'description' => esc_html__( 'This is a color control with form_component value is HslaStringColorPicker. The saved value will be a string', 'kirki' ),
		'section'     => 'color_advanced_section',
		'default'     => 'hsla(206, 23%, 25%, 0.7)',
		'choices'     => [
			'form_component' => 'HslaStringColorPicker',
		],
		'transport'   => 'postMessage',
	]
);

/**
 * DateTime Control.
 */
new \Kirki\Field\Date(
	[
		'settings'    => 'kirki_demo_date',
		'label'       => esc_html__( 'Date Control', 'kirki' ),
		'description' => esc_html__( 'This is a date control.', 'kirki' ),
		'section'     => 'date_section',
		'default'     => '',
	]
);

new \Kirki\Field\Date(
	[
		'settings'    => 'kirki_demo_date_2',
		'label'       => esc_html__( 'Date Control 2', 'kirki' ),
		'description' => esc_html__( 'This is a date control.', 'kirki' ),
		'section'     => 'date_section',
		'default'     => '',
	]
);

/**
 * Editor Controls
 */
new \Kirki\Field\Editor(
	[
		'settings'    => 'kirki_demo_editor_1',
		'label'       => esc_html__( 'First Editor Control', 'kirki' ),
		'description' => esc_html__( 'This is an editor control.', 'kirki' ),
		'section'     => 'editor_section',
		'default'     => '',
	]
);

new \Kirki\Field\Editor(
	[
		'settings'    => 'kirki_demo_editor_2',
		'label'       => esc_html__( 'Second Editor Control', 'kirki' ),
		'description' => esc_html__( 'This is a 2nd editor control just to check that we do not have issues with multiple instances.', 'kirki' ),
		'section'     => 'editor_section',
		'default'     => esc_html__( 'Default Text', 'kirki' ),
	]
);

/**
 * Color-Palette Controls.
 *
 * @link https://kirki.org/docs/controls/color-palette.html
 */
new \Kirki\Field\Color_Palette(
	[
		'settings'    => 'kirki_demo_color_palette_simple',
		'label'       => esc_html__( 'Simple Colors Set', 'kirki' ),
		'description' => esc_html__( 'With default size (28). The `size` here is inner size (without border)', 'kirki' ),
		'section'     => 'color_palette_section',
		'default'     => '#888888',
		'transport'   => 'postMessage',
		'choices'     => [
			'colors' => [ '#000000', '#222222', '#444444', '#666666', '#888888', '#aaaaaa', '#cccccc', '#eeeeee', '#ffffff' ],
			'style'  => 'round',
		],
	]
);

new \Kirki\Field\Color_Palette(
	[
		'settings'    => 'kirki_demo_color_palette_material_all',
		'label'       => esc_html__( 'Material Design Colors — All', 'kirki' ),
		'description' => esc_html__( 'Showing all material design colors using `round` shape and size is 17', 'kirki' ),
		'section'     => 'color_palette_section',
		'default'     => '#D1C4E9',
		'transport'   => 'postMessage',
		'choices'     => [
			'colors' => Helper::get_material_design_colors( 'all' ),
			'shape'  => 'round',
			'size'   => 17,
		],
	]
);

new \Kirki\Field\Color_Palette(
	[
		'settings'    => 'kirki_demo_color_palette_material_primary',
		'label'       => esc_html__( 'Material Design Colors — Primary', 'kirki' ),
		'description' => esc_html__( 'Showing primary material design colors', 'kirki' ),
		'section'     => 'color_palette_section',
		'choices'     => [
			'colors' => Helper::get_material_design_colors( 'primary' ),
			'size'   => 25,
		],
	]
);

new \Kirki\Field\Color_Palette(
	[
		'settings'    => 'kirki_demo_color_palette_material_red',
		'label'       => esc_html__( 'Material Design Colors — Red', 'kirki' ),
		'description' => esc_html__( 'Showing red material design colors', 'kirki' ),
		'section'     => 'color_palette_section',
		'choices'     => [
			'colors' => Helper::get_material_design_colors( 'red' ),
			'size'   => 16,
		],
	]
);

new \Kirki\Field\Color_Palette(
	[
		'settings'    => 'kirki_demo_color_palette_a100',
		'label'       => esc_html__( 'Material Design Colors — A100', 'kirki' ),
		'description' => esc_html__( 'Showing "A100" variant of material design colors', 'kirki' ),
		'section'     => 'color_palette_section',
		'default'     => '#FF80AB',
		'choices'     => [
			'colors' => Helper::get_material_design_colors( 'A100' ),
			'size'   => 60,
			'style'  => 'round',
		],
	]
);

Kirki::add_field(
	'kirki_demo_config',
	[
		'type'        => 'color-palette',
		'settings'    => 'kirki_demo_color_palette_old',
		'label'       => 'The Old Way',
		'description' => 'Using `Kirki::add_field` in round shape',
		'section'     => 'color_palette_section',
		'transport'   => 'postMessage',
		'choices'     => [
			'colors' => [ '#000000', '#222222', '#444444', '#666666', '#888888', '#aaaaaa', '#cccccc', '#eeeeee', '#ffffff' ],
			'style'  => 'round',
		],
	]
);

add_action(
	'customize_register',
	function( $wp_customize ) {
		/**
		 * The custom control class
		 */
		class Kirki_Demo_Custom_Control extends Kirki\Control\Base {
			public $type = 'kirki-demo-custom-control';

			public function render_content() {

				$saved_value = $this->value();
				?>

				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<span class="customize-control-description description"><?php echo esc_html( $this->description ); ?></span>

				<div class="kirki-demo-custom-control">
					<div class="slider"></div>
					<input type="text" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $saved_value ); ?>" class="customize-control-slider-value" <?php $this->link(); ?> />
				</div>

				<?php
			}
		}

		// Register our custom control with Kirki.
		add_filter(
			'kirki_control_types',
			function( $controls ) {
				$controls['kirki-demo-custom-control'] = 'Kirki_Demo_Custom_Control';
				return $controls;
			}
		);

	}
);

Kirki::add_field(
	'kirki_demo_config',
	[
		'type'        => 'kirki-demo-custom-control',
		'settings'    => 'kirki_demo_custom_control_old_way',
		'label'       => esc_html__( 'Custom Control', 'kirki' ),
		'description' => 'A custom control demo, registered by extending `Kirki\\Control\\Base` class.',
		'section'     => 'custom_section',
		'transport'   => 'postMessage',
	]
);

/**
 * Dashicons control.
 *
 * @link https://kirki.org/docs/controls/dashicons.html
 */
new \Kirki\Field\Dashicons(
	[
		'settings'    => 'kirki_demo_dashicons_setting_0',
		'label'       => esc_html__( 'Dashicons Control', 'kirki' ),
		'description' => esc_html__( 'Using a custom array of dashicons', 'kirki' ),
		'section'     => 'dashicons_section',
		'default'     => 'menu',
		'choices'     => [
			'menu',
			'admin-site',
			'dashboard',
			'admin-post',
			'admin-media',
			'admin-links',
			'admin-page',
		],
	]
);

new \Kirki\Field\Dashicons(
	[
		'settings'    => 'kirki_demo_dashicons_setting_1',
		'label'       => esc_html__( 'All Dashicons', 'kirki' ),
		'description' => esc_html__( 'Showing all dashicons', 'kirki' ),
		'section'     => 'dashicons_section',
		'default'     => 'menu',
	]
);

/**
 * Dimension Control.
 */
new \Kirki\Field\Dimension(
	[
		'settings'    => 'kirki_demo_dimension_0',
		'label'       => esc_html__( 'Dimension Control', 'kirki' ),
		'description' => esc_html__( 'A simple dimension control.', 'kirki' ),
		'section'     => 'dimension_section',
		'default'     => '10px',
		'choices'     => [
			'accept_unitless' => true,
		],
	]
);

/**
 * Dimensions Control.
 */
new \Kirki\Field\Dimensions(
	[
		'settings'    => 'kirki_demo_dimensions_0',
		'label'       => esc_html__( 'Dimensions Control', 'kirki' ),
		'description' => esc_html__( 'Sample of dimensions control with 2 fields.', 'kirki' ),
		'section'     => 'dimensions_section',
		'default'     => [
			'width'  => '100px',
			'height' => '100px',
		],
	]
);

new \Kirki\Field\Dimensions(
	[
		'settings'    => 'kirki_demo_dimensions_1',
		'label'       => esc_html__( 'Dimension Control', 'kirki' ),
		'description' => esc_html__( 'Sample of dimensions control with 4 fields.', 'kirki' ),
		'section'     => 'dimensions_section',
		'default'     => [
			'padding-top'    => '1em',
			'padding-bottom' => '10rem',
			'padding-left'   => '1vh',
			'padding-right'  => '10px',
		],
	]
);

new \Kirki\Field\Dimensions(
	[
		'settings'    => 'kirki_demo_padding',
		'label'       => esc_html__( 'Padding Control', 'kirki' ),
		'description' => esc_html__( 'Sample of padding controls with 3 fields.', 'kirki' ),
		'section'     => 'dimensions_section',
		'default'     => [
			'top'        => '1em',
			'bottom'     => '10rem',
			'horizontal' => '1vh',
		],
	]
);

new \Kirki\Field\Dimensions(
	[
		'settings'    => 'kirki_demo_spacing',
		'label'       => esc_html__( 'Spacing Control', 'kirki' ),
		'description' => esc_html__( 'Sample of spacing controls with 4 fields.', 'kirki' ),
		'section'     => 'dimensions_section',
		'default'     => [
			'top'    => '1em',
			'bottom' => '10rem',
			'left'   => '1vh',
			'right'  => '10px',
		],
	]
);

/**
 * Dropdown-pages Control.
 */
new \Kirki\Field\Dropdown_Pages(
	[
		'settings'    => 'kirki_demo_dropdown_pages',
		'label'       => esc_html__( 'Dropdown Pages Control', 'kirki' ),
		'description' => esc_html__( 'Sample of dropdown pages control.', 'kirki' ),
		'section'     => 'dropdown_pages_section',
		'default'     => [
			'width'  => '100px',
			'height' => '100px',
		],
	]
);

/**
 * Generic Controls.
 */
new \Kirki\Field\Text(
	[
		'settings'        => 'kirki_demo_generic_text',
		'label'           => esc_html__( 'Generic Control — Text Field', 'kirki' ),
		'description'     => esc_html__( 'The demo of this control has partial refresh with transport is postMessage', 'kirki' ),
		'section'         => 'generic_section',
		'transport'       => 'postMessage',
		'default'         => '',
		'partial_refresh' => [
			'generic_text_refresh' => [
				'selector'        => '.kirki-partial-refresh-demo',
				'render_callback' => function() {
					$value = get_theme_mod( 'kirki_demo_generic_text' );
					return $value ? 'value of Generic URL Field control is: ' . $value : '';
				},
			],
		],
	]
);

new \Kirki\Field\URL(
	[
		'settings'        => 'kirki_demo_generic_url',
		'label'           => esc_html__( 'Generic Control — URL Field', 'kirki' ),
		'description'     => esc_html__( 'The demo of this control has partial refresh without transport is defined', 'kirki' ),
		'section'         => 'generic_section',
		'default'         => '',
		'partial_refresh' => [
			'generic_text_refresh2' => [
				'selector'        => '.kirki-partial-refresh-demo2',
				'render_callback' => function() {
					$value = get_theme_mod( 'kirki_demo_generic_url' );
					return $value ? 'value of Generic URL Field control is: ' . $value : '';
				},
			],
		],
	]
);

new \Kirki\Field\Textarea(
	[
		'settings'    => 'kirki_demo_generic_textarea',
		'label'       => esc_html__( 'Generic Control — Textarea Field', 'kirki' ),
		'description' => esc_html__( 'Description', 'kirki' ),
		'section'     => 'generic_section',
		'default'     => '',
	]
);

new \Kirki\Field\Generic(
	[
		'settings'    => 'kirki_demo_generic_custom',
		'label'       => esc_html__( 'Generic Control — Custom Input.', 'kirki' ),
		'description' => esc_html__( 'The "generic" control allows you to add any input type you want. In this case we use type="password" and define custom styles.', 'kirki' ),
		'section'     => 'generic_section',
		'default'     => '',
		'choices'     => [
			'element'  => 'input',
			'type'     => 'password',
			'style'    => 'background-color:black;color:red;',
			'data-foo' => 'bar',
		],
	]
);

/**
 * Image Control.
 */
new \Kirki\Field\Image(
	[
		'settings'    => 'kirki_demo_image_url',
		'label'       => esc_html__( 'Image Control (URL)', 'kirki' ),
		'description' => esc_html__( 'The saved value will be the URL.', 'kirki' ),
		'section'     => 'image_section',
		'default'     => '',
	]
);

new \Kirki\Field\Image(
	[
		'settings'    => 'kirki_demo_image_id',
		'label'       => esc_html__( 'Image Control (ID)', 'kirki' ),
		'description' => esc_html__( 'The saved value will an ID.', 'kirki' ),
		'section'     => 'image_section',
		'default'     => '',
		'choices'     => [
			'save_as' => 'id',
		],
	]
);

new \Kirki\Field\Image(
	[
		'settings'    => 'kirki_demo_image_array',
		'label'       => esc_html__( 'Image Control (array)', 'kirki' ),
		'description' => esc_html__( 'The saved value will an array.', 'kirki' ),
		'section'     => 'image_section',
		'default'     => '',
		'choices'     => [
			'save_as' => 'array',
		],
	]
);

/**
 * Upload control.
 */
new \Kirki\Field\Upload(
	[
		'settings'    => 'kirki_demo_upload_url',
		'label'       => esc_html__( 'Upload Control (URL)', 'kirki' ),
		'description' => esc_html__( 'The saved value will the URL.', 'kirki' ),
		'section'     => 'upload_section',
		'default'     => '',
		'transport'   => 'postMessage',
	]
);

/**
 * Multicheck Control.
 */
new \Kirki\Field\Multicheck(
	[
		'settings' => 'kirki_demo_multicheck',
		'label'    => esc_html__( 'Multickeck Control', 'kirki' ),
		'section'  => 'multicheck_section',
		'default'  => [ 'option-1', 'option-3', 'option-4' ],
		'priority' => 10,
		'choices'  => [
			'option-1' => esc_html__( 'Option 1', 'kirki' ),
			'option-2' => esc_html__( 'Option 2', 'kirki' ),
			'option-3' => esc_html__( 'Option 3', 'kirki' ),
			'option-4' => esc_html__( 'Option 4', 'kirki' ),
			'option-5' => esc_html__( 'Option 5', 'kirki' ),
		],
	]
);

/**
 * Multicolor Control.
 */
new \Kirki\Field\Multicolor(
	[
		'settings'  => 'kirki_demo_multicolor',
		'label'     => esc_html__( 'Multicolor Control', 'kirki' ),
		'section'   => 'multicolor_section',
		'priority'  => 10,
		'transport' => 'postMessage',
		'choices'   => [
			'link'      => esc_html__( 'Link Color', 'kirki' ),
			'hover'     => esc_html__( 'And this is hover color with long label so you know how it is displayed.', 'kirki' ),
			'active'    => esc_html__( 'Active Color', 'kirki' ),
			'another1'  => esc_html__( 'Another color 1', 'kirki' ),
			'another2'  => esc_html__( 'Another color 2', 'kirki' ),
			'another3'  => esc_html__( 'Another color 3', 'kirki' ),
			'another4'  => esc_html__( 'Another color 4', 'kirki' ),
			'another5'  => esc_html__( 'Another color 5', 'kirki' ),
			'another6'  => esc_html__( 'Another color 6', 'kirki' ),
			'another7'  => esc_html__( 'Another color 7', 'kirki' ),
			'another8'  => esc_html__( 'Another color 8', 'kirki' ),
			'another9'  => esc_html__( 'Another color 9', 'kirki' ),
			'another10' => esc_html__( 'Another color 10', 'kirki' ),
			'another11' => esc_html__( 'Another color 11', 'kirki' ),
			'another12' => esc_html__( 'Another color 12', 'kirki' ),
			'another13' => esc_html__( 'Another color 13', 'kirki' ),
			'another14' => esc_html__( 'Another color 14', 'kirki' ),
			'another15' => esc_html__( 'Another color 15', 'kirki' ),
		],
		'alpha'     => true,
		'default'   => [
			'link'   => '#0088cc',
			'hover'  => '#00aaff',
			'active' => '#00ffff',
		],
	]
);

/**
 * Number Control.
 */
new \Kirki\Field\Number(
	[
		'settings' => 'kirki_demo_number',
		'label'    => esc_html__( 'Number Control', 'kirki' ),
		'section'  => 'number_section',
		'priority' => 10,
		'choices'  => [
			'min'  => -5,
			'max'  => 5,
			'step' => 1,
		],
	]
);

/**
 * Palette Control.
 */
new \Kirki\Field\Palette(
	array(
		'settings' => 'kirki_demo_palette',
		'label'    => esc_html__( 'Control Palette', 'kirki' ),
		'section'  => 'palette_section',
		'default'  => 'blue',
		'choices'  => array(
			'a200'  => Kirki_Helper::get_material_design_colors( 'A200' ),
			'blue'  => Kirki_Helper::get_material_design_colors( 'blue' ),
			'green' => array( '#E8F5E9', '#C8E6C9', '#A5D6A7', '#81C784', '#66BB6A', '#4CAF50', '#43A047', '#388E3C', '#2E7D32', '#1B5E20', '#B9F6CA', '#69F0AE', '#00E676', '#00C853' ),
			'bnw'   => array( '#000000', '#ffffff' ),
		),
	)
);

/**
 * Radio Control.
 */
new \Kirki\Field\Radio(
	[
		'settings'    => 'kirki_demo_radio',
		'label'       => esc_html__( 'Radio Control', 'kirki' ),
		'description' => esc_html__( 'The description here.', 'kirki' ),
		'section'     => 'radio_section',
		'default'     => 'option-3',
		'choices'     => [
			'option-1' => esc_html__( 'Option 1', 'kirki' ),
			'option-2' => esc_html__( 'Option 2', 'kirki' ),
			'option-3' => esc_html__( 'Option 3', 'kirki' ),
			'option-4' => esc_html__( 'Option 4', 'kirki' ),
			'option-5' => esc_html__( 'Option 5', 'kirki' ),
		],
	]
);

/**
 * Radio-Buttonset Control.
 */
new \Kirki\Field\Radio_Buttonset(
	[
		'settings'    => 'kirki_demo_radio_buttonset',
		'label'       => esc_html__( 'Radio-Buttonset Control', 'kirki' ),
		'description' => esc_html__( 'Sample of radio-buttonset control.', 'kirki' ),
		'section'     => 'radio_buttonset_section',
		'default'     => 'option-2',
		'choices'     => [
			'option-1' => esc_html__( 'Option 1', 'kirki' ),
			'option-2' => esc_html__( 'Option 2', 'kirki' ),
			'option-3' => esc_html__( 'Option 3', 'kirki' ),
		],
	]
);

/**
 * Radio-Image Control.
 */
new \Kirki\Field\Radio_Image(
	[
		'settings'    => 'kirki_demo_radio_image',
		'label'       => esc_html__( 'Radio-Image Control', 'kirki' ),
		'description' => esc_html__( 'Sample of radio image control.', 'kirki' ),
		'section'     => 'radio_image_section',
		'default'     => 'travel',
		'choices'     => [
			'moto'    => 'https://jawordpressorg.github.io/wapuu/wapuu-archive/wapuu-moto.png',
			'cossack' => 'https://raw.githubusercontent.com/templatemonster/cossack-wapuula/master/cossack-wapuula.png',
			'travel'  => 'https://jawordpressorg.github.io/wapuu/wapuu-archive/wapuu-travel.png',
		],
	]
);

/**
 * Repeater Control.
 */
new \Kirki\Field\Repeater(
	[
		'settings'    => 'kirki_demo_repeater',
		'label'       => esc_html__( 'Repeater Control', 'kirki' ),
		'description' => esc_html__( 'Sample of repeater control.', 'kirki' ),
		'section'     => 'repeater_section',
		'default'     => [
			[
				'link_text'   => esc_html__( 'Kirki Site', 'kirki' ),
				'link_url'    => 'https://kirki.org/',
				'link_target' => '_self',
				'checkbox'    => false,
			],
			[
				'link_text'   => esc_html__( 'Kirki Repository', 'kirki' ),
				'link_url'    => 'https://github.com/aristath/kirki',
				'link_target' => '_self',
				'checkbox'    => false,
			],
		],
		'fields'      => [
			'link_text'   => [
				'type'        => 'text',
				'label'       => esc_html__( 'Link Text', 'kirki' ),
				'description' => esc_html__( 'This will be the label for your link', 'kirki' ),
				'default'     => '',
			],
			'link_url'    => [
				'type'        => 'text',
				'label'       => esc_html__( 'Link URL', 'kirki' ),
				'description' => esc_html__( 'This will be the link URL', 'kirki' ),
				'default'     => '',
			],
			'link_target' => [
				'type'        => 'select',
				'label'       => esc_html__( 'Link Target', 'kirki' ),
				'description' => esc_html__( 'This will be the link target', 'kirki' ),
				'default'     => '_self',
				'choices'     => [
					'_blank' => esc_html__( 'New Window', 'kirki' ),
					'_self'  => esc_html__( 'Same Frame', 'kirki' ),
				],
			],
			'checkbox'    => [
				'type'    => 'checkbox',
				'label'   => esc_html__( 'Checkbox', 'kirki' ),
				'default' => false,
			],
		],
	]
);

/**
 * Select Control.
 */
new \Kirki\Field\Select(
	[
		'settings'    => 'kirki_demo_select',
		'label'       => esc_html__( 'Select Control', 'kirki' ),
		'description' => esc_html__( 'Sample of single mode select control.', 'kirki' ),
		'section'     => 'select_section',
		'default'     => 'option-3',
		'placeholder' => esc_html__( 'Select an option', 'kirki' ),
		'choices'     => [
			'option-1' => esc_html__( 'Option 1', 'kirki' ),
			'option-2' => esc_html__( 'Option 2', 'kirki' ),
			'option-3' => esc_html__( 'Option 3', 'kirki' ),
			'option-4' => esc_html__( 'Option 4', 'kirki' ),
			'option-5' => esc_html__( 'Option 5', 'kirki' ),
		],
	]
);

new \Kirki\Field\Select(
	[
		'settings'    => 'kirki_demo_select_multiple',
		'label'       => esc_html__( 'Select Control', 'kirki' ),
		'description' => esc_html__( 'Sample of multiple mode select control.', 'kirki' ),
		'section'     => 'select_section',
		'default'     => 'option-3',
		'multiple'    => 3,
		'choices'     => [
			'option-1' => esc_html__( 'Option 1', 'kirki' ),
			'option-2' => esc_html__( 'Option 2', 'kirki' ),
			'option-3' => esc_html__( 'Option 3', 'kirki' ),
			'option-4' => esc_html__( 'Option 4', 'kirki' ),
			'option-5' => esc_html__( 'Option 5', 'kirki' ),
		],
	]
);

/**
 * Slider Control.
 */
new \Kirki\Field\Slider(
	[
		'settings'    => 'kirki_demo_slider',
		'label'       => esc_html__( 'Slider Control', 'kirki' ),
		'description' => esc_html__( 'Sample of slider control.', 'kirki' ),
		'section'     => 'slider_section',
		'default'     => '10',
		'transport'   => 'postMessage',
		'tooltip'     => esc_html__( 'This is the tooltip', 'kirki' ),
		'choices'     => [
			'min'  => 0,
			'max'  => 100,
			'step' => 1,
		],
	]
);

Kirki::add_field(
	'kirki_demo_config',
	[
		'type'        => 'slider',
		'settings'    => 'kirki_demo_slider_old',
		'label'       => esc_html__( 'Slider Control — Using Old Way', 'kirki' ),
		'description' => 'Added using `Kirki::add_field` (the old Kirki API)',
		'section'     => 'slider_section',
		'transport'   => 'postMessage',
		'choices'     => [
			'min'  => 0,
			'max'  => 100,
			'step' => 0.5,
		],
	]
);

/**
 * Sortable control.
 */
new \Kirki\Field\Sortable(
	[
		'settings' => 'kirki_demo_sortable',
		'label'    => __( 'This is a sortable control.', 'kirki' ),
		'section'  => 'sortable_section',
		'default'  => [ 'option3', 'option1', 'option4' ],
		'choices'  => [
			'option1' => esc_html__( 'Option 1', 'kirki' ),
			'option2' => esc_html__( 'Option 2', 'kirki' ),
			'option3' => esc_html__( 'Option 3', 'kirki' ),
			'option4' => esc_html__( 'Option 4', 'kirki' ),
			'option5' => esc_html__( 'Option 5', 'kirki' ),
			'option6' => esc_html__( 'Option 6', 'kirki' ),
		],
	]
);

/**
 * Switch control.
 */
new \Kirki\Field\Checkbox_Switch(
	[
		'settings'    => 'kirki_demo_switch',
		'label'       => esc_html__( 'Switch Field', 'kirki' ),
		'description' => esc_html__( 'Simple switch control', 'kirki' ),
		'section'     => 'switch_section',
		'transport'   => 'postMessage',
		'default'     => true,
	]
);

new \Kirki\Field\Checkbox_Switch(
	[
		'settings'        => 'kirki_demo_switch_custom_label',
		'label'           => esc_html__( 'Switch Field — With custom labels', 'kirki' ),
		'description'     => esc_html__( 'Switch control using custom labels', 'kirki' ),
		'section'         => 'switch_section',
		'default'         => true,
		'choices'         => [
			'on'  => esc_html__( 'Enabled', 'kirki' ),
			'off' => esc_html__( 'Disabled', 'kirki' ),
		],
		'active_callback' => [
			[
				'setting'  => 'kirki_demo_switch',
				'operator' => '==',
				'value'    => true,
			],
		],
	]
);

/**
 * Toggle control.
 */
Kirki::add_field(
	'kirki_demo_config',
	[
		'type'        => 'toggle',
		'settings'    => 'kirki_demo_toggle_setting',
		'label'       => esc_html__( 'Toggle Field', 'kirki' ),
		'description' => esc_html__( 'Toggle is just utilizing switch control but aligned horizontally & without the text', 'kirki' ),
		'section'     => 'toggle_section',
		'default'     => '1',
		'priority'    => 10,
		'transport'   => 'postMessage',
	]
);

/**
 * Typography Control.
 */
new \Kirki\Field\Typography(
	[
		'settings'    => 'kirki_demo_kirki_typography_setting',
		'label'       => esc_html__( 'Typography Control', 'kirki' ),
		'description' => esc_html__( 'The full set of options.', 'kirki' ),
		'section'     => 'typography_section',
		'priority'    => 10,
		'transport'   => 'postMessage',
		'default'     => [
			'font-family'     => 'Roboto',
			'variant'         => 'regular',
			'font-style'      => 'normal',
			'color'           => '#333333',
			'font-size'       => '14px',
			'line-height'     => '1.5',
			'letter-spacing'  => '0',
			'text-transform'  => 'none',
			'text-decoration' => 'none',
			'text-align'      => 'left',
			'margin-top'      => '0',
			'margin-bottom'   => '0',
		],
		'output'      => [
			[
				'element' => 'body, p',
			],
		],
		'choices'     => [
			'fonts' => [
				'google'   => [ 'popularity', 60 ],
				'families' => [
					'custom' => [
						'text'     => 'My Custom Fonts (demo only)',
						'children' => [
							[
								'id'   => 'helvetica-neue',
								'text' => 'Helvetica Neue',
							],
							[
								'id'   => 'linotype-authentic',
								'text' => 'Linotype Authentic',
							],
						],
					],
				],
				'variants' => [
					'helvetica-neue'     => [ 'regular', '900' ],
					'linotype-authentic' => [ 'regular', '100', '300' ],
				],
			],
		],
	]
);

new \Kirki\Field\Typography(
	[
		'settings'    => 'kirki_demo_typography_setting_1',
		'label'       => esc_html__( 'Typography Control', 'kirki' ),
		'description' => esc_html__( 'Just the font-family and font-weight.', 'kirki' ),
		'section'     => 'typography_section',
		'priority'    => 10,
		'transport'   => 'auto',
		'default'     => [
			'font-family' => 'Roboto',
		],
		'output'      => [
			[
				'element' => [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ],
			],
		],
	]
);

/**
 * Example function that creates a control containing the available sidebars as choices.
 *
 * @return void
 */
function kirki_sidebars_select_example() {
	$sidebars = [];
	if ( isset( $GLOBALS['wp_registered_sidebars'] ) ) {
		$sidebars = $GLOBALS['wp_registered_sidebars'];
	}
	$sidebars_choices = [];
	foreach ( $sidebars as $sidebar ) {
		$sidebars_choices[ $sidebar['id'] ] = $sidebar['name'];
	}
	if ( ! class_exists( 'Kirki' ) ) {
		return;
	}
	new \Kirki\Field\Select(
		[
			'settings'    => 'kirki_demo_sidebars_select',
			'label'       => esc_html__( 'Sidebars Select', 'kirki' ),
			'description' => esc_html__( 'An example of how to implement sidebars selection.', 'kirki' ),
			'section'     => 'select_section',
			'default'     => 'primary',
			'choices'     => $sidebars_choices,
			'priority'    => 30,
		]
	);
}
add_action( 'init', 'kirki_sidebars_select_example', 999 );
