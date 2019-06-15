---
layout: default
title: WordPress Customizer Radio Buttonset Control
slug: radio-buttonset
subtitle: Learn how to create a radio buttonset control using the Kirki Customizer Framework.
mainMaxWidth: 55rem;
bodyClasses: control page
returns: string
heroButtons:
  - url: ../controls
    class: white button round border-only
    icon: fa fa-arrow-circle-o-left
    label: Back to Controls
---

You can define the available options using the `choices` argument and formatting them as an array `key => label`.

### Example

```php
Kirki::add_field( 'theme_config_id', [
	'type'        => 'radio-buttonset',
	'settings'    => 'my_setting',
	'label'       => esc_html__( 'Radio-Buttonset Control', 'kirki' ),
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
