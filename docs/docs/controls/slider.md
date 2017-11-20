---
layout: default
title: The "slider" control
slug: slider
subtitle: Learn how to create controls using Kirki
mainMaxWidth: 50rem;
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
Kirki::add_field( 'theme_config_id', array(
	'type'        => 'slider',
	'settings'    => 'my_setting',
	'label'       => esc_attr__( 'This is the label', 'textdomain' ),
	'section'     => 'section_id',
	'default'     => 42,
	'choices'     => array(
		'min'  => '0',
		'max'  => '100',
		'step' => '1',
	),
) );
```
