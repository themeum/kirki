---
layout: default
title: preset
published: true
mainMaxWidth: 55rem;
---

The `preset` argument allows you to change the values of one or more controls, based on the value of another control.

In the following example, changing the value of `color_scheme_radio` will automatically update the values of `color_setting_one` and `color_setting_two`. The color controls retain the functionality to be interacted with independently.

Example:

```php
Kirki::add_field( 'theme_config_id', [
	'type'        => 'radio',
	'settings'    => 'color_scheme_radio',
	'label'       => esc_attr__( 'Radio Control', 'kirki' ),
	'description' => esc_attr__( 'This radio will control the following two color controls.', 'kirki' ),
	'section'     => 'preset_section',
	'default'     => 'orange',
	'choices'     => [
		'red'    => esc_html__( 'Red', 'kirki' ),
		'blue'   => esc_html__( 'Blue', 'kirki' ),
		'orange' => esc_html__( 'Orange', 'kirki' ),
	],
	'preset'      => array(
		'red'    => array(
			'settings' => array(
				'color_setting_one' => '#db0000',
				'color_setting_two' => '#871616',
			),
		),
		'blue'   => [
			'settings' => [
				'color_setting_one' => '#428ed1',
				'color_setting_two' => '#1e73be',
			],
		],
		'orange' => [
			'settings' => [
				'color_setting_one' => '#d6a356',
				'color_setting_two' => '#dd9933',
			],
		],
	),
] );

Kirki::add_field( 'theme_config_id', [
	'type'        => 'color',
	'settings'    => 'color_setting_one',
	'label'       => __( 'Color Control One', 'kirki' ),
	'description' => esc_html__( 'This is a color control.', 'kirki' ),
	'section'     => 'preset_section',
	'default'     => '#d6a356',
] );

Kirki::add_field( 'theme_config_id', [
	'type'        => 'color',
	'settings'    => 'color_setting_two',
	'label'       => __( 'Color Control Two', 'kirki' ),
	'description' => esc_html__( 'This is a color control.', 'kirki' ),
	'section'     => 'preset_section',
	'default'     => '#dd9933',
] );
```
