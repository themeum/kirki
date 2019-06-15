---
layout: default
title: WordPress Customizer Dimensions Control
slug: dimensions
subtitle: Learn how to create a dimensions control using the Kirki Customizer Framework.
mainMaxWidth: 55rem;
bodyClasses: control page
returns: array
heroButtons:
  - url: ../controls
    class: white button round border-only
    icon: fa fa-arrow-circle-o-left
    label: Back to Controls
---

The `dimensions` control allows you to control multiple dimensions on the same control.
You can define the properties it will use in the field's `default` argument.

## Examples:

Controlling the `width` and `height`:

```php
Kirki::add_field( 'theme_config_id', [
	'type'        => 'dimensions',
	'settings'    => 'my_setting',
	'label'       => esc_html__( 'Dimension Control', 'kirki' ),
	'description' => esc_html__( 'Description Here.', 'kirki' ),
	'section'     => 'my_section',
	'default'     => [
		'width'  => '100px',
		'height' => '100px',
	],
] );
```

Controlling the padding:

```php
Kirki::add_field( 'theme_config_id', [
	'type'        => 'dimensions',
	'settings'    => 'my_setting',
	'label'       => esc_html__( 'Dimension Control', 'kirki' ),
	'description' => esc_html__( 'Description Here.', 'kirki' ),
	'section'     => 'my_section',
	'default'     => [
		'padding-top'    => '1em',
		'padding-bottom' => '10rem',
		'padding-left'   => '1vh',
		'padding-right'  => '10px',
	],
] );
```

You can use any dimensions and define the labels using a snippet like this:

```php
Kirki::add_field( 'theme_config_id', [
	'type'        => 'dimensions',
	'settings'    => 'my_setting',
	'label'       => esc_html__( 'Dimension Control', 'kirki' ),
	'description' => esc_html__( 'Description Here.', 'kirki' ),
	'section'     => 'my_section',
	'default'     => [
		'min-width'  => '100px',
		'max-width'  => '500px',
		'min-height' => '50px',
		'max-height' => '10em',
	],
	'choices'     => [
		'labels' => [
			'min-width'  => esc_html__( 'Min Width', 'kirki' ),
			'max-width'  => esc_html__( 'Max Width', 'kirki' ),
			'min-height' => esc_html__( 'Min Height', 'kirki' ),
			'max-height' => esc_html__( 'Max Height', 'kirki' ),
		],
	],
] );
```
