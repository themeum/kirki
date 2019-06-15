---
layout: default
title: WordPress Customizer Radio Control
slug: radio
subtitle: Learn how to create a radio control using the Kirki Customizer Framework.
mainMaxWidth: 55rem;
bodyClasses: control page
returns: string
heroButtons:
  - url: ../controls
    class: white button round border-only
    icon: fa fa-arrow-circle-o-left
    label: Back to Controls
---

You can define the available options using the `choices` argument and formating them as an array `key => label`.

### Example

```php
Kirki::add_field( 'theme_config_id', [
	'type'        => 'radio',
	'settings'    => 'my_setting',
	'label'       => esc_html__( 'Radio Control', 'kirki' ),
	'section'     => 'section_id',
	'default'     => 'red',
	'priority'    => 10,
	'choices'     => [
		'red'   => esc_html__( 'Red', 'kirki' ),
		'green' => esc_html__( 'Green', 'kirki' ),
		'blue'  => esc_html__( 'Blue', 'kirki' ),
	],
] );
```

In case you need to add additional, extra-long descriptions to your radio options you can use a format like this:

```php
Kirki::add_field( 'theme_config_id', [
	'type'        => 'radio',
	'settings'    => 'my_setting',
	'label'       => esc_html__( 'Radio Control', 'kirki' ),
	'section'     => 'section_id',
	'default'     => 'red',
	'priority'    => 10,
	'choices'     => [
		'red'   => [
			esc_html__( 'Red', 'kirki' ),
			esc_html__( 'These are some extra details about Red', 'kirki' ),
		],
		'green' => [
			esc_html__( 'Green', 'kirki' ),
			esc_html__( 'These are some extra details about Green', 'kirki' ),
		],
		'blue'  => [
			esc_html__( 'Blue', 'kirki' ),
			esc_html__( 'These are some extra details about Blue', 'kirki' ),
		],
	],
] );
```
