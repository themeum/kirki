---
layout: default
title: WordPress Customizer Text Control
slug: text
subtitle: Learn how to create a text control using the Kirki Customizer Framework.
mainMaxWidth: 55rem;
bodyClasses: control page
returns: string
heroButtons:
  - url: ../controls
    class: white button round border-only
    icon: fa fa-arrow-circle-o-left
    label: Back to Controls
---

`text` controls allow you to add a simple, single-line text input.

### Example

```php
Kirki::add_field( 'theme_config_id', [
	'type'     => 'text',
	'settings' => 'my_setting',
	'label'    => esc_html__( 'Text Control', 'kirki' ),
	'section'  => 'section_id',
	'default'  => esc_html__( 'This is a default value', 'kirki' ),
	'priority' => 10,
] );
```
