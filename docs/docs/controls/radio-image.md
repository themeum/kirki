---
layout: default
title: WordPress Customizer Radio Image Control
slug: radio-image
subtitle: Learn how to create a radio image control using the Kirki Customizer Framework.
mainMaxWidth: 55rem;
bodyClasses: control page
returns: string
heroButtons:
  - url: ../controls
    class: white button round border-only
    icon: fa fa-arrow-circle-o-left
    label: Back to Controls
---

You can define the available options using the `choices` argument and formating them as an array `key => URL`.

### Example

```php
Kirki::add_field( 'theme_config_id', [
	'type'        => 'radio-image',
	'settings'    => 'my_setting',
	'label'       => esc_html__( 'Radio Control', 'kirki' ),
	'section'     => 'section_id',
	'default'     => 'red',
	'priority'    => 10,
	'choices'     => [
		'red'   => get_template_directory_uri() . '/assets/images/red.png',
		'green' => get_template_directory_uri() . '/assets/images/green.png',
		'blue'  => get_template_directory_uri() . '/assets/images/blue.png',
	],
] );
```
