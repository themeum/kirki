---
layout: default
title: The "Kirki WCAG Link Colorpicker" control
slug: kirki-wcag-link-color
subtitle: Premium Kirki Control
mainMaxWidth: 55rem;
bodyClasses: control page
returns: string
heroButtons:
  - url: https://wplemon.com/downloads/kirki-wcag-link-colorpicker/
    class: white button round border-only
    icon: fa fa-arrow-circle-o-right
    label: Buy License
---


<div class="callout success" style="text-align:center">
	<p>This is a premium control. You can use in your <strong>premium theme</strong> by purchasing a license.</p>
	<a href="https://wplemon.com/downloads/kirki-wcag-link-colorpicker/" class="button round">Buy License</a>
</div>

The **Kirki WCAG Link Colorpicker** plugin is an advanced control for the WordPress Customizer and can be used as an add-on for the Kirki Toolkit. 

You can use this control one of 2 ways:

1. Using the default WordPress Customizer API
2. As an addon to Kirki.

WordPress Plugin and Theme developers can use this new control to automatically suggest accessible link colors based on the value of a background color as well as the color of surrounding text.

Users can select one of 2 modes:

* **Auto** – Automatically picks the most accessible color for the selected color combinations for background and text colors.
* **Custom** – Lets the user pick a custom color.

## Usage

When embedding this control in your theme, you will need to include its file and also add a filter to properly modify the URL for the scripts and styles this addon uses:

```php
require_once get_template_directory() . '/inc/kirki-wcga-lc/kirki-wcag-lc.php';
/**
 * Modify the URL for assets in our custom control.
 *
 * @return string
 */
function my_theme_kirki_wcag_link_color_url() {
	return get_template_directory_uri() . '/inc/kirki-wcag-lc';
}
add_filter( 'kirki_wcag_link_color_url', 'my_theme_kirki_wcag_link_color_url' );
```

## Adding a control.

The purpose of this control is to recommend text-colors based on the background colors defined in a 2nd control. It can't work on its own and **requires** having a background-color control and a color control for your text. You can reference the theme-mods you use for background and color text settings in the choices for this control.

### Using the Native WordPress Customizer API:

If you want to use the WordPress Customizer API, then you can add your control like this:

```php
/**
 * Add section, settings and controls.
 *
 * @param WP_Customize_Manager $wp_customize The WordPress Customizer object.
 * @return void
 */
function my_theme_example_kirki_wcag_controls( $wp_customize ) {

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

	// Add text-color control. This can be a simple colorpicker
	// but in this example we're using the kirki-wcag-text-color control.
	// See https://kirki.org/docs/controls/kirki-wcag-text-color.html
	$wp_customize->add_control( new Kirki_WCAG_Text_Color( $wp_customize, 'text_color', [
		'label'       => esc_html__( 'Text Color', 'my-theme' ),
		'description' => esc_html__( 'Select the text color for your content. Please choose one of the recommended colors to ensure readability with your selected background-color, or switch to the "Custom Color" tab to select any other color you want.', 'my-theme' ),
		'section'     => 'my_theme_colors',
		'choices'     => [
			'setting' => 'background_color',
		],
	] ) );

	// Add link-color setting.
	$wp_customize->add_setting( 'links_color', [
		'default'           => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
	] );

	// Add text-color control.
	$wp_customize->add_control( new Kirki_WCAG_Link_Color( $wp_customize, 'links_color', [
		'label'       => esc_html__( 'Links Color', 'my-theme' ),
		'description' => esc_html__( 'Select the color for your links.', 'my-theme' ),
		'section'     => 'my_theme_colors',
		'choices'     => [
			'backgroundColor' => 'background_color',
			'textColor'       => 'text_color',
		],
	] ) );
}
add_action( 'customize_register', 'my_theme_example_kirki_wcag_controls' );
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
	],
] );

// Add links-color control.
Kirki::add_field( 'my_theme', [
	'settings'    => 'links_color',
	'label'       => esc_html__( 'Links Color', 'my-theme' ),
	'description' => esc_html__( 'Select the color for your links', 'my-theme' ),
	'type'        => 'kirki-wcga-lc',
	'section'     => 'my_theme_colors',
	'default'     => '#0f5e97',
	'choices'     => [
		'backgroundColor' => 'background_color',
		'textColor'       => 'text_color',
	],
] );
```

In the above examples We add a `my_theme_colors` section and inside that section 3 controls:
* `background_color` controls our background color.
* `text_color` controls our text color.
* `links_color` controls our links color.

The text-color control can be a simple colorpicker, but in order to further enhance the accessibility automation for our example we're using the `kirki-wcag-tc` control. See [this article](https://kirki.org/docs/controls/kirki-wcag-text-color.html) for more detials on that control if needed.

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
| `backgroundColor` | **REQUIRED** | `string` | – | The setting of the background-color theme-mode we want to listen to.
| `textColor` | **REQUIRED** | `string` | – | The setting of the text-color theme-mode we want to listen to.

<div class="callout warning">
	<h2>Licensing</h2>
	<ul>
		<li>This product is licenced under GPL 2.0.</li>
		<li>Purchasing a license allows you to include it in a single premium plugin or theme.</li>
		<li>If you want to include it in more than 1 of your products, a separate license will have to be acquired for each of your products.</li>
		<li><strong>You may not include this control in a free product.</strong></li>
	</ul>
</div>

<a href="https://wplemon.com/downloads/kirki-wcag-link-colorpicker/" class="button round">Buy License</a>
