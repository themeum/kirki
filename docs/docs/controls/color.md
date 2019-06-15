---
layout: default
title: WordPress Customizer Color Control
slug: color
subtitle: Learn how to create a color picker control using the Kirki Customizer Framework.
mainMaxWidth: 55rem;
bodyClasses: control page
returns: string
heroButtons:
  - url: ../controls
    class: white button round border-only
    icon: fa fa-arrow-circle-o-left
    label: Back to Controls
---

The `color` control allows you to create colorpickers. WordPress uses [iris](http://automattic.github.io/Iris/) for colorpickers and Kirki extends the default WordPress Color controls adding the ability to select `rgba` colors with the addition of an opacity slider.

### Example

#### Adding a hex-only colorpicker

```php
Kirki::add_field( 'theme_config_id', [
	'type'        => 'color',
	'settings'    => 'color_setting_hex',
	'label'       => __( 'Color Control (hex-only)', 'kirki' ),
	'description' => esc_html__( 'This is a color control - without alpha channel.', 'kirki' ),
	'section'     => 'section_id',
	'default'     => '#0088CC',
] );
```

<img src="https://raw.githubusercontent.com/aristath/kirki/master/docs/assets/images/color-hex.png" alt="color-hex control example" style="max-width:300px;">

------------------

#### Adding an rgba colorpicker

```php
Kirki::add_field( 'theme_config_id', [
	'type'        => 'color',
	'settings'    => 'color_setting_rgba',
	'label'       => __( 'Color Control (with alpha channel)', 'kirki' ),
	'description' => esc_html__( 'This is a color control - with alpha channel.', 'kirki' ),
	'section'     => 'section_id',
	'default'     => '#0088CC',
	'choices'     => [
		'alpha' => true,
	],
] );
```
<img src="https://raw.githubusercontent.com/aristath/kirki/master/docs/assets/images/color-rgba.png" alt="color-rgba control example" style="max-width:300px;">

--------------------

#### Adding a hue-only colorpicker

```php
Kirki::add_field( 'theme_config_id', [
	'type'        => 'color',
	'settings'    => 'color_setting_hue',
	'label'       => __( 'Color Control - hue only.', 'kirki' ),
	'description' => esc_html__( 'This is a color control - hue only.', 'kirki' ),
	'section'     => 'section_id',
	'default'     => '#0088CC',
	'mode'        => 'hue',
] );
```
<img src="https://raw.githubusercontent.com/aristath/kirki/master/docs/assets/images/color-hue.png" alt="color-hue control example" style="max-width:300px;">

<div class="callout warning ribbon-full">
    <h5>Caution:</h5>
    <p>If you use a hue-only control the saved value will not be a hex or rgba color. Instead the value will be an integer. You can use that value in HSL or HSLA colors in your themes. For more info on HSLA you can read <a href="https://css-tricks.com/yay-for-hsla/" target="_blank">this article</a></p>
</div>

### Usage

Most times you won't have to manually retrieve the value of `color` controls since the `output` argument can cover most use-cases.

```php
<div style="color:<?php echo get_theme_mod( 'my_setting', '#FFFFFF' ); ?>">
	<p>The text-color of this div is controlled by "my_setting".
</div>
```
