---
layout: default
title: The "Kirki WCAG Text Colorpicker" control
slug: kirki-wcag-text-color
subtitle: Premium Kirki Control
mainMaxWidth: 55rem;
bodyClasses: control page
returns: string
heroButtons:
  - url: https://wplemon.com/downloads/kirki-wcag-text-colorpicker/
    class: white button round border-only
    icon: fa fa-arrow-circle-o-right
    label: Buy License
---


<div class="callout success" style="text-align:center">
	<p>This is a premium control. You can use in your <strong>premium theme</strong> by purchasing a license.</p>
	<a href="https://wplemon.com/downloads/kirki-wcag-text-colorpicker/" class="button round">Buy License</a>
</div>

<img src="https://raw.githubusercontent.com/aristath/kirki/master/docs/assets/images/kirki-atcp.gif" alt="accessible-textlorpicker control example" style="max-width:300px;max-height:100vh;float:right;padding-left:1em;">
The **Kirki WCAG Text Colorpicker** plugin is an advanced control for the WordPress Customizer and can be used as an add-on for the Kirki Toolkit. 

You can use this control one of 2 ways:

1. Using the default WordPress Customizer API
2. As an addon to Kirki.

WordPress Plugin and Theme developers can use this new control to automatically suggest accessible text colors based on the value of a background color.

Users can select one of 3 modes:

* **Auto** – Automatically picks the most accessible color for the selected background.
* **Recommended** – Suggests colors that when combined with the selected background, comply with WCAG standards.
* **Custom** – Lets the user pick a custom color.

You can configure most of the arguments used to calculate the accessible colors when adding the field.

## Usage

When embedding this control in your theme, you will need to include its file and also add a filter to properly modify the URL for the scripts and styles this addon uses:

```php
require_once get_template_directory() . '/inc/kirki-wcga-tc/kirki-wcag-tc.php';
/**
 * Modify the URL for assets in our custom control.
 *
 * @return string
 */
function my_theme_kirki_wcag_text_color_url() {
	return get_template_directory_uri() . '/inc/kirki-wcag-tc';
}
add_filter( 'kirki_wcag_text_color_url', 'my_theme_kirki_wcag_text_color_url' );
```

## Adding a control.

The purpose of this control is to recommend text-colors based on the background colors defined in a 2nd control. It can't work on its own and **requires** having a background-color control which you will then reference in the choices for this control.

### Using the Native WordPress Customizer API:

If you want to use the WordPress Customizer API, then you can add your control like this:

```php
/**
 * Add section, settings and controls.
 *
 * @param WP_Customize_Manager $wp_customize The WordPress Customizer object.
 * @return void
 */
function my_theme_example_kirki_wcag_tc( $wp_customize ) {

	// Add section.
	$wp_customize->add_section( 'my_theme_colors', [
		'title'    => esc_html__( 'Colors', 'my-theme' ),
	] );

	// Add background-color setting.
	$wp_customize->add_setting( 'background_color', [
		'default'           => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	] );

	// Add background-color control.
	$wp_customize->add_control( 'background_color', [
		'type'        => 'color',
		'section'     => 'my_theme_colors',
		'label'       => esc_html__( 'Background Color', 'my-theme' ),
		'description' => esc_html__( 'Select a background color for your content.', 'my-theme' ),
	] );

	// Add text-color setting.
	$wp_customize->add_setting( 'text_color', [
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
	] );

	// Add text-color control.
	$wp_customize->add_control( new Kirki_WCAG_Text_Color( $wp_customize, 'text_color', [
		'label'       => esc_html__( 'Text Color', 'my-theme' ),
		'description' => esc_html__( 'Select the text color for your content. Please choose one of the recommended colors to ensure readability with your selected background-color, or switch to the "Custom Color" tab to select any other color you want.', 'my-theme' ),
		'section'     => 'my_theme_colors',
		'choices'     => [
			'setting' => 'background_color',
			// 'maxHueDiff'          => 60,   // Optional.
			// 'stepHue'             => 15,   // Optional.
			// 'maxSaturation'       => 0.5,  // Optional.
			// 'stepSaturation'      => 0.1,  // Optional.
			// 'stepLightness'       => 0.05, // Optional.
			// 'precissionThreshold' => 6,    // Optional.
			// 'contrastThreshold'   => 4.5   // Optional.		
		],
	] ) );
}
add_action( 'customize_register', 'my_theme_example_kirki_wcag_tc' );
```

### Using the Kirki API:

The above code can be written using the Kirki API like this:

```php
// Add Kirki Config.
Kirki::add_config( 'my_theme', [
	'capability'  => 'edit_theme_options',
	'option_type' => 'theme_mod',
] );

Kirki::add_section( 'my_theme_colors', [
	'title'    => esc_html__( 'Colors', 'my-theme' ),
] );

// Add background control.
Kirki::add_field( 'my_theme', [
	'settings'    => 'background_color',
	'label'       => esc_html__( 'Background Color', 'my-theme' ),
	'description' => esc_html__( 'Select a background color for your content.', 'my-theme' ),
	'type'        => 'color',
	'section'     => 'my_theme_colors',
	'default'     => '#ffffff',
] );

// Add text-color control.
Kirki::add_field( 'my_theme', [
	'settings'    => 'text_color',
	'label'       => esc_html__( 'Text Color', 'my-theme' ),
	'description' => esc_html__( 'Select the text color for your content. Please choose one of the recommended colors to ensure readability with your selected background-color, or switch to the "Custom Color" tab to select any other color you want.', 'my-theme' ),
	'type'        => 'kirki-wcga-tc',
	'section'     => 'my_theme_colors',
	'default'     => '#000000',
	'choices'     => [
		'setting' => 'background_color',
		// 'maxHueDiff'          => 60,   // Optional.
		// 'stepHue'             => 15,   // Optional.
		// 'maxSaturation'       => 0.5,  // Optional.
		// 'stepSaturation'      => 0.1,  // Optional.
		// 'stepLightness'       => 0.05, // Optional.
		// 'precissionThreshold' => 6,    // Optional.
		// 'contrastThreshold'   => 4.5   // Optional.		
	],
] );
```

