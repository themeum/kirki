---
layout: default
title: The "radio-image" control
slug: radio-image
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

You can define the available options using the `choices` argument and formating them as an array `key => URL`.

### Example

```php
Kirki::add_field( 'my_config', array(
	'type'        => 'radio-image',
	'settings'    => 'my_setting',
	'label'       => esc_html__( 'Radio Control', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => 'red',
	'priority'    => 10,
	'choices'     => array(
		'red'   => get_template_directory_uri() . '/assets/images/red.png',
		'green' => get_template_directory_uri() . '/assets/images/green.png',
		'blue'  => get_template_directory_uri() . '/assets/images/blue.png',
	),
) );
```
