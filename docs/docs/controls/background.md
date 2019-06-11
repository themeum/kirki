---
layout: default
title: WordPress Customizer Background Control
slug: background
subtitle: Learn how to create a background control using the Kirki Customizer Framework.
mainMaxWidth: 55rem;
bodyClasses: control page
returns: array
heroButtons:
  - url: ../controls
    class: white button round border-only
    icon: fa fa-arrow-circle-o-left
    label: Back to Controls
---

The `background` control allows you to have every CSS background property under one roof.

### Example

```php
Kirki::add_field( 'theme_config_id', [
	'type'        => 'background',
	'settings'    => 'background_setting',
	'label'       => esc_html__( 'Background Control', 'kirki' ),
	'description' => esc_html__( 'Background conrols are pretty complex - but extremely useful if properly used.', 'kirki' ),
	'section'     => 'section_id',
	'default'     => [
		'background-color'      => 'rgba(20,20,20,.8)',
		'background-image'      => '',
		'background-repeat'     => 'repeat',
		'background-position'   => 'center center',
		'background-size'       => 'cover',
		'background-attachment' => 'scroll',
	],
	'transport'   => 'auto',
	'output'      => [
		[
			'element' => 'body',
		],
	],
] );
```
