---
layout: default
title: The "radio" control
slug: radio
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
Kirki::add_field( 'theme_config_id', array(
	'type'        => 'radio',
	'settings'    => 'my_setting',
	'label'       => __( 'Radio Control', 'textdomain' ),
	'section'     => 'section_id',
	'default'     => 'red',
	'priority'    => 10,
	'choices'     => array(
		'red'   => esc_attr__( 'Red', 'textdomain' ),
		'green' => esc_attr__( 'Green', 'textdomain' ),
		'blue'  => esc_attr__( 'Blue', 'textdomain' ),
	),
) );
```

In case you need to add additional, extra-long descriptions to your radio options you can use a format like this:

```php
Kirki::add_field( 'theme_config_id', array(
	'type'        => 'radio',
	'settings'    => 'my_setting',
	'label'       => __( 'Radio Control', 'textdomain' ),
	'section'     => 'section_id',
	'default'     => 'red',
	'priority'    => 10,
	'choices'     => array(
		'red'   => array(
			esc_attr__( 'Red', 'my_textdomain' ),
			esc_attr__( 'These are some extra details about Red', 'textdomain' ),
		),
		'green' => array(
			esc_attr__( 'Green', 'kirki' ),
			esc_attr__( 'These are some extra details about Green', 'textdomain' ),
		),
		'blue'  => array(
			esc_attr__( 'Blue', 'kirki' ),
			esc_attr__( 'These are some extra details about Blue', 'textdomain' ),
		),
	),
) );
```
