---
layout: default
title: The "switch" control
slug: switch
subtitle: Learn how to create controls using Kirki
mainMaxWidth: 50rem;
bodyClasses: control page
returns: boolean
heroButtons:
  - url: ../controls
    class: white button round border-only
    icon: fa fa-arrow-circle-o-left
    label: Back to Controls
---


Switches provide a simple way to turn on/off options. They return a `boolean` so you can easily check their value in your code and act on them.

Switch controls are internally [`checkbox`](checkbox) controls styled differently.

One main difference that `switch` controls have from [`checkbox`](checkbox) and [`toggle`](toggle) controls is that on switches you can change their labels.

By default the labels are ON/OFF. To change them you can use the `choices` argument:

```php
'choices' => array(
    'on'  => esc_attr__( 'Enable', 'textdomain' ),
    'off' => esc_attr__( 'Disable', 'textdomain' )
)
```

### Example

Switches have the benefit of allowing you to change their labels.
In the example below we'll be using 'Enable' and 'Disable' as labels.
The default labels are "On" & "Off", so if you don't want to change them you can simply omit the `choices` argument.

```php
Kirki::add_field( 'my_config', array(
	'type'        => 'switch',
	'settings'    => 'my_setting',
	'label'       => __( 'This is the label', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => '1',
	'priority'    => 10,
	'choices'     => array(
		'on'  => esc_attr__( 'Enable', 'my_textdomain' ),
		'off' => esc_attr__( 'Disable', 'my_textdomain' ),
	),
) );
```

### Usage

```php
<?php if ( true == get_theme_mod( 'my_setting', true ) ) : ?>
	<p>Switch is ON</p>
<?php else : ?>
	<p>Switch is OFF</p>
<?php endif; ?>
```
