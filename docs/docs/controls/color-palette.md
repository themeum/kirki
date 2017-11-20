---
layout: default
title: The "color-palette" control
slug: color-palette
subtitle: Learn how to create controls using Kirki
mainMaxWidth: 50rem;
bodyClasses: control page
returns: string
heroButtons:
  - url: ../controls
    class: white button round border-only
    icon: fa fa-arrow-circle-o-left
    label: Back to Controls
---

The `color-palette` control allows you to define an array of colors and users can choose from those colors. Internally the control is a simple radio control with some additional styling to make color selection easier.

You can define inside the `choices` arguments an array of colors, the style (`round` or not) and also the size each color will have. See the examples below.

### Example

```php
Kirki::add_field( 'theme_config_id', array(
	'type'        => 'color-palette',
	'settings'    => 'color_palette_setting_0',
	'label'       => esc_attr__( 'Color-Palette', 'textdomain' ),
	'description' => esc_attr__( 'This is a color-palette control', 'textdomain' ),
	'section'     => 'section_id',
	'default'     => '#888888',
	'choices'     => array(
		'colors' => array( '#000000', '#222222', '#444444', '#666666', '#888888', '#aaaaaa', '#cccccc', '#eeeeee', '#ffffff' ),
		'style'  => 'round',
	),
) );
```
The result of the above example would look like this:

<img src="https://raw.githubusercontent.com/aristath/kirki/master/docs/assets/images/color-palette-bw-round.png" alt="color-palette control example 1" style="max-width:300px;">

Additionally the `Kirki_Helper` class provides helper methods in case you want to use Google's [Material Design color palettes](https://material.io/guidelines/style/color.html#color-color-palette).

Some additional examples using those helper methods:

#### Material-design Colors - All.

```php
Kirki::add_field( 'theme_config_id', array(
	'type'        => 'color-palette',
	'settings'    => 'color_palette_setting_4',
	'label'       => esc_attr__( 'Color-Palette', 'textdomain' ),
	'description' => esc_attr__( 'Material Design Colors - all', 'textdomain' ),
	'section'     => 'section_id',
	'default'     => '#F44336',
	'choices'     => array(
		'colors' => Kirki_Helper::get_material_design_colors( 'all' ),
		'size'   => 17,
	),
) );
```
<img src="https://raw.githubusercontent.com/aristath/kirki/master/docs/assets/images/color-palette-md-all.png" alt="color-palette control example 2" style="max-width:300px;">

#### Material-design Colors - Primary

```php
Kirki::add_field( 'theme_config_id', array(
	'type'        => 'color-palette',
	'settings'    => 'color_palette_setting_1',
	'label'       => esc_attr__( 'Color-Palette', 'textdomain' ),
	'description' => esc_attr__( 'Material Design Colors - primary', 'textdomain' ),
	'section'     => 'section_id',
	'default'     => '#000000',
	'choices'     => array(
		'colors' => Kirki_Helper::get_material_design_colors( 'primary' ),
		'size'   => 25,
	),
) );
```
<img src="https://raw.githubusercontent.com/aristath/kirki/master/docs/assets/images/color-palette-md-primary.png" alt="color-palette control example 2" style="max-width:300px;">

#### All Material-design Colors - Reds

```php
Kirki::add_field( 'theme_config_id', array(
	'type'        => 'color-palette',
	'settings'    => 'color_palette_setting_2',
	'label'       => esc_attr__( 'Color-Palette', 'kirki' ),
	'description' => esc_attr__( 'Material Design Colors - red', 'textdomain' ),
	'section'     => 'section_id',
	'default'     => '#FF1744',
	'choices'     => array(
		'colors' => Kirki_Helper::get_material_design_colors( 'textdomain' ),
		'size'   => 16,
	),
) );
```
<img src="https://raw.githubusercontent.com/aristath/kirki/master/docs/assets/images/color-palette-md-red.png" alt="color-palette control example 2" style="max-width:300px;">

#### All Material-design Colors - A100 variation.

```php
Kirki::add_field( 'theme_config_id', array(
	'type'        => 'color-palette',
	'settings'    => 'color_palette_setting_3',
	'label'       => esc_attr__( 'Color-Palette', 'textdomain' ),
	'description' => esc_attr__( 'Material Design Colors - A100', 'textdomain' ),
	'section'     => 'section_id',
	'default'     => '#FF80AB',
	'choices'     => array(
		'colors' => Kirki_Helper::get_material_design_colors( 'A100' ),
		'size'   => 60,
		'style'  => 'round',
	),
) );
```
<img src="https://raw.githubusercontent.com/aristath/kirki/master/docs/assets/images/color-palette-md-a100.png" alt="color-palette control example 2" style="max-width:300px;">
