---
layout: default
title: multiple
published: true
mainMaxWidth: 55rem;
---


The `multiple` argument is only used in the `select` controls.

Its value is an integer and defines the number of simultaneous options the user will be able to choose for the `select` control in question.

Defaults to `1`.

```php
Kirki::add_field( 'my_config', [
	'type'        => 'select',
	'settings'    => 'my_setting',
	'label'       => esc_html__( 'This is the label', 'kirki' ),
	'section'     => 'my_section',
	'default'     => [ 'option-1' ],
	'priority'    => 10,
	'multiple'    => 999,
	'choices'     => [
		'option-1' => esc_html__( 'Option 1', 'kirki' ),
		'option-2' => esc_html__( 'Option 2', 'kirki' ),
		'option-3' => esc_html__( 'Option 3', 'kirki' ),
		'option-4' => esc_html__( 'Option 4', 'kirki' ),
	],
] );
```