In the above examples We add a `my_theme_colors` section and inside that section 2 controls:
* `background_color` controls our background color.
* `text_color` controls our text-color.

In our `text_color` control we define the background-color we want our control to check colors again in the `['choices']['setting']` argument. When users change their background-color, the text-color will be autocalculated:

* If the user has chosen to use an **auto** color, then the text-color will be either white or black depending on the luminosity of their selected background.
* If the user has chosen to use a **recommended** color, then a list of accessible colors will be displayed and they can choose one of these colors.
* If the user has chosen to use a **custom** color, no action will be taken.

## Arguments

The control accepts the same arguments as any other control. Please note that `choices` is required.

| SETTING | REQUIRED? | TYPE | DESCRIPTION |
| ------ | ------ | ------ | ------ |
| `settings` | **REQUIRED** | `string` | The name of the theme_mod you want to save.
| `label` | OPTIONAL | `string` | The label of the control.
| `description` | OPTIONAL | `string` | The control’s description. Shows below the label.
| `type` | **REQUIRED** | `string` | The control-type. To use this control this must be set to Kirki_WCAG_Text_Color.
| `section` | **REQUIRED** | `string` | The section in which this control will be added.
| `priority` | OPTIONAL | `int` | The control’s priority.
| `default` | **REQUIRED** | `string` | The default color.
| `choices` | **REQUIRED** | `array` | An array of options for this control.

### `choices` parameters

The `choices` argument is an array that can have the following parameters:

| KEY | REQUIRED? | TYPE | DEFAULT | DESCRIPTION
| ------ | ------ | ------ | ------ | ------ |
| `setting` | **REQUIRED** | `string` | – | The setting of the background-color control we want to listen to.
| `maxHueDiff` | OPTIONAL | `int` | `60` | The maximum hue difference a recommended color can have. This number can be any value between 0 and 359. The higher the value, the more recommended colors will be allowed to deviate from the background color’s hue. Please note that the number defined in this argument will be used in both directions, so the actual search window will be double the defined value.
| `stepHue` | OPTIONAL | `int` | `15` | How many degrees we want to go on each step when looking for accessible colors. Lower values are more precice – but slower.
| `maxSaturation` | OPTIONAL | `float` | `0.8` | Text colors should not be allowed to have a high saturation or be too intense. You can define the maximum saturation text-colors should have here. This can be a value between 0 and 1. Lower values are more precice – but slower.
| `stepSaturation` | OPTIONAL | `float` | `0.1` | How detailed searches should be with the saturation. Use a number between 0 and 1. Lower values are more precice – but slower.
| `stepLightness` | OPTIONAL | `float` | `0.05` | How detailed color searches will be regarding their lightness.
| `precissionThreshold` | OPTIONAL | `int` | `6` | If the color-search returns less than 6 colors (or the number you have defined), then the accuracy of the searches is doubled and more coloors are searched.
| `contrastThreshold` | OPTIONAL | `float` | `4.5` | The minimum required contrast betwween the background color and the text color. By default we use 4.5 so that a 4.5:1 contrast is achieved – as per the WCAG recomentations.

## How it works

When you select a background color,we first check the current hue:

Starting from 0 we increase the saturation by the number defined in the `stepSaturation` value until we reach the number defined in the
`maxSaturation` value.

For each saturation step, we then check the lightness: Starting from 0 all the way to 1, in increments defined by the `stepLightness` value.

After the current hue is checked, we “rotate” the color-wheel by a number of degrees equal to the value of the `stepHue` argument, and we repeat the same process to get all accessible colors for that hue.

Then we repeat the same process until the rotation reaches the number defined in the `maxHueDiff` value.

Then we do the same rotating the color-wheel in the opposite direction.

### How many colors does the control check?​

The number of colors checked every time the background color changes depends on the options you define. We have defined some sane defaults that produce enough colors to choose from without sacrificing performance, but you can change these defaults to suit your own needs. However, when doing so it is important to keep in mind that for every background color that changes, this control will have to go through hundreds of possible combinations of colors and check the contrast of each and every one of them to find accessible combinations. Using too detailed values will produce an unreasonably high number of colors for the user to choose from, and the higher the number of combinations that needs to be checked the higher the impact on performance on the user’s browser.

A quick calculation of how many colors the control checks on each background change can be done with this formula:

```
2 * ( 1 + maxHueDiff / stepHue ) * (maxSaturation / stepSaturation ) * ( 1 / stepLightness )
```

For the default values that makes 1600 checks for every background color change and we have found that a number of 1000-2000 color checks works best for performance – though there won’t be any issues if you go higher than that as long as your custom configuration is kept within some sane limits.

<div class="callout warning">
	<h2>Licensing</h2>
	<ul>
		<li>This product is licenced under GPL 2.0.</li>
		<li>Purchasing a license allows you to include it in a single premium plugin or theme.</li>
		<li>If you want to include it in more than 1 of your products, a separate license will have to be acquired for each of your products.</li>
		<li><strong>You may not include this control in a free product.</strong></li>
	</ul>
</div>

<a href="https://wplemon.com/downloads/kirki-wcag-text-colorpicker/" class="button round">Buy License</a>
