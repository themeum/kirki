---
layout: default
title: The "toggle" control
slug: toggle
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

Toggles provide a simple way to turn on/off options. They return a `boolean` so you can easily check their value in your code and act on them (check the examples for more details).

Toggle controls are internally [`checkbox`](checkbox) controls styled differently.

### Example

```php
Kirki::add_field( 'my_config', array(
	'type'        => 'toggle',
	'settings'    => 'my_setting',
	'label'       => esc_attr__( 'This is the label', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => '1',
	'priority'    => 10,
) );
```

### Usage

```php
<?php if ( true == get_theme_mod( 'my_setting', true ) ) : ?>
	<p>Toggle is enabled</p>
<?php else : ?>
	<p>Toggle is disabled</p>
<?php endif; ?>
```
