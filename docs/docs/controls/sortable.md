---
layout: default
title: The "sortable" control
slug: sortable
subtitle: Learn how to create controls using Kirki
mainMaxWidth: 50rem;
bodyClasses: control page
returns: array
heroButtons:
  - url: ../controls
    class: white button round border-only
    icon: fa fa-arrow-circle-o-left
    label: Back to Controls
---

Example:

```php
Kirki::add_field( 'my_config', array(
	'type'        => 'sortable',
	'settings'    => 'my_setting',
	'label'       => __( 'This is the label', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => array(
		'option3',
		'option1',
		'option4'
	),
	'choices'     => array(
		'option1' => esc_attr__( 'Option 1', 'kirki' ),
		'option2' => esc_attr__( 'Option 2', 'kirki' ),
		'option3' => esc_attr__( 'Option 3', 'kirki' ),
		'option4' => esc_attr__( 'Option 4', 'kirki' ),
		'option5' => esc_attr__( 'Option 5', 'kirki' ),
		'option6' => esc_attr__( 'Option 6', 'kirki' ),
	),
	'priority'    => 10,
) );
```
