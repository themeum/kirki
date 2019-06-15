---
layout: default
title: WordPress Customizer Select Control
slug: select
subtitle: Learn how to create a select control using the Kirki Customizer Framework.
mainMaxWidth: 55rem;
bodyClasses: control page
returns: string|int
heroButtons:
  - url: ../controls
    class: white button round border-only
    icon: fa fa-arrow-circle-o-left
    label: Back to Controls
---

### Example

```php
Kirki::add_field( 'theme_config_id', [
	'type'        => 'select',
	'settings'    => 'my_setting',
	'label'       => esc_html__( 'This is the label', 'kirki' ),
	'section'     => 'section_id',
	'default'     => 'option-1',
	'priority'    => 10,
	'multiple'    => 1,
	'choices'     => [
		'option-1' => esc_html__( 'Option 1', 'kirki' ),
		'option-2' => esc_html__( 'Option 2', 'kirki' ),
		'option-3' => esc_html__( 'Option 3', 'kirki' ),
		'option-4' => esc_html__( 'Option 4', 'kirki' ),
	],
] );
```
