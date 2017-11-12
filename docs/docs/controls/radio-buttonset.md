---
layout: default
title: The "radio-buttonset" control
slug: radio-buttonset
subtitle: Learn how to create controls using Kirki
mainMaxWidth: 50rem;
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
Kirki::add_field( 'my_config', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'my_setting',
	'label'       => __( 'Radio-Buttonset Control', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => 'red',
	'priority'    => 10,
	'choices'     => array(
		'red'   => esc_attr__( 'Red', 'my_textdomain' ),
		'green' => esc_attr__( 'Green', 'my_textdomain' ),
		'blue'  => esc_attr__( 'Blue', 'my_textdomain' ),
	),
) );
```
