---
layout: default
title: The "Kirki Box Shadow" control
slug: kirki-box-shadow
subtitle: Premium Kirki Control
mainMaxWidth: 55rem;
bodyClasses: control page
returns: array
heroButtons:
  - url: https://wplemon.com/downloads/kirki-box-shadow/
    class: white button round border-only
    icon: fa fa-arrow-circle-o-right
    label: Buy License
---


<div class="callout success" style="text-align:center">
	<p>This is a premium control. You can use in your <strong>premium theme</strong> by purchasing a license.</p>
	<a href="https://wplemon.com/downloads/kirki-box-shadow/" class="button round">Buy License</a>
</div>

<img src="https://raw.githubusercontent.com/aristath/kirki/master/docs/assets/images/kirki-box-shadow.gif" alt="box-shadow control example" style="max-width:300px;max-height:100vh;float:right;padding-left:1em;">

The **Kirki Box shadow** control is an advanced control for the WordPress Customizer and can be used as an add-on for the Kirki Toolkit. It introduces a new custom control to the WordPress Customizer using the Kirki API.
You can use this control one of 2 ways:

1. Using the default WordPress Customizer API
2. As an addon to Kirki.

## Usage

When embedding this control in your theme, you will need to include its file and also add a filter to properly modify the URL for the scripts and styles this addon uses:

```php
require_once get_template_directory() . '/inc/kirki-box-shadow/kirki-box-shadow.php';
/**
 * Modify the URL for assets in our custom control.
 *
 * @return string
 */
function my_theme_kirki_kirki_box_shadow_control_url() {
	return get_template_directory_uri() . '/inc/kirki-box-shadow';
}
add_filter( 'kirki_box_shadow_control_url', 'my_theme_kirki_kirki_box_shadow_control_url' );
```

## Adding a control.

### Using the Native WordPress Customizer API:

If you want to use the WordPress Customizer API, then you can add your control like this:

```php
/**
 * Add section, settings and controls.
 *
 * @param WP_Customize_Manager $wp_customize The WordPress Customizer object.
 * @return void
 */
function my_theme_example_kirki_box_control( $wp_customize ) {

	// Add a section.
	$wp_customize->add_section( 'my_section', [
		'title'    => esc_html__( 'My Section', 'kirki' ),
	] );

	// Add setting.
	$wp_customize->add_setting( 'my_setting', [
		'default' => '0px 0px 0px 0px #000000',
	] );

	// Add control.
	$wp_customize->add_control( new Kirki_Box_Shadow_Control( $wp_customize, 'my_setting', [
		'label'       => esc_html__( 'Box Shadow Control', 'kirki' ),
		'description' => esc_html__( 'Box-Shadow Options.', 'kirki' ),
		'type'        => 'kirki-box-shadow',
		'section'     => 'my_section',
	] ) );
}
add_action( 'customize_register', 'my_theme_example_kirki_box_control' );
```

### Using the Kirki API:

The above code can be written using the Kirki API like this:

```php
// Add Kirki Config.
Kirki::add_config( 'my_theme', [
	'capability'  => 'edit_theme_options',
	'option_type' => 'theme_mod',
] );

Kirki::add_section( 'my_section', [
	'title' => esc_html__( 'My Section', 'kirki' ),
] );

Kirki::add_field( 'my_theme', [
	'settings'    => 'my_setting',
	'label'       => esc_html__( 'Box Shadow Control', 'kirki' ),
	'description' => esc_html__( 'Box-Shadow Options.', 'kirki' ),
	'type'        => 'kirki-box-shadow',
	'section'     => 'my_section',
	'default'     => '0px 0px 0px 0px #000000',
] );
```

In the above examples We add a `my_section` section and inside that section a box-shadow control on the `my_setting` setting.

## Arguments

The control accepts the same arguments as any other control. 

## Return value

The value returned is a the compilation of all controls and is formatted as a string that can be used directly as the CSS value.

## Use with Kirki

If you use this control with the Kirki Toolkit, then you can take advantage of Kirki's automatic CSS-generation and `postMessage` scripts.

To make this control affect a `#my-element` element on our page with live-updating in the customizer and automatic CSS generation on the frontend, you can simply add the `transport` and `output` arguments, so the above example would become like this:

```php
Kirki::add_field( 'my_theme', [
	'settings'    => 'my_setting',
	'label'       => esc_html__( 'Box Shadow Control', 'kirki' ),
	'description' => esc_html__( 'Box-Shadow Options.', 'kirki' ),
	'type'        => 'kirki-box-shadow',
	'section'     => 'my_section',
	'default'     => '0px 0px 0px 0px #000000',
	'transport'   => 'auto',
	'output'      => [
		[
			'element'  => '#my-element',
			'property' => 'box-shadow',
		],
	],
] );
```

<div class="callout warning">
	<h2>Licensing</h2>
	<ul>
		<li>This product is licenced under GPL 2.0.</li>
		<li>Purchasing a license allows you to include it in a single premium plugin or theme.</li>
		<li>If you want to include it in more than 1 of your products, a separate license will have to be acquired for each of your products.</li>
		<li><strong>You may not include the “Kirki Box Shadow addon-on in a free product.</strong></li>
	</ul>
</div>

<a href="https://wplemon.com/downloads/kirki-box-shadow/" class="button round">Buy License</a>
