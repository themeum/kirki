---
layout: default
title: multiple
published: false
---


The `multiple` argument is only used in the `select` controls.

Its value is an integer and defines the number of simultaneous options the user will be able to choose for the `select` control in question.

Defaults to `1`.

```php
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'select',
	'settings'    => 'my_setting',
	'label'       => esc_html__( 'This is the label', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => array('option-1'),
	'priority'    => 10,
	'multiple'    => 999,
	'choices'     => array(
		'option-1' => esc_attr__( 'Option 1', 'my_textdomain' ),
		'option-2' => esc_attr__( 'Option 2', 'my_textdomain' ),
		'option-3' => esc_attr__( 'Option 3', 'my_textdomain' ),
		'option-4' => esc_attr__( 'Option 4', 'my_textdomain' ),
	),
) );
```
