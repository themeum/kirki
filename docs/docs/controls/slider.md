---
layout: default
title: WordPress Customizer Slider Control
slug: slider
subtitle: Learn how to create a slider control using the Kirki Customizer Framework.
mainMaxWidth: 55rem;
bodyClasses: control page
returns: string|int|float
heroButtons:
  - url: ../controls
    class: white button round border-only
    icon: fa fa-arrow-circle-o-left
    label: Back to Controls
---

`slider` controls are numeric fields that allow you to set a minimum value, a maximum value and a step.

### Example

```php
Kirki::add_field( 'theme_config_id', [
	'type'        => 'slider',
	'settings'    => 'my_setting',
	'label'       => esc_html__( 'This is the label', 'kirki' ),
	'section'     => 'section_id',
	'default'     => 42,
	'choices'     => [
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	],
] );
```
